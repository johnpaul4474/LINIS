<?php

namespace App\Http\Controllers\Linen;

use App\Models\Linen\LinenRawMaterials;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Linen\StockRoom;
use App\Models\Linen\Storage;
use Illuminate\Validation\Rule;
use App\Models\Linen\Requests;
use DB;

class LinenInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockRooms = StockRoom::select()->orderBy('stock_room','asc')->get();
        $storageList = Storage::select()->orderBy('storage_name','asc')->get();
       // $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','desc')->get();
        $rawMaterials = DB::select("select * , (raw_material.quantity * raw_material.unit_cost) as total_price from [nora].[paul].[linen_raw_materials] as raw_material");

        $materialCount = DB::table('nora.paul.linen_raw_materials')->count() ;

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ){ 
            $requestList = Requests::select()->orderBy('created_at', 'desc' )->get();
        }else{
            if(Auth::user()->ward_id != null){
                $requestList = Requests::select()->where('ward_id',Auth::user()->ward_id)->orderBy('created_at', 'desc' )->get();
            }
            if(Auth::user()->office_id  != null ){
                $requestList = Requests::select()->where('office_id',Auth::user()->office_id)->orderBy('created_at', 'desc' )->get();  
            }
        }

       // dd(Auth::user()->role_id,Auth::user()->ward_id,Auth::user()->office_id);
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
             $productsList = DB::select('EXEC nora.paul.linen_getBulkProducts');
            
             $productCount = DB::table('nora.paul.linen_products')->where('is_condemned',0)->count();
        }
        else{
            if(Auth::user()->office_id != null){      
                $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward =null'.', @office='.Auth::user()->office_id);
                $productCount = DB::table('nora.paul.linen_products')->where('is_condemned',0)->where('issued_office_id',Auth::user()->office_id)->count();
            }else if(Auth::user()->ward_id != null){
                $productsList = DB::select('EXEC nora.paul.linen_getProductsListByWardOffice @ward ='.Auth::user()->ward_id.', @office=null');
                $productCount = DB::table('nora.paul.linen_products')->where('is_condemned',0)->where('issued_ward_id',Auth::user()->ward_id)->count();
                
            }
        }
            
        
       
        return view('linenInventory', compact('materialCount','productCount','rawMaterials','stockRooms','storageList','productsList','requestList'));
           
        
    }

    public function create()
    {

        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','desc')->get();
        $stockRooms = StockRoom::select()->orderBy('stock_room','asc')->get();
        $storageList = Storage::select()->orderBy('storage_name','asc')->get();
        $lastRecord = DB::table('nora.paul.linen_raw_materials')->latest()->first();
        $lastRecord =$lastRecord->stock_number + 1;
        

        return view('linenMaterials.linenAddMaterial', compact('rawMaterials','stockRooms','storageList','lastRecord'));
    }

    public function store(Request $request)
    {   

       

        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();

        //////// TO-DO clean database for new records start from 0
        $latestId = DB::table('nora.paul.linen_raw_materials')->orderBy('id','desc')->first();
        $newRecordId =0;
        if($latestId != null){
            $newRecordId = (int)$latestId->id +1;
        }else{
            $newRecordId = 1;
        }

        if($request->isArchived == true){    
            $isArchived = true ;      
            // Validator::make($request->all(), [
            //     'received_at' =>  'required|date|before_or_equal:2021-12-31', 
            // ])->validate();
        }else{
            $isArchived = false ;    
        }

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Added Raw Material ID: '.$newRecordId.' stock number: '.$request->stock_number. " type: ".$request->type,
            "created_at" =>  \Carbon\Carbon::now(), 
            
        ]);
        if($request->isAvailable == true){
            $isAvailable = true;
        }else{
            $isAvailable = false;
        }

        $stocknumbersList = DB::select("select stock_number from [nora].[paul].[linen_raw_materials]");

        $stockNumberValidationList = []; 

        foreach ($stocknumbersList as $data) {
            array_push($stockNumberValidationList,$data->stock_number);
        }

        Validator::make($request->all(), [
                'stock_number' =>  [
                    'required',
                    Rule::notIn($stockNumberValidationList),
                ], 
        ])->validate();

       DB::table('nora.paul.linen_raw_materials')
       ->insert([
        'stock_number' => $request->stock_number,	
        'quantity' => $request->quantity,	
        'unit' => $request->unit,	
        'description' => $request->description,	
        'unit_cost' => $request->unit_cost,	
        'type' => $request->type,	
        'created_at' => \Carbon\Carbon::now(),
        'stock_room' =>$request->stockRoom,	
        'storage_room' => $request->storageRoom,        
        'is_archived' => $isArchived,
        'is_available' => $isAvailable,
        'received_at' => $request->received_at

           
       ]);
       return redirect()->route('material')->with('success', 'Raw material added successfully');
    }

    
    public function update(Request $request)
    {
      
      
        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Updated Raw MaterialID: '.$request->idRawMaterial.' stock number: '.$request->stock_number,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);

        $latestId = DB::table('nora.paul.linen_raw_materials')->orderBy('id','desc')->first();
        $newRecordId =0;
        if($latestId != null){
            $newRecordId = (int)$latestId->id +1;
        }else{
            $newRecordId = 1;
        }


        if($request->isArchivedEdit == true){    
            $isArchivedEdit = true ;      
            // Validator::make($request->all(), [
            //     'received_at_edit' =>  'required|date|before_or_equal:2021-12-31', 
            // ])->validate();
           
        }else{
            $isArchivedEdit = false ;    
        }


        if($request->isAvailableEdit == true){
            $isAvailableEdit = true;
        }else{
            $isAvailableEdit = false;
        }


        DB::table('nora.paul.linen_raw_materials')
        ->where('id', (int)$request->idRawMaterial)
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
            "updated_at" => \Carbon\Carbon::now(),            
        ]);
       
       
        return redirect()->route('material')->with('info', 'Raw material updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Linen\LinenInventory  $linenInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Deleted  Raw Material id: '.$request->id,
            "created_at" =>  \Carbon\Carbon::now()
            
        ]);

        //$rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();

        LinenRawMaterials::where('id', (int)$request->id)->delete();

        return redirect()->route('material')->with('error', 'Raw material deleted successfully');
    }


}
