<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function register(Request $data){
        $data->validate(['name'=>'required','email'=>'required|email','password'=>'required|confirmed']);
        UserService::RegisterUser($data);
    }
}
