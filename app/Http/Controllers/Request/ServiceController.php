<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\Requests;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        //to do filter by user get only for ward or office
        
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ) { 
            $requestList = Requests::select()->orderBy('status', 'asc' )->get();
        } else {
            if(Auth::user()->ward_id != null) {
                $requestList = Requests::select()->where('ward_id',Auth::user()->ward_id)->orderBy('status', 'asc' )->get();
            }
            if(Auth::user()->office_id  != null ) {
                $requestList = Requests::select()->where('office_id',Auth::user()->office_id)->orderBy('status', 'asc' )->get();  
            }
        }

       

        return view('requests.services',compact('requestList'));
    }

    public function updateComment(Request $request, $id) {
        $request1 = Requests::find($id);
        $request1->comments = $request->remarks;
        $request1->save();

        return redirect("/services");
    }
}
