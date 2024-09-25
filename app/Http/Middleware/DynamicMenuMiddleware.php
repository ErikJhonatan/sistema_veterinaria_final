<?php

namespace App\Http\Middleware;

use App\Config\PermisosValue;
use App\Http\Services\PermisoService;
use App\Models\PermisoRol;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class DynamicMenuMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $menu = $this->buildMenuForUser($user);
            Config::set('adminlte.menu', $menu);
        }

        return $next($request);
    }

    protected function buildMenuForUser($user)
    {

        $permisosUsuario = PermisoService::permisosRol($user->rol_id);
        $menu =  [
            // Navbar items:
            [
                'type'         => 'navbar-search',
                'text'         => 'Buscar',
                'topnav_right' => true,
            ],
            [
                'type'         => 'fullscreen-widget',
                'topnav_right' => true,
            ],


            [
                'type'         => 'navbar-notification',
                'icon'         => 'fa fa-user-plus',
                'topnav_right' => true,
                'url'          => 'cliente/create',
                'id'           => 'idCrearCliente',
            ],
            [
                'type'         => 'navbar-notification',
                'icon'         => 'fa fa-paw',
                'topnav_right' => true,
                'url'          => 'mascota/create',
                'id'           => 'idCrearMascota',
            ],


            // Sidebar items:
            [
                'type' => 'sidebar-menu-search',
                'text' => 'Buscar',
            ],
            [
                'text' => 'blog',
                'url'  => 'admin/blog',
                'can'  => 'manage-blog',
            ],
            [
                'text'        => 'Inicio',
                'url'         => 'dashboard',
                'icon'        => 'fas fa-fw fa-home',
                'label_color' => 'success',
            ],
            (
                in_array(PermisosValue::CLIENTE_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Clientes',
                    'icon'    => 'fas fa-fw fa-users',
                    'submenu' => [
                        [
                            'text' => 'Listado',
                            'icon' => 'fas fa-fw fa-list',
                            'url'  => 'cliente',
                        ],
                        [
                            'text' => 'Gestión',
                            'icon' => 'fas fa-fw fa-chart-pie',
                            'url'  => 'clienteGraf',
                        ],
                        (
                            in_array(PermisosValue::CLIENTE_VER_AUDITORIA, $permisosUsuario) ?
                            [
                                'text' => 'Auditoria',
                                'icon' => 'fas fa-fw fa-chart-pie',
                                'url'  => 'cliente/cliente/auditoria',
                            ] : []
                        )
                    ]
                ]
                : []
            ),
            // venta
            (
                in_array(PermisosValue::VENTA_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Ventas',
                    'icon'    => 'fas fa-fw fa-dolly-flatbed',
                    'submenu' => [
                        [
                            'text' => 'Listado',
                            'icon' => 'fas fa-fw fa-list',
                            'url'  => 'ventas',
                        ],
                        (
                            in_array(PermisosValue::VENTA_CREAR, $permisosUsuario) ?
                            [
                                'text' => 'Crear Venta',
                                'icon' => 'fas fa-fw fa-plus',
                                'url'  => 'ventas/create',
                            ] : []
                        ),
                        [
                            'text' => 'Comprobantes',
                            'icon' => 'fas fa-fw fa-receipt',
                            'url'  => 'comprobantes',
                        ],
                        [
                            'text' => 'Entradas / Salidas',
                            'icon' => 'fas fa-fw fa-cash-register',
                            'url'  => 'cajas',
                        ],
                        [
                            'text' => 'Cuadrar Caja',
                            'icon' => 'fas fa-fw fa-dollar-sign',
                            'url'  => 'cuadrar-caja',
                        ],
                    ]
                ]
                : []
            ),
            // contabilidad
            (                
                in_array(PermisosValue::VENTA_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Contabilidad',
                    'icon'    => 'fas fa-fw fa-calculator',
                    'submenu' => [
                        [
                            'text' => 'Ingresos',
                            'icon' => 'fas fa-fw fa-coins',
                            'url'  => 'ingresos',
                        ],
                        [
                            'text' => 'Compras',
                            'icon' => 'fas fa-fw fa-shopping-cart',
                            'url'  => 'compras',
                        ],
                        [
                            'text' => 'Gastos',
                            'icon' => 'fas fa-fw fa-file-invoice-dollar',
                            'url'  => 'gastos',
                        ],
                        [
                            'text' => 'Capital',
                            'icon' => 'fas fa-fw fa-hand-holding-usd',
                            'url'  => 'capital',
                        ],
                        [
                            'text' => 'Equipos',
                            'icon' => 'fas fa-fw fa-tools',
                            'url'  => 'equipos',
                        ],
                        [
                            'text' => 'Reportes',
                            'icon' => 'fas fa-fw fa-file-alt',
                            'url'  => 'reportes',
                        ],
                        [
                            'text' => 'Año Contable',
                            'icon' => 'fas fa-fw fa-layer-group',
                            'url'  => 'anio-contable',
                        ],
                    ]
                ]
                : []
            ),
            // mascota
            (
                in_array(PermisosValue::MASCOTA_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Mascotas',
                    'icon'    => 'fas fa-fw fa-dog',
                    'submenu' => [
                        [
                            'text' => 'Listado',
                            'icon' => 'fas fa-fw fa-list',
                            'url'  => 'mascota',
                        ],
                        [
                            'text' => 'Gestion',
                            'icon' => 'fas fa-fw fa-chart-pie',
                            'url'  => 'mascotaGraf',
                        ],
                        (
                            in_array(PermisosValue::MASCOTA_VER_AUDITORIA, $permisosUsuario) ?
                            [
                                'text' => 'Auditoria',
                                'icon' => 'fas fa-fw fa-receipt',
                                'url'  => 'mascota/mascota/auditoria',
                            ] : []
                        ),
                    ]
                ]
                : []
            ),
            
            // gestion
            [
                'text' => 'Gestión',
                'icon' => 'fas fa-fw fa-chart-pie',
                'url'  => 'graficos-ventas',
            ],
                
            // evento
            (
                in_array(PermisosValue::EVENTO_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Eventos',
                    'icon'    => 'fas fa-fw fa-calendar',
                    'submenu' => [
                        [
                            'text' => 'Calendario',
                            'icon' => 'fas fa-fw fa-calendar-alt',
                            'url'  => 'evento',
                        ],
                        [
                            'text' => 'Listado',
                            'icon' => 'fas fa-fw fa-list',
                            'url'  => 'evento/list',
                        ],
                    ]
                ]
                : []
            ),
            // productos
            (
                in_array(PermisosValue::PRODUCTO_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Productos',
                    'icon'    => 'fas fa-fw fa-box-open',
                    'submenu' => [
                        [
                            'text' => 'Catalogo',
                            'icon' => 'fas fa-fw fa-clipboard-list',
                            'url'  => 'producto',
                        ],
                        (
                            in_array(PermisosValue::PRODUCTO_VER_AUDITORIA, $permisosUsuario) ?
                            [
                                'text' => 'Auditoria',
                                'icon' => 'fas fa-fw fa-receipt',
                                'url'  => 'producto/producto/auditoria',
                            ] : []
                        ),
                    ]
                ] : []
            ),
            // servicios
            (
                in_array(PermisosValue::SERVICIO_VER_MODULO, $permisosUsuario) ?
                [
                    'text'        => 'Servicios',
                    'icon'        => 'fas fa-fw fa-briefcase-medical',
                    'label_color' => 'success',
                    'submenu' => [
                        [
                            'text' => 'Listado',
                            'icon' => 'fas fa-fw fa-clipboard-list',
                            'url'  => 'servicio',
                        ],
                        (
                            in_array(PermisosValue::SERVICIO_VER_AUDITORIA, $permisosUsuario) ?
                            [
                                'text' => 'Auditoria',
                                'icon' => 'fas fa-fw fa-receipt',
                                'url'  => 'servicio/servicio/auditoria',
                            ] : []
                        ),
                    ]

                ] : []
            ),
            // proveedores
            (
                in_array(PermisosValue::PROVEEDOR_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Proveedores',
                    'icon'    => 'fas fa-fw fa-shopping-cart',
                    'submenu' => [
                        [
                            'text' => 'Listado',
                            'icon' => 'fas fa-fw fa-list',
                            'url'  => 'proveedor',
                        ],
                    ]
                ] : []
            ),
            // inventario
            (
                in_array(PermisosValue::INVENTARIO_VER_MODULO, $permisosUsuario) ?
                [
                    'text'    => 'Inventario',
                    'icon'    => 'fas fa-fw fa-boxes',
                    'submenu' => [
                        [
                            'text' => 'Stocks',
                            'icon' => 'fas fa-fw fa-sign-in-alt',
                            'url'  => 'stocks',
                        ],
                        [
                            'text' => 'Almacenes',
                            'icon' => 'fas fa-fw fa-warehouse',
                            'url'  => 'almacenes',
                        ],
                    ]
                ] : []
            ),
            [
                'text'    => 'Configuracion',
                'icon'    => 'fas fa-fw fa-cogs',
                'submenu' => [
                    [
                        'text' => 'Formas de Pago',
                        'icon' => 'far fa-credit-card',
                        'url'  => 'formaPago',
                    ],
                    [
                        'text' => 'Lineas',
                        'icon' => 'fas fa-fw fa-grip-lines',
                        'url'  => 'linea',
                    ],
                    [
                        'text' => 'Categorias',
                        'icon' => 'fas fa-fw fa-table',
                        'url'  => 'categoria',
                    ],
                    [
                        'text' => 'Sub Categorias',
                        'icon' => 'fas fa-fw fa-border-all',
                        'url'  => 'subCategoria',
                    ],
                    [
                        'text' => 'Presentacion',
                        'icon' => 'fas fa-fw fa-book-medical',
                        'url'  => 'presentacion',
                    ],
                    [
                        'text' => 'Unidad de Medida',
                        'icon' => 'fas fa-fw fa-vial',
                        'url'  => 'unidadMedida',
                    ],
                    [
                        'text' => 'Especies',
                        'icon' => 'fas fa-fw fa-dove',
                        'url'  => 'especie',
                    ],
                    [
                        'text' => 'Razas',
                        'icon' => 'fas fa-fw fa-paw',
                        'url'  => 'raza',
                    ],
                    [
                        'text' => 'Tipos de Evento',
                        'icon' => 'fas fa-fw fa-calendar',
                        'url'  => 'tipoEvento',
                    ],
                    [
                        'text' => 'Estados de Evento',
                        'icon' => 'fas fa-fw fa-calendar-check',
                        'url'  => 'estadoEvento',
                    ],
                    [
                        'text' => 'Notificaciones de Evento',
                        'icon' => 'fas fa-fw fa-calendar-week',
                        'url'  => 'notificacion',
                    ],
                    [
                        'text' => 'Tipo de Almacen',
                        'icon' => 'fas fa-fw fa-boxes',
                        'url'  => 'tipoAlmacen',
                    ],
                    (
                        in_array(PermisosValue::USUARIO_VER_MODULO, $permisosUsuario) ?
                        [
                            'text' => 'Usuarios',
                            'icon' => 'fas fa-fw fa-users',
                            'url'  => 'usuarios',
                        ] : []
                    ),
                    (
                        in_array(PermisosValue::ROL_VER_MODULO, $permisosUsuario) ?
                        [
                            'text' => 'Roles',
                            'icon' => 'fas fa-fw fa-user-tag',
                            'url'  => 'roles',
                        ] : []
                    ),
                ]
            ],

        ];



        return $menu;
    }
}
