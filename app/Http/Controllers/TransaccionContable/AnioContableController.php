<?php

namespace App\Http\Controllers\TransaccionContable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnioContableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contabilidad.anio-contable');
    }

    
}
