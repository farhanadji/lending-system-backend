<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Books as BookCollection;
use App\Http\Resources\Book as BookDetail;
use App\Book;

class bookapi extends Controller
{
    public function index(){
        $books = new BookCollection(Book::get());
        return $books;
    }

    public function detail(Request $request){
        $book = Book::where('id','=', $request->id)->first();
        return new BookDetail($book);
    }
}
