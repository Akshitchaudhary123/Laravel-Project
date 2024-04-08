<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Storage;

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
        $data->validate(['email' => 'required|string']);
        return UserService::uploadImg($data);
    }
    public static function getImg(Request $data)
    {
        $data->validate(['email' => 'required|string']);
        return UserService::getImg($data);
    }
    public static function removeImg(Request $data)
    {
        $data->validate(['email' => 'required|string']);
        return UserService::removeImg($data);
    }
    public static function downloadImg(Request $data)
    {
        $data->validate(['email' => 'required|string']);
        $details = File::getPath($data->email);
        $url = $details['url'];
        if(!isset($url)){throw new Exception("No Image Found");
        }
        $contents = file_get_contents($url);
        // $filename = "ProfilePhoto";
        $filename = basename($url);
        Storage::put('public/' . $filename, $contents);
        return response()->download(storage_path('app/public/' . $filename));
    }
    public static function downloadPdf(Request $data)
    {
        $data->validate(['email' => 'required|string']);
        $details = File::getPath($data->email);
        $url = $details['url'];
        if(!isset($url)){throw new Exception("No Image Found");
        }
        $contents = file_get_contents($url);
        $filename = basename($url);
        Storage::put('public/' . $filename, $contents);
        return response()->download(storage_path('app/public/' . $filename),$filename);
    }
}
