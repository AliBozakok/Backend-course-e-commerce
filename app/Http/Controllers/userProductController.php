<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class userProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q=product::query();
        if($request->has('tilte'))
        {
            $q->where('title','LIKE',$request->tilte.'%');
        }
       // $prodcuts= product::getActive()->get();
       $products= $q->getActive()->get();
        return response()->json(["data"=>$products]);
    }

    public function show(string $id)
    {
        $product= product::findOrFail($id);
        return response()->json(["data"=>$product]);
    }

   public function recent()
   {
    $products= product::getActive()->orderBy('craeted_at','desc')->get();
    return response()->json(["data"=>$products]);
   }
}
