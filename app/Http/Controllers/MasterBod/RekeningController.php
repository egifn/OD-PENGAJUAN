<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        return view('bod.master_bod.rekening.index');
    }
    
}
