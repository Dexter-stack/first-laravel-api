<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\welcome;



class authController extends Controller
{

    public $muser;
    //

    public function message(){
        return ['message'=>"error"];
    }

    public function register(Request $req){




        $req->validate([
    
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|confirmed|min:5|max:12'
        ]);
           $data = new users;
           $data->name = $req->name;
           $data->email = $req->email;
           $data->password = Hash::make($req->password);
           $data->save();

           $token = $data->createToken('mytoken')->plainTextToken;
           $response=[

            "user"=>$data,
            'token'=>$token


           ];
    
           if($data){
               return response($response,201);
           }else{
               return ['message'=>'error occured'];
           }
    
       }

       public function logout(Request $req){
           auth()->user()->tokens()->delete();

           return ['message'=>"you have logged out"];
       }


       public function sendMail(Request $req){

        $req->validate([
            "email"=>"required|email|exists:users"
        ]);

       $sent = Mail::to($req->email)->send(new welcome());
       if($sent){
           return ['message'=>'a mail has been sent to your email'];
       }else{
           return ['message'=>'check your mail again'];
       }

  }

  public function login(Request $req){


    $req->validate([
    
        
        "email"=>"required|email|exists:users",
        'password'=>'required|string|min:5|max:12'
    ]);
       $user = users::where('email',$req->email)->first();
        //$this->muser = $user->verified;
       //check password
    //    if(!$user && !Hash::check($req->password, $user->password)){

    //     return ["message"=>"wrong password"];
    //    }

    if(!$user){
        return ["message"=>"wrong creds"];
    }else{
        //check password
        if(Hash::check($req->password,$user->password)){
            //store user id in session
            $token = $user->createToken('mytoken')->plainTextToken;
            $response=[
     
             "user"=>$user,
             'token'=>$token
     
     
            ];
     
            if($user){
                return response($response,201);
            }else{
                return ['message'=>'error occured'];
            }
     
            

        }else{
            return ['message'=>'incorrect password '];
        }
    }


       
    //    $token = $user->createToken('mytoken')->plainTextToken;
    //    $response=[

    //     "user"=>$user,
    //     'token'=>$token


    //    ];

    //    if($user){
    //        return response($response,201);
    //    }else{
    //        return ['message'=>'error occured'];
    //    }











  }


}
