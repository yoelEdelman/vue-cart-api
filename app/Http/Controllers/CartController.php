<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::all()->load('product');

        return response()->json($cart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 422);
        }
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['error' => true, 'message' => 'Product with ID '. $request->product_id . ' not found'], 404);
        }

        $cart = Cart::where('product_id', $request->product_id)->first();

        if ($cart) {
            $cart->quantity += 1;
        }
        else {
            $cart = new Cart();
            $cart->quantity = 1;
            $cart->product_id = $request->product_id;
        }
        $cart->save();

        $cart->load('product');
        return response()->json($cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        Cart::truncate();

        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $cart = Cart::where('product_id', $id)->first();
        if (!$cart) {
            return response()->json(['error' => true, 'message' => 'Product with ID '. $id . ' not found'], 404);
        }
        $cart->delete();

        return response()->json([], 200);


    }
}
