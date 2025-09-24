<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        $profile=DB::table("profile")->where("id",1)->first();
        return response()->json($profile);
    }
    public function update(Request $request)
    {
        DB::table("profile")->where("id",1)
        ->update([
            "phone"=>$request->phone,
            "email"=>$request->email,
            "address"=>$request->address,
        ]);
        return response()->json([
            "message"=>"success updated profile"
        ]);
    }
}
