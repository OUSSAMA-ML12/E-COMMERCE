<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{
    //


    public function index()
    {
        $products = Product::all(); 
        View('frontEnd.app',compact('products'));
    }
}
