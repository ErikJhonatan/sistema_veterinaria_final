@extends('adminlte::page')

@section('title', 'VetSys | Escritorio')


@section('content_header')
    <h1 class="m-0 text-dark">Escritorio</h1>
@stop

@section('content')
@yield('content_body')
<div class="row">

    @if ( $permisoService->autorizado($permisosValue::VENTA_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/ventas">
                <div class="info-box" style="background-color: #fd7e14; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>
                        <span class="info-box-text">Ventas</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    @if ( $permisoService->autorizado($permisosValue::VENTA_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/cajas">
                <div class="info-box" style="background-color: #20c997; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>
                        <span class="info-box-text">Entradas/salidas</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    
    {{-- @if ( $permisoService->autorizado($permisosValue::COMPROBANTES_VER_MODULO, $permisos)) --}}
    <div class="col-sm-2">
        <a href="/comprobantes">
            <div class="info-box" style="background-color: #6f42c1; color:white">   
                <div class="info-box-content align-items-center">
                    <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                    <span class="info-box-text">Comprobantes</span>
                </div>
            </div>
        </a>    
    </div>
    {{-- @endif --}}

     
    @if ( $permisoService->autorizado($permisosValue::PRODUCTO_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/producto">
                <div class="info-box" style="background-color: #007bff; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-box"></i></span>
                        <span class="info-box-text">Productos</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    
        <div class="col-sm-2">
            <a href="/graficos-ventas">
                <div class="info-box" style="background-color: #007bff; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                        <span class="info-box-text">Gestion / Graficos</span>
                    </div>
                </div>
            </a>    
        </div>
    

    @if ( $permisoService->autorizado($permisosValue::SERVICIO_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/servicio">
                <div class="info-box" style="background-color: #dc3545; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-concierge-bell"></i></span>
                        <span class="info-box-text">Servicios</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    @if ( $permisoService->autorizado($permisosValue::PROVEEDOR_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/proveedor">
                <div class="info-box"  style="background-color: #17a2b8; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-truck-loading"></i></span>
                        <span class="info-box-text">Proveedores</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    @if ( $permisoService->autorizado($permisosValue::INVENTARIO_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/stocks">
                <div class="info-box" style="background-color: #ffc107; color:black">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-warehouse"></i></span>
                        <span class="info-box-text">Stocks</span>
                    </div>
                </div>
            </a>  
        </div>
    @endif
    
    @if ( $permisoService->autorizado($permisosValue::INVENTARIO_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/almacenes">
                <div class="info-box" style="background-color: #17a2b8; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-warehouse"></i></span>
                        <span class="info-box-text">Almacenes</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif


    @if ( $permisoService->autorizado($permisosValue::CLIENTE_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/cliente">
                <div class="info-box" style="background-color:#3c8dbc; color:#fff">
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <span class="info-box-text">Clientes</span>
                    </div>
                </div>
            </a>   
        </div>
    @endif

    @if ( $permisoService->autorizado($permisosValue::MASCOTA_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/mascota">
                <div class="info-box" style="background-color: #ff851b; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-paw"></i></span>
                        <span class="info-box-text">Mascotas</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif


    @if ( $permisoService->autorizado($permisosValue::EVENTO_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/evento">
                <div class="info-box" style="background-color: #28a745; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                        <span class="info-box-text">Eventos</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    

    @if ( $permisoService->autorizado($permisosValue::USUARIO_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/usuarios">
                <div class="info-box" style="background-color: #6c757d; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <span class="info-box-text">Usuarios</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    @if ( $permisoService->autorizado($permisosValue::ROL_VER_MODULO, $permisos))
        <div class="col-sm-2">
            <a href="/roles">
                <div class="info-box" style="background-color: #343a40; color:white">   
                    <div class="info-box-content align-items-center">
                        <span class="info-box-icon"><i class="fas fa-user-tag"></i></span>
                        <span class="info-box-text">Roles/Permiso</span>
                    </div>
                </div>
            </a>    
        </div>
    @endif

    @if ($permisoService->autorizado($permisosValue::PERMISOS_RRHH, $permisos))
    <div class="col-sm-2">
        <a href="/RRHH">
            <div class="info-box" style="background-color: #1f6bb8; color:white">   
                <div class="info-box-content align-items-center">
                    <span class="info-box-icon"><i class="fas fa-user-plus"></i></span>
                    <span class="info-box-text">Crear empleado</span>
                </div>
            </div>
        </a>    
    </div>
    <div class="col-sm-2">
        <a href="/RRHH/Work/Areas">
            <div class="info-box" style="background-color: #5587b9; color:white">   
                <div class="info-box-content align-items-center">
                    <span class="info-box-icon"><i class="fa fa-briefcase"></i></span>
                    <span class="info-box-text">Crear Area de Trabajo</span>
                </div>
            </div>
        </a>    
    </div>
    <div class="col-sm-2">
        <a href="/RRHH/Work/Organigrama">
            <div class="info-box" style="background-color: #5587b9; color:white">   
                <div class="info-box-content align-items-center">
                    <span class="info-box-icon"><i class="fa fa-sitemap"></i></span>
                    <span class="info-box-text">Organigramas</span>
                </div>
            </div>
        </a>    
    </div>

    <div class="col-sm-2">
        <a href="/RRHH/Work/Nomina/Deduccion">
            <div class="info-box" style="background-color: #5587b9; color:white">   
                <div class="info-box-content align-items-center">
                    <span class="info-box-icon"><i class="fa fa-book"></i></span>
                    <span class="info-box-text">Deducciones Nomina</span>
                </div>
            </div>
        </a>    
    </div>
    <div class="col-sm-2">
        <a href="/RRHH/Nomina/Bonificaicon/Vista">
            <div class="info-box" style="background-color: #5587b9; color:white">   
                <div class="info-box-content align-items-center">
                    <span class="info-box-icon"><i class="fa fa-book"></i></span>
                    <span class="info-box-text">Bonificaciones Nomina</span>
                </div>
            </div>
        </a>    
    </div>
    
    @endif

    

</div>
@stop
