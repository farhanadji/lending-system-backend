<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Book;
use DataTables;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-books')) return $next($request);
            abort(403, 'Only Admin that can access this page!');
          });
    }

    public function index()
    {
        if(request()->ajax()){
            $data = Book::first()->get();
            return Datatables::of($data)->addIndexColumn()->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
                $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
                return $btn;
            })->rawColumns(['action'])->make(true);
        }
        return view('books.index');
    }

    public function store(Request $request)
    {
        $bookId = $request->book_id;
        $book = Book::updateOrCreate(
            ['id' => $bookId],
            ['title' => $request->title,
            'author' => $request->author,
            'price' => $request->price
            ]
        );
        return response()->json(['success' => 'Add new book sucessfully!']);
    }

    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function destroy($id)
    {
        Book::find($id)->delete();

        return response()->json(['success' => 'Book deleted successfully!']);
    }
}
