<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('payment.edit-payment-method', compact('paymentMethods'));
    }

    public function create()
    {
        return view('payment.create-payment-method');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:payment_methods,name',
            'no_direction' => 'required|integer',
            'admin_name' => 'required|string',
        ]);

        PaymentMethod::create($validatedData);

        return redirect()->route('payment-methods.index');
    }


    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('payment.edit-payment-method', compact('paymentMethod'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'no_direction' => 'required|integer',
            'admin_name' => 'required|string',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update($validatedData);

        return redirect()->route('payment-methods.index');
    }

    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('payment-methods.index');
    }

    
}
