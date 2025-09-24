<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecController extends Controller
{
    public function index($section)
    {
        $rows=DB::table("spec")->where("section",$section)->get();
        $rows->map(function($row){
            $row->id=$row->id;
            $row->title=$row->title;
            $row->description=$row->content;
            $row->image=url($row->image);
        });
        return response()->json($rows);
    }

    public function update(Request $request, $id)
    {
        $imagePath = $request->input('image');
        
        // If new image uploaded
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/content'), $filename);
            $imagePath = '/uploads/content/' . $filename;
        }
        // Update record in database
        DB::table('spec')
            ->where('id', $id)
            ->update([
                'title'   => $request->title,
                'content' => $request->content,
                'image'   => $imagePath,
            ]);

        return response()->json(['message' => 'Updated']);
    }
}
