<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersList;

class HomeController extends Controller
{
    public function unauthorized() {
        return view('unathorized');
    }
    public function notFound() {
        return view('notFound');
    }
    
    public function index(Request $request) {
        if(\Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('welcome'); // this is a login page
        }
    }

    public function authTunnel(Request $request) {
        if(!config("app.debug")) {
            $referer = $request->headers->get('referer');
        
            if(!$referer || parse_url($referer)["host"] != "192.168.6.179") {
                return redirect()->route('notFound');
            }
        }

        if($request->employeeid) {
            if($request->user()) {
                \Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            $user = UsersList::where("employee_id", $request->employeeid)->first();

            // Create user if does not exist
            if(!$user) {
                $homis = \DB::table("hospital.dbo.user_acc")
                    ->where("employeeid", $request->employeeid)
                    ->first();

                if(!$homis) {
                    return redirect()->route('unauthorized');
                }

                $hpersonal = \DB::table("hospital.dbo.hpersonal")
                    ->where("employeeid", $request->employeeid)
                    ->first();

                $user = UsersList::create([
                    'username' => $homis->user_name,	
                    'name' => $hpersonal->lastname . ", " . $hpersonal->firstname,	
                    'employee_id' => $request->employeeid,	
                    'role_name' => 'user',
                    'role_id' => 3
                ]);
            }

            if($user) {
                \Auth::loginUsingId($user->id);
            }
        }

        if(\Auth::check()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('unauthorized');
        }
    }
}
