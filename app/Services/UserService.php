<?php

namespace App\Services;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public static function RegisterUser($data)
    {
        $return = [];
        //checking is email already exist
        if (User::where('email', $data->email)->first()) {
            $return['message'] = 'Email Already Exist';
            $return['status'] = 'Failed';
        } else {
            $details = [
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'remember_token' => $data->remember_token,
            ];
            $user = User::insertUserDetails($details);
            $token = $user->createToken($data->email)->plainTextToken;
            $return['message'] = 'Successfully Registered';
            $return['token'] = $token;
            $return['status'] = 'Success';
        }
        return $return;
    }
    public static function LoginUser($data)
    {
        $return = [];
        //checking is email exist
        $user = User::where('email', $data->email)->first();
        //checking is password match
        if ($user && Hash::check($data->password, $user->password)) {
            $token = $user->createToken($data->email)->plainTextToken;
            $return['message'] = 'Successfully Login';
            $return['token'] = $token;
            $return['status'] = 'Success';
        } else {
            $return['message'] = 'Invalid User or Password';
            $return['status'] = 'Failed';
        }
        return $return;
    }

    public static function LogOutUser()
    {
        $return = [];
        Auth::user()->tokens()->delete();
        $return['message'] = 'Successfully LogOut';
        $return['status'] = 'success';
        return $return;
    }

    public static function UserDetails()
    {
        $return = [];
        $user_details = Auth::user();
        $return['User Details'] = $user_details;
        $return['message'] = 'Successfully Fetched';
        $return['status'] = 'success';
        return $return;
    }
    public static function passwordReset($data)
    {
        $return = [];
        //checking if email exist
        $user = User::select('name')->where('email', $data->email)->first();
        if ($user) {
            $token = Str::random(60); //generating token
            $updated_data = [
                'email' => $data->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ];
            PasswordReset::insert($updated_data);
            // dump("http://127.0.0.1:3000/api/user/reset/".$token);
            $message = [
                'token' => $token,
                'username'=> $user->name,
            ];
            sendMail('PasswordReset', 'Reset Password', $data->email, $message);
            $return['message'] = 'Password Reset Request Successfully Sent';
            $return['status'] = 'success';
        } else {
            $return['message'] = 'User Not Exist';
            $return['status'] = 'Failed';
        }
        return $return;
    }
}
