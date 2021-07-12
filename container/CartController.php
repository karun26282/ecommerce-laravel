<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {
        return view('cart');
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $id = $request->id;

        if($id)
        {
            $product = Product::find($id);
            if(!$product){
                abort(404);
            }

            $cart = session()->get('cart');

            if(!$cart)
            {
                $cart = [
                    $id => [
                        'title' => $product->title,
                        'quantity' => 1,
                        'price' => $product->price,
                        'color' => $product->color,
                        'image' => $product->image,
                        'sku' => $product->sku
                    ]
                ];

                session()->put('cart', $cart);

                return response('Product added successfully to cart');
            }

            if(isset($cart[$id])){
                $cart[$id]['quantity']++;
                session()->put('cart',$cart);

                return response('Product added successfully to cart');
            }

            $cart[$id] = [
                'title' => $product->title,
                'quantity' => 1,
                'price' => $product->price,
                'color' => $product->color,
                'image' => $product->image,
                'sku' => $product->sku
            ];
            session()->put('cart', $cart);

            return response('Product added successfully to cart');
        }
    }

    public function addQty(Request $request){
        $validator = Validator::make($request->all(),[
            'qty' => 'required|numeric',
            'id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $cart = session()->get('cart');

        if(!empty($cart[$request->id]))
        {
            if($request->qty > 0)
            {
                $cart[$request->id]['quantity'] = $request->qty;
                session()->put('cart', $cart);
            }
        }
    }

    public function minusQty(Request $request){
        $validator = Validator::make($request->all(),[
            'qty' => 'required|numeric',
            'id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $cart = session()->get('cart');

        if(!empty($cart[$request->id]))
        {
            if($request->qty > 0)
            {
                $cart[$request->id]['quantity'] - 1;
                session()->put('cart', $cart);
            }
        }
    }
    public function deleteItem(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $cart = session()->get('cart');

        if(!empty($cart[$request->id]))
        {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            return response('Product remove successfully');
        }
    }
}
