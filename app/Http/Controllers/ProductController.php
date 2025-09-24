<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getByCategory($categoryId)
    {
        return DB::table('product')
            ->join('category', 'category.id', '=', 'product.cat_id')
            ->where('product.cat_id', $categoryId)
            ->select('product.*', 'category.cat_name')
            ->get();
    }

    public function store(Request $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/products', 'public');
        }
        $id = DB::table('product')->insertGetId([
            'cat_id' => $request->cat_id,
            'model' => $request->model,
            'description' => $request->description,
            'image' => url($path ? "/storage/$path" : null),
        ]);
        return response()->json(['id' => $id]);
    }

    public function update(Request $request)
    {
        $id=$request->id;
        DB::table('product')->where('id', $id)->update([
            'cat_id' => $request->cat_id,
            'model' => $request->model,
            'description' => $request->description,
            'image' => $request->image,
        ]);
        return response()->json(['message' => 'Updated']);
    }

    public function destroy($id)
    {
        DB::table('product')->where('id', $id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // public version
    public function publicByCategory($categoryId)
    {
        $rows = DB::table('product')->where('cat_id', $categoryId)->get();
        return $rows->map(function ($row) {
            $row->image = url($row->image);
            return $row;
        });
    }
}
