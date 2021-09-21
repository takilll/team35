<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class hobby extends Model
{
    use HasFactory;

    protected $table = "users";
    protected $fillable = ['nickname', 'mail', 'password', 'profile_img_path'];

    protected $guarded = ['id'];
    public function isLogin($mail, $password)
    {
        $sql = "SELECT id "
             . "  FROM users "
             . " WHERE mail = '{$mail}' "
             . "   AND password = '{$password}' ";
        dd($sql);
        return DB::select($sql);
    }

    public function getUser($mail)
    {
        $sql = "SELECT * "
             . "  FROM users "
             . " WHERE mail = '{$mail}' ";
        return DB::select($sql);
    }
 
}

