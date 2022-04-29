<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class DepartmentController extends Controller
{
    public static function wardList()
    { 
       return  DB::Select("SELECT * FROM jhay.linen_ward ORDER BY ward_name ASC");
    }

    public static function officeList()
    { 
       return  DB::Select("SELECT * FROM jhay.linen_office ORDER BY office_name ASC");
    }
}
