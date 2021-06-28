<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $user = User::count();
        $order = Order::where('status', 'dipesan')->count();
        return view('index', compact('user', 'order'));
    }
}
