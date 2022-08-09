<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\users;
use App\Http\Controllers\authController;

class testAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
    
        
            "email"=>"required|email|exists:users",
            'password'=>'required|string|min:5|max:12'
        ]);

        //get user email 
        $user = users::where('email',$request->email)->first();
        

        if($user->verified == 1){
            return $next($request);
        }else{
            return response(['message'=>"you need to verify your accout "]);
        }
        
    }
}
