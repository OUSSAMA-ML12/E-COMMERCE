<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $products = Product::inRandomOrder()->limit(3)->get();
        return view('layout_second.app',compact('products'));
    }

    public function productsClient()
    {
        $products = Product::all();
        return view('layout_second.products',compact('products'));
    }

    public function checkout()
    {
        return view('layout_second.checkout');
    }

   

    public function placeOrder(Request $request)
{
    $validator = Validator::make($request->all(), [
        'full_name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'phone' => 'required|string|max:20',
        'cart' => 'required|json',
        'total_price' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $cart = json_decode($request->cart, true);
    $orderNumber = 'ORD-' . strtoupper(uniqid());

    foreach ($cart as $item) {
        Order::create([
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'total_price' => $item['price'] * $item['quantity'],
            'is_delivered' => false,
            'client_name' => $request->full_name,
            'client_address' => $request->address,
            'client_phone' => $request->phone,
        ]);
    }

    // Retour à la même page avec un message de succès
    return back()->with([
        'success' => 'Votre commande a été passée avec succès!',
        'order_number' => $orderNumber,
        'total_amount' => $request->total_price
    ]);
}



    public function show()
    {
        
    }

}
