@extends('adminlte::page')
@section('title', 'Consultorio veterinario SOS | Seleccionar Año Contable')

@section('content_header')
  <h1 class="m-0 text-dark"><i class="fas fa-fw fa-calendar"></i> Seleccionar Año Contable</h1>
@stop

@section('content')
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Seleccionar Año</h3>
    </div>
    <div class="card-body">
      <div class="form-group col-md-3">
        <label class="form-label" for="anio_contable">Año Contable</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-fw fa-calendar"></i></span>
          </div>
          <select class="form-control form-control-sm" id="anio_contable" name="anio_contable" required>
            <option value="" disabled selected>* Seleccionar Año...</option>
            @for ($year = 2024; $year <= 2030; $year++)
              <option value="{{ $year }}">{{ $year }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="button" class="btn bg-gradient-primary btn-sm" id="guardar_anio"><i class="fas fa-fw fa-save"></i>
        Guardar Año</button>
    </div>
  </div>
@stop

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const anioContable = localStorage.getItem('anio-contable');
      if (anioContable) {
        document.getElementById('anio_contable').value = anioContable;
      }});
    </script>
  <script>
    document.getElementById('guardar_anio').addEventListener('click', function() {
      const anioContable = document.getElementById('anio_contable').value;
      if (anioContable) {
        localStorage.setItem('anio-contable', anioContable);
        Swal.fire({
          icon: 'success',
          title: 'Año contable guardado',
          text: 'Año contable guardado: ' + anioContable,
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Por favor, seleccione un año.',
        });
      }
    });
  </script>
@endpush
