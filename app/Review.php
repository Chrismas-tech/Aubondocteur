<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function medecin() {
        return $this->belongsTo('App\Medecin');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
