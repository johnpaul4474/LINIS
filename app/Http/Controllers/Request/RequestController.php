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
use App\Models\Linen\Requests;

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

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Request product: '.$request->product_name.' Quantity: '.$request->product_quantity.' Ward: '.Auth::user()->ward_id.' Office: '.Auth::user()->office_id,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);
        
        

        $wardList = DB::Select("SELECT * FROM jhay.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM jhay.linen_office ORDER BY office_name ASC");

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;
        if(Auth::user()->ward_id != null){
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward){
                if($ward->id ==  Auth::user()->ward_id ){
                    $wardName = $ward->ward_name;
                    $requestorDetails = $ward->ward_name;
                }
            }
            $requestorDetails = Auth::user();
        }
        if(Auth::user()->office_id  != null ){
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office){
                if($office->id ==  Auth::user()->office_id ){
                    $officeName = $office->office_name;
                   
                }
            }
            $requestorDetails = Auth::user();
        }

        
      
       
        Requests::create([
            'product_name_request' => $request->product_name,
            'product_quantity_request' =>  $request->product_quantity,
            'name' => Auth::user()->name,
            'employee_id' => Auth::user()->employee_id,
            'role_name'=> Auth::user()->role_name,
            'role_id'=> Auth::user()->role_id ,
            'ward_id'=> $wardId ,
            'office_id'=> $officeId,
            'status'=>1]);

                //status request
                // 1 = new
                // 2 = in progress
                // 3 = finished
                // 4 = reopened
                // 5 = deleted

        event(new LinisNotification('sendRequest',
        Auth::user(),        
        $request->product_name,
        $request->product_quantity,
        $wardName,
        $officeName,
        $requestorDetails       
        ));

        return redirect()->route('services')->with('success', 'Request submitted successfully');
    }

    public function processRequest(Request $request){
       
        $wardList = DB::Select("SELECT * FROM jhay.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM jhay.linen_office ORDER BY office_name ASC");

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;
        if(Auth::user()->ward_id != null){
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward){
                if($ward->id ==  Auth::user()->ward_id ){
                    $wardName = $ward->ward_name;
                }
            }
        }
        if(Auth::user()->office_id  != null ){
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office){
                if($office->id ==  Auth::user()->office_id ){
                    $officeName = $office->office_name;
                }
            }
        }
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Process Request id: '.$request->id.' Processed by: '.Auth::user()->employee_id,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);

        DB::table('nora.paul.linen_requests')
        ->where('id', $request->id)
        ->update([
            'status' => 2,
            'processed_by' => Auth::user()->name,
            'processed_by_emp_id' => Auth::user()->employee_id,
            'processed_at' => \Carbon\Carbon::now()
        ]);

            //status request
                // 1 = new
                // 2 = in progress
                // 3 = finished
                // 4 = reopened
                // 5 = deleted
        $requestorDetails =Requests::select()->where('id',$request->id)->first();
        event(new LinisNotification('processRequest',
        Auth::user(),        
        $request->product_name_request,
        $request->product_quantity_request,
        $wardName,
        $officeName,
        $requestorDetails
        ));

        return redirect()->route('services')->with('success', 'Request processed successfully');
    }

    public function pickUpProductRequest(Request $request){
        $wardList = DB::Select("SELECT * FROM jhay.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM jhay.linen_office ORDER BY office_name ASC");

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;
        if(Auth::user()->ward_id != null){
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward){
                if($ward->id ==  Auth::user()->ward_id ){
                    $wardName = $ward->ward_name;
                }
            }
        }
        if(Auth::user()->office_id  != null ){
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office){
                if($office->id ==  Auth::user()->office_id ){
                    $officeName = $office->office_name;
                }
            }
        }
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Request for pick up ! Process Request id: '.$request->id.' Processed by: '.Auth::user()->employee_id,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);

        DB::table('nora.paul.linen_requests')
        ->where('id', $request->id)
        ->update([
            'status' => 3,
            'processed_by' => Auth::user()->name,
            'processed_by_emp_id' => Auth::user()->employee_id,
            'processed_at' => \Carbon\Carbon::now()
        ]);

            //status request
                // 1 = new
                // 2 = in progress
                // 3 = finished
                // 4 = reopened
                // 5 = deleted
        $requestorDetails =Requests::select()->where('id',$request->id)->first();
        event(new LinisNotification('processRequest',
        Auth::user(),        
        $request->product_name_request,
        $request->product_quantity_request,
        $wardName,
        $officeName,
        $requestorDetails
        ));
        return redirect()->route('services')->with('success', 'Request ready for pick up');
    }

    public function issueProductRequest(Request $request){
       
        $requestId = $request->id; 
        
        return redirect()->route('services')->with('success', 'Request processed successfully');
    }
}
