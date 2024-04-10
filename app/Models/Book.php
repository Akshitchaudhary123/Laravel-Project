<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public static function getChapters($class,$subject,$branch=null){
        return ($branch==null)?Book::where('class',$class)->where('subject',$subject)->get():Book::where('class',$class)->where('subject',$subject)->where('branch',$branch)->get();
    }
}
