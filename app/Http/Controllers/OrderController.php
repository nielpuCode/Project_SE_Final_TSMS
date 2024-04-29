<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;


class OrderController extends Controller
{
    public function showOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('order.order', compact('order'));
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}
