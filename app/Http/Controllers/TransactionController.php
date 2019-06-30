<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-transaction')) return $next($request);
            abort(403, 'Only Admin that can access this page!');
          });
    }

    public function index()
    {
        if(request()->ajax()){
            $data = Transaction::select('transactions.id','users.name as user_name', 'user_id', 'transactions.status',
            'total_price', 'borrow_date', 'return_date')->leftJoin('users','transactions.user_id', '=',  'users.id')->get();

            return Datatables::of($data)->addIndexColumn()->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTransaction">Edit</a>';
                $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTransaction">Delete</a>';
                return $btn;
            })->rawColumns(['action'])->make(true);
        }
        return view('transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $transaction_id = $request->transaction_id;
        $transaction = Transaction::find($transaction_id);
        $transaction->status = $request->status;

        $transaction->save();

        // $transactions = Transaction::updateOrCreate(
        //     ['id' => $transaction_id],
        //     ['user_id' => $request->user_id,
        //     'total_price' => $request->total_price,
        //     'borrow_date' => $request->borrow_date,
        //     'return_date' => $request->return_date,
        //     'status' => $request->status]
        // );

        return response()->json(['success' => 'Add new user successfully!']);
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return response()->json($transaction);
    }

    public function destroy($id)
    {   
        Transaction::find($id)->delete();
     
        return response()->json(['success'=>'Transaction deleted successfully.']);
    }
}
