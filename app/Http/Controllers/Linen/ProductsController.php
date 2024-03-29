<?php

namespace App\Http\Controllers\Linen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockRoom;
use App\Models\Storage;
use App\Models\Products;
use App\Models\LinenRawMaterials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use App\Models\ActivityLogs;

class ProductsController extends Controller
{
    public function index(Request $request) {
        $stockRoomsList = StockRoom::select()->orderBy('stock_room','asc')->get();
        $storageList = Storage::select()->orderBy('storage_name','asc')->get();
        $rawMaterials = LinenRawMaterials::orderBy('created_at','desc')->get();
        $productsList = DB::select('EXEC nora.paul.linen_getBulkProductsv2');
        
        return view('linenMaterials.linenProducts', compact('rawMaterials','stockRoomsList','storageList','productsList'));
    }

    public function addProduct(Request $request) {
        $rawMaterials = LinenRawMaterials::orderBy('created_at','asc')->get();

        //////// TO-DO clean database for new records start from 0
        $latestId = Products::orderBy('id','desc')->first();
        $newRecordId =0;

        if($latestId != null) {
            $newRecordId = (int)$latestId->id +1;
        } else {
            $newRecordId = 1;
        }

        // change validator not should be less than 0
        Validator::make($request->all(), [
            'availability' => 'required|numeric|gt:0', 
        ])->validate();

        ActivityLogs::create(['activity_details' => 'Added New Product Material ID: '.$newRecordId.'  raw material stock number: '.$request->stock_number. " raw material id: ".$request->rawMaterialId]);

        /// TO DO get logic behind creating products
        LinenRawMaterials::where('id', floatval($request->material_used))
            ->decrement('quantity', floatval($request->materialUsedQuantity));

        ActivityLogs::create(['activity_details' => 'Quantity deducted:  raw material stock number: '.$request->stock_number. " raw material id: ".$request->material_used]);

        $productCount = Products::where('raw_material_stock_number', $request->stock_number)->count() + 1;
        $quantityProduct = (int)$request->quantity + $productCount - 1; 
        $productsList = [];
        $create_date = Carbon::now()->format('H:i:s');
        $created_at = Carbon::now();
        $product_bulk_id = $request->rawMaterialId.$request->stockRoom.$request->storageRoom.$request->quantity.$request->created_at.Carbon::now()->timestamp;
        
        for ($productCount ; $productCount <= $quantityProduct; $productCount++) {
            Products::create([
                    'raw_material_id'              => $request->rawMaterialId,	
                    'raw_material_stock_number'    => $request->stock_number,
                    'material_used_quantity'       => floatval($request->materialUsedQuantity),	
                    'stock_room_id'                => $request->stockRoom,	
                    'storage_room_id'              => $request->storageRoom,	
                    'product_stock_id'             => $request->stock_number.'-'.$productCount,
                    'product_name'                 => $request->product_name,	
                    'create_date'                  => $request->created_at." ".$create_date,	
                    'product_unit'                 => $request->unit,
                    'product_quantity'             => $request->quantity,
                    'product_available_quantity'   => $request->quantity,
                    'product_condemned_quantity'   => 0,	
                    'product_losses_quantity'      => 0,
                    'product_issued_quantity'      => 0,
                    'product_returned_quantity'    => 0,
                    'product_unit_cost'            => $request->unit_cost, 
                    'is_issued'                    => false,
                    'is_available'                 => true,  
                    'is_condemned'                 => false, 
                    'is_lossed'                    => false,
                    'is_returned'                  => false,
                    'product_bulk_id'              => $product_bulk_id
                ]);
        }
      
        return redirect()->route('products')->with('success', 'Product added successfully');
    }

    public function destroy(Request $request) {
        $stringIds = $request->id;
        $productsListId = explode(',', $stringIds);
      
        ActivityLogs::create(['activity_details' => 'Deleted  Products id: '.$stringIds]);

        $rawMaterialId = Products::distinct()->whereIn('id', $productsListId)->get();

        LinenRawMaterials::where('id', $rawMaterialId[0]->raw_material_stock_number)
            ->increment('quantity', floatval($rawMaterialId[0]->material_used_quantity));

        Products::whereIn('id', $productsListId)->delete();
        
        return redirect()->route('products')->with('error', 'Raw material deleted successfully');
    }

    public function update(Request $request) {
        ActivityLogs::create(['activity_details' => 'Updated Product id: '.$request->productsId. " raw material id: ".$request->material_used]);

        Products::where('id', (int) $request->productsId)
            ->update([
                'raw_material_id'           => $request->material_used,	
                'raw_material_stock_number' => $request->stock_number,	
                'stock_room_id'             => $request->stockRoom,	
                'storage_room_id'           => $request->storageRoom,	
                'product_name'              => $request->product_name,	
                'create_date'               => $request->created_at,	
                'product_unit'              => $request->unit,
                'product_quantity'          => $request->quantity,	
                'product_unit_cost'         => $request->unit_cost,
                'available_quantity'        => $request->quantity
            ]);
        
        return redirect()->route('products')->with('info', 'Product updated successfully');
    }
}
