<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\File;
use App\Models\PersonalAccessToken as ModelsPersonalAccessToken;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
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
            sendMail('SuccessfullyRegistered', 'Registration Successful', $data->email);
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

    public static function AllData()
    {
        // $return = [
        //       "userId"=> 1,
        //       "id"=> 1,
        //       "title"=> "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        //       "body"=> "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
        //   ];
        $return = [];
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
                'email' => isset($data->email) ? $data->email : null,
                'phone_no' => isset($data->phone_no) ? $data->phone_no : null,
                'otp' => $otp,
                'token' => $token,
                'created_at' => Carbon::now(),
            ];
            Otp::where('email', $data->email)->delete();
            Otp::insert($updated_data);
            // dump("http://127.0.0.1:3000/api/user/reset/".$token);
            $message = [
                'token' => $token,
                'otp' => $otp,
                'username' => $user->name,
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

    public static function resetPassword($data)
    {
        $return = [];
        $time = Carbon::now()->subMinutes(5)->toDateTimeString();
        PasswordReset::where('created_at', '<=', $time)->delete();
        $passwordReset = PasswordReset::where('token', $data->token)->first();
        if ($passwordReset) {
            User::where('email', $passwordReset->email)->update(['password' => Hash::make($data->password)]);
            PasswordReset::where('token', $data->token)->delete();
            Otp::where('token', $data->token)->delete();
            $return['message'] = 'Password Reset Successfully';
            $return['status'] = 'Success';
        } else {
            $return['message'] = 'Token Invalid/Expired';
            $return['status'] = 'failed';
        }
        return $return;
    }

    public static function getOtpByEmail($data)
    {
        $return = [];
        $otp = Otp::select('otp')->where('email', $data->email)->orderBy('id', 'desc')->first();
        if ($otp) {
            $return['otp'] = $otp;
            $return['status'] = 'Success';
        } else {
            $return['status'] = 'failed';
        }
        return $return;
    }

    public static function resetPasswordByOtp($data)
    {
        $return = [];
        $time = Carbon::now()->subMinutes(5)->toDateTimeString();
        PasswordReset::where('created_at', '<=', $time)->delete();
        $passwordReset = Otp::where('email', $data->email)->orderBy('id', 'desc')->first();
        if (isset($passwordReset) && $passwordReset->otp == $data->otp) {
            User::where('email', $passwordReset->email)->update(['password' => Hash::make($data->password)]);
            PasswordReset::where('token', $data->token)->delete();
            Otp::where('token', $data->token)->delete();
            $return['message'] = 'Password Reset Successfully';
            $return['status'] = 'Success';
        } else {
            $return['message'] = 'Token Invalid/Expired';
            $return['status'] = 'failed';
        }
        return $return;
    }

    public static function OpenAI($data)
    {
        $request = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "system",
                    "content" => $data['content']
                ]
            ]
        ];
        $req = json_encode($request);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . getenv('OPENAI_API_KEY') ?? '',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $response = curl_exec($ch);

        curl_close($ch);
        $result = json_decode($response);
        $content = $result->choices[0]->message->content;
        $return = [];
        $return['content'] = $content;
        return $return;
    }

    public static function uploadImg($request)
    {
        $return=[];
        if (User::where('email', $request->email)->first()) {
            // $uploadedFileUrl = Cloudinary::upload($request->file('file')->getRealPath())->getSecurePath();
            $result = $request->file->storeOnCloudinary('ProfileImage');
            $uploadedFileUrl = $result->getPath();
            $uploadedFilePublicId = $result->getPublicId();
            $details=[
                'email' => isset($request->email)?$request->email:null,
                'phone_no' => isset($request->phone_no)?$request->phone_no:null,
                'url' => $uploadedFileUrl,
                'public_id' => $uploadedFilePublicId,
            ];
            File::savePath($details);
            $return['url']=$uploadedFileUrl;
        }else{
            throw new Exception("Invalid User");   
        }
        return $return;
    }

    public static function UserDetails($request)
    {
        $return = [];
        $details = [];
        if(!empty($request->token)){
            $details = ModelsPersonalAccessToken::select('name')->where('token', $request->token)->first();
        };
        $request->email = (isset($details['name']))?$details['name']:$request->email;
        $data = User::where('email', $request->email)->get();
        $url = File::getPath($request->email);
        if (!empty($url['url'])) {
            $return['url'] = $url['url'];
        }else{
            $return['url'] = $url['url'];
        }
        // $user_details = Auth::user();
        $return['User Details'] = $data;
        $return['message'] = 'Successfully Fetched';
        $return['status'] = 'success';
        return $return;
    }

    public static function getImg($request)
    {
        $return=[];
        $details = File::getPath($request->email);
        if (!empty($details['url'])) {
            $return['url'] = $details['url'];
            $return['message'] = 'Image Found';
        }else{
            $return['url'] = null;
            $return['message'] = 'No Image Found';
        }
        return $return;
    }

    public static function removeImg($request)
    {
        $return=[];
        $details = File::getPath($request->email);
        File::softDeletePath($request->email);
        Cloudinary::uploadApi()->destroy($details['public_id']);
        $return['message'] = 'success';
        return $return;
    }

}
