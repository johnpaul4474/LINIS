<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\StockRoom;
use App\Models\Storage;
use Illuminate\Validation\Rule;
use DB;
use App\Events\LinisNotification;
use Illuminate\Support\Arr;
use App\Models\Requests;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\Ward;

class ReportsController extends Controller {
    public function index() {
        $linenInventory = [];
        $linenInventoryReport = [];
        $officeward = "";

        return view('Reports.reports',compact('linenInventory', $linenInventory,'linenInventoryReport',$linenInventoryReport,'officeward'));
    }

    public function linenInventory(Request $request) {
        $rawDate = $request->month.'-01';
        $currentMonth = Carbon::parse($rawDate)->format('Y-m-d');
        $lastMonth = Carbon::parse($rawDate)->subMonths(1)->format('Y-m-d');
        $nextMonth = Carbon::parse($rawDate)->addMonths(1)->format('Y-m-d');
        $officeward = null ;

        $linenInventory = [];
        $linenInventoryReport = [];
        if($request->office != null) {      
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByOffice  @office='.$request->office);
            $linenInventoryReport = DB::select('EXEC nora.paul.linen_generateReportOffice  @office='.$request->office.', @currentMonth="'.$currentMonth.'", @nextMonth="'.$nextMonth.'", @lastMonth="'.$lastMonth.'"');
            $officeward = Office::where('id',$request->office)->pluck('office_name')[0];
        }
        if($request->ward != null) {
            $linenInventory = DB::select('EXEC nora.paul.linen_getProductsListByWard @ward ='.$request->ward);
            $linenInventoryReport = DB::select('EXEC nora.paul.linen_generateReportWard @ward ='.$request->ward.', @currentMonth="'.$currentMonth.'", @nextMonth="'.$nextMonth.'", @lastMonth="'.$lastMonth.'"');
            $officeward = Ward::where('id',$request->ward)->pluck('ward_name')[0];    

        }
        
        return view('Reports.reports',compact('linenInventory', $linenInventory,'linenInventoryReport',$linenInventoryReport,'officeward', 'currentMonth'));
    }
}
        
