<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return DB::table('category')->get();
    }

    public function store(Request $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/category', 'public');
        }
        $id = DB::table('category')->insertGetId([
            'cat_name' => $request->categoryName,
            'image' => url($path ? "/storage/$path" : null),
        ]);
        return response()->json(['id' => $id]);
    }

    public function destroy($id)
    {
        DB::table('category')->where('id', $id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // public version
    public function publicList()
    {
        $rows = DB::table('category')->get();
        return $rows->map(function ($row) {
            $row->image = url($row->image);
            return $row;
        });
    }
}
