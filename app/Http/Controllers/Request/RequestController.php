<?php

namespace App\Http\Controllers\Request;

use App\Models\LinenRawMaterials;
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
use App\Models\Requests;
use Redirect,Response;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\Ward;
use App\Views\ProductsList;
use App\Models\Products;

class RequestController extends Controller
{
    public function index() {
        if(Auth::user()->office_id != null) {      
            $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward =null'.', @office='.Auth::user()->office_id);
        } else if (Auth::user()->ward_id != null) {
            $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward ='.Auth::user()->ward_id.', @office=null');
        }

        return view('requests.request', compact('productsList'));
    }

    public function newRequest(Request $request) {
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Request product: '.$request->product_name.' Quantity: '.$request->product_quantity.' Ward: '.Auth::user()->ward_id.' Office: '.Auth::user()->office_id,
            "created_at"        => Carbon::now(), 
        ]);

        $wardList = Ward::all();
        $officeList = Office::all();

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;

        if(Auth::user()->ward_id != null) {
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward) {
                if($ward->id == Auth::user()->ward_id ) {
                    $wardName = $ward->ward_name;
                    $requestorDetails = $ward->ward_name;
                }
            }
            $requestorDetails = Auth::user();
        }

        if(Auth::user()->office_id  != null ) {
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office) {
                if($office->id == Auth::user()->office_id ) {
                    $officeName = $office->office_name;
                   
                }
            }
            $requestorDetails = Auth::user();
        }
       
        Requests::create([
            'product_name_request'      => $request->product_name,
            'product_quantity_request'  => $request->product_quantity,
            'name'                      => Auth::user()->name,
            'employee_id'               => Auth::user()->employee_id,
            'role_name'                 => Auth::user()->role_name,
            'role_id'                   => Auth::user()->role_id ,
            'ward_id'                   => $wardId ,
            'office_id'                 => $officeId,
            'status'                    => 1
        ]);

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

    public function processRequest(Request $request) {
        $wardList = Ward::all();
        $officeList = Office::all();

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;
        if(Auth::user()->ward_id != null) {
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward) {
                if($ward->id == Auth::user()->ward_id ) {
                    $wardName = $ward->ward_name;
                }
            }
        }
        if(Auth::user()->office_id  != null ) {
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office) {
                if($office->id == Auth::user()->office_id ) {
                    $officeName = $office->office_name;
                }
            }
        }
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Process Request id: '.$request->id.' Processed by: '.Auth::user()->employee_id,
            "created_at" => Carbon::now(), 
        ]);

        Requests::where('id', $request->id)
            ->update([
                'status' => 2,
                'processed_by' => Auth::user()->name,
                'processed_by_emp_id' => Auth::user()->employee_id,
                'processed_at' => Carbon::now(),
                'comments' => $request->remarksSave
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

    public function pickUpProductRequest(Request $request) {
        $wardList = Ward::all();
        $officeList = Office::all();

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;

        if(Auth::user()->ward_id != null) {
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward) {
                if($ward->id == Auth::user()->ward_id ) {
                    $wardName = $ward->ward_name;
                }
            }
        }

        if(Auth::user()->office_id  != null ) {
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office) {
                if($office->id == Auth::user()->office_id ) {
                    $officeName = $office->office_name;
                }
            }
        }
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Request for pick up ! Process Request id: '.$request->id.' Processed by: '.Auth::user()->employee_id,
            "created_at" => Carbon::now(), 
        ]);

        Requests::where('id', $request->id)
            ->update([
                'status' => 3,
                'processed_by' => Auth::user()->name,
                'processed_by_emp_id' => Auth::user()->employee_id,
                'processed_at' => Carbon::now(),
                'comments' => $request->remarksSave
            ]);

        //status request
        // 1 = new
        // 2 = in progress
        // 3 = READY FOR PICKUP
        // 4 = FINISHED
               
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

    public function issueProductRequest(Request $request) {
        $requestId = $request->id;

        $productsList  = ProductsList::all();
        
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ) { 
            $requestList = Requests::select()->where('id',$requestId)->orderBy('created_at', 'desc' )->get();
        } else {
            if(Auth::user()->ward_id != null) {
                $requestList = Requests::select()->where('ward_id',Auth::user()->ward_id)->where('id',$requestId)->orderBy('created_at', 'desc' )->get();
            }
            if(Auth::user()->office_id  != null ) {
                $requestList = Requests::select()->where('office_id',Auth::user()->office_id)->where('id',$requestId)->orderBy('created_at', 'desc' )->get();  
            }
        }

        $wardList = Ward::all();
        $officeList = Office::all();

        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;
        if(Auth::user()->ward_id != null) {
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward) {
                if($ward->id == Auth::user()->ward_id ) {
                    $wardName = $ward->ward_name;
                }
            }
        }
        if(Auth::user()->office_id  != null ) {
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office) {
                if($office->id == Auth::user()->office_id ) {
                    $officeName = $office->office_name;
                }
            }
        }
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Request finished ! Process Request id: '.$request->id.' Processed by: '.Auth::user()->employee_id,
            "created_at" => Carbon::now(), 
        ]);

        $wardList = Ward::all();
        $officeList = Office::all();
         
        Requests::where('id', $request->id)
            ->update([            
                'comments' => $request->remarksSave
            ]);

        return view('requests.issuanceRequest', compact('productsList','requestList','wardList','officeList'));
        
    }

    public function issueFinalRequest(Request $request) {
        $wardList = Ward::all();
        $officeList = Office::all();

        
        $wardName = null;
        $officeName= null;
        $wardId = null;
        $officeId = null;
        if(Auth::user()->ward_id != null) {
            $wardId = Auth::user()->ward_id; 
            foreach($wardList as $ward) {
                if($ward->id == $request->ward_id ) {
                    $wardName = $ward->ward_name;
                }
            }
        }
        if(Auth::user()->office_id  != null ) {
            $officeId = Auth::user()->office_id;
            foreach($officeList as $office) {
                if($office->id == $request->office_id ) {
                    $officeName = $office->office_name;
                }
            }
        }
        Requests::where('id', $request->id)
            ->update([
                'status' => 4,
                'processed_by' => Auth::user()->name,
                'processed_by_emp_id' => Auth::user()->employee_id,
                'processed_at' => Carbon::now()
            ]);

        $requestorDetails =Requests::select()->where('id',$request->id)->first();
        event(new LinisNotification('processRequest',
        Auth::user(),        
        $request->product_name_request,
        $request->product_quantity_request,
        $wardName,
        $officeName,
        $requestorDetails
        ));
        


        return redirect()->route('services')->with('success', 'Request succesfully  issued');
    }

    public function retrieveItemsList(Request $request) {

        $productIds = explode(',', $request->productIds);
        dd($request);
        Products::where('product_bulk_id', $request->bulkId)->increment('product_available_quantity',count($productIds))
                                                            ->decrement('product_issued_quantity',count($productIds));
        
        
        Products::whereIn('id', $productIds)
        ->update([
            'is_available' => true,	
            'issued_office_id' => null,	
            'issued_ward_id' => null,	
            'issued_date' =>null,
            "returned_date" => Carbon::now()
        ]);
        
        $productsList  = ProductsList::all();

       

        return Response::json($productsList);
    }

    public function editRemarks(Request $request) {
       
        Requests::where('id', $request->id)
            ->update([            
                'comments' => $request->remarksSave
            ]);

        return redirect()->route('services')->with('success', 'Remarks added successfully');
    }
}
