<?php

namespace App\Http\Controllers\Linen;

use App\Models\LinenRawMaterials;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\StockRoom;
use App\Models\Storage;
use App\Models\Products;
use Illuminate\Validation\Rule;
use App\Models\Requests;
use App\Models\Office;
use App\Models\Ward;
use App\Models\UsersList;
use DB;
use Carbon\Carbon;

class LinenInventoryController extends Controller
{
    public function index(Request $request) {
        // check if user has a ward/office
        if($request->user() && !$request->user()->ward_id && !$request->user()->office_id) {
            // Send user to register page
            return redirect()->route('selectArea');
        }

        $stockRooms = StockRoom::select()->orderBy('stock_room', 'asc')->get();
        $storageList = Storage::select()->orderBy('storage_name', 'asc')->get();
        $rawMaterials = LinenRawMaterials::all();
        $materialCount = LinenRawMaterials::count() ;

        $requestList = [];
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ) {
            $requestList = Requests::select()->orderBy('created_at', 'desc' )->get();
        } else {
            if(Auth::user()->ward_id != null) {
                $requestList = Requests::select()->where('ward_id',Auth::user()->ward_id)->orderBy('created_at', 'desc' )->get();
            }

            if(Auth::user()->office_id  != null ) {
                $requestList = Requests::select()->where('office_id',Auth::user()->office_id)->orderBy('created_at', 'desc' )->get();  
            }
        }

        $productCount = 0;
        $productsList = [];
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
             $productsList = DB::select('EXEC nora.paul.linen_getBulkProducts');
             $productCount = Products::where('is_condemned',0)
                                ->where('is_lossed',0)
                                ->where('is_available',1)
                                ->count();
        } else{
            if(Auth::user()->office_id != null) {      
                $productsList = DB::select('EXEC nora.paul.linen_getProductsListByOffice @office='.Auth::user()->office_id);
                $productCount = Products::where('is_condemned',0)
                                ->where('is_lossed',0)
                                ->where('is_available',0)
                                ->where('is_returned',0)
                                ->where('issued_office_id',Auth::user()->office_id)->count();
            }
            if(Auth::user()->ward_id != null) {
                $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWard @ward ='.Auth::user()->ward_id);
                $productCount = Products::where('is_condemned',0)
                                ->where('is_lossed',0)
                                ->where('is_available',0)
                                ->where('is_returned',0)
                                ->where('issued_ward_id',Auth::user()->ward_id)->count();
                
            }
        }
       
        return view('linenInventory', compact('materialCount','productCount','rawMaterials','stockRooms','storageList','productsList','requestList'));
    }

    public function selectArea(Request $request) {
        if($request->user()) {
            $user = UsersList::find($request->user()->id);

            if(!!$request->office_id || !!$request->ward_id) {
                $user->update([
                    "office_id" => $request->office_id,
                    "ward_id" => $request->ward_id
                ]);

                return redirect()->route('home');
            } else {
                // Send user to register page
                $wards = Ward::all();
                $offices = Office::all();
    
                return view("selectArea", compact('wards', 'offices'));
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function create() {
        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','desc')->get();
        $stockRooms = StockRoom::select()->orderBy('stock_room','asc')->get();
        $storageList = Storage::select()->orderBy('storage_name','asc')->get();
        $lastRecord = LinenRawMaterials::latest()->first();
       
        if($lastRecord == null) {
            $lastRecord = 1;
        } else {
            $lastRecord = $lastRecord->stock_number + 1;
        }

        return view('linenMaterials.linenAddMaterial', compact('rawMaterials','stockRooms','storageList','lastRecord'));
    }

    public function store(Request $request) {
        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();

        //////// TO-DO clean database for new records start from 0
        $latestId = LinenRawMaterials::orderBy('id','desc')->first();
        $newRecordId = 0;

        if($latestId != null) {
            $newRecordId = (int) $latestId->id +1;
        } else {
            $newRecordId = 1;
        }

        if($request->isArchived == true) {    
            $isArchived = true;
        } else {
            $isArchived = false;    
        }

        ActivityLogs::create(['activity_details' => 'Added Raw Material ID: '.$newRecordId.' stock number: '.$request->stock_number. " type: ".$request->type]);

        if($request->isAvailable == true) {
            $isAvailable = true;
        } else {
            $isAvailable = false;
        }

        $stockNumberValidationList = LinenRawMaterials::all()->pluck("stock_number");

        $lastRecord = LinenRawMaterials::latest()->first();

        $raw = LinenRawMaterials::create([
            'stock_number'  => $lastRecord ? $lastRecord->stock_number + 1 : 1,	
            'quantity'      => $request->quantity,	
            'unit'          => $request->unit,	
            'description'   => $request->description,	
            'unit_cost'     => $request->unit_cost,	
            'type'          => $request->type,
            'stock_room'    => $request->stockRoom,	
            'storage_room'  => $request->storageRoom,        
            'is_archived'   => $isArchived,
            'is_available'  => $isAvailable,
            'received_at'   => $request->received_at
        ]);
    
        return redirect()->route('material')->with('success', 'Raw material added successfully');
    }
    
    public function update(Request $request) {
        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();

        ActivityLogs::create(['activity_details' => 'Updated Raw MaterialID: '.$request->idRawMaterial.' stock number: '.$request->stock_number]);

        $latestId = LinenRawMaterials::orderBy('id','desc')->first();
        $newRecordId = 0;

        if($latestId != null) {
            $newRecordId = (int) $latestId->id +1;
        } else {
            $newRecordId = 1;
        }

        if($request->isArchivedEdit == true) {    
            $isArchivedEdit = true;
        } else {
            $isArchivedEdit = false;    
        }

        if($request->isAvailableEdit == true) {
            $isAvailableEdit = true;
        } else {
            $isAvailableEdit = false;
        }

        LinenRawMaterials::where('id', (int)$request->idRawMaterial)
            ->update([
                'stock_number' => $request->stock_number,	
                'quantity' => $request->quantity,	
                'unit' => $request->unit,	
                'description' => $request->description,	
                'unit_cost' => $request->unit_cost,	
                'type' => $request->type,
                'is_archived' => $isArchivedEdit,
                'is_available' => $isAvailableEdit,	
                'received_at' => $request->received_at_edit,
                "updated_at" => Carbon::now(),            
            ]);
       
        return redirect()->route('material')->with('info', 'Raw material updated successfully');
    }

    public function destroy(Request $request) {
        ActivityLogs::create(['activity_details' => 'Deleted  Raw Material id: '.$request->id]);

        LinenRawMaterials::where('id', (int)$request->id)->delete();

        return redirect()->route('material')->with('error', 'Raw material deleted successfully');
    }
}
