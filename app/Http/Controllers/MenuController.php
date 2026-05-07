<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return view('menu');
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
        ]);

        MenuItem::create($request->all());

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu item added successfully!');
    }

    // UPDATE — show the edit form
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu.edit', compact('menuItem'));
    }

    // UPDATE — save changes to database
    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'emoji'       => 'nullable|string|max:10',
        ]);

        $menuItem->update($request->all());

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu item updated successfully!');
    }

    // DELETE — remove item from database
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu item deleted successfully!');
    }
}