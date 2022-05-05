<?php

namespace App\Http\Controllers\Issuance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\Products;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IssuanceController extends Controller
{
    public function index(Request $request){
      
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
        products.product_unit_cost,
        raw_material.quantity as raw_material_quantity,
        products.stock_room_id,
        products.storage_room_id,
        products.is_available,
        products.is_condemned,
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
        
       
         
        return view('issuance.issuance', compact('productsList'));
    }

    public function issueProduct(Request $request){
     
        Validator::make($request->all(), [
            'availableProducts' =>  'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Product issued: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->decrement('product_available_quantity',(int)$request->quantity);

        
        DB::table('nora.paul.linen_products')
        ->whereIn('id', $productIds)
        ->update([
            'is_available' => false,	
            'issued_office_id' => $request->office,	
            'issued_ward_id' => $request->ward,	
            'issued_date' => \Carbon\Carbon::now() ,
            "returned_date" => null          
        ]);

        

    

        return redirect()->route('home')->with('success', 'Issued product successfully');
    }

    public function destroy(Request $request)
    {
        
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Deleted Condemned Product stock number: '.$request->id,
            "created_at" =>  \Carbon\Carbon::now()
            
        ]);

        
       
        Products::where('product_bulk_id', $request->product_bulk_id)->decrement('product_available_quantity');
        
        Products::where('id', (int)$request->id)->delete();

        return redirect()->route('issuance')->with('error', 'Deleted Condemned Product deleted successfully');
    }

    public function issueProductRequest(Request $request, $requestId){
     
        Validator::make($request->all(), [
            'availableProducts' =>  'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id' => Auth::user()->employee_id,
            'activity_details' => 'Product issued: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office,
            "created_at" =>  \Carbon\Carbon::now(), 
        ]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->decrement('product_available_quantity',(int)$request->quantity);

        
        DB::table('nora.paul.linen_products')
        ->whereIn('id', $productIds)
        ->update([
            'is_available' => false,	
            'issued_office_id' => $request->office,	
            'issued_ward_id' => $request->ward,	
            'issued_date' => \Carbon\Carbon::now() ,
            "returned_date" => null          
        ]);

        return redirect()->route('home')->with('success', 'Issued product successfully');
    }

}
