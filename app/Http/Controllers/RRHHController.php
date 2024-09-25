<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employes;
use App\Models\Genere;
use App\Models\Employes_title;
use App\Models\Work_area;
use Illuminate\Validation\Rule;
use App\Models\Employes_status;
use App\Models\Degree_education;
use App\Models\Path_certification;
use App\Models\Job_reference;
use App\Models\Additional_information;
use App\Models\Evalution_employes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmployeeRegistered;
use Illuminate\Support\Facades\Mail;
use App\Models\Asistencia;
use App\Models\deducciones;
use App\Models\bonificacion;


class RRHHController extends Controller
{
    public function IndexEmployes(){
        $Employes = Employes::select(
            'employes.id',
            'employes.name as Name_employe',
            'employes.phone',
            'employes.email',
            'employes.birthdate',
            'genere.name as GenereName',
            'employes.address',
            'employes.phone_emergency',
            'employes_title.name as EmployeTitle',
            'work_area.name as WorkArea',
            'employe1.name as Supervisor',
            'employes.start_work',
            'employes_status.name as EmployesStatus',
            'employes.start_working_hours',
            'employes.end_working_hours',
            'degree_education.name as DegreeName',
            'employes.path_certification',
            'employes.animal_handling_experience',
            'employes.path_health_safety_information',
            'employes.path_medical_conditions',
            'employes.path_job_references',
            'employes.additional_information',
            'employes.notes'

        )
        ->where('employes.es_activo',1)
        ->join('work_area','work_area.id','=','employes.work_area')
        ->join('degree_education','degree_education.id','=','employes.degree_education')
        ->join('employes_title','employes_title.id','=','employes.employee_title')
        ->join('employes as employe1','employe1.id','=','employes.id')
        ->join('employes_status','employes_status.id','=','employes.employment_status')
        ->join('genere','genere.id','=','employes.genere')
        ->get();

        return view('RRHH.employes.View')->with('employes',$Employes)->with('Menss',session('Menss'));
    }
    public function CreateEmploye(){
        $Genere = Genere::all();
        $Employes_title = Employes_title::all();
        $Work_area = Work_area::where('es_activo',1)->get();
        $Sup = Employes::where('es_activo',1)->get();
        $EEstatus = Employes_status::all();
        $Degree = Degree_education::all();
        return view('RRHH.employes.Create')
        ->with('genere',$Genere)
        ->with('employe_title',$Employes_title)
        ->with('work_area',$Work_area)
        ->with('sup',$Sup)
        ->with('employment_status',$EEstatus)
        ->with('Grade',$Degree);
    }
    public function WorkAreaIndex(){
        $Work_area = Work_area::where('es_activo',1)->get();
        return view('RRHH.WorkArea.View')->with('WorkArea',$Work_area)->with('Menss',session('Menss'));
    }
    public function WorkAreaCreate(){
        return view('RRHH.WorkArea.Create');
    }
    public function WorkAreaCreateForm(Request $request){
        $request->validate([
            'name' => [
                'required',
                Rule::unique('work_area')->where(function ($query) {
                    return $query->where('es_activo', 1);
                }),
            ],
        ]);
        try {
            $Work_area = new Work_area();
            $Work_area->name = $request->name;
            $Work_area->create_user = Auth()->user()->id;
            $Work_area->save();
            return redirect()->route('WorkAreaIndex')->with('Menss',1);
        } catch (\Throwable $th) {
            return redirect()->route('WorkAreaIndex')->with('Menss',2);
        }
    }
    public function WorkAreaDelete($id){
        if(empty($id)){
            return redirect()->route('WorkAreaIndex')->with('Menss',3);
        }else{
            $WorkAreaValidate = Work_area::where('id',$id)->where('create_user',Auth()->user()->id)->exists();
            if($WorkAreaValidate){
              try {
                Work_area::where('id',$id)
                ->update([
                    'es_activo' => 0
                ]);
                return redirect()->route('WorkAreaIndex')->with('Menss',5);
              } catch (\Throwable $th) {
                return redirect()->route('WorkAreaIndex')->with('Menss',2);
              }
            }else{
                return redirect()->route('WorkAreaIndex')->with('Menss',4);
            }
        }
    }
    public function WorkAreaEdit($id){
        $Work_Area = Work_area::where('id',$id)->first();
        return view('RRHH.WorkArea.Edit')->with('Work_Area',$Work_Area);
    }
    public function WorkAreaEditForm(Request $request){
        $request->validate([
            'name' => [
                'required',
                Rule::unique('work_area')->where(function ($query) {
                    return $query->where('es_activo', 1);
                }),
            ],
        ]);
        try {
            Work_area::where('id',$request->id)
            ->update([
                'name' => $request->name
            ]);
            return redirect()->route('WorkAreaIndex')->with('Menss',6);
        } catch (\Throwable $th) {
            return redirect()->route('WorkAreaIndex')->with('Menss',2);
        }
    }
    public function CreateEmployeForm(Request $request){
        
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric|unique:employes',
            'email' =>'email|unique:employes|required',
            'birthdate' => 'required|date',
            'genere' => 'required|integer',
            'address' => 'required|string',
            'phone_emergency' => 'required|numeric',
            'employe_title' => 'integer|required',
            'work_area' => 'integer|required',
            //'supervisor', => 'integer|required',
            'FIL' => 'required|date',
            'employment_status' => 'required|integer',
            'HIT' => 'required|date_format:H:i',
            'HET' => 'required|date_format:H:i',
            'GDE' => 'required|integer',
            'certification.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'EMA' => 'required|boolean',
            'CDM' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'RDV' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'IFA.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'required|string'

        ]);

            $NewEmploye = new Employes();
            $NewEmploye->name = $request->name;
            $NewEmploye->phone = $request->phone;
            $NewEmploye->email = $request->email;
            $NewEmploye->birthdate = $request->birthdate;
            $NewEmploye->genere = $request->genere;
            $NewEmploye->address = $request->address;
            $NewEmploye->phone_emergency = $request->phone_emergency;
            $NewEmploye->employee_title = $request->employe_title;
            $NewEmploye->work_area = $request->work_area;
            $NewEmploye->supervisor = 1;
            $NewEmploye->start_work = $request->FIL;
            $NewEmploye->employment_status = $request->employment_status;
            $NewEmploye->start_working_hours = $request->HIT;
            $NewEmploye->end_working_hours = $request->HET;
            $NewEmploye->degree_education = $request->GDE;
            $NewEmploye->animal_handling_experience = $request->EMA;
            if ($request->hasFile('RDV')) {
                $health_safety_information = $request->file('RDV');
                $path_health_safety_information = $health_safety_information->store('Registros_Vacunacion', 'public');
                $NewEmploye->path_health_safety_information = $path_health_safety_information;
            }
            
            if ($request->hasFile('CDM')) {
                $medical_conditions = $request->file('CDM');
                $path_medical_conditions = $medical_conditions->store('Condiciones_medicas', 'public');
                $NewEmploye->path_medical_conditions = $path_medical_conditions;
            }
            $NewEmploye->notes = $request->notes;
            $NewEmploye->save();
            $NewEmployeID = $NewEmploye->id;
            Employes::where('id',$NewEmployeID)
            ->update([
                'path_certification' => $NewEmployeID,
                'path_job_references' => $NewEmployeID,
                'additional_information' => $NewEmployeID,
            ]);
            if ($request->hasFile('certification')) {
                foreach ($request->file('certification') as $file) {
                    $path = $file->store('public/certifications');
                    $path = str_replace('public/', 'Certificados', $path); 
                    $Certification = new Path_certification();
                    $Certification->path = $path;
                    $Certification->id_employe = $NewEmployeID;
                    $Certification->save();
                    
                }
            }
            if ($request->hasFile('RLB')) {
                foreach ($request->file('RLB') as $file) {
                    $path = $file->store('public/Referencias');
                    $path = str_replace('public/', 'Referencias', $path); 
                    $Certification = new Job_reference();
                    $Certification->job_references = $path;
                    $Certification->id_employe = $NewEmployeID;
                    $Certification->save();
                    
                }
            }
            if ($request->hasFile('IFA')) {
                foreach ($request->file('IFA') as $file) {
                    $path = $file->store('public/IFA');
                    $path = str_replace('public/', 'IFA', $path); 
                    $Certification = new Additional_information();
                    $Certification->path= $path;
                    $Certification->id_usuario = $NewEmployeID;
                    $Certification->save();
                    
                }
            }
            $qrCodeData = $request->input('qr_code');
            $qrCodeData = str_replace('data:image/png;base64,', '', $qrCodeData);
            $qrCodeData = base64_decode($qrCodeData);
            $qrPath = 'qrcodes/employee_' . uniqid() . '.png';
            Storage::put($qrPath, $qrCodeData);
            Mail::to($request->email)->send(new EmployeeRegistered($request, $qrPath));
            return redirect()->route('ViewEmployes')->with('Menss',1);
       
     
    }
    public function EditEmploye($id){
        $Employes = Employes::where('id',$id)->first();
        $Genere = Genere::all();
        $Employes_title = Employes_title::all();
        $Work_area = Work_area::where('es_activo',1)->get();
        $Sup = Employes::where('es_activo',1)->get();
        $EEstatus = Employes_status::all();
        $Degree = Degree_education::all();
        return view('RRHH.employes.Edit')
        ->with('employes',$Employes)
        ->with('genere',$Genere)
        ->with('employe_title',$Employes_title)
        ->with('work_area',$Work_area)
        ->with('sup',$Sup)
        ->with('employment_status',$EEstatus)
        ->with('Grade',$Degree);
    }
    public function EditEmployeForm(Request $request){
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' =>'email|required',
            'birthdate' => 'required|date',
            'genere' => 'required|integer',
            'address' => 'required|string',
            'phone_emergency' => 'required|numeric',
            'employe_title' => 'integer|required',
            'work_area' => 'integer|required',
            //'supervisor', => 'integer|required',
            'FIL' => 'required|date',
            'employment_status' => 'required|integer',
            'HIT' => 'required',
            'HET' => 'required',
            'GDE' => 'required|integer',
            'notes' => 'required|string'

        ]);
        try {
            Employes::where('id',$request->id)
            ->update([
              'name' => $request->name,
              'phone' => $request->phone,
               'email' => $request->email,
               'birthdate' => $request->birthdate,
               'genere' => $request->genere,
               'address' => $request->address,
               'phone_emergency' => $request->phone_emergency,
               'employee_title' => $request->employe_title,
               'work_area' => $request->work_area,
               'supervisor' => $request->supervisor,
               'start_work' => $request->FIL,
               'employment_status' => $request->employment_status,
               'start_working_hours' => $request->HIT,
               'end_working_hours' => $request->HET,
               'degree_education' => $request->GDE,
               'notes' => $request->notes
            ]);
            return redirect()->route('ViewEmployes')->with('Menss',3);
        } catch (\Throwable $th) {
            return redirect()->route('ViewEmployes')->with('Menss',2);
        }

    }
    public function EvaluateEmploye($id){
        $Employe = Employes::select('employes.id','employes.name','work_area.name as WN')
        ->where('employes.id',$id)
        ->join('work_area','work_area.id','=','employes.work_area')
        ->first();
        return view('RRHH.employes.evaluate')->with('id',$id)->with('Employe',$Employe);
    }
    public function EvaluateEmployeForm(Request $request){
        
        $request->validate([
            'id' => 'required',
            'quality' => 'required|integer|max:5',
            'quantity' => 'required|integer|max:5',
            'CDP' => 'required|integer|max:5',
            'LDM' => 'required|integer|max:5',
            'COMDL' => 'required|string|max:255',
            'CT' => 'required|integer|max:5',
            'CDA' => 'required|integer|max:5',
            'COMHT' => 'required|string|max:255',
            'TEE' => 'required|integer|max:5',
            'Comu' => 'required|integer|max:5',
            'LiD' => 'required|integer|max:5',
            'COMHI' => 'required|string|max:255',
            'INI' => 'required|integer|max:5',
            'ACT' =>  'required|integer|max:5',
            'FIAB' => 'required|integer|max:5',
            'COMCYA' => 'required|string|max:255',
            'PC' =>  'required|integer|max:5',
            'DH'=> 'required|integer|max:5',
            'FR' => 'required|integer|max:5',
            'COMDES' => 'required|string|max:255',
            'OE' => 'required|integer|max:5',
            'IEN' => 'required|integer|max:5',
            'COMOR' => 'required|string|max:255',
            'COME360' => 'required|string|max:255',
            'PF' => 'required|string|max:255',
            'ADM' => 'required|string|max:255',
            'OPEPP' =>  'required|string|max:255',
            'PDD' => 'required|string|max:255',
        ]);
        
         $currentMonth = date('m'); 
        $currentYear = date('Y'); 

$exists = Evalution_employes::where('employe_id', $request->id)
    ->whereMonth('created_at', $currentMonth)
    ->whereYear('created_at', $currentYear)
    ->exists();

    if ($exists) {
        return redirect()->route('ViewEmployes')->with('Menss',4);
    } else {
    try {
        $NewEvaluate = new Evalution_employes();
        $NewEvaluate->employe_id = $request->id;
        $NewEvaluate->evaluator = Auth()->user()->id;
        $NewEvaluate->quality_work = $request->quality;
        $NewEvaluate->quantity_work = $request->quantity;
        $NewEvaluate->CDP = $request->CDP;
        $NewEvaluate->LDM = $request->LDM;
        $NewEvaluate->COMDL = $request->COMDL;
        $NewEvaluate->CT = $request->CT;
        $NewEvaluate->CDA = $request->CDA;
        $NewEvaluate->COMHT = $request->COMHT;
        $NewEvaluate->TEE = $request->TEE;
        $NewEvaluate->Comu = $request->Comu;
        $NewEvaluate->LiD = $request->LiD;
        $NewEvaluate->COMHI = $request->COMHI;
        $NewEvaluate->INI = $request->INI;
        $NewEvaluate->ACT = $request->ACT;
        $NewEvaluate->FIAB = $request->FIAB;
        $NewEvaluate->COMCYA = $request->COMCYA;
        $NewEvaluate->PC = $request->PC;
        $NewEvaluate->DH = $request->DH;
        $NewEvaluate->FR = $request->FR;
        $NewEvaluate->COMDES = $request->COMDES;
        $NewEvaluate->OE = $request->OE;
        $NewEmploye->Salario_Bruto = $request->salario_bruto;
        $NewEvaluate->IEN = $request->IEN;
        $NewEvaluate->COMOR = $request->COMOR;
        $NewEvaluate->AUTO = $request->AUTO;
        $NewEvaluate->EPP = $request->EPP;
        $NewEvaluate->EDSUP = $request->EDSUP;
        $NewEvaluate->EDSUB = $request->EDSUB;
        $NewEvaluate->COME360 = $request->COME360;
        $NewEvaluate->PF = $request->PF;
        $NewEvaluate->ADM = $request->ADM;
        $NewEvaluate->OPEPP = $request->OPEPP;
        $NewEvaluate->PDD = $request->PDD;
        $NewEvaluate->save();
        return redirect()->route('ViewEmployes')->with('Menss',5);
    } catch (\Throwable $th) {
        return redirect()->route('ViewEmployes')->with('Menss',2);
    }
   }

    }
    public function ViewEvaluations($id){
        if(empty($id)){
            return redirect()->route('ViewEmployes')->with('Menss',2);  
        }else{
           $Evaluations = Evalution_employes::where('employe_id',$id)->get();
           $EmployeName = Employes::where('id',$id)->value('name');
           return view('RRHH.employes.ViewEvaluation')->with('evaluation',$Evaluations)->with('EmployeName',$EmployeName); 
        }
    }
    public function EvaluationTable($id){
        if(empty($id)){
            return redirect()->route('ViewEmployes')->with('Menss',2);  
        }else{
            $Evaluation = Evalution_employes::select(
                'evalution_employes.employe_id as id',
                'employes.name as EmployeName',
                'work_area.name as WName',
                'evalution_employes.created_at',
                'users.name as Evaluator',
                'evalution_employes.quality_work',
                'evalution_employes.quantity_work',
                'evalution_employes.CDP',
                'evalution_employes.LDM',
                'evalution_employes.COMDL',
                'evalution_employes.CT',
                'evalution_employes.CDA',
                'evalution_employes.COMHT',
                'evalution_employes.TEE',
                'evalution_employes.Comu',
                'evalution_employes.LiD',
                'evalution_employes.COMHI',
                'evalution_employes.INI',
                'evalution_employes.ACT',
                'evalution_employes.FIAB',
                'evalution_employes.COMCYA',
                'evalution_employes.PC',
                'evalution_employes.DH',
                'evalution_employes.FR',
                'evalution_employes.COMDES',
                'evalution_employes.OE',
                'evalution_employes.IEN',
                'evalution_employes.COMOR',
                'evalution_employes.AUTO',
                'evalution_employes.EPP',
                'evalution_employes.EDSUP',
                'evalution_employes.EDSUB',
                'evalution_employes.COME360',
                'evalution_employes.PF',
                'evalution_employes.ADM',
                'evalution_employes.OPEPP',
                'evalution_employes.PDD'

            )
            ->where('evalution_employes.id',$id)
            ->join('users','users.id','=','evalution_employes.evaluator')
            ->join('employes','employes.id','=','evalution_employes.employe_id')
            ->join('work_area','work_area.id','=','employes.work_area')
            ->first();
            return view('RRHH.employes.ViewEvaluationForm')->with('e',$Evaluation);
        }
    }
    public function OrganigramaView(){
        return view('RRHH.Organigrama.View');
    }
    public function Attendance(){
        return view('RRHH.Atendance.View')->with('Menss',session('Menss'))->with('Retardo',session('Retardo'));
    }
    public function FormularioAsistencia(Request $request){
        $request->validate([
            'type' => 'required|string|in:Llegada,Almuerzo,Salida',
            'qr_code' => 'required|string'
        ]);
      
        switch ($request->type) {
            case 'Llegada':
                $Empleado = Employes::where('email',$request->qr_code)->value('id');
                $Hoy = date('Y-m-d');
                $HoraActual = time('H:i:s');
                $Llegada = Asistencia::where('id', $Empleado)
                ->whereDate('created_at', $Hoy)
                ->exists();
                if($Llegada){
                  return redirect()->route('Asistencia')->with('Menss',2);
                }else{
                 try {
                    $A = new Asistencia();
                    $A->Comienzo_trabajo = time();
                    $Retraso = Employes::where('id',$Empleado)->value('start_work');
                    $HoraActual = new DataTime(time('H:i:s'));
                    $Retraso = new DataTime($Retraso);
                    if($HoraActual > $Retraso){
                    $Intervalo = $HoraActual->diff($Retraso);
                    $DiferenciMinutos = $Intervalo->h * 60 + $Intervalo->i;
                    }else{
                        $DiferenciMinutos = 0;
                    }
                    $A->Retraso_Llegada = $DiferenciMinutos;
                    $A->Empleado =  $Empleado;
                    $A->save();
                    return redirect()->route('Asistencia')->with('Menss',3)->with('Retardo',$DiferenciMinutos);
                 } catch (\Throwable $th) {
                    return redirect()->route('Asistencia')->with('Menss',1);
                 }
                }
                
                break;
            case 'Almuerzo':
            $Empleado = Employes::where('email',$request->qr_code)->value('id');
            $Hoy = date('Y-m-d');
            $HoraActual = time('H:i:s');
            $Almuerzo = Asistencia::where('id', $Empleado)
            ->Where('Inicio_Almuerzo','No posee')
            ->whereDate('created_at', $Hoy)
            ->exists();
            if($Almuerzo){
            $AlmuerzoRetardo = Asistencia::where('id',$Empleado)
            ->whereDate('created_at', $Hoy)
            ->first();
            $Inicio = new DataTime($AlmuerzoRetardo->Inicio_Almuerzo);
            $Fin = new DataTime(date('H:i:s'));
            $Intervalo = $Fin->diff($Inicio);
            $IntervaloMinutos = $Intervalo->h * 60 + $Intervalo->i;
            $RetrasoAlmuerzo = $IntervaloMinutos > 60 ? $IntervaloMinutos:0;
              try {
                Asistencia::where('id',$Empleado)
                ->whereDate('created_at', $Hoy)
                ->update([
                    'Finalizar_Almuerzo' => time('H:i:s'),
                    'Retraso_Almuerzo' => $RetrasoAlmuerzo
                ]);
                return redirect()->route('Asistencia')->with('Menss',3)->with('Retardo',$RetrasoAlmuerzo);
              } catch (\Throwable $th) {
                return redirect()->route('Asistencia')->with('Menss',1);
              }
            }else{
                try {
                    Asistencia::where('id',$Emplead)
                    ->whereDate('created_at', $Hoy)
                    ->update([
                        'Inicio_Almuerzo' => time('H:i:s')
                    ]);
                    return redirect()->route('Asistencia')->with('Menss',4);
                } catch (\Throwable $th) {
                    return redirect()->route('Asistencia')->with('Menss',1);
                }
            }

            break;
            case 'Salida':
                $Empleado = Employes::where('email',$request->qr_code)->value('id');
                $Hoy = date('Y-m-d');
                $HoraActual = time('H:i:s');
                $Salida = Asistencia::where('id', $Empleado)
                ->whereDate('created_at', $Hoy)
                ->exists();
                if($Salida){
                    $Retraso = Employes::where('id',$Empleado)->value('end_work');
                    $HoraActual = new DataTime(time('H:i:s'));
                    $Retraso = new DataTime($Retraso);
                    if($HoraActual > $Retraso){
                    $Intervalo = $HoraActual->diff($Retraso);
                    $DiferenciMinutos = $Intervalo->h * 60 + $Intervalo->i;
                    }else{
                        $DiferenciMinutos = 0;
                    }
                   Asistencia::where('id', $Empleado)
                   ->whereDate('created_at', $Hoy)
                   ->update(['Salida_Trabajo' =>time('H:i:s'),
                                   'Retraso_Salida' => $DiferenciMinutos]);
                    return redirect()->route('Asistencia')->with('Menss',5)->with('Retardo',$DiferenciMinutos);
                }else{
                    return redirect()->route('Asistencia')->with('Menss',6);
                
                }

                break;
            
            default:
                # code...
                break;
        }
    }
    public function FormularioDeduciones(){
        return view('RRHH.Nomina.Deducciones.Crear');
    }
    public function CrearDeduccion(Request $request){
        $request->validate([
            'nombre' => 'required|string',
            'porcentaje' => 'required|numeric'
        ]);

        try {
            $NDE = new deducciones();
            $NDE->nombre = $request->nombre;
            $NDE->porcentage = $request->porcentaje;
            $NDE->es_activo = 1;
            $NDE->save();
            return redirect()->route('VistaDeducciones')->with('Menss',2);
        } catch (\Throwable $th) {
            return redirect()->route('VistaDeducciones')->with('Menss',1);
        }

    }
    public function VistaDedduciones(){
        $deducciones = deducciones::where('es_activo',1)->get();
        return view('RRHH.Nomina.Deducciones.Vista')->with('deducciones',$deducciones)->with('Menss',session('Menss'));
    }
     public function ElimianrDedduccion($id){
        if(empty($id)){
            return redirect()->route('VistaDeducciones')->with('Menss',1);
        }else{
          try {
            deducciones::Where('id',$id)->update([
                'es_activo' => 0
            ]);
            return redirect()->route('VistaDeducciones')->with('Menss',3);
          } catch (\Throwable $th) {
            return redirect()->route('VistaDeducciones')->with('Menss',1);
          }
        }

    }
    public function FormularioBonificaciones(){
        return view('RRHH.Nomina.Bonificaciones.Crear');
    }
    public function CrearBonificaciones(Request $request){
        $request->validate([
            'nombre' => 'required|string',
            'porcentaje' => 'required|numeric'
        ]);

        try {
            $NDE = new bonificacion();
            $NDE->nombre = $request->nombre;
            $NDE->porcentage = $request->porcentaje;
            $NDE->es_activo = 1;
            $NDE->save();
            return redirect()->route('VistaBonificaciones')->with('Menss',2);
        } catch (\Throwable $th) {
            return redirect()->route('VistaBonificaciones')->with('Menss',1);
        }

    }
    public function VistaBonificacion(){
        $bonificaciones = bonificacion::where('es_activo',1)->get();
        return view('RRHH.Nomina.Bonificaciones.Vista')->with('bonificaciones',$bonificaciones)->with('Menss',session('Menss'));
    }
     public function ElimianrBonificaciones($id){
        if(empty($id)){
            return redirect()->route('VistaBonificaciones')->with('Menss',1);
        }else{
          try {
            bonificacion::Where('id',$id)->update([
                'es_activo' => 0
            ]);
            return redirect()->route('VistaBonificaciones')->with('Menss',3);
          } catch (\Throwable $th) {
            return redirect()->route('VistaBonificaciones')->with('Menss',1);
          }
        }
     }
}
