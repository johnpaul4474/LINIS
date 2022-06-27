<?php

namespace App\Http\Controllers\Linen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\StockRoom;
use App\Models\Linen\Storage;
use App\Models\Linen\Products;
use App\Models\Linen\LinenRawMaterials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        $stockRoomsList = StockRoom::select()->orderBy('stock_room','asc')->get();
        $storageList = Storage::select()->orderBy('storage_name','asc')->get();
        // $rawMaterials = DB::select("select * , (raw_material.quantity * raw_material.unit_cost) as total_price from [nora].[paul].[linen_raw_materials] as raw_material");
        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','desc')->get();
        $productsList = DB::select('EXEC nora.paul.linen_getBulkProductsv2');

        
        
        return view('linenMaterials.linenProducts', compact('rawMaterials','stockRoomsList','storageList','productsList'));
    }

    public function addProduct(Request $request)
    {
       
        $rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();

        //////// TO-DO clean database for new records start from 0
        $latestId = DB::table('nora.paul.linen_products')->whereNull('deleted_at')->orderBy('id','desc')->first();
        $newRecordId =0;
        if($latestId != null){
            $newRecordId = (int)$latestId->id +1;
        }else{
            $newRecordId = 1;
        }

        // if($request->isArchived == true){    
        //     $isArchived = true ;      
        //     // Validator::make($request->all(), [
        //     //     'received_at' =>  'required|date|before_or_equal:2021-12-31', 
        //     // ])->validate();
        // }else{
        //     $isArchived = false ;    
        // }

            // change validator not should be less than 0

        Validator::make($request->all(), [
                'availability' =>  'required|numeric|gt:0', 
            ])->validate();

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Added New Product Material ID: '.$newRecordId.'  raw material stock number: '.$request->stock_number. " raw material id: ".$request->rawMaterialId,
            "created_at" =>  \Carbon\Carbon::now(),             
        ]);

        /// TO DO get logic behind creating products
        DB::table('nora.paul.linen_raw_materials')
        ->where('id', floatval($request->material_used))
        ->decrement('quantity', floatval($request->materialUsedQuantity));

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Quantity deducted:  raw material stock number: '.$request->stock_number. " raw material id: ".$request->material_used,
            "created_at" =>  \Carbon\Carbon::now(),             
        ]);
        

        $productCount = DB::table('nora.paul.linen_products')-> where('raw_material_stock_number',$request->stock_number)
                                ->count() + 1;
                               


        $quantityProduct = (int)$request->quantity + $productCount - 1; 
        $productsList = [];
        $create_date = \Carbon\Carbon::now()->format('H:i:s');
        $created_at = \Carbon\Carbon::now();
        //dd(\Carbon\Carbon::now()->format('His'),\Carbon\Carbon::now()->timestamp);
        $product_bulk_id = $request->rawMaterialId.$request->stockRoom.$request->storageRoom.$request->quantity.$request->created_at.\Carbon\Carbon::now()->timestamp;
        
        for ($productCount ; $productCount <= $quantityProduct; $productCount++){
            DB::table('nora.paul.linen_products')
            ->insert(
                    [   'raw_material_id' => $request->rawMaterialId,	
                        'raw_material_stock_number' => $request->stock_number,
                        'material_used_quantity' => floatval($request->materialUsedQuantity),	
                        'stock_room_id' => $request->stockRoom,	
                        'storage_room_id' => $request->storageRoom,	
                        'product_stock_id' => $request->stock_number.'-'.$productCount,
                        'product_name' => $request->product_name,	
                        'create_date' => $request->created_at." ".$create_date,	
                        'product_unit' => $request->unit,
                        'product_quantity' =>$request->quantity,
                        'product_available_quantity' =>$request->quantity,
                        'product_condemned_quantity' =>0,	
                        'products.product_losses_quantity' =>0,
                        'products.product_issued_quantity' =>0,
                        'products.product_returned_quantity' =>0,
                        'product_unit_cost' => $request->unit_cost, 
                        'is_issued' => false,
                        'is_available' => true,  
                        'is_condemned' => false, 
                        'is_lossed'     =>false,
                        'is_returned' => false,                        
                        'created_at' => $created_at,
                        'product_bulk_id'=>$product_bulk_id
                ]);
        }    


       
     
      
       return redirect()->route('products')->with('success', 'Product added successfully');
    }

    public function destroy(Request $request)
    {
        

        $stringIds = $request->id;
        $productsListId = explode(',', $stringIds);
      
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Deleted  Products id: '.$stringIds,
            "created_at" =>  \Carbon\Carbon::now()
            
        ]);

        //$rawMaterials = LinenRawMaterials::select()->orderBy('created_at','asc')->get();
        $rawMaterialId = Products::distinct()
                        ->whereIn('id', $productsListId)->get();
        //dd($productsListId,$rawMaterialId[0]->raw_material_stock_number,$rawMaterialId[0]->material_used_quantity);

        DB::table('nora.paul.linen_raw_materials')
        ->where('id', $rawMaterialId[0]->raw_material_stock_number)
        ->increment('quantity', floatval($rawMaterialId[0]->material_used_quantity));


        Products::whereIn('id', $productsListId)->delete();
        // $product =Products::select()->where('id', $request->id)->get();
        // dd($product[0]->product_name);
        return redirect()->route('products')->with('error', 'Raw material deleted successfully');
    }

    public function update(Request $request){
       
       
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Updated Product id: '.$request->productsId. " raw material id: ".$request->material_used,
            "updated_at" =>  \Carbon\Carbon::now(),             
        ]);

        DB::table('nora.paul.linen_products')
        ->where('id', (int)$request->productsId)
        ->update([
        'raw_material_id' => $request->material_used,	
        'raw_material_stock_number' => $request->stock_number,	
        'stock_room_id' => $request->stockRoom,	
        'storage_room_id' => $request->storageRoom,	
        'product_name' => $request->product_name,	
        'create_date' => $request->created_at,	
        'product_unit' => $request->unit,
        'product_quantity' =>$request->quantity,	
        'product_unit_cost' => $request->unit_cost,        
        'created_at' => \Carbon\Carbon::now(),
        'available_quantity' => $request->quantity,
           
       ]);
       return redirect()->route('products')->with('info', 'Product updated successfully');
    }

}
