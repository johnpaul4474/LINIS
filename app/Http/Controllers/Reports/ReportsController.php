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
        $officeward = "";
        return view('Reports.reports',compact('linenInventory', $linenInventory,'linenInventoryReport',$linenInventoryReport,'officeward'));
    }

    public function linenInventory(Request $request){
        //dd($request);
        $rawDate = $request->month.'-01';
        $currentMonth = Carbon::parse($rawDate)->format('Y-m-d');
        $lastMonth = Carbon::parse($rawDate)->subMonths(1)->format('Y-m-d');
        $nextMonth = Carbon::parse($rawDate)->addMonths(1)->format('Y-m-d');
        $officeward ;

        $linenInventoryReport = [];
        if($request->office != null){      
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByOffice  @office='.$request->office);
            $linenInventoryReport = DB::select('EXEC nora.paul.linen_generateReportOffice  @office='.$request->office.', @currentMonth="'.$currentMonth.'", @nextMonth="'.$nextMonth.'", @lastMonth="'.$lastMonth.'"');
            $officeward =  DB::table('nora.paul.linen_office')
                            ->select('office_name')
                            ->where('id',$request->office)
                            ->first();
        }
        if($request->ward != null){
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByWard @ward ='.$request->ward);
            $linenInventoryReport = DB::select('EXEC nora.paul.linen_generateReportWard @ward ='.$request->ward.', @currentMonth="'.$currentMonth.'", @nextMonth="'.$nextMonth.'", @lastMonth="'.$lastMonth.'"');
            $officeward =  DB::table('nora.paul.linen_ward')
                            ->select('ward_name')
                            ->where('id',$request->ward)
                            ->first();       

        }


       //dd($officeward);
        
        return view('Reports.reports',compact('linenInventory', $linenInventory,'linenInventoryReport',$linenInventoryReport,'officeward'));
    }
}
        
