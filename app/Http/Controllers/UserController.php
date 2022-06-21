<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDetail;
use App\Models\DailyReport;
use App\Models\Deals;
use App\Models\UserMap;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function getUsers(Request $request){
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = "<a href='/admin/user/$row->id' class='edit btn btn-success btn-sm'>Update</a>";
                           $btn = $btn."&nbsp<a href='/admin/user/delete/$row->id' class='edit btn btn-danger btn-sm'>Delete</a>";
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
       
    }

    public function addUser(){
        $report = Deals::select('deal_id')->groupBy('deal_id')->get();
        return view('admin.user.add', compact('report'));
    }

    public function storeUser(Request $request){
        $data = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:RD_users',
            'company' => 'required',
            'type' => 'required',
            'password' => 'required',
            'deal' => 'required'
        ]);

        if ($data->fails()) {
            return Helpers::failure([ 'message' => $data->errors()->first()], 'users.add', 400);
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->type = $request->type;
        $user->password = Hash::make($request->password);
        $user->save();
        if($user){
            foreach($request->deal as $value){
                UserMap::create([
                    'user_id' => $user->id,
                    'deal_id' => $value,
                ]);
            }
            Mail::to($request->email)->send(new AccountDetail($request));
            return Helpers::success([ 'message' => "User Added"], 'users', 200);
           
        }else{
            return Helpers::failure([ 'message' =>"Details not saved"], 'users.add', 400);
        }
    }

    public function edit($id){
        $report = DailyReport::select('deal_id')->groupBy('deal_id')->get();
        $data = User::where('id',$id)->with(['map'])->first();
        return view('admin.user.edit',compact('data','report'));
    }

    public function update(Request $request , $id){
        $data = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'type' => 'required',
            'deal' => 'required'
        ]);

        if ($data->fails()) {
            return Helpers::failure([ 'message' => $data->errors()->first()], 'user.edit', 400);
        }

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->type = $request->type;
        $user->save();
        if($request->deal){
            UserMap::where('user_id',$id)->delete();
        }
        foreach($request->deal as $value){
            $user->map()
            ->updateOrCreate([
                'user_id' => $id,
                'deal_id' => $value
            ]);
        }
        return Helpers::success([ 'message' => "User Updated"], 'users', 200);

    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        $user->map()->delete();
        return Helpers::success([ 'message' => "User Deleted"], 'users', 200);
    }
   
}