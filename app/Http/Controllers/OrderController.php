<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Validate manually so we can return JSON errors for AJAX
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'street'   => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user      = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty.',
            ], 422);
        }

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        try {
            $order = DB::transaction(function () use ($user, $cartItems, $total, $request) {

                $order = Order::create([
                    'user_id'        => $user->id,
                    'total'          => $total,
                    'status'         => 'pending',
                    'payment_method' => 'cash_on_delivery',
                    'recipient_name' => $request->name,
                    'phone'          => $request->phone,
                    'street'         => $request->street,
                    'barangay'       => $request->barangay,
                    'landmark'       => $request->landmark ?? null,
                ]);

                foreach ($cartItems as $item) {
                    $order->items()->create([
                        'name'     => $item->name,
                        'emoji'    => $item->emoji,
                        'price'    => $item->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                CartItem::where('user_id', $user->id)->delete();

                return $order;
            });

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to place order: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message'  => 'Order placed successfully!',
            'order_id' => $order->id,
        ], 201);
    }
}