<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function pay(Order $order)
    {
        $url = $this->midtrans->createTransaction($order);

        return redirect($url);
    }

    public function callback(Request $request)
    {
        // Validasi notifikasi dari Midtrans
        $notif = new \Midtrans\Notification();

        $order = Order::find($notif->order_id);

        if ($notif->transaction_status == 'settlement') {
            $order->update(['payment' => 'paid']);
        } elseif ($notif->transaction_status == 'pending') {
            $order->update(['payment' => 'pending']);
        } elseif (in_array($notif->transaction_status, ['deny','cancel','expire'])) {
            $order->update(['payment' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }
}
