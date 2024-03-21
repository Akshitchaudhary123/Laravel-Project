<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use GrahamCampbell\ResultType\Success;

class UserController extends Controller
{
    public function register(Request $data){
        $data->validate(['name'=>'required','email'=>'required|email','password'=>'required|confirmed']);
        return UserService::RegisterUser($data);
    }
    public function login(Request $data){
        $data->validate(['email'=>'required|email','password'=>'required']);
        return UserService::LoginUser($data);
    }
    public function logout(Request $data){
        return UserService::LogOutUser();
    }
    public function AllData(Request $data){
        return UserService::AllData();
    }
    public function UserDetails(Request $data){
        return UserService::UserDetails($data);
    }
    public static function OpenAI(Request $data)
    {
        $data->validate(['content' => 'required|string']);
        return UserService::OpenAI($data);
    }
    public static function UploadImg(Request $data)
    {
        // $data->validate(['content' => 'required|string']);
        return UserService::uploadImg($data);
    }
}
