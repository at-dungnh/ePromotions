<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SocialAccount extends Model
{

    protected $fillable = ['user_id', 'social_id', 'social_type'];

    /**
    * [Get the user that owns the social account ]
    *
    * @return [user] [information of user]
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
