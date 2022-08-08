<?php

namespace App\Http\Controllers\StockRoom;

use App\Models\StockRoom;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\ActivityLogs;

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
        $storage = Storage::create([
            'stock_room_id' => $request->stock_room_id,
            'storage_name' => strtoupper($request->storage_name)
        ]);

        ActivityLogs::create(['activity_details' => 'Added Storage ID: '.$storage->id.' STORAGE NAME: '.strtoupper($storage->storage_name)]);

        return response()->json($storage->fresh());
    }

    public function updateStorage(Request $request)
    {
        $storage = Storage::find($request->id);
        $storage->update([
            "storage_name" => strtoupper($request->storage_name)
        ]);

        ActivityLogs::create(['activity_details' => 'Updated Storage Storage ID: '.$storage->id.' STORAGE NAME: '.strtoupper($request->storage_name)]);

        return response()->json($storage->fresh());
    }

    public function destroy(Request $request)
    {
        ActivityLogs::create(['activity_details' => 'Deleted  storage id: '.$request->id]);

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
