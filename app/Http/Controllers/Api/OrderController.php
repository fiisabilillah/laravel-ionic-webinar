<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Midtrans\Config;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function history(Request $request)
    {

        $orders = Order::with('user')
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->where('orders.user_id', $request->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ], 201);
    }
    function store(Request $request)
    {

        //     var_dump($request->all());
        //  exit();
        // Set konfigurasi Midtrans
        Config::$clientKey = config('midtrans.clientKey'); //untuk core api
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $tanggal = Carbon::now();

        $order = Order::create([
            'user_id' => $request->user_id,
            'tanggal' => $tanggal,
            'jumlah_barang' => $request->jumlah_barang,
            'jumlah_harga' => $request->jumlah_harga,
            'kode' => mt_rand(100, 999),
            'status' => 'Pending',
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $request->jumlah_harga,
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        foreach ($request->items as $item) {
            $barang = Barang::where('id', $item['id'])->first();
            $orderdetail = OrderDetail::create([
                'order_id' => $order->id,
                'barang_id' => $item['id'],
                'harga' => $item['quantity'] * $barang->harga,
                'jumlah' => $item['quantity'],
            ]);
        }

        $order = Order::find($order->id);
        $order->token_midtrans = $snapToken;
        $order->update();

        return response()->json([
            'success' => true,
            'url' => $order,
            'message' => 'Order Created',
        ], 201);
    }

    function handle(Request $request)
    {
        $notif = new \Midtrans\Notification();
        $transaction = $notif->transaction_status;
        $fraud = $notif->fraud_status;
        return response()->json($notif);
        $order = Order::find($notif->order_id);
        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $order->status =  $fraud;
            } else if ($fraud == 'accept') {
                $order->status = $transaction;
            }
        } else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
                $order->status =  $fraud;
            } else if ($fraud == 'accept') {
                $order->status =  $fraud;
            }
        } else if ($transaction == 'deny') {
            $order->status =  $transaction;
        }

        $order->update();
    }

    function status(Request $request)
    {
        $status = \Midtrans\Transaction::status($request->order_id);
        return response()->json([
            'success' => true,
            'data' => $status
        ], 201);
    }
}
