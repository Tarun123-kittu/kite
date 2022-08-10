<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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

    public function getUsers(Request $request)
    {
        $data = User::where('first_name', 'like', '%' . $request->search . '%')
            ->orWhere('last_name', 'like', '%' . $request->search . '%')
            ->orWhere('company', 'like', '%' . $request->search . '%')
            ->paginate($request->per_page);
        return response(['message' => "Success", 'data' => $data], 200);
    }

    public function allDeals()
    {
        $deals = Deals::select('deal_id')->groupBy('deal_id')->get();
        if ($deals) {
            return response(['message' => "Success", 'data' => $deals], 200);
        } else {
            return response(['message' => "Data Not Found"], 404);
        }
        return view('admin.user.add', compact('report'));
    }

    public function storeUser(Request $request)
    {
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
            return response(['message' => "Bad Request", 'errors' => $data->errors()->all()], 400);
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->type = $request->type;
        $user->password = Hash::make($request->password);
        $user->save();
        if ($user) {
            foreach ($request->deal as $value) {
                UserMap::create([
                    'user_id' => $user->id,
                    'deal_id' => $value,
                ]);
            }
            Mail::to($request->email)->send(new AccountDetail($request));
            return response(['message' => "User Added"], 200);
        } else {
            return response(['message' => "Details not saved"], 400);
        }
    }

    public function userById($id)
    {
        $data = User::where('id', $id)->with(['map'])->first();
        if ($data) {
            return response(['message' => "success", 'data' => $data], 200);
        } else {
            return response(['message' => "user not found"], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'type' => 'required',
            'deal' => 'required'
        ]);

        if ($data->fails()) {
            return Helpers::failure(['message' => $data->errors()->first()], 'user.edit', 400);
        }

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->type = $request->type;
        $user->save();
        if ($request->deal) {
            UserMap::where('user_id', $id)->delete();
        }
        foreach ($request->deal as $value) {
            $user->map()
                ->updateOrCreate([
                    'user_id' => $id,
                    'deal_id' => $value
                ]);
        }
        return response(['message' => "User Updated"], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $user->map()->delete();
        return response(['message' => "User Deleted"], 200);
    }
}
