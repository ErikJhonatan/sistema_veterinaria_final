<?php

use App\Models\Comprobante;
use Database\Seeders\TiposComprobantes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => TiposComprobantes::class]);

        DB::table('comprobantes')->update(['tipo_id' => Comprobante::BOLETA]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
