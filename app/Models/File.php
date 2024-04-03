<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class File extends Model
{
    use HasFactory;
    public static function savePath($data){
        File::insertGetId($data);
    }
    public static function getPath($email){
        return File::where('email', $email)->whereNull('deleted_at')->orderBy('id', 'desc')->first();
    }
    public static function softDeletePath($email){
        File::where('email', $email)->update(['deleted_at'=>Carbon::now()]);
    }
}
