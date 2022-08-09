<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\w_list;
use App\Models\users;
use Validator;
use Illuminate\Support\Facades\Hash;
class MainController extends Controller
{
    //
   public function getData(){
       return ['data'=>w_list::all()];
   }

   public function getDataById($id){
       $data = w_list::find($id);
       if($data){
           return $data;
       }else{
           return ['message'=>"the user does not exist"];
       }


   }

   public function saveData(Request $req){

    $rules = array(

        'email'=>'required|unique:w_list|email'




    );
    $validator = Validator::make($req->all(),$rules);

    if($validator->fails()){
        return $validator->errors();
    }else{



    $data = new w_list;
    $data->email = $req->email;

    $res = $data->save();
    if($res){
        return ['message'=>'Data inserted successfully'];
    }else{
        return ['message'=>'error occured'];
    }



    }



    

   }
   public function update(Request $req){
       $data = w_list::find($req->id);
       $data->email = $req->email;
       $res= $data->save();
       if($res){
           return ['message'=>'Data Updated successfully'];
       }else{
           return ['message'=>'error occured'];
       }

       
   }

   public function delete($id){
       $data = w_list::find($id);
       $result = $data->delete();
       if($result){
           return ['message'=>"email deleted successfully"];
       }else{
           return ['message'=>"error occured"];
       }
   }

   public function createUser(Request $req){




    $req->validate([

        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:5|max:12'
    ]);
       $data = new users;
       $data->name = $req->name;
       $data->email = $req->email;
       $data->password = Hash::make($req->password);
       $data->save();

       if($data){
           return ['message'=>"data saved "];
       }else{
           return ['message'=>'error occured'];
       }

   }








}
