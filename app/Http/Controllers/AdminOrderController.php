<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,out_for_delivery,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.menu.index', ['tab' => 'orders'])
                         ->with('success', 'Order #' . str_pad($id, 4, '0', STR_PAD_LEFT) . ' updated!');
    }
}