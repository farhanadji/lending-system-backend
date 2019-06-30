<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{


    protected $fillable = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function book(){
        return $this->belongsToMany('App\Book');
    }

    public function getPrice(){
        return optional($this->book)->price;
    }

    public function getTotalPrice($interval){

        return $this->getPrice() * $interval;
    }
}
