<?php

namespace App\Http\Controllers\StockRoom;

use App\Models\StockRoom;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use DB;

class StockRoomController extends Controller
{
    public function index()
    {

        $stockRooms = StockRoom::select()->orderBy('stock_room','asc')->get();
        $storageList = Storage::select()->orderBy('storage_name','asc')->get();

        $stockRoomStorage = DB::table('nora.paul.linen_stock_rooms as stock_room')
            ->join('nora.paul.linen_storage as storage', 'stock_room.id', '=', 'storage.stock_room_id')  
            ->select('stock_room.id as stock_room_id','storage.id as storage_id','stock_room.stock_room', 'storage.storage_name')  
            ->whereNull('stock_room.deleted_at')  
            ->WhereNull('storage.deleted_at') 
            ->orderBy('stock_room.stock_room','asc')     
            ->get();

           
        return view('linenStockroom.stockroom',compact('stockRooms','storageList','stockRoomStorage'));
    }


    
    public function store(Request $request)
    {
        
        $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        $storageList = Storage::select()->orderBy('created_at','asc')->get();

        $stockRoomValidationList = []; 
        foreach ($stockRooms as $data) {
            array_push($stockRoomValidationList,$data->stock_room);
        }

        //dd($stockRoomValidationList);
        Validator::make($request->all(), [
            'stock_room' => ['required', 'string', 'max:255',Rule::notIn(array_map("strtoupper",$stockRoomValidationList))], 
        ])->validate();

        
        //////// TO-DO clean database for new records start from 0
        $latestId = DB::table('nora.paul.linen_stock_rooms')->orderBy('id','desc')->first();
        $newRecordId =0;
        if($latestId != null) {
            $newRecordId = (int)$latestId->id +1;
        } else {
            $newRecordId = 1;
        }

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Added Stock Room ID: '.$newRecordId.' stock room: '.$request->stock_room,
            "created_at" => Carbon::now(), 
            
        ]);

        DB::table('nora.paul.linen_stock_rooms')
        ->insert([
         'stock_room' => strtoupper($request->stock_room),	  
         'created_at' => Carbon::now(),	
         

            
        ]);

        return redirect()->route('stockroom')->with('success', 'Stock Room added successfully');
    }

    public function update(Request $request)
    { 
        $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        $storageList = Storage::select()->orderBy('created_at','asc')->get();

        $stockRoomValidationList = []; 
        foreach ($stockRooms as $data) {
            array_push($stockRoomValidationList,$data->stock_room);
        }

        Validator::make($request->all(), [
            'edit_stock_room' => ['required', 'string', 'max:255',Rule::notIn(array_map("strtoupper",$stockRoomValidationList))], 
        ])->validate();

        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Updated Stock Room ID: '.$request->idStockRoom.' stock_room: '.$request->edit_stock_room,
            'updated_at' => Carbon::now(), 
        ]);

        DB::table('nora.paul.linen_stock_rooms')
        ->where('id', (int)$request->idStockRoom)
        ->update([
            'stock_room' => $request->edit_stock_room,
            'updated_at' => Carbon::now(),	
                     
        ]);
       
       
        return redirect()->route('stockroom')->with('info', 'Stock Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockRoom  $stockRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       //also deletes the entry for nora.paul_linen_storage which contains the stock_room_id
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Deleted  Stock room id: '.$request->id,
            "created_at" => Carbon::now(),             
        ]);

        $stockRooms = StockRoom::select()->orderBy('created_at','desc')->get();
        $storageList = Storage::select()->orderBy('created_at','asc')->get();
        StockRoom::where('id', $request->id)->delete();
        Storage::where('stock_room_id', $request->id)->delete();

        return redirect()->route('stockroom')->with('error', 'Stock Room deleted successfully');
    }
}
