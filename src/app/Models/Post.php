<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $fillable = ['user_id','category','title','text','hobby_img_path','prefecture','municipalities'];

    public static function find($id)
    {
        $sql = "SELECT * "
             . "  FROM posts "
             . " WHERE id = '{$id}' ";
        return DB::select($sql);
    }
}
