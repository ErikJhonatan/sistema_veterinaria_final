<?php

namespace App\Config;

class PermisosValue {

    const CLIENTE_VER_MODULO = 'cliente_ver_modulo';
    const CLIENTE_CREAR = 'cliente_crear';
    const CLIENTE_EDITAR = 'cliente_editar';
    const CLIENTE_ELIMINAR = 'cliente_eliminar';
    const CLIENTE_VER_AUDITORIA = 'cliente_ver_auditoria';

    const VENTA_VER_MODULO = 'venta_ver_modulo';
    const VENTA_CREAR = 'venta_crear';
    const VENTA_ELIMINAR = 'venta_eliminar';

    const MASCOTA_VER_MODULO = 'mascota_ver_modulo';
    const MASCOTA_CREAR = 'mascota_crear';
    const MASCOTA_EDITAR = 'mascota_editar';
    const MASCOTA_ELIMINAR = 'mascota_eliminar';
    const MASCOTA_VER_AUDITORIA = 'mascota_ver_auditoria';

    const PRODUCTO_VER_MODULO = 'producto_ver_modulo';
    const PRODUCTO_CREAR = 'producto_crear';
    const PRODUCTO_EDITAR = 'producto_editar';
    const PRODUCTO_ELIMINAR = 'producto_eliminar';
    const PRODUCTO_VER_AUDITORIA = 'producto_ver_auditoria';

    const EVENTO_VER_MODULO = 'evento_ver_modulo';
    const EVENTO_CREAR = 'evento_crear';
    const EVENTO_EDITAR = 'evento_editar';
    const EVENTO_ELIMINAR = 'evento_eliminar';

    const SERVICIO_VER_MODULO = 'servicio_ver_modulo';
    const SERVICIO_CREAR = 'servicio_crear';
    const SERVICIO_EDITAR = 'servicio_editar';
    const SERVICIO_ELIMINAR = 'servicio_eliminar';
    const SERVICIO_VER_AUDITORIA = 'servicio_ver_auditoria';

    const PROVEEDOR_VER_MODULO = 'proveedor_ver_modulo';
    const PROVEEDOR_CREAR = 'proveedor_crear';
    const PROVEEDOR_EDITAR = 'proveedor_editar';
    const PROVEEDOR_ELIMINAR = 'proveedor_eliminar';

    CONST INVENTARIO_VER_MODULO = 'inventario_ver_modulo';
    CONST INVENTARIO_MODIFICAR = 'inventario_modificar';

    const USUARIO_VER_MODULO = 'usuario_ver_modulo';
    const USUARIO_CREAR = 'usuario_crear';
    const USUARIO_EDITAR = 'usuario_editar';
    const USUARIO_ELIMINAR = 'usuario_eliminar';

    const ROL_VER_MODULO = 'rol_ver_modulo';
    const PERMISOS_RRHH = 'permisos_rrhh';

    public static function rolesPermisos(){
        return [
            [
                'nombre' => self::CLIENTE_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => true,
            ],
            [
                'nombre' => self::PERMISOS_RRHH,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
                'rrhh' => true,
            ],
            [
                'nombre' => self::CLIENTE_CREAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::CLIENTE_EDITAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::CLIENTE_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::CLIENTE_VER_AUDITORIA,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::VENTA_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::VENTA_CREAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::VENTA_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::MASCOTA_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => true,
            ],
            [
                'nombre' => self::MASCOTA_CREAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::MASCOTA_EDITAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::MASCOTA_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::PRODUCTO_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::PRODUCTO_CREAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::PRODUCTO_EDITAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::PRODUCTO_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::PRODUCTO_VER_AUDITORIA,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::EVENTO_VER_MODULO,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::EVENTO_CREAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::EVENTO_EDITAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::EVENTO_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::SERVICIO_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => true,
            ],
            [
                'nombre' => self::SERVICIO_CREAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => true,
            ],
            [
                'nombre' => self::SERVICIO_EDITAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => true,
            ],
            [
                'nombre' => self::SERVICIO_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => true,
            ],
            [
                'nombre' => self::PROVEEDOR_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::PROVEEDOR_CREAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::PROVEEDOR_EDITAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::PROVEEDOR_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::INVENTARIO_VER_MODULO,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
            [
                'nombre' => self::INVENTARIO_MODIFICAR,
                'administrador' => true,
                'vendedor' => true,
                'doctor' => false,
            ],
           
            [
                'nombre' => self::USUARIO_VER_MODULO,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::USUARIO_CREAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::USUARIO_EDITAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::USUARIO_ELIMINAR,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::ROL_VER_MODULO,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::SERVICIO_VER_AUDITORIA,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ],
            [
                'nombre' => self::MASCOTA_VER_AUDITORIA,
                'administrador' => true,
                'vendedor' => false,
                'doctor' => false,
            ]
            
        ];
    }

}
