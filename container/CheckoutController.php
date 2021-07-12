<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function shipping(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'country' => 'required|alpha_num',
            'address' => 'required|string',
            'city' => 'required|alpha_num',
            'state' => 'required|alpha_num',
            'zipcode' => 'required|alpha_num',
            'phone' => 'required|numeric',
        ]);

        if($validator->fails()){
            return redirect('checkout')->withInput()->withErrors($validator);
        }

        $cart = session()->get('cart');
        $user_id = Auth::user()->id;
        $create = 0;
        if($user_id){
            if($cart)
            {
                $total_price = 0;
                // Orders
                foreach (session('cart') as $id => $details){
                    $total_price = $total_price + ($details['quantity'] * $details['price']);
                }
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $order  = $api->order->create(array('receipt' => rand(1000, 9999) . 'ORD', 'amount' => $total_price * 100, 'currency' => 'INR')); // Creates order
                $orderId = $order['id'];
                foreach (session('cart') as $id => $details){
                    $product_id = $id;
                    $sub_total = $details['quantity'] * $details['price'];
                    $quantity = $details["quantity"];

                    $create = Shipping::create
                    ([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'sub_total' => $sub_total,
                        'order_id' => $orderId,
                        'name' => $request->name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zipcode' => $request->zipcode,
                        'phone' => $request->phone
                    ]);

                }
            }
        }
        if($create == true){
            session()->put('phone', $request->phone);
            session()->put('order_id', $orderId);
            session()->put('amount', $total_price);
            return redirect('razorpay-payment');
        }
    }

    public function payment(Request $request)
    {
        if($request->razorpay_order_id)
        {
            $update = Shipping::whereIn('order_id', [$request->razorpay_order_id])->update
            ([
                'razorpay_id' => $request->razorpay_payment_id,
                'payment_status' => true,
                'signature' => $request->razorpay_signature
            ]);

            if($update == true){
                $cart = session()->get('cart');
                unset($cart);
                return redirect('/Thank-You');
            }
        }
    }
}
