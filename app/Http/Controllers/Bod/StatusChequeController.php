<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusChequeController extends Controller
{
    public function index()
    {
        return view('bod.master_bod.status_cheque.index');
    }
}
