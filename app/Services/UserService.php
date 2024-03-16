<?php

namespace App\Services;

use App\Models\Otp;
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
        // $return = [
        //       "userId"=> 1,
        //       "id"=> 1,
        //       "title"=> "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        //       "body"=> "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
        //   ];
        $return=[];
          $data = User::get();
        //   pp($data);
          foreach ($data as $key => $value) {
            $return[] = $value;
            # code...
          }
        // $user_details = Auth::user();
        // $return['User Details'] = $user_details;
        // $return['message'] = 'Successfully Fetched';
        // $return['status'] = 'success';
        return $return;
    }

    public static function passwordReset($data)
    {
        $return = [];
        $otp = rand(1000, 9999);
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
            $updated_data = [
                'email' => isset($data->email)?$data->email:null,
                'phone_no' => isset($data->phone_no)?$data->phone_no:null,
                'otp' => $otp,
                'token' => $token,
                'created_at' => Carbon::now(),
            ];
            Otp::insert($updated_data);
            // dump("http://127.0.0.1:3000/api/user/reset/".$token);
            $message = [
                'token' => $token,
                'otp' => $otp,
                'username'=> $user->name,
            ];
            sendMail('PasswordReset', 'Reset Password', $data->email, $message);
            $return['message'] = 'Password Reset Request Successfully Sent';
            $return['token'] = $token;
            $return['otp'] = $otp;
            $return['status'] = 'success';
        } else {
            $return['message'] = 'User Not Exist';
            $return['status'] = 'Failed';
        }
        return $return;
    }

    public static function resetPassword($data){
        $return=[];
        $time=Carbon::now()->subMinutes(5)->toDateTimeString();
        PasswordReset::where('created_at','<=',$time)->delete();
        $passwordReset = PasswordReset::where('token',$data->token)->first();
        if($passwordReset){
            User::where('email',$passwordReset->email)->update(['password'=>Hash::make($data->password)]);
            PasswordReset::where('token',$data->token)->delete();
            Otp::where('token',$data->token)->delete();
            $return['message']='Password Reset Successfully';
            $return['status']='Success';
        }else{
            $return['message']='Token Invalid/Expired';
            $return['status']='failed';
        }
        return $return;
    }

    public static function getOtpByEmail($data){
        $return=[];
        $otp = Otp::select('otp')->where('email', $data->email)->orderBy('id','desc')->first();
        if($otp){
            $return['otp']=$otp;
            $return['status']='Success';
        }else{
            $return['status']='failed';
        }
        return $return;
    }

    public static function resetPasswordByOtp($data){
        $return=[];
        $time=Carbon::now()->subMinutes(5)->toDateTimeString();
        PasswordReset::where('created_at','<=',$time)->delete();
        $passwordReset = Otp::where('email',$data->email)->orderBy('id','desc')->first();
        if(isset($passwordReset) && $passwordReset->otp==$data->otp){
            User::where('email',$passwordReset->email)->update(['password'=>Hash::make($data->password)]);
            PasswordReset::where('token',$data->token)->delete();
            Otp::where('token',$data->token)->delete();
            $return['message']='Password Reset Successfully';
            $return['status']='Success';
        }else{
            $return['message']='Token Invalid/Expired';
            $return['status']='failed';
        }
        return $return;
    }

}
