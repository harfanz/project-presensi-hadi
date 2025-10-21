<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request){
       if(Auth::guard('users')->attempt(['id_pkl' => $request->id_pkl, 'password' => $request->password])){
        return redirect('/dashboard');
       }else{
        return redirect('/')->with(['warning' =>'Id/Password salah']);
       }
    }


    public function proseslogout()
    {
        if(Auth::guard('users')-> check()){
            Auth::guard('users')->logout();
            return redirect('/');
        }

    }

    public function proseslogoutadmin()
    {
        if(Auth::guard('admin')-> check()){
            Auth::guard('admin')->logout();
            return redirect('/panel');
        }
    }

    public function prosesloginadmin(Request $request){
       if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
        return redirect('/panel/dashboardadmin');
       }else{
        return redirect('/panel')->with(['warning' =>'Email/Password salah']);
       }
    }
}
