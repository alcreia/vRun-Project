<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //
    protected $fillable = [
        'userId',
        'angkatan',
        'raceType',
        'jarak',
        'image',
        'submit_at',
    ];
}
