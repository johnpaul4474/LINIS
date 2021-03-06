<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\Products;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Linen\Requests;
use App\Models\Linen\UsersList;


class RoleController extends Controller
{
    public function index (){

        $usersList = UsersList::select()->where('office_id','6')->orderBy('role_id','asc')->get();  
        
       
        return view('role.roleManagement',compact('usersList'));
    }

    public function assignAdmin (Request $request){
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Assigned admmin user id: '.$request->id,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);

        DB::table('nora.paul.linen_users')
        ->where('id', $request->userId)
        ->update([
            'role_id' => 1,
            'role_name' => 'super_admin' ,           
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return redirect()->route('roleManagement')->with('success', 'User role successfully changed');
    }

    public function listusers (){

        $usersList = UsersList::select()->where('role_id','3')->orderBy('name','asc')->get();  
        
       
        return view('role.usersList',compact('usersList'));
    }
}
