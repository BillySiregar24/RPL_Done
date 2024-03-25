<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(){
        $menu = Menu::whereNull('parent_menu')
        ->with(['submenu'=>fn($q) => $q->orderBy('urutan_menu', 'asc')])
        ->orderBy('urutan_menu', 'asc')
        ->get();
    dd($menu);
    }
}
