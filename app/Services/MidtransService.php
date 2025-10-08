<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Exception;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($order)
    {
        try {
            // Ensure we have all required data
            if (!$order || !$order->user) {
                throw new Exception('Order or user data is missing');
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? '',
                ],
                'item_details' => [
                    [
                        'id' => $order->id,
                        'price' => $order->total_price,
                        'quantity' => 1,
                        'name' => 'Cinema Ticket - ' . ($order->seat->ticket->movie->title ?? 'Movie Ticket'),
                    ]
                ],
            ];

            $snapToken = Snap::createTransaction($params);
            return $snapToken->redirect_url;
        } catch (Exception $e) {
            Log::error('Midtrans transaction creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
