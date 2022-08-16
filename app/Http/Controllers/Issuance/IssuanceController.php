<?php

namespace App\Http\Controllers\Issuance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Requests;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\Ward;
use App\Views\ProductsList;
use App\Models\ActivityLogs;

class IssuanceController extends Controller {
    public function index(Request $request) {
        $productsList  = ProductsList::all();
        
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
         
        $wardList = Ward::all();
        $officeList = Office::all();
    
        return view('issuance.issuance', compact('productsList','requestList','wardList','officeList'));
    }

    public function issueProduct(Request $request) {
        Validator::make($request->all(), [
            'availableProducts' => 'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        ActivityLogs::create(['activity_details' => 'Product issued: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->decrement('product_available_quantity',(int)$request->quantity);
        
        foreach($productIds as $id) {
            $product = Products::find($id);
            $product->update([
                'is_available'              => false,
                'is_issued'                 => true,
                'is_returned'               => false,
                'is_lossed'                 => false,
                'is_condemned'              => false,            
                'issued_office_id'          => $request->office,	
                'issued_ward_id'            => $request->ward,	
                'issued_date'               => Carbon::now(),
                'returned_date'             => null,
                'condemned_date'            => null,
                'lossed_date'               => null,
                'product_issued_quantity'   => count($productIds),
                'product_unit_cost'         => $product->product_unit_cost*(100 + $request->additional)/100,
                'issuance_additional_cost'  => $request->additional
            ]);
        }
        
        $productsList  = ProductsList::all();
        $wardList = Ward::all();
        $officeList = Office::all();

        return view('issuance.issuance', compact('productsList','wardList','officeList'));
    }

    public function destroy(Request $request) {
        ActivityLogs::create(['activity_details' => 'Deleted Condemned Product stock number: '.$request->id]);
       
        Products::where('product_bulk_id', $request->product_bulk_id)->decrement('product_available_quantity');
        Products::where('id', (int)$request->id)->delete();

        return redirect()->route('issuance')->with('error', 'Deleted Condemned Product deleted successfully');
    }

    public function issueProductRequest(Request $request, $requestId) {
        Validator::make($request->all(), [
            'availableProducts' => 'required|numeric|gt:-1', 
        ])->validate();

        $productIds = explode(',', $request->productIds);

        ActivityLogs::create(['activity_details' => 'Product issued: '.$request->productIds.' Ward: '.$request->ward.' Office: '.$request->office]);
        
        Products::where('product_bulk_id', $request->finishedProduct)->decrement('product_available_quantity', (int) $request->quantity);
        
        Products::whereIn('id', $productIds)
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
