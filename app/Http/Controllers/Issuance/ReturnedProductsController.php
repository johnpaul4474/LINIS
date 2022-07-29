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
use Carbon\Carbon;

class ReturnedProductsController extends Controller
{
    public function index() {
        $productsList  = DB::select("
            SELECT	products.id ,
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
                office.office_name,
                products.issued_ward_id,
                ward.ward_name,
                products.create_date,
                products.updated_at,
                (products.product_quantity *
                    products.product_unit_cost) as total_cost
                FROM nora.paul.linen_products as products 
                inner join nora.paul.linen_stock_rooms as stocks
                on products.stock_room_id = stocks.id
                inner join nora.paul.linen_storage as storages
                on products.storage_room_id = storages.id
                inner join nora.paul.linen_raw_materials as raw_material
                on products.raw_material_id = raw_material.id  
                left join nora.paul.linen_ward as ward
                on products.issued_ward_id = ward.id
                left join nora.paul.linen_office as office
                on products.issued_office_id = office.id
                where products.deleted_at is null
                order by products.id asc,products.is_available desc
            ");
        
        return view('issuance.returned', compact('productsList'));
    }

    public function returningProducts(Request $request) {
        Validator::make($request->all(), [
            'availableProducts' => 'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Product Returned: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office,
            "created_at"        => Carbon::now()
        ]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->increment('product_available_quantity',count($productIds));


        DB::table('nora.paul.linen_products')
            ->whereIn('id', $productIds)
            ->update([
                'is_available'              => true,	
                'is_returned'               => true,	 
                'is_issued'                 => false,         
                "updated_at"                => Carbon::now(),  
                "returned_date"             => Carbon::now(),
                'product_returned_quantity' => count($productIds) 
            ]);

        return redirect()->route('returnedProducts')->with('success', 'Returned product successfully');
    }

    public function destroy(Request $request) {
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Deleted Condemned Product stock number: ' . $request->id,
            "created_at"        => Carbon::now()
        ]);
       
        Products::where('product_bulk_id', $request->product_bulk_id)->decrement('product_available_quantity');
        Products::where('id', (int)$request->id)->delete();

        return redirect()->route('returnedProducts')->with('error', 'Condemned Product deleted successfully');
    }

    public function condemned(Request $request) {
        $productIds = explode(',', $request->productIdsCondemn);
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Product condemned: '.$request->productIdsCondemn.' Ward: '.$request->wardCondemn. ' Office: '.$request->officeCondemn,
            "created_at"        => Carbon::now(), 
        ]);

        Products::where('product_bulk_id', $request->finishedProduct)->increment('product_available_quantity',count($productIds));

        DB::table('nora.paul.linen_products')
            ->whereIn('id', $productIds)
            ->update([
                'is_available'                  => false, 
                'is_condemned'                  => true,  
                'is_returned'                   => false,	
                'is_issued'                     => false,
                "returned_date"                 => null, 
                "updated_at"                    => Carbon::now(),
                'condemned_date'                => Carbon::now(),
                'product_condemned_quantity'    => count($productIds) 
            ]);
        
        return redirect()->route('returnedProducts')->with('error', 'Condemned Product added successfully');
    }

    public function losses(Request $request) {
        $productIds = explode(',', $request->productIdsLosses);
        
        DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Product lossed: '.$request->productIdsLosses.' Ward: '.$request->wardLosses. ' Office: '.$request->officeLosses,
            "created_at"        => Carbon::now()
        ]);

        DB::table('nora.paul.linen_products')
            ->whereIn('id', $productIds)
            ->update([
                'is_available'              => false, 
                "returned_date"             => null,
                'is_returned'               => false,	
                'is_condemned'              => false,  
                'is_lossed'                 => true,
                'is_issued'                 => false,
                "updated_at"                => Carbon::now(),
                'lossed_date'               => Carbon::now(),
                'product_losses_quantity'   => count($productIds) 
            ]);
 
        return redirect()->route('returnedProducts')->with('error', 'Lossed Product added successfully');
    }
}
