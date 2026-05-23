<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('variant.product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->variant->price * $item->quantity;
        });

        $shipping = $subtotal >= 150 ? 0 : 10;

        $total = $subtotal + $shipping;

        return view('cart.index', compact(
            'cartItems',
            'subtotal',
            'shipping',
            'total'
        ));
    }

    public function add(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:variants,variant_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $existing = Cart::where('user_id', Auth::id())
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($existing) {

            $existing->increment('quantity', $request->quantity);

        } else {

            Cart::create([
                'user_id' => Auth::id(),
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'added_at' => now(),
            ]);

        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Added to cart!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();

        return back()->with('success', 'Item removed.');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Cart cleared.');
    }
}