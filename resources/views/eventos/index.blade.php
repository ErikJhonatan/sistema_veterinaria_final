@extends('adminlte::page')

@section('title', 'VetSys|Eventos')
@section('css')

@stop
@php
$config = [
    "singleDatePicker" => true,
    "showDropdowns" => true,
    "startDate" => "js:moment()",
    "minYear" => 2000,
    "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
    "timePicker" => true,
    "timePicker24Hour" => true,
    "timePickerSeconds" => true,
    "cancelButtonClasses" => "btn-danger",
    "locale" => ["format" => "YYYY-MM-DD HH:mm:ss"],
];
@endphp



@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-calendar-day"></i>  Eventos</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-body">
        @if (session('msg'))
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <x-adminlte-alert theme="success" id='success-alert' title="" dismissable>
                {{session('msg')}}
                </x-adminlte-alert> 
            </div>
        </div>
        @endif 
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
        <!-- Modal-->
        <div class="modal fade" id="ModalNew" role="modal-dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="ModalTitulo"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="myForm" action="{{ url('') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" id="Tipo" name="Tipo" value="">
                                <input type="hidden" id="idDb" name="idDb" value="">
                                <div class="col-md-6">
                                    {{-- propietario --}}
                                    <div class="form-group" >
                                        <label class="form-label"> Propietario </label>
                                        <select class="form-control form-control-sm" id="Propietario" name="Propietario" required style="width: 100%;">
                                            <option value="">* Propietario...</option>
                                            @foreach ($clientes as $clie)
                                            <option value="{{$clie->id}}">{{$clie->Nombre.' '.$clie->Apellido.' | '.$clie->DocumentoIdentidad}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- mascota --}}
                                    <div class="form-group" id="MascotaN">
                                        <label class="form-label"> Mascota </label>
                                        <select class="form-control form-control-sm" id="Mascota" name="Mascota" required>
                                            <option value="">* Mascota ...</option>
                                        </select>
                                    </div>

                                    {{-- <div class="form-group" id="PropietarioU">
                                        <input type="text" class="form-control form-control-sm" id="PropietarioM" name="PropietarioM" value="" placeholder="" readonly>
                                    </div> --}}
                                    {{-- fecha inicio --}}
                                    <div class="form-group" >
                                        <label class="form-label"> Fecha inicio </label>
                                        <div class="input-group mb-3">
                                            
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <input type="datetime-local" class="form-control form-control-sm" id="FechaInicio" name="FechaInicio" required value="" placeholder="Fecha de Inicio">
                                        </div>
                                    </div>

                                    {{-- fecha fin --}}
                                    <div class="form-group" >
                                        <label class="form-label"> Fecha Fin </label>
                                        <div class="input-group mb-3">
                                            
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <input type="datetime-local" class="form-control form-control-sm" required id="FechaFin" name="FechaFin" value="" placeholder="Fecha Fin">
                                        </div>
                                    </div>

                                    {{-- nombre evento --}}
                                    <div class="form-group" >
                                        <label class="form-label"> Nombre evento </label>
                                        <div class="input-group mb-3">
                                            
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-signature"></i>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" required id="Evento" name="Evento" value="" placeholder="Nombre evento" >
                                        </div>
                                    </div>

                                    {{-- tipo evento --}}
                                    <div class="form-group">
                                        <label class="form-label"> Tipo Evento </label>
                                        <select class="form-control form-control-sm" id="TipoEvento" name="TipoEvento" required>
                                            <option value="">* Tipo Evento ...</option>
                                            @foreach ($tiposEvento as $te)
                                            <option value="{{$te->id}}">{{$te->TipoEvento}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- responsable --}}
                                    <div class="form-group">
                                        <label class="form-label"> Usuario / Responsable </label>
                                        <select class="form-control form-control-sm" id="Responsable" name="Responsable" required>
                                            <option value="">* Responsabe ...</option>
                                            @foreach ($users as $us)
                                            <option value="{{$us->id}}">{{$us->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            
                                <div class="col-md-6">
                                    
                                    
                                    {{-- <div class="form-group" id="MascotaU">
                                        <input type="text" class="form-control form-control-sm" id="MascotaM" name="MascotaM" value="" placeholder="" readonly>
                                    </div> --}}
                                    
                                    {{-- observacion --}}
                                    <div class="form-group" >
                                        <label class="form-label"> Observacion </label>
                                        <div class="input-group mb-3">
                                            
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-sticky-note"></i>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="Observacion" name="Observacion" value="" placeholder="Observacion">
                                        </div>
                                    </div>

                                    {{-- estado evento --}}
                                    <div class="form-group">
                                        <label class="form-label"> Estado evento </label>
                                        <select class="form-control form-control-sm" id="EstadoEvento" name="EstadoEvento" required>
                                            <option value="">* Estado Evento ...</option>
                                            @foreach ($estadoEvento as $ee)
                                            <option value="{{$ee->id}}">{{$ee->EstadoEvento}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- notificacion --}}
                                    <div class="form-group">
                                        <label class="form-label"> Notificacion </label>
                                        <select class="form-control form-control-sm" id="Notificacion" name="Notificacion" required>
                                            <option value="">* Notificacion ...</option>
                                            @foreach ($notificacion as $no)
                                            <option value="{{$no->id}}">{{$no->notificacion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <!-- <button type="submit" id="BtnSend" class="btn btn-primary">Guardar</button> -->
                            <button type="submit" id="BtnSend" class="btn btn-primary">Guardar</button>
                            <button type="submit" id="BtnSendM" class="btn btn-primary">Modificar</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    var SITEURL = "{{ url('/') }}";
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar')
        let calendar = new FullCalendar.Calendar(calendarEl,  {
            initialView: 'dayGridMonth',
            editable:true,
            selectable:true,
            locale:'es',
            height: 800,
            headerToolbar:{
                start: 'today prev,next',
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay,list'
            },
            buttonText:{
                today:    'hoy',
                month:    'mes',
                week:     'semana',
                day:      'dia',
                list:     'lista'
                },
            events: @json($allEventos),
            dateClick: function(info) {
                console.log(info)
                cleanForm();
                $('#BtnSend').show();
                $('#BtnSendM').hide();
                $('#Tipo').val('1');


                $("#ModalNew").modal();
            },    
            eventClick: async function(info) {
                $('#Propietario').val(info.event.extendedProps.idCliente);
                $("#Mascota").empty();
                await buscarMascotas(info.event.extendedProps.idCliente)
                setTimeout(() => {
                    $('#Mascota').val(info.event.extendedProps.idMascota);
                }, 1000);

                $('#Observacion').val(info.event.extendedProps.Observacion);
                
                $('#FechaInicio').val(info.event.extendedProps.FechaInicio);
                $('#FechaFin').val(info.event.extendedProps.FechaFin)
                
                $('#Evento').val(info.event.title);
                $('#TipoEvento').val(info.event.extendedProps.idTipoEvento);
                $('#Responsable').val(info.event.extendedProps.idUsuario);
                
                
                $('#EstadoEvento').val(info.event.extendedProps.idEstadoEvento);
                $('#Notificacion').val(info.event.extendedProps.idNotificacion);
                $('#idDb').val(info.event.extendedProps.idDb);   
                $('#BtnSend').hide();
                $('#BtnSendM').show();
                $('#Tipo').val('2');
                $("#ModalNew").modal('show');

               
            },
        })
        calendar.render();

        // $('#Propietario').select2({
        //     dropdownParent: $('#ModalNew')
        // });
    
        $("#Propietario").change(function(){
            $("#Mascota").empty();
            buscarMascotas($(this).val())     
        });

        async function buscarMascotas(value){
            await $.ajax({  
                type: "GET",  
                url: "/getMascotas/"+ value,    
                dataType: "json", 
                success: function (data) { 
                    var option = "<option value=''>* Mascota...</option>";
                    $.each(data, function(i,item){
                        option = option+"<option value='" + item.id + "'>"+ item.Mascota+ "</option>";
                    });
                    $("#Mascota").append(option);
                }, //End of AJAX Success function  
            });   
        }

        $('#myForm').submit(function(e) {
            e.preventDefault(); // Evita que el formulario se envíe de la manera predeterminada

            let registro = getForm();

            // Aquí puedes verificar si 'registro' tiene todos los campos requeridos
            // Si no es así, puedes mostrar un mensaje de error y retornar para evitar que se ejecute el código restante

            if ($('#BtnSend').is(':focus')) {
                addReg(registro);
            } else if ($('#BtnSendM').is(':focus')) {
                updReg(registro);
            }

            $("#ModalNew").modal('hide');
        });

        function cleanForm() {
            $('#Propietario').val('');
            $('#FechaInicio').val('');
            $('#Evento').val('');
            $('#TipoEvento').val('');
            $('#Responsable').val('');
            $('#Mascota').val('');
            $('#FechaFin').val('');
            $('#Observacion').val('');
            $('#EstadoEvento').val('');
            $('#Notificacion').val('');
            $('#Tipo').val('');   
        }

        function getForm() {
            let registro = {
                idCliente: $('#Propietario').val(),
                FechaInicio: $('#FechaInicio').val(),
                FechaFin: $('#FechaFin').val(),
                Evento: $('#Evento').val(),
                idTipoEvento: $('#TipoEvento').val(),
                idMascota: $('#Mascota').val(),
                Observacion: $('#Observacion').val(),
                idEstadoEvento: $('#EstadoEvento').val(),
                idNotificacion: $('#Notificacion').val(),
                idUsuario: $('#Responsable').val(),
                IdDb: $('#idDb').val(),
                Tipo: $('#Tipo').val(), 
                usuarioAutenticadoId: "{{ Auth::user()->id }}"
            };
            return registro;
        }

        function addReg(reg) {

            $.ajax({
                type: 'POST',
                url: '/api/evento',
                data: reg,
                headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                success: function(msg) {
                    window.location.replace('/evento');               
                },
                error: function(error) {
                    alert("Hay un problema:" + error);
                }
            });
        }

        function updReg(registro) {
            console.log(registro);
        $.ajax({
            type: 'PUT',
            url: '/api/evento/' + registro.IdDb,
            data: registro,
            headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
            success: function(msg) {
                calendar.refetchEvents();
                window.location.replace('/evento');  
            },
            error: function(error) {
                alert("Hay un problema:" + error);
            }
        });
    }
    });
   
</script>
@endpush