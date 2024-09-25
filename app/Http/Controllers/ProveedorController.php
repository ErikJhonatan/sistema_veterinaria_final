<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Services\PermisoService;
use App\Models\Proveedor;
use App\Models\FormaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::PROVEEDOR_VER_MODULO, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $proveedor = Proveedor::orderBy("created_at", "desc")->get();
        return view('proveedores.index',['proveedores'=>$proveedor]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::PROVEEDOR_CREAR, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $formaPagos = FormaPago::all(); 
        return view('proveedores.create',['formaPagos'=>$formaPagos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // $request->validate([
        //     'NombrePrveedor'=>'required|max:3',
        //     'email'=>'nullable|email'
        // ]);
        $proveedor = new Proveedor();
        $proveedor->Proveedor = $request->input('NombrePrveedor');
        $proveedor->NumeroTributario = $request->input('IdentificadorTributario');
        $proveedor->Email = $request->input('Email');
        $proveedor->CuentaBancaria = $request->input('CuentaBancaria');
        $proveedor->Direccion = $request->input('Direccion');
        $proveedor->TelefonoFijo = $request->input('TelefonoFijo');
        $proveedor->TelefonoMovil = $request->input('TelefonoMovil');
        $proveedor->Web = $request->input('SitioWeb');
        $proveedor->idFormaDePago = $request->input('FormaPago');
        $proveedor->Contacto = $request->input('PersonaContacto');
        $proveedor->Observacion = $request->input('Observaciones');

        $proveedor->save();
        return redirect()->route('proveedor.index')->with('msg','Registro guardado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::PROVEEDOR_EDITAR, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $proveedor = Proveedor::find($id);
        $formaPagos = FormaPago::all();
        return view('proveedores.edit',['proveedor'=>$proveedor,'formaPagos'=>$formaPagos ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->Proveedor = $request->input('NombrePrveedor');
        $proveedor->NumeroTributario = $request->input('IdentificadorTributario');
        $proveedor->Email = $request->input('Email');
        $proveedor->CuentaBancaria = $request->input('CuentaBancaria');
        $proveedor->Direccion = $request->input('Direccion');
        $proveedor->TelefonoFijo = $request->input('TelefonoFijo');
        $proveedor->TelefonoMovil = $request->input('TelefonoMovil');
        $proveedor->Web = $request->input('SitioWeb');
        $proveedor->idFormaDePago = $request->input('FormaPago');
        $proveedor->Contacto = $request->input('PersonaContacto');
        $proveedor->Observacion = $request->input('Observaciones');
        $proveedor->save();

        return redirect()->route('proveedor.index')->with('msg','Proveedor modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
