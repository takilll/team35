<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nickname', 'mail', 'title', 'body', 'to_user_id', 'to_nickname', 'to_mail'
    ];

}
