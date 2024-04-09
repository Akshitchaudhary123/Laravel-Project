<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    public static function getSubjects($class,$branch=null){
        return ($branch==null)?Subject::where('class',$class)->get():Subject::where('class',$class)->where('branch',$branch)->get();
    }
}
