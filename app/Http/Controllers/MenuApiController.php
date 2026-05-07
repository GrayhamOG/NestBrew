<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;

class MenuApiController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::where('available', true)->get();
        return response()->json($menuItems);
    }
}