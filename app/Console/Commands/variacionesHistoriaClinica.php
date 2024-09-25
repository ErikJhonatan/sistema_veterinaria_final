<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class variacionesHistoriaClinica extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:variaciones-historia-clinica';

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
        $diagnosticos = [
            "Parvovirus",
            "Moquillo",
            "Leptospirosis",
            "Rabia",
            "Tos de las perreras",
            "Enfermedad de Lyme",
            "Infección por parásitos intestinales",
            "Dermatofitosis",
            "Otitis",
            "Alergias",
            "Enfermedad cardíaca",
            "Cistitis",
            "Artritis",
            "Diabetes",
            "Insuficiencia renal"
        ];
        
        foreach ($diagnosticos as $diagnostico) {
            DB::table('diagnosticos')->insert([
                'nombre' => $diagnostico
            ]);
        }
        
        $examenes_auxiliares = [
            "Hemograma Completo",
            "Bioquímica Sanguínea",
            "Análisis de Orina",
            "Radiografías (Rayos X)",
            "Ecografía",
            "Electrocardiograma (ECG)",
            "Endoscopia",
            "Citología",
            "Cultivo Bacteriano y Sensibilidad",
            "Pruebas Serológicas",
            "Pruebas de Hormonas Tiroideas",
            "Pruebas de Alergia",
            "Análisis de Heces",
            "Tomografía Computarizada (CT)",
            "Resonancia Magnética (MRI)"
        ];
        
        foreach ($examenes_auxiliares as $examen) {
            DB::table('examenes_auxiliares')->insert([
                'nombre' => $examen
            ]);
        }

    }
}
