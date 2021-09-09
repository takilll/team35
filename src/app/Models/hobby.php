<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hobby extends Model
{
    use HasFactory;

    protected $table = "users";
    protected $fillable = ['nickname', 'mail', 'password', 'profile_img_path'];
}
