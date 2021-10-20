<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','category','title','text','hobby_img_path','prefecture','municipalities'];

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    /**
     * リプライにLIKEを付いているかの判定
    *
    * @return bool true:Likeがついてる false:Likeがついてない
    */
    public function is_liked_by_auth_user()
    {
        $user = Session::get('user');

        $likers = array();
        foreach($this->likes as $like) {
        array_push($likers, $like->user_id);
        }
        if (in_array($user[0]->id, $likers)) {
        return true;
        } else {
        return false;
        }
    }
}
