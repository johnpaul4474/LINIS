<?php

namespace App\Http\Controllers\Issuance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\Products;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Linen\Requests;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\Ward;

class IssuanceController extends Controller {
    public function index(Request $request) {
        $productsList  = \DB::select("
            SELECT products.id ,
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
                products.is_returned,
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
            on products.raw_material_id = raw_material.id  where products.deleted_at is null order by products.is_available desc
        ");
        
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
         
        $wardList = Ward::orderBy('ward_name')->get();
        $officeList = Office::orderBy('office_name')->get();
    
        return view('issuance.issuance', compact('productsList','requestList','wardList','officeList'));
    }

    public function issueProduct(Request $request) {
        Validator::make($request->all(), [
            'availableProducts' => 'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        \DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Product issued: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office,
            "created_at"        => Carbon::now(), 
        ]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->decrement('product_available_quantity',(int)$request->quantity);
        
        \DB::table('nora.paul.linen_products')
            ->whereIn('id', $productIds)
            ->update([
                'is_available'              => false,
                'is_issued'                 => true,
                'is_returned'               => false,
                'is_lossed'                 => false,
                'is_condemned'              => false,            
                'issued_office_id'          => $request->office,	
                'issued_ward_id'            => $request->ward,	
                'issued_date'               => Carbon::now() ,
                'returned_date'             => null,
                'condemned_date'            => null,
                'lossed_date'               => null,
                'product_issued_quantity'   => count($productIds)           
            ]);
        
        $productsList  = \DB::select("
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
                products.is_returned,
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
            on products.raw_material_id = raw_material.id  where products.deleted_at is null  order by products.is_available desc
        ");
    
        $wardList = Ward::orderBy('ward_name')->get();
        $officeList = Office::orderBy('office_name')->get();

        return view('issuance.issuance', compact('productsList','wardList','officeList'));
    }

    public function destroy(Request $request) {
        \DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Deleted Condemned Product stock number: '.$request->id,
            "created_at"        => Carbon::now()
        ]);
       
        Products::where('product_bulk_id', $request->product_bulk_id)->decrement('product_available_quantity');
        Products::where('id', (int)$request->id)->delete();

        return redirect()->route('issuance')->with('error', 'Deleted Condemned Product deleted successfully');
    }

    public function issueProductRequest(Request $request, $requestId) {
        Validator::make($request->all(), [
            'availableProducts' => 'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        \DB::table('nora.paul.linen_activity_logs')->insert([
            'employee_id'       => Auth::user()->employee_id,
            'activity_details'  => 'Product issued: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office,
            "created_at"        => Carbon::now(), 
        ]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->decrement('product_available_quantity', (int) $request->quantity);
        
        \DB::table('nora.paul.linen_products')
            ->whereIn('id', $productIds)
            ->update([
                'is_available' => false,
                'is_issued' => true,
                'is_returned' => false,
                'is_lossed' => false,
                'is_condemned' => false,          	
                'issued_office_id' => $request->office,	
                'issued_ward_id' => $request->ward,	
                'issued_date' => Carbon::now() ,
                "returned_date" => null,
                'condemned_date' => null,
                'lossed_date' => null,
                'product_issued_quantity' => count($productIds)         
            ]);

        return redirect()->route('home')->with('success', 'Issued product successfully');
    }
}
