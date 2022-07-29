<?php

namespace App\Http\Controllers\Issuance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\Products;
use App\Views\ProductsList;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReturnedProductsController extends Controller
{
    public function index() {
        $productsList  = ProductsList::all();
        
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

        Products::whereIn('id', $productIds)
            ->update([
                'is_available'              => true,	
                'is_returned'               => true,	 
                'is_issued'                 => false,         
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

        Products::whereIn('id', $productIds)
            ->update([
                'is_available'                  => false, 
                'is_condemned'                  => true,  
                'is_returned'                   => false,	
                'is_issued'                     => false,
                "returned_date"                 => null, 
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

        Products::whereIn('id', $productIds)
            ->update([
                'is_available'              => false, 
                "returned_date"             => null,
                'is_returned'               => false,	
                'is_condemned'              => false,  
                'is_lossed'                 => true,
                'is_issued'                 => false,
                'lossed_date'               => Carbon::now(),
                'product_losses_quantity'   => count($productIds) 
            ]);
 
        return redirect()->route('returnedProducts')->with('error', 'Lossed Product added successfully');
    }
}
