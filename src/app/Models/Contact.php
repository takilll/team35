<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id', 'nickname', 'mail', 'title', 'massage', 'user_id', 'nickname', 'mail'
    ];
}
