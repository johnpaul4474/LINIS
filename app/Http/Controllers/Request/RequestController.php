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
use Redirect,Response;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

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

        $wardList = DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");

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
        $wardList = DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");

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

        DB::table('nora.paul.linen_requests')
            ->where('id', $request->id)
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
        $wardList = DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");

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

        DB::table('nora.paul.linen_requests')
            ->where('id', $request->id)
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

        $productsList  = DB::select("SELECT	products.id ,
            products.raw_material_id,		
            products.raw_material_stock_number,
            raw_material.unit, 
            raw_material.description as material_used,
            products.product_bulk_id,
            products.product_stock_id,
            products.product_name,
            stocks.stock_room,
            storages.storage_name,
            products.product_unit,
            products.product_quantity,
            products.product_available_quantity,
            products.product_condemned_quantity,
            products.product_losses_quantity,
            products.product_unit_cost,
            raw_material.quantity as raw_material_quantity,
            products.stock_room_id,
            products.storage_room_id,
            products.is_available,
            products.is_condemned,
            products.is_lossed,
            products.issued_office_id,
            products.issued_ward_id,
            products.create_date,
            (products.product_quantity *
                products.product_unit_cost) as total_cost
            FROM nora.paul.linen_products as products 
            inner join nora.paul.linen_stock_rooms as stocks
            on products.stock_room_id = stocks.id
            inner join nora.paul.linen_storage as storages
            on products.storage_room_id = storages.id
            inner join nora.paul.linen_raw_materials as raw_material
            on products.raw_material_id = raw_material.id  where products.deleted_at is null  order by products.is_available desc");
        
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


        $wardList = DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");

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

        $wardList = DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");


        $officeList = DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");
         
        DB::table('nora.paul.linen_requests')
        ->where('id', $request->id)
        ->update([            
            'comments' => $request->remarksSave
        ]);
        return view('requests.issuanceRequest', compact('productsList','requestList','wardList','officeList'));
        
    }

    public function issueFinalRequest(Request $request) {

        $wardList = DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");
        $officeList = DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");

        
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
        DB::table('nora.paul.linen_requests')
        ->where('id', $request->id)
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
        
        
        DB::table('nora.paul.linen_products')
        ->whereIn('id', $productIds)
        ->update([
            'is_available' => true,	
            'issued_office_id' => null,	
            'issued_ward_id' => null,	
            'issued_date' =>null,
            "updated_at" => Carbon::now(),  
            "returned_date" => Carbon::now()
           
        
        ]);
        
        $productsList  = DB::select("SELECT	products.id ,
        products.raw_material_id,		
        products.raw_material_stock_number,
        raw_material.unit, 
        raw_material.description as material_used,
        products.product_bulk_id,
        products.product_stock_id,
        products.product_name,
        stocks.stock_room,
        storages.storage_name,
        products.product_unit,
        products.product_quantity,
        products.product_available_quantity,
        products.product_condemned_quantity,
        products.product_losses_quantity,
        products.product_unit_cost,
        raw_material.quantity as raw_material_quantity,
        products.stock_room_id,
        products.storage_room_id,
        products.is_available,
        products.is_condemned,
        products.is_lossed,
        products.issued_office_id,
        products.issued_ward_id,
        products.create_date,
        (products.product_quantity *
		    products.product_unit_cost) as total_cost
        FROM nora.paul.linen_products as products 
        inner join nora.paul.linen_stock_rooms as stocks
        on products.stock_room_id = stocks.id
        inner join nora.paul.linen_storage as storages
        on products.storage_room_id = storages.id
        inner join nora.paul.linen_raw_materials as raw_material
        on products.raw_material_id = raw_material.id  where products.deleted_at  is null  and products.id in ( $request->productIds ) or products.is_available = 1 order by products.is_available desc");

       

        return Response::json($productsList);
    }

    public function editRemarks(Request $request) {
       
        DB::table('nora.paul.linen_requests')
        ->where('id', $request->id)
        ->update([            
            'comments' => $request->remarksSave
        ]);

        return redirect()->route('services')->with('success', 'Remarks added successfully');
    }
}
