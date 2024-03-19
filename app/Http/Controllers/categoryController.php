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
        $category= Category::all();
        return response()->json(["data"=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'name'=>['required','string'
            ]]);
            Category::create($input);
            return response()->json(["message"=>"category is added successfully"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=Category::findOrFail($id);
        return response()->json(["data"=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input=$request->validate([
            'name'=>['required','string']
        ]);
        $category=Category::findOrFail($id);
        $category->update($input);
        return response()->json(["message"=>"category is updated successfully"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::findOrFail($id);
        $category->delete();
        return response()->json(["message"=>"category is deleted successfully"]);

    }
}
