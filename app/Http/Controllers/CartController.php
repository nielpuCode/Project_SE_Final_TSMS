<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\PaymentMethod;

class CartController extends Controller
{
    public function index()
    {
        // Retrieve cart items for the authenticated user from the database
        $cartItems = CartItem::where('user_id', auth()->id())->get();

        // Pass the cart items and payment methods to the view
        return view('cart.main-cart', compact('cartItems'));
    }

    public function storeOrder(Request $request)
    {
        // Retrieve cart items from the database
        $cartItems = CartItem::where('user_id', auth()->id())->get();

        // Calculate the total amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->component->price;
        });

        // Calculate the tax amount
        $taxAmount = $totalAmount * 0.05;

        // Calculate the total amount with tax
        $totalAmountWithTax = $totalAmount + $taxAmount;

        // Create a new order
        $order = new Order();
        $order->order_name = Str::random(12);
        $order->user_id = auth()->id();
        $order->total_amount = $totalAmount;
        $order->tax_amount = $taxAmount;
        $order->total_amount_with_tax = $totalAmountWithTax;

        if ($request->has('payment_method')) {
            $order->payment_method = $request->payment_method;
        }

        $order->save();

        // Reduce the quantity of components in the comp_components table
        foreach ($cartItems as $cartItem) {
            $component = $cartItem->component;
            $component->quantity -= $cartItem->quantity;

            // If the quantity is 0, remove the component
            if ($component->quantity <= 0) {
                $component->delete();
            } else {
                $component->save();
            }
        }

        // Clear the cart for the user
        CartItem::where('user_id', auth()->id())->delete();

        // Redirect to the order history page
        return redirect()->route('showOrders')->with('success', 'Order placed successfully.');
    }


    public function showOrders()
    {
        if (auth()->user()->name === 'tsms' && auth()->user()->email === 'tsms@gmail.com') {
            $orders = Order::all();
        } else {
            $orders = Order::where('user_id', auth()->id())->get();

        }

        // Pass the orders to the view
        return view('order.order', compact('orders'));
    }


    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('showOrders')->with('success', 'Order deleted successfully.');
    }



    public function toPayment(Request $request)
    {
        // Retrieve cart items for the authenticated user from the database
        $cartItems = CartItem::where('user_id', auth()->id())->get();

        // Calculate the total amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->component->price;
        });

        // Retrieve payment methods from the database
        $paymentMethods = PaymentMethod::all();

        // Pass the cart items and total amount to the view
        // return view('payment.payment', compact('cartItems', 'totalAmount'));
        return view('payment.payment', compact('cartItems', 'totalAmount', 'paymentMethods'));
    }


    public function addItemToCart(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'component_id' => 'required|exists:comp_components,id',
        ]);

        // Check if the item already exists in the cart for the current user
        $existingCartItem = CartItem::where('user_id', auth()->id())
                                     ->where('comp_component_id', $request->component_id)
                                     ->first();

        // If the item already exists in the cart, update the quantity
        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => $existingCartItem->quantity + 1,
            ]);
        } else {
            // If the item doesn't exist in the cart, create a new cart item
            CartItem::create([
                'user_id' => auth()->id(),
                'comp_component_id' => $request->component_id,
                'quantity' => 1, // Set default quantity to 1
            ]);
        }

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Item added to cart successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('showCart')->with('success', 'Cart item quantity updated successfully.');
    }

    public function destroy($id)
    {
        // Find the cart item by ID and delete it
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        // Redirect back to the cart page with a success message
        return redirect()->route('showCart')->with('success', 'Item removed from cart successfully.');
    }
}
