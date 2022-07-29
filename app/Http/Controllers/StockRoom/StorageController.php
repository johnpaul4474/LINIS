<?php

namespace App\Http\Controllers\StockRoom;

use App\Models\Linen\StockRoom;
use App\Models\Linen\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StorageController extends Controller
{
    public function index()
    {

        // $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        // $storageList = Storage::select()->orderBy('created_at','desc')->get();
        // $stockRoomStorage = DB::table('nora.paul.linen_stock_rooms as stock_room')
        //     ->join('nora.paul.linen_storage as storage', 'stock_room.id', '=', 'storage.stock_room_id')  
        //     ->select('stock_room.id as stock_room_id','storage.id as storage_id','stock_room.stock_room', 'storage.storage_name')          
        //     ->get();
        
        // return view('linenStockroom.stockroom',compact('stockRooms','storageList','stockRoomStorage'));
    }

    public function addStorage(Request $request)
    {
   

        $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        $storageList = Storage::select()->orderBy('created_at','asc')->get();
        //////// TO-DO clean database for new records start from 0
        $latestId = DB::table('nora.paul.linen_storage')->orderBy('id','desc')->first();

        $newRecordId =0;
        if($latestId != null) {
            $newRecordId = (int)$latestId->id +1;
        } else {
            $newRecordId = 1;
        }

        //TO DO validation of stock room with its storage value
        // $storageValidationList = []; 
        // foreach ($storageList as $data) {
        //     array_push($storageValidationList,$data->storage_name);
        // }

        
        // Validator::make($request->all(), [
        //     'storage' => ['required', 'string', 'max:255',Rule::notIn(array_map("strtoupper",$storageValidationList))], 
        // ])->validate();


        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Added Storage ID: '.$newRecordId.' STORAGE NAME: '.strtoupper($request->storage),
            "created_at" => Carbon::now(), 
            
        ]);

        DB::table('nora.paul.linen_storage')
        ->insert([
         'stock_room_id' => $request->stockRoom,
         'storage_name' => strtoupper($request->storage),		  
         'created_at' => Carbon::now(),	   
            
        ]);

        return redirect()->route('stockroom')->with('success', 'Storage added successfully');
    }

    public function updateStorage(Request $request)
    {
    
        //TO DO validation of stock room with its storage value
        // $storageValidationList = []; 
        // foreach ($storageList as $data) {
        //     array_push($storageValidationList,$data->storage_name);
        // }

    
        // Validator::make($request->all(), [
        //     'storage' => ['required', 'string', 'max:255',Rule::notIn(array_map("strtoupper",$storageValidationList))], 
        // ])->validate();


        $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        $storageList = Storage::select()->orderBy('created_at','asc')->get();
        $stockRoomStorage = DB::table('nora.paul.linen_stock_rooms as stock_room')
        ->join('nora.paul.linen_storage as storage', 'stock_room.id', '=', 'storage.stock_room_id')  
        ->select('stock_room.id as stock_room_id','storage.id as storage_id','stock_room.stock_room', 'storage.storage_name')  
        ->whereNull('stock_room.deleted_at')  
        ->WhereNull('storage.deleted_at') 
        ->orderBy('stock_room.stock_room','asc')     
        ->get();
        //////// TO-DO clean database for new records start from 0
        $latestId = DB::table('nora.paul.linen_storage')->orderBy('id','desc')->first();

        $newRecordId =0;
        if($latestId != null) {
            $newRecordId = (int)$latestId->id +1;
        } else {
            $newRecordId = 1;
        }

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Updated Storage Storage ID: '.$request->idStorage.' STORAGE NAME: '.strtoupper($request->edit_storage).' STOCK ROOM: '.$request->editStockRoomStorage,
            "updated_at" => Carbon::now(), 
            
        ]);

        DB::table('nora.paul.linen_storage')
        ->where('id', (int)$request->idStorage)
        ->update([
         'stock_room_id' => $request->editStockRoomStorage,
         'storage_name' => strtoupper($request->edit_storage),		  
         'updated_at' => Carbon::now(),	   
            
        ]);

        return redirect()->route('stockroom')->with('info', 'Storage updated successfully');
    }

    public function destroy(Request $request)
    {
       
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Deleted  storage id: '.$request->id,
            "created_at" => Carbon::now(),             
        ]);

        $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        $storageList = Storage::select()->orderBy('created_at','asc')->get();
        // $stockRoomStorage = DB::table('nora.paul.linen_stock_rooms as stock_room')
        // ->join('nora.paul.linen_storage as storage', 'stock_room.id', '=', 'storage.stock_room_id')  
        // ->select('stock_room.id as stock_room_id','storage.id as storage_id','stock_room.stock_room', 'storage.storage_name')  
        // ->whereNull('stock_room.deleted_at')  
        // ->WhereNull('storage.deleted_at') 
        // ->orderBy('stock_room.stock_room','asc')     
        // ->get();
     
        Storage::where('id', $request->id)->delete();

        return redirect()->route('stockroom')->with('error', 'Storage deleted successfully');
    }

}
