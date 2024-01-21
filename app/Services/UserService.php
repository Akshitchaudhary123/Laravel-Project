<?php

namespace App\Services;

use App\Models\User;

class UserService{
    public static function RegisterUser($data){
        $return=[];
        //checking is email already exist
        if(User::where('email',$data->email)->first){
            $return['message']='Email Already Exist';
            return $return;
        }else{
            
        }
    }
}