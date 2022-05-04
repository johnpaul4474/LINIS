<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Linen\Requests;

class ServiceController extends Controller
{
    public function index(){
        $newRequest = Requests::select()->where('status',1)->orderBy('created_at', 'desc' )->get();

        return view('requests.services',compact('newRequest'));
    }
}
