<?php

namespace App\Repositories\Cart ;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Cart\CartRepository;

class CartModelRepository implements CartRepository
{
    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id ;
    }

    public function get()
    {
        return Cart::where('cookie_id', '=', $this->getCookieId())->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)
        ->where('cookie_id', '=', $this->getCookieId())
        ->first();
        if(!$item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'cookie_id' => $this->getCookieId(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
            $this->get()->push($cart);
            return $cart ;
        }

        return $item->increment('quantity', $quantity);
    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)->update([
            'quantity' => $quantity,
        ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)->where('cookie_id', '=', $this->getCookieId())->delete();
    }

    public function flush()
    {
        Cart::where('cookie_id', '=', $this->getCookieId())->destroy();
    }

    public function total()
    {
        return Cart::where('cookie_id', '=', $this->getCookieId())
        ->join('products', 'products.id', '=', 'carts.products_id')
        ->selectRaw('SUM(products.price * carts.quantity) as total')
        ->value('total');
    }

}
