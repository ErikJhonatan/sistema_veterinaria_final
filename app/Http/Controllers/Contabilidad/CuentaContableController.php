<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\CuentaContable;

class CuentaContableController extends Controller
{
    //
    protected function getCuentaContableHierarchy($cuentas, $parentId = null)
    {
        $result = [];

        foreach ($cuentas as $cuenta) {
            if ($cuenta->cuenta_contable_id == $parentId) {
                $children = $this->getCuentaContableHierarchy($cuentas, $cuenta->id);

                if ($children) {
                    $cuenta->subcuentas = $children;
                }

                $result[] = $cuenta;
            }
        }

        return $result;
    }
    public function index()
    {
        $cuentas = CuentaContable::all();
        $cuentasJerarquicas = $this->getCuentaContableHierarchy($cuentas);
        return response()->json($cuentasJerarquicas);
    }
}
