<?php

namespace App\Http\Controllers;

use App\Models\Subsidiary;
use Illuminate\Http\Request;

class SubsidiariesController extends Controller
{
    public function store(Request $request){
        $subsidiary = Subsidiary::create([
            "name" => $request->name,
            "ubication" => $request->ubication,
            "rif" => $request->rif,
            "enterprise_id" => auth('api')->id()
        ]);
        return response()->json([
            'message'=>'Subsidiary created successfully', 
            'Subsidiary'=>$subsidiary]);
    }

    public function show(Subsidiary $subsidiary){
        if($this->userVerify($subsidiary->enterprise_id)){
            return response()->json($subsidiary);
        }
        return response("Not authorized", 403);
    }

    protected function userVerify($enterprise_id){

        if($enterprise_id == auth('api')->id()){
            return true;
        }
        return false;
    }
}
