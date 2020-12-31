<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\User;


class RacePaymentController extends Controller
{

    /**
     * Make request global.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Class constructor.
     *
     * @param \Illuminate\Http\Request $request User Request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set midtrans configuration
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_ID');
        // Uncomment for production environment
        // \Midtrans\Config::$isProduction = true;
        Midtrans\Config::$isSanitized = true;
        Midtrans\Config::$is3ds = true;
    }

    public function showRaceForm() {   

        if(DB::table('user_data')->where('user_id',Auth::user()->id)->first()) {
            return redirect('/payment');
        } else {
            $racetype = DB::table('race_category')->get();
            $jersey = DB::table('jersey')->get();
            $donate = DB::table('donations')->get();
            return view('race.index', compact('racetype','donate','jersey'));
        }
    }

    public function registerRacer(Request $request) {
        DB::table('user_data')->insert([
            'user_id' => Auth::user()->id,
            'name' => $request['name'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'angkatan' => $request['angkatan'],
            'alamat' => $request['alamat'],
            'phone' => $request['phone'],
            'jersey' => $request['jersey'],
            'donate' => $request['donation'],
            'race_type' => $request['racetype'],
        ]);
        return redirect('/payment');
    }

    public function payment(Request $request) {

        $id = Auth::user()->id;
        $race = DB::table('user_data')->where('user_id',$id)->value('race_type');
        $jersey = DB::table('user_data')->where('user_id',$id)->value('jersey');
        $donate = DB::table('user_data')->where('user_id',$id)->value('donate');

        $raceType = DB::table('race_category')->where('id',$race)->value('type');
        $racePrice = DB::table('race_category')->where('id',$race)->value('price');
        $jerseyPrice = DB::table('jersey')->where('size',$jersey)->value('price');
        $donatePrice = DB::table('donations')->where('id',$donate)->value('price');
        $user = DB::table('user_data')->where('user_id',$id)->first();

        return view('race.payment',compact('user','raceType','racePrice','donatePrice','jerseyPrice','jersey'));
    }

    public function requestMidtrans() {

        $id = Auth::user()->id;
        $race = DB::table('user_data')->where('user_id',$id)->value('race_type');
        $jersey = DB::table('user_data')->where('user_id',$id)->value('jersey');
        $donate = DB::table('user_data')->where('user_id',$id)->value('donate');

        $raceType = DB::table('race_category')->where('id',$race)->value('type');
        $racePrice = DB::table('race_category')->where('id',$race)->value('price');
        $jerseyPrice = DB::table('jersey')->where('size',$jersey)->value('price');
        $donatePrice = DB::table('donations')->where('id',$donate)->value('price');

        if(DB::table('transactions')->where('user_id', Auth::user()->id)->doesntExist()) {

            $transaction = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => ($racePrice + $jerseyPrice + $donatePrice),
                ),
                'item_details' => array(
                    array(
                        'id' => 'feeRace',
                        'price' => $racePrice,
                        'quantity' => 1,
                        'name' => "Biaya Pendaftaran Kategori ".$raceType,
                    ),
                ),
            );

            if($jerseyPrice > 0) {
                array_push($transaction['item_details'], 
                    array(
                        'id' => 'feeJersey',
                        'price' => $jerseyPrice,
                        'quantity' => 1,
                        'name' => "Biaya Jersey Ukuran ".$jersey,
                    )
                    );
            };

            if($donatePrice > 0) {
                array_push($transaction['item_details'], 
                    array(
                        'id' => 'feeDonate',
                        'price' => $donatePrice,
                        'quantity' => 1,
                        'name' => "Donasi untuk Celebrity Run",
                    )
                );
            };

            $snapToken = Midtrans\Snap::getSnapToken($transaction);

            Transaction::create([
                'user_id' => $id,
                'snap_token' => $snapToken,
                'price' => ($racePrice + $jerseyPrice + $donatePrice),
            ]);

        } else {
            $snapToken = DB::table('transactions')
                ->where('user_id', $id)
                ->value('snap_token');
        }

        return response($snapToken);
    }

    public function paymentNotification(Request $request) {
        $notif = new Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $id = Auth::user()->id;
        $raceType = DB::table('race_category')->where('id',$race)->value('type');

        DB::table('transactions')
            ->where('user_id', $id)
            ->update([
                'order_id' => $order_id,
                'type' => $type,
                'status' => $transaction,
            ]);

        if ($transaction == 'capture') {
        // For credit card transaction, we need to check whether transaction is challenge by FDS or not
        if ($type == 'credit_card'){
            if($fraud == 'challenge'){
            // TODO set payment status in merchant's database to 'Challenge by FDS'
            // TODO merchant should decide whether this transaction is authorized or not in MAP
            echo "Transaction order_id: " . $order_id ." is challenged by FDS";
            }
            else {
            // TODO set payment status in merchant's database to 'Success'
            echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
            }
            }
        }
        else if ($transaction == 'settlement'){
        // TODO set payment status in merchant's database to 'Settlement'
            DB::table('transactions')
                ->where('user_id', $id)
                ->update(['status' => $transaction]);
            DB::table('participants')
                ->insertOrIgnore([
                    'user_id' => $id,
                    'angkatan' => Auth::user()->angkatan,
                    'raceType' => $raceType,
                ]);
        }
        else if($transaction == 'pending'){
        // TODO set payment status in merchant's database to 'Pending'
            DB::table('transactions')
                ->where('user_id', Auth::user()->id)
                ->update(['status' => $transaction]);
        }
        else if ($transaction == 'deny') {
        // TODO set payment status in merchant's database to 'Denied'
            DB::table('transactions')
                ->where('user_id', Auth::user()->id)
                ->update(['status' => $transaction]);
        }
        else if ($transaction == 'expire') {
        // TODO set payment status in merchant's database to 'expire'
            DB::table('transactions')
                ->where('user_id', Auth::user()->id)
                ->update(['status' => $transaction]);
        }
        else if ($transaction == 'cancel') {
        // TODO set payment status in merchant's database to 'Denied'
            DB::table('transactions')
                ->where('user_id', Auth::user()->id)
                ->update(['status' => $transaction]);
        }

        return; 
    }

    public function payComplete() {
        return redirect('/info');
    }

    public function handleUpload(Request $request) {
        request()->validate([

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
            'distance' => 'numeric',
            'strava_link' => 'string|nullable'
        ]);

        $dist = str_replace(".","_",request()->distance);
        $imageName = time().'-'.Auth::user()->id.'-'.Auth::user()->name.'-'.$dist.'km.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('progress'), $imageName);

        DB::table('uploads')->insert([
            'user_id' => Auth::user()->id,
            'distance' => $request->distance,
            'image' => $imageName,
            'link' => $request->strava_link,
        ]);

        return redirect('/info')
            ->with('success','Gambar berhasil diupload. Mohon tunggu verifikasi dari kami.');
    }
}
