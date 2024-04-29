<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\CartItem;


class PaymentController extends Controller
{
    public function addToPayment(Request $request)
    {
        $validatedData = $request->validate([
            'cart_id' => 'required|exists:cart_items,id',
            'comp_component_id' => 'required|exists:cart_items,comp_component_id',
        ]);

        Payment::create([
            'user_id' => auth()->id(),
            'cart_id' => $validatedData['cart_id'],
            'comp_component_id' => $validatedData['comp_component_id'],
        ]);
    }
}

