<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\User;
use DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-users')) return $next($request);
            abort(403, 'Only Admin that can access this page!');
          });
    }

    public function json(){
    
         return datatables(User::all())->toJson();
    }

    public function index()
    {
        if(request()->ajax()){
            $data = User::latest()->get();
            return Datatables::of($data)->addIndexColumn()->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
                $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
                return $btn;
            })->rawColumns(['action'])->make(true);
        }
        return view('users.index');
    }

    public function store(Request $request)
    {
        $userId = $request->user_id;
        $user = User::updateOrCreate(
            ['id' => $userId],
            ['name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => $request->role]
        );

        return response()->json(['success' => 'Add new user successfully!']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
     
        return response()->json(['success'=>'User deleted successfully.']);
    }
}
