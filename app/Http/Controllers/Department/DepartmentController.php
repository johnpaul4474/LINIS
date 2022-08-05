<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Ward;

class DepartmentController extends Controller {
	public static function wardList() { 
		return Ward::all();
	}

	public static function officeList() { 
		return Office::all();
	}

	public function index() {
		$wards = $this->wardList();
		$offices = $this->officeList();

		return view("departments.departmentsList", compact('wards', 'offices'));
	}

	public function wardIssuedProducts($ward_id) {
		$name = Ward::find($ward_id)->ward_name;
		$type = "(WARD)";

		$products = \DB::select("
			select
				product_stock_id,
				product_unit,
				product_quantity,
				product_unit_cost,
				total_cost,
				product_name,
				case
					when is_condemned=1 then 'Condemned'
					when is_lossed=1 then 'Lost'
					when is_returned=1 then 'Returned'
					else 'Issued'
				end as status
			from nora.paul.linen_products_list
			where issued_ward_id = ?
		", [$ward_id]);

		return view("departments.issuedProducts", compact('products', 'name', 'type'));
	}

	public function officeIssuedProducts($office_id) {
		$name = Office::find($office_id)->office_name;
		$type = "(OFFICE)";
		
		$products = \DB::select("
			select
				product_stock_id,
				product_unit,
				product_quantity,
				product_unit_cost,
				total_cost,
				product_name,
				case
					when is_condemned=1 then 'Condemned'
					when is_lossed=1 then 'Lost'
					when is_returned=1 then 'Returned'
					else 'Issued'
				end as status
			from nora.paul.linen_products_list
			where issued_office_id = ?
		", [$office_id]);

		return view("departments.issuedProducts", compact('products', 'name', 'type'));
	}
}
