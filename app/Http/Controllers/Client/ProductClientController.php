<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductClientController extends Controller
{
    public function index()
    {
        return view('client.layout.app');
    }
}
