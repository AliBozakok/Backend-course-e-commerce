<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $categoy= Category::all();
      return response()->json(["data"=>$categoy]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate(['name'=>['required','string']]);
        Category::create($input);
        return response()->json(["message"=>"categoy is added successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoy=Category::findOrFail($id);
        return response()->json(["data"=>$categoy]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input= $request->validate(['name'=>['required','string']]);
        $categoy=Category::findOrFail($id);
        $categoy->update($input);
        return response()->json(["message"=>"categoy is updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoy=Category::findOrFail($id);
        $categoy->delete();
        return response()->json(["message"=>"categoy is deleted successfully"]);
    }
}
