<?php

namespace App\Http\Controllers\Request;

use App\Models\Linen\LinenRawMaterials;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Linen\StockRoom;
use App\Models\Linen\Storage;
use Illuminate\Validation\Rule;
use DB;
use App\Events\LinisNotification;
use Illuminate\Support\Arr;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        if(Auth::user()->office_id != null){      
            $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward =null'.', @office='.Auth::user()->office_id);
        }else if(Auth::user()->ward_id != null){
            $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward ='.Auth::user()->ward_id.', @office=null');
            
        }
        

        return view('requests.request', compact('productsList'));
    }

    public function newRequest(Request $request){
        

        $mesasgeToSend = ['username' => Auth::user()->employee_id];
        $mesasgeToSend = Arr::add($mesasgeToSend, 'message' , $request->product_name);


        event(new LinisNotification(Auth::user()->employee_id,$request->product_name));
        return redirect()->route('request')->with('success', 'Request submitted successfully');
    }
}
