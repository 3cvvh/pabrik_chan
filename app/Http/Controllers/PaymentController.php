<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    if(Auth::user()->pabrik->Ispaid == true) {
        abort(404,'authenticated');
    }


    if(Auth::user()->pabrik->ispaid == false){
        $snapToken = '';
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // Pastikan ada payment record
        $pabrik_pay = Auth::user()->pabrik->payment->first();
        if (!$pabrik_pay) {
            // Jika belum ada payment, buat baru
            $pabrik_pay = Payment::create([
                'pabrik_id' => Auth::user()->pabrik->id,
                'amount' => 94000,
                'status' => 'pending'
            ]);
        }

        $user = Auth::user();
        $pabrik = Auth::user()->pabrik;
        $transaction_details = array(
            'order_id' => $pabrik_pay->invoiceNumber,
            'gross_amount' => $pabrik_pay->amount,
        );

        $customer_details = array(
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $pabrik->no_telepon,
            'billing_address' => array(
                'first_name' => $user->name,
                'phone' => $pabrik->no_telepon,
                'address' => $pabrik->alamat
            ),
            'shipping_address' => array(
                'first_name' => $user->name,
                'phone' => $pabrik->no_telepon,
                'address' => $pabrik->alamat,
            )
        );

        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details
        );


        try {
            $snapToken = Snap::getSnapToken($transaction);
            // Simpan snap token ke payment record di table payments
            $pabrik_pay->snap_token = $snapToken;
            $pabrik_pay->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    $judul = "payment|page";
    return view("payment.berlangganan", compact("judul", "snapToken"));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $judul = "payment|page";
        return view("payment.detail",compact('judul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
    public function success()
    {
        $judul = "payment|success";
        return view("payment.berhasil",compact('judul'));
    }
    public function handleCallback(){
        \Midtrans\Config::$serverKey = config("midtrans.server_key");
        \Midtrans\config::$isProduction = config("midtrans.is_production");
        $notif = new \Midtrans\Notification();
        $transaksi = $notif->transaction_status;
        $fraud = $notif->fraud_status;
        #dpt kan order id
        $order_id = $notif->order_id;


        $order = Payment::where('invoiceNumber',$order_id)->first();
        if(!$order){
            return response()->json(['message' => 'Order not found'],404);
        }
if ($transaksi === 'capture') {
            if ($fraud === 'challenge') {
                $this->changeStatus($order,"challange",$notif);
            } elseif ($fraud === 'accept') {
                $this->changeStatus($order,"sukses",$notif);
            }
        } elseif ($transaksi === 'cancel' || $transaksi === 'expire' || $transaksi === 'deny') {
            $this->changeStatus($order,"gagal",$notif);
        } elseif ($transaksi === 'settlement') {
            $this->changeStatus($order,"sukses",$notif);
        } elseif ($transaksi === 'pending') {
            $this->changeStatus($order,"pending",$notif);
        }
return response()->json(['success' => true],200);
    }
protected function changeStatus ( $order, string $status, $notif){
 $order->status = $status;
 if($status == 'gagal'){
    $order->snap_token = null;
 }
        $order->save();

        if ($status === 'sukses' && $order->pabrik) {
            $pabrik = $order->pabrik;
            $pabrik->ispaid = true;
            $pabrik->save();
        }
}
}
