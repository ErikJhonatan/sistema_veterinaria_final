<?php

namespace App\Console\Commands;

use App\Config\PermisosValue;
use App\Models\Permiso;
use App\Models\PermisoRol;
use App\Models\Rol;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PermisosRoles extends Command
{

    

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:permisos-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $permisos = PermisosValue::rolesPermisos();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
        DB::table('permisos_roles')->truncate();
        DB::table('permisos')->truncate();

        if($permisos && count($permisos) > 0){
            foreach($permisos as $item){

                $permiso = new Permiso([
                    'nombre' => $item["nombre"]
                ]);
                $permiso->timestamps = false;
                $permiso->save();
                
                if($item["administrador"]){
                    PermisoRol::insert([
                        'rol_id' => Rol::ADMINISTRADOR,
                        'permiso_id' => $permiso->id,
                    ]);
                }
                if($item["vendedor"]){
                    PermisoRol::insert([
                        'rol_id' => Rol::VENDEDOR,
                        'permiso_id' => $permiso->id,
                    ]);
                }

                if($item["doctor"]){
                    PermisoRol::insert([
                        'rol_id' => Rol::DOCTOR,
                        'permiso_id' => $permiso->id,
                    ]);
                }

               
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "Permisos generados correctamente";
        
    }
}
