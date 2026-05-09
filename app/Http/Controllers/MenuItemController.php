<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Models\Order;

class MenuItemController extends Controller
{
    // READ — show all menu items
    public function index()
{
    $menuItems = MenuItem::orderBy('category')->get();
    $orders    = Order::with(['user', 'items'])->latest()->get();

    return view('admin.menu.index', compact('menuItems', 'orders'));
}

    // CREATE — show the create form
    public function create()
    {
        return view('admin.menu.create');
    }

    // CREATE — save new item to database
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'emoji'       => 'nullable|string|max:10',
            'available'   => 'nullable',
        ]);

        MenuItem::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'description' => $request->description,
            'price'       => $request->price,
            'emoji'       => $request->emoji,
            'available'   => $request->available ? 1 : 0,
        ]);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu item added successfully!');
    }

    // UPDATE — show the edit form
    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return view('admin.menu.edit', compact('menuItem'));
    }

    // UPDATE — save changes to database
    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'emoji'       => 'nullable|string|max:10',
            'available'   => 'nullable',
        ]);

        $menuItem->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'description' => $request->description,
            'price'       => $request->price,
            'emoji'       => $request->emoji,
            'available'   => $request->available ? 1 : 0,
        ]);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu item updated successfully!');
    }

    // DELETE — remove item from database
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu item deleted!');
    }
}