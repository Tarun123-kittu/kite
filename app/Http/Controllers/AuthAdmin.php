<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthAdmin extends Controller
{
    
    public static function login(User $auth){
            Session::put('admin',$auth);
    }

    public static function isLoggedIn(){
        return Session::has('admin');
    }

    public static function redo(User $auth){
            Session::put('admin',$auth);
    }

    public static function check(){
        return $check=User::where('id',Session::get('admin')->id)->first();
    }

    public static function user(){
        return Session::get('admin');
    }

    public static function logout(){
            Session::flush();        
    }
}
