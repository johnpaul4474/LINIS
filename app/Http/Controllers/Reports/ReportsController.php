<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Linen\StockRoom;
use App\Models\Linen\Storage;
use Illuminate\Validation\Rule;
use DB;
use App\Events\LinisNotification;
use Illuminate\Support\Arr;
use App\Models\Linen\Requests;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $linenInventory = [];
        return view('Reports.reports',compact('linenInventory', $linenInventory));
    }

    public function linenInventory(Request $request){
    
        if($request->office != null){      
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward =null'.', @office='.$request->office);
                            
            
        }
        
        if($request->ward != null){
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward ='.$request->ward.', @office=null');
                      
        }
        
        return view('Reports.reports',compact('linenInventory', $linenInventory));
    }
}
        
