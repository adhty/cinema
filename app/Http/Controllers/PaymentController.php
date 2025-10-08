<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function pay(Order $order)
    {
        try {
            // Check if the order belongs to the authenticated user or is admin
            if (auth()->user()->is_admin || auth()->id() === $order->user_id) {
                $url = $this->midtrans->createTransaction($order);
                return redirect($url);
            } else {
                abort(403, 'Unauthorized to access this order');
            }
        } catch (\Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create payment: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        try {
            // Validasi notifikasi dari Midtrans
            $notif = new \Midtrans\Notification();
            
            $order = Order::find($notif->order_id);

            if (!$order) {
                Log::error('Order not found for transaction: ' . $notif->order_id);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            if ($notif->transaction_status == 'settlement') {
                $order->update(['payment' => 'paid']);
                Log::info('Payment settled for order: ' . $notif->order_id);
            } elseif ($notif->transaction_status == 'pending') {
                $order->update(['payment' => 'pending']);
                Log::info('Payment pending for order: ' . $notif->order_id);
            } elseif (in_array($notif->transaction_status, ['deny','cancel','expire','failure'])) {
                $order->update(['payment' => 'failed']);
                Log::info('Payment failed for order: ' . $notif->order_id . ' Status: ' . $notif->transaction_status);
            } elseif ($notif->transaction_status == 'capture' && strpos($notif->fraud_status, 'accept') !== false) {
                // For credit card transactions
                $order->update(['payment' => 'paid']);
                Log::info('Payment captured and accepted for order: ' . $notif->order_id);
            } elseif ($notif->transaction_status == 'capture' && strpos($notif->fraud_status, 'challenge') !== false) {
                $order->update(['payment' => 'pending']);
                Log::info('Payment captured but challenged for order: ' . $notif->order_id);
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Callback processing failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
