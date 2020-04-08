<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Veritrans_Notification;

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

    public function  payment(Request $request) {

        if(DB::table('transactions')->where('user_id', Auth::user()->id)->doesntExist()) {

            $transaction = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => 150000,
                ),
                'item_details' => array(
                    array(
                        'id' => 'fee',
                        'price' => 150000,
                        'quantity' => 1,
                        'name' => "Biaya Pendaftaran Virtual Run Reuni Akbar SMAN 3",
                    ),
                ),
            );

            $snapToken = Midtrans\Snap::getSnapToken($transaction);

            DB::table('transactions')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'snap_token' => $snapToken,
                ]);

        } else {
            $snapToken = DB::table('transactions')
                ->where('user_id', Auth::user()->id)
                ->value('snap_token');
        }

        return view('pages.racepayment',['snapToken' => $snapToken]);
    }

    public function paymentNotification(Request $request) {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_ID');
        $notif = new Veritrans_Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        DB::table('transactions')
            ->where('user_id', Auth::user()->id)
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
                ->where('user_id', Auth::user()->id)
                ->update(['status' => $transaction]);
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

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        $imageName = time().'-'.Auth::user()->id.'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('progress'), $imageName);

        DB::table('participants')
            ->where('user_id', Auth::user()->id)
            ->update([
                'image' => $imageName,
                'submit_at' => date('Y-m-d H:i:s', time())]);

        return redirect('/info')
            ->with('success','Gambar berhasil diupload. Mohon tunggu verifikasi dari kami.');
    }
}
