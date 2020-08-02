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

    public function payment(Request $request) {

        $id = Auth::user()->id;
        $race = DB::table('user_race_categories')->where('users_id',$id)->value('race_category_id');
        $jersey = DB::table('user_jerseys')->where('users_id',$id)->value('jersey_size');
        $donate = DB::table('user_donations')->where('users_id',$id)->value('donations_id');

        $raceType = DB::table('race_category')->where('id',$race)->value('type');
        $racePrice = DB::table('race_category')->where('id',$race)->value('price');
        $jerseyPrice = DB::table('jersey')->where('size',$jersey)->value('price');
        $donatePrice = DB::table('donations')->where('id',$donate)->value('price');
        $user = DB::table('users')->where('id',$id)->first();

        return view('race.payment',compact('user','raceType','racePrice','donatePrice','jerseyPrice','jersey'));
    }

    public function requestMidtrans() {

        $id = Auth::user()->id;
        $race = DB::table('user_race_categories')->where('users_id',$id)->value('race_category_id');
        $jersey = DB::table('user_jerseys')->where('users_id',$id)->value('jersey_size');
        $donate = DB::table('user_donations')->where('users_id',$id)->value('donations_id');

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
                'total_price' => $transaction['transaction_details']['gross_amount'],
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
    }

    public function payComplete() {
        return redirect('/info');
    }

    public function handleUpload(Request $request) {
        request()->validate([

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        $imageName = time().'-'.Auth::user()->id.'-'.Auth::user()->name.'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('progress'), $imageName);

        return redirect('/info')
            ->with('success','Gambar berhasil diupload. Mohon tunggu verifikasi dari kami.');
    }
}
