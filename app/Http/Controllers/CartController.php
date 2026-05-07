<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // GET — return all cart items for logged in user
    public function index()
    {
        $items = CartItem::where('user_id', Auth::id())->get();
        $total = $items->sum(fn($item) => $item->price * $item->quantity);

        return response()->json([
            'items' => $items,
            'total' => number_format($total, 2)
        ]);
    }

    // POST — add item to cart
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'emoji' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Check if item already exists in cart
        $existing = CartItem::where('user_id', Auth::id())
                            ->where('name', $request->name)
                            ->first();

        if ($existing) {
            // Just increase the quantity
            $existing->increment('quantity');
            $item = $existing;
        } else {
            // Add new item
            $item = CartItem::create([
                'user_id'  => Auth::id(),
                'name'     => $request->name,
                'emoji'    => $request->emoji,
                'price'    => $request->price,
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $request->name . ' added to cart!',
            'item'    => $item
        ]);
    }

    // DELETE — remove one item from cart
    public function destroy($id)
    {
        $item = CartItem::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        $item->delete();

        return response()->json(['success' => true]);
    }

    // PATCH — update quantity
    public function update(Request $request, $id)
    {
        $item = CartItem::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true, 'item' => $item]);
    }

    // DELETE — clear entire cart
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}