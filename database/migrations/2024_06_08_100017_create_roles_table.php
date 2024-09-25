<?php

use App\Models\Rol;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo');
            $table->timestamps();
        });

        DB::table("roles")->insert([
            ['nombre' => 'Administrador', 'codigo' => 'administrador'],
            ['nombre' => 'Vendedor', 'codigo' => 'vendedor'],
            ['nombre' => 'Doctor', 'codigo' => 'doctor'],
        ]);

        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });

        Schema::create('permisos_roles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('permiso_id');
            $table->foreign("permiso_id")->references("id")->on("permisos");

            $table->unsignedBigInteger('rol_id');
            $table->foreign("rol_id")->references("id")->on("roles");

        });

        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });

        DB::table("sedes")->insert([
            ['nombre' => 'Sede Chorrillos'],
            ['nombre' => 'Sede Lurin'],
        ]);

        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('rol_id')->default(Rol::ADMINISTRADOR)->after('remember_token');
            $table->foreign("rol_id")->references("id")->on("roles");

            $table->unsignedBigInteger('sede_id')->nullable()->after('rol_id');
            $table->foreign("sede_id")->references("id")->on("sedes");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');

        Schema::dropIfExists('permisos_roles');

        Schema::dropIfExists('permisos');

        Schema::dropIfExists('sedes');

        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('rol_id');
            $table->dropColumn('sede_id');
        });
    }
};
