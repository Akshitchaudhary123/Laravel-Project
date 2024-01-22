<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\UserService;

class PasswordResetController extends Controller
{
    public static function passwordReset(Request $data)
    {
        $data->validate(['email' => 'required|email']);
        return UserService::passwordReset($data);
    }
    public static function resetPassword(Request $data)
    {
        $data->validate(['password' => 'required|confirmed']);
        return UserService::resetPassword($data);
    }
}
