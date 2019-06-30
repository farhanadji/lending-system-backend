<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Book_Transaction;
use Auth;
use App\User;
use App\Book;
use DateTime;

class TransactionApiController extends Controller
{
    public function borrow(Request $request){
        $error = 0;
        $status = "error";
        $message = "";


        $user = Auth::user();

        if($user){
            $transaction = new Transaction;
            $transaction->user_id = $user->id;
            $transaction->total_price = 0;
            $transaction->borrow_date = $request->borrow_date;
            $transaction->return_date = $request->return_date;

            //date to int
            $borrowdate = $request->borrow_date;
            $returndate = $request->return_date;
            $date1 = new DateTime($borrowdate);
            $date2 = new DateTime($returndate);
            $interval = $date1->diff($date2);
            $days = $interval->format('%a');


            $transaction->status = 'BORROWED';
            if($transaction->save()){
                $calculate_price = 0;
                $book_id = $request->id;
                $book = Book::find($book_id);
                if($book){
                    $book->count = $book->count + 1;
                    $book->save();
                    
                    $calculate_price = $days * $book->price;

                    $book_transaction = new Book_transaction;
                    $book_transaction->book_id = $book->id;
                    $book_transaction->transaction_id = $transaction->id;
                    $book_transaction->save();

                    $transaction->total_price = $calculate_price;
                    $transaction->save();
                }
            }
            $status = 'success';
            $message = 'borrow book sucessfully';
        }else{
            $status = 'error';
            $meesage = 'borrow book failed';
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ],200);
    }

    public function mytransaction(Request $request){
        $user = Auth::user();
        $status = "error";
        $message = "";
        $book_name = [];
        $data = [];

        if($user){
            $transaction = Transaction::select('*')
            ->where('user_id', '=', $user->id)->orderBy('id','DESC')->get();
            $status = "success";
            $message = "transaction data "; 
            $data = $transaction;
        }else{
            $message = "not found";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],200);
    }


}
