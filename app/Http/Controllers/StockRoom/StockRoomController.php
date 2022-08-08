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
use App\Models\ActivityLogs;

use DB;

class StockRoomController extends Controller
{
    public function index()
    {

        $stockRooms = StockRoom::with("storages")->orderBy('stock_room','asc')->get();

        // $storageList = Storage::select()->orderBy('storage_name','asc')->get();

        // $stockRoomStorage = DB::table('nora.paul.linen_stock_rooms as stock_room')
        //     ->join('nora.paul.linen_storage as storage', 'stock_room.id', '=', 'storage.stock_room_id')  
        //     ->select('stock_room.id as stock_room_id','storage.id as storage_id','stock_room.stock_room', 'storage.storage_name')  
        //     ->whereNull('stock_room.deleted_at')  
        //     ->WhereNull('storage.deleted_at') 
        //     ->orderBy('stock_room.stock_room','asc')     
        //     ->get();

           
        // return view('linenStockroom.stockroom',compact('stockRooms','storageList','stockRoomStorage'));
        return view('linenStockroom.index',compact('stockRooms'));
    }
    
    public function store(Request $request)
    {
        $stockRoom = StockRoom::create([
            'stock_room' => strtoupper($request->stock_room)
        ]);

        ActivityLogs::create(['activity_details' => 'Added Stock Room ID: '.$stockRoom->id.' stock room: '.$stockRoom->stock_room]);

        return response()->json($stockRoom);
    }

    public function update(Request $request)
    { 
        $stockRoom = StockRoom::find($request->id);
        $stockRoom->update([
            "stock_room" => strtoupper($request->stock_room)
        ]);

        ActivityLogs::create(['activity_details' => 'Updated Stock Room ID: '.$stockRoom->id.' stock_room: '.$stockRoom->stock_room]);
       
        return response()->json($stockRoom->fresh());
    }

    public function destroy(Request $request)
    {
        $stockRoom = StockRoom::with("storages")->find($request->id);
        if(sizeof($stockRoom->storages) > 0) {
            return response()->json("Delete all stoarges in this room first before deleting this stock room.");
        } else {
            $stockRoom->delete();
            ActivityLogs::create(['activity_details' => 'Deleted  Stock room id: '.$request->id]);
        }

        return response()->json(true);
    }
}
