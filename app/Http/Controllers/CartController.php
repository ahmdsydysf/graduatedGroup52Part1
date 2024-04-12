<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        $items = $cart->get();

        return view('front.all_cart', compact('items'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required' , 'int' , 'exists:products,id'],
            'quantity' => ['nullable' , 'int' , 'min:1'],
        ]);
        $product = Product::findOrFail($request->product_id);
        $cart->add($product, $request->quantity);

        return to_route('carts.index');

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required' , 'int' , 'exists:products,id'],
            'quantity' => ['nullable' , 'int' , 'min:1'],
        ]);
        $product = Product::findOrFail($request->product_id);

        $cart->update($product, $request->quantity);

        return to_route('carts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart, $id)
    {
        $cart->delete($id);
    }
}
