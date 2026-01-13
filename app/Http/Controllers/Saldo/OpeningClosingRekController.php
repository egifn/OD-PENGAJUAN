<?php

namespace App\Http\Controllers\Saldo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpeningClosingRekController extends Controller
{
    public function index()
    {
    	return view ('saldo.opening_closing.index');
    }
}
