<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class book_transaction extends Model
{
    protected $table = 'book_transaction';

    protected $fillable = [
        'transaction_id', 'book_id'
    ];
}
