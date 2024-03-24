<?php

namespace App\Http\Controllers;

use App\Http\Resources\cartResource;
use Illuminate\Http\Request;
use App\Models\Cart;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caartItems= Cart::where('userId',auth()->id())->get();
        return cartResource::collection($caartItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'productId'=>['required'],
            'qty'=>['numeric','nullable']
        ]);
        $item= cart::where('productId',$input['productId'])
        ->where('userId',auth()->id())->first();
        if(!$item)
        {
           $input['userId']= auth()->id();
           cart::create($input);
           return response()->json(["message"=>"item is added"]);
        }
        $cartQty=$item->qty;
        if($cartQty >$item->product->qunatityInStock)
        {
            return response()->json(["message"=>"qty not avialable"]);
        }
        $item->qty= $cartQty + 1;
        $item->save();
        return response()->json(["message"=>"item is updated"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $caartItems= cart::findOrFail($id);
        return new cartResource($caartItems);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item= cart::where('productId',$id)->where('userId',auth()->id())->firstOrFail();
        $item->delete();
        return response()->json(["message"=>"item is deleted successfully"]);
    }
}
