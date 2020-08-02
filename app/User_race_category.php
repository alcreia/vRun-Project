<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_race_category extends Model
{
    //
    protected $guarded = [];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
