<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public function transaction(){
        return $this->belongsToMany('App\Transaction');
    }

    public $timestamps = false;

    protected $fillable = [
        'title', 'author', 'price',
    ];
}
