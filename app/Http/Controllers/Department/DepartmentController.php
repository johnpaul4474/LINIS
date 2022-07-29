<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Ward;

class DepartmentController extends Controller {
	public static function wardList() { 
		return Ward::orderBy('ward_name')->get();
	}

	public static function officeList() { 
		return Office::orderBy('office_name')->get();
	}
}
