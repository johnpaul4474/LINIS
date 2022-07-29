<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;

class DepartmentController extends Controller {
	public static function wardList() { 
		return \DB::Select("SELECT * FROM nora.paul.linen_ward ORDER BY ward_name ASC");
	}

	public static function officeList() { 
		return \DB::Select("SELECT * FROM nora.paul.linen_office ORDER BY office_name ASC");
	}
}
