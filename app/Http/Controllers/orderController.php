<?php

namespace App\Http\Controllers;

use App\Http\Resources\orderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrderItem;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders= Order::where('userId',auth()->id())->get();
        return orderResource::collection($orders) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'address'=>['required'],
            'phone'=>['required']
        ]);
        $orderId= Order::latest()->first();
        if($orderId == null)
        {
           $orderId=1;
        }
        else
        {
           $orderId= $orderId+1;
        }
        $caartItems= cart::where('userId',auth()->id())->get();
        $orderTotal= 0;
        foreach($caartItems as $item)
        {
            OrderItem::craete([
                'orderId'=>$orderId,
                'productId'=>$item->productId,
                'qty'=>$item->qty
            ]);
            $item->decrease();
            $orderTotal= $orderTotal + $item->total;
            $item->delete();
        }
        Order::create([
            'userId'=>auth()->id(),
            'total'=>$orderTotal,
            'address'=>$input['address'],
            'phone'=>$input['phone']
        ]);
        return response()->json(["message"=>"order is created Finsh!"]);

        }

}
