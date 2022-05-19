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
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $linenInventory = [];
        $linenInventoryReport = [];
        return view('Reports.reports',compact('linenInventory', $linenInventory,'linenInventoryReport',$linenInventoryReport));
    }

    public function linenInventory(Request $request){
        $rawDate = $request->month.'-01';
        $currentMonth = Carbon::parse($rawDate)->format('Y-m-d');
        //$prevMonth = Carbon::parse($rawDate)->subMonths(1)->format('Y-m-d');
        $nextMonth = Carbon::parse($rawDate)->addMonths(1)->format('Y-m-d');
     
        $linenInventoryReport = [];
        if($request->office != null){      
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward =null'.', @office='.$request->office);
            $linenInventoryReport = DB::select('EXEC nora.paul.linen_generateReport @ward =null'.', @office='.$request->office.', @currentMonth="'.$currentMonth.'", @nextMonth="'.$nextMonth.'"');
        }
        
        if($request->ward != null){
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward ='.$request->ward.', @office=null');
            $linenInventoryReport = DB::select('EXEC nora.paul.linen_generateReport @ward ='.$request->ward.', @office=null, @currentMonth="'.$currentMonth.'", @nextMonth="'.$nextMonth.'"');
                      
                      
        }



        
        return view('Reports.reports',compact('linenInventory', $linenInventory,'linenInventoryReport',$linenInventoryReport));
    }
}
        
