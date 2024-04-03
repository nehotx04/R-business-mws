<?php

namespace App\Http\Controllers;

use App\Models\Subsidiary;
use Illuminate\Http\Request;

class SubsidiariesController extends Controller
{
    //function to verify if loged user is the same to the subsidiary owner
    protected function userVerify($enterprise_id){

        if($enterprise_id == auth('api')->id()){
            return true;
        }
        
        return false;
    }

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

    public function index(){
        $subsidiaries = Subsidiary::where('enterprise_id','=',auth('api')->id())->paginate(10);
        return response()->json(["message"=>"Request successfull","subsidiaries"=>$subsidiaries]);
    }

    public function destroy(Subsidiary $subsidiary){
        if($this->userVerify($subsidiary->enterprise_id)){
            $subsidiary->delete();
            return response("Subsidiary deleted successfully");
        }
        return response("Not authorized", 403);
    }

    public function update(Subsidiary $subsidiary,Request $request){
        if($this->userVerify($subsidiary->enterprise_id)){
            $subsidiary->name = $request->name;
            $subsidiary->ubication = $request->ubication;
            $subsidiary->rif = $request->rif;
            $subsidiary->save();
            return response()->json(["message"=>"Subsidiary updated successfully","Subsidiary"=>$subsidiary]);
        }
        return response("Not authorized", 403);
    }
}
