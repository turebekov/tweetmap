<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
    protected $fillable = [
        'username', 'geo', 'tweet_text',
    ];
}
