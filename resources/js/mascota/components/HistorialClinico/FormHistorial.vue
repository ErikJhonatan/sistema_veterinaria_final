<template>
    <div v-if="mostrarFechaAtencion || mostrarMotivoAtencion || mostrarDescripcion" class="border p-3 rounded mt-1">
        <div  class="flex flex-row flex-wrap gap-4">
            <div
            v-if="mostrarFechaAtencion"
            class="mb-3">
                <label 
                class="form-label">
                    Fecha de atencion
                </label>
                <input 
                type="datetime-local"
                class="form-control" 
                v-model="formulario.fecha_atencion"
                >
            </div>
            <div
            v-if="mostrarMotivoAtencion"
            class="mb-3">
                <label 
                class="form-label">
                {{  tipoHistorialClinico === 'Cirugia' ? 'Nombre cirugia' : 'Motivo de consulta' }}
                </label>
                <input 
                type="text"
                class="form-control"
                v-model="formulario.motivo_atencion"
                >
            </div>
        </div>
        <div
        v-if="mostrarDescripcion"
        >
            <label
            class="form-label"
            >
            Anamnesis y descripción del caso
            </label>
            <textarea
            class="form-control"
            v-model="formulario.descripcion"
            />
        </div>
    </div>

    
    <div 
    class="border p-3 rounded mt-1 flex flex-col"
    >
        <!-- constante fisiologicas -->
        <div class="mb-2 font-semibold">
            Constante fisiologicas
        </div>

        <div class="flex flex-row gap-2 flex-wrap">
            <!-- temperatura -->
            <div class="input-group mb-3">
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                
                >
                <i data-toggle="tooltip" data-placement="top" title="Temperatura" class="fa fa-thermometer-empty " aria-hidden="true"></i>
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="Temperatura" 
                v-model="formulario.temperatura"
                >

                <!-- frecuencia cardiaca -->
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                >
                <i data-toggle="tooltip" data-placement="top" title="Frecuencia Cardiaca" class="fa fa-heart" aria-hidden="true"></i>
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="Frecuencia cardiaca" 
                v-model="formulario.frecuencia_cardiaca"
                >
            </div>
            <!-- frecuencia_respiratoria -->
            <div class="input-group mb-3">
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                data-toggle="tooltip" data-placement="top" title="Frecuencia respiratoria"
                >
                FR
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="frecuencia respiratoria" 
                v-model="formulario.frecuencia_respiratoria"
                >

                <!-- peso -->
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                data-toggle="tooltip" data-placement="top" title="Peso"
                >
                PS
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="Peso" 
                v-model="formulario.peso"
                >
            </div>

            <!-- porcentaje hidratacion -->
            <div class="input-group mb-3">
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                data-toggle="tooltip" data-placement="top" title="Porcentaje deshidratacion"
                >
                DHT
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="porcentaje hidratacion" 
                v-model="formulario.porcentaje_deshidratacion"
                >

                <!-- tiempo llenado capilar -->
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                data-toggle="tooltip" data-placement="top" title="Tiempo llenado capilar"
                >
                TLC
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="tiempo llenado capilar" 
                v-model="formulario.tiempo_llenado_capilar"
                >
            </div>

            <!-- presion arterial -->
            <div class="input-group mb-3">
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                data-toggle="tooltip" data-placement="top" title="Presion arterial"
                >
                PA
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="Presion arterial" 
                v-model="formulario.presion_arterial"
                >

                <!-- examen tacto rectal -->
                <span 
                style="min-width: 50px;"
                class="input-group-text flex justify-center"
                data-toggle="tooltip" data-placement="top" title="Examen de tacto rectal"
                >
                DRE
                </span>
                <input 
                type="text" 
                class="form-control" 
                placeholder="examen tacto rectal" 
                v-model="formulario.examen_tacto_rectal"
                >
            </div>
        </div>
    </div>

    <!-- cirugia -->
    <div 
    class="border p-3 rounded mt-1 flex flex-row flex-wrap"
    v-if="tipoHistorialClinico === 'Cirugia'"
    >

        <div class="form-check form-check-inline">
            <input v-model="formulario.conformidad_pago" class="form-check-input" type="checkbox"  value="true">
            <label class="form-check-label">Conformidad de Pago</label>
        </div>
        <div class="form-check form-check-inline">
            <input v-model="formulario.documentacion_firmada" class="form-check-input" type="checkbox"  value="true">
            <label class="form-check-label">Documentacion Firmada</label>
        </div>
        <div class="form-check form-check-inline">
            <input v-model="formulario.riesgo_quirurgico"  class="form-check-input" type="checkbox"  value="true" >
            <label class="form-check-label"> Riesgo Quirúrgico</label>
        </div>
        <div class="form-check form-check-inline">
            <input v-model="formulario.miccion" class="form-check-input" type="checkbox"  value="true" >
            <label class="form-check-label"> Micción - Deposicion</label>
        </div>
        <div class="form-check form-check-inline">
            <input v-model="formulario.ayuno_previo" class="form-check-input" type="checkbox"  value="true" >
            <label class="form-check-label"> Ayuno previo</label>
        </div>
        
    </div>

    <!-- examen clinico -->
    <div 
    v-if="mostrarExamenClinico"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-3">
            <label 
            class="form-label">
                Examen clinico
            </label>
            <textarea 
            class="form-control"
            v-model="formulario.examen_clinico"
            />
        </div>
    </div>

    <!-- diagnostico -->
    <div 
    v-if="mostrarDiagnostico"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-2 font-semibold">
            Diagnostico
        </div>
        <combo-form
        :defaultValue="defaultValueDianosticoMascota"
        :options="diagnosticos"
        ref="refDiagnostico"
        :confirmar-antes-de-eliminar="isEditMode"
        @remover="eliminarDiagnosticoMascota($event)"
        />
        <div class="flex justify-end" v-if="isEditMode">
            <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click="guardarDiagnosticoMascota"
            >
                Guardar diagnosticos
            </button>
        </div>
    </div>
    

    <!-- examenes auxiliares -->
    <div 
    v-if="mostrarExamenAuxiliar"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-2 font-semibold">
            Exámenes auxiliares
        </div>
        <combo-form
        :defaultValue="defaultValueExamenAuxiliarMascota"
        :options="examenesAuxiliares"
        :confirmar-antes-de-eliminar="isEditMode"
        @remover="eliminarExamenAuxiliarMascota($event)"
        ref="refExamenAuxiliar"
        />
        <div class="flex justify-end" v-if="isEditMode">
            <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click="guardarExamenAuxiliarMascota"
            >
                Guardar examenes
            </button>
        </div>
    </div>

    <!-- tratamientos mascotas -->
    <div 
    v-if="mostrarTratamiento"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-2 font-semibold">
            Tratamiento
        </div>
        <combo-form
        :defaultValue="defaultValueTratamientosMascotas"
        :options="productos.map((p) => ({
            ...p,
            nombre: p.Producto
        }))"
        :confirmar-antes-de-eliminar="isEditMode"
        @remover="eliminarTratamiento($event)"
        ref="refTratamiento"
        />

        <div class="flex justify-end" v-if="isEditMode">
            <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click="guardarTratamiento(refTratamiento, defaultValueTratamientosMascotas, 'Tratamiento')"
            >
                Guardar tratamientos
            </button>
        </div>
        
    </div>

    <!-- vacuna -->
    <div 
    v-if="mostrarVacuna"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-2 font-semibold">
            Vacunas
        </div>
        <combo-form
        :default-value="defaultValueVacunas"
        :options="productos.map((p) => ({
            ...p,
            nombre: p.Producto
        }))"
        :confirmar-antes-de-eliminar="isEditMode"
        @remover="eliminarTratamiento($event)"
        ref="refVacuna"
        />
        <div class="flex justify-end" v-if="isEditMode">
            <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click="guardarTratamiento(refVacuna, defaultValueVacunas, 'Vacuna')"
            >
                Guardar vacunas
            </button>
        </div>
        
    </div>

    <!-- antiparasitarios -->
    <div 
    v-if="mostrarAntiparasitarios"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-2 font-semibold">
            Antiparasitarios
        </div>
        <combo-form
        :defaultValue="defaultValueAntiparasitarios"
        :options="productos.map((p) => ({
            ...p,
            nombre: p.Producto
        }))"
        :confirmar-antes-de-eliminar="isEditMode"
        @remover="eliminarTratamiento($event)"
        ref="refAntiparasitarios"
        />
        <div class="flex justify-end" v-if="isEditMode">
            <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click="guardarTratamiento(refAntiparasitarios, defaultValueAntiparasitarios, 'Antiparasitario')"
            >
                Guardar antiparasitarios
            </button>
        </div>
    </div>

    <!-- antipulgas -->
    <div 
    v-if="mostrarAntipulgas"
    class="border p-3 rounded mt-1 flex flex-col mb-2">
        <div class="mb-2 font-semibold">
            Antipulgas
        </div>
        <combo-form
        :defaultValue="defaultValueAntipulgas"
        :options="productos.map((p) => ({
            ...p,
            nombre: p.Producto
        }))"
        :confirmar-antes-de-eliminar="isEditMode"
        @remover="eliminarTratamiento($event)"
        ref="refAntipulgas"
        />
        <div class="flex justify-end" v-if="isEditMode">
            <button 
            type="button" 
            class="btn btn-success btn-sm"
            @click="guardarTratamiento(refAntipulgas, defaultValueAntipulgas, 'Antipulgas')"
            >
                Guardar antipulgas
            </button>
        </div>
       
    </div>

    <!-- exito -->
    <div 
    v-if="exito && !isEditMode"
    class="alert alert-success" role="alert">
    Guardado correctamente
    </div>

    <!-- error -->
    <div 
    v-if="error"
    class="alert alert-danger" role="alert">
    No se guardo correctamente
    </div>  

    <!-- salir, guardar -->
    <div  v-if="!isEditMode" class="flex flex-row justify-between my-2">
        <button 
        type="button" 
        class="btn btn-danger"
        @click="emit('salir')"
        >
            Atras
        </button>
        <button 
        type="button" 
        class="btn btn-success"
        @click="guardarHistorialClinico"
        :disabled="!algunCampoTieneDatos || guardandoHistorialClinico"
        >
           {{ guardandoHistorialClinico ? 'Guardando...' : 'Guardar' }}        
        </button>
    </div>

</template>

<script setup>
import { reactive, toRefs, computed, ref, onMounted, watch, nextTick } from 'vue';
import ComboForm from './ComboForm.vue';
import axios from 'axios';
import baseUrl from '../../../baseUrl';
import { useHistorialClinico } from '../../composables/useHistorialClinico';
import debounce from '../../../utils/debounce';
import Swal from 'sweetalert2'

const props =  defineProps({
    diagnosticos: Array,
    examenesAuxiliares: Array,
    productos: Array,
    tipoHistorialClinico: String,
    tiposHistoriasClinicas: Array,
    mascotaId: Number,
    historiaClinica: {
        type: Object,
        required: false,
    },
})

const emit = defineEmits(["salir", "actualizarHistorial"])

const {
    tipoHistorialClinicoComposable,
    mostrarFechaAtencion,
    mostrarMotivoAtencion,
    mostrarDescripcion,
    mostrarDiagnostico,
    mostrarExamenAuxiliar,
    mostrarTratamiento,
    mostrarVacuna,
    mostrarAntiparasitarios,
    mostrarAntipulgas,
    mostrarExamenClinico
 } = useHistorialClinico()

const { historiaClinica, tiposHistoriasClinicas, diagnosticos, examenesAuxiliares, productos, tipoHistorialClinico, mascotaId } = toRefs(props);

watch(tipoHistorialClinico, (value) => {
    tipoHistorialClinicoComposable.value = value
})

const aucomplentadoFormulario = ref(false)
onMounted(async () => {
    if(isEditMode.value){
        aucomplentadoFormulario.value = true
        completarFormulario()
        await nextTick()
        aucomplentadoFormulario.value = false
    }
    tipoHistorialClinicoComposable.value = tipoHistorialClinico.value
})

const isEditMode = computed(() => !!historiaClinica.value)


const formulario = reactive({
    fecha_atencion: null,
    motivo_atencion: null,
    descripcion: null,

    // constantes fisiologicas
    temperatura: null,
    frecuencia_cardiaca: null,
    frecuencia_respiratoria: null,
    peso: null,
    porcentaje_deshidratacion: null,
    tiempo_llenado_capilar: null,
    presion_arterial: null,
    examen_tacto_rectal: null,
    examen_clinico: null,

    // cirugia
    conformidad_pago: null,
    documentacion_firmada: null,
    riesgo_quirurgico: null,
    miccion: null,
    ayuno_previo: null,
    
})

const refDiagnostico = ref(null) 
const refExamenAuxiliar = ref(null) 
const refTratamiento = ref(null) 
const refVacuna = ref(null) 
const refAntiparasitarios = ref(null) 
const refAntipulgas = ref(null) 

const guardarHistorialClinico = () => {
    let historialClinico = {
        ...formulario,
        idMascota: mascotaId.value,
        tipo_historia_clinica_id: tiposHistoriasClinicas.value.find((t) => t.nombre === tipoHistorialClinico.value).id
    }
    if(refDiagnostico?.value?.combos){
        historialClinico.diagnosticos_mascotas = refDiagnostico.value.combos.map((d) => {
            return {
                diagnostico_id : d.id,
                observacion: d.observacion
            }
        })
    }

    if(refExamenAuxiliar?.value?.combos){
        historialClinico.examenes_auxiliares_mascotas = refExamenAuxiliar.value.combos.map((d) => {
            return {
                examen_auxiliar_id : d.id,
                observacion: d.observacion,
                mascota_id:  mascotaId.value,
            }
        })
    }

    if(refTratamiento?.value?.combos){
        historialClinico.tratamientos = refTratamiento.value.combos.map((d) => {
            return {
                producto_id : d.id,
                observacion: d.observacion
            }
        })
    }

    if(refVacuna?.value?.combos){
        historialClinico.vacunas = refVacuna.value.combos.map((d) => {
            return {
                producto_id : d.id,
                observacion: d.observacion
            }
        })
    }

    if(refAntiparasitarios?.value?.combos){
        historialClinico.anti_parasitarios = refAntiparasitarios.value.combos.map((d) => {
            return {
                producto_id : d.id,
                observacion: d.observacion
            }
        })
    }
    if(refAntipulgas?.value?.combos){
        historialClinico.anti_pulgas = refAntipulgas.value.combos.map((d) => {
            return {
                producto_id : d.id,
                observacion: d.observacion
            }
        })
    }

    crearHistorial(historialClinico)
}

const guardandoHistorialClinico = ref(false)
const exito = ref(false)
const error = ref(false)
const crearHistorial = async (data) => {
    error.value = false;
    exito.value = false;
    if(guardandoHistorialClinico.value) return 
   try {
    guardandoHistorialClinico.value = true;
    const response = await axios.post(baseUrl + '/api/historiaClinica', data)
    
    setTimeout(() => {
        emit("actualizarHistorial")
        emit("salir")
    }, 1000);
   } catch (error) {
        error.value = true;
   } finally{
    exito.value = true;
    setTimeout(() => {
        guardandoHistorialClinico.value = false;
    }, 1000);
    
   } 
}

const editarHistorial = async (data) => {
    error.value = false;
    exito.value = false;
    if(guardandoHistorialClinico.value) return 

    data = {
        ...data,
        idMascota: mascotaId.value,
        tipo_historia_clinica_id: tiposHistoriasClinicas.value.find((t) => t.nombre === tipoHistorialClinico.value).id
    }

    try {
        guardandoHistorialClinico.value = true;
        const response = await axios.put(baseUrl + '/api/historiaClinica/' + historiaClinica.value.id, data)
        exito.value = true;
        setTimeout(() => {
            emit("actualizarHistorial")
            emit("salir")
        }, 1000);
    } catch (error) {
            error.value = true;
    } finally{
        
        setTimeout(() => {
            guardandoHistorialClinico.value = false;
        }, 1000);
        
    } 
}

const algunCampoTieneDatos =  computed(() => {
    return Object.values(formulario).some((value) => value)
})

const defaultValueExamenAuxiliarMascota = ref(null)
const defaultValueDianosticoMascota = ref(null)
const defaultValueTratamientosMascotas = ref(null)
const defaultValueVacunas = ref(null)
const defaultValueAntiparasitarios = ref(null)
const defaultValueAntipulgas = ref(null)

const completarFormulario = () => {

    formulario.fecha_atencion = historiaClinica.value.fecha_atencion
    formulario.motivo_atencion = historiaClinica.value.motivo_atencion
    formulario.descripcion = historiaClinica.value.descripcion
    formulario.temperatura = historiaClinica.value.temperatura
    formulario.frecuencia_cardiaca = historiaClinica.value.frecuencia_cardiaca
    formulario.frecuencia_respiratoria = historiaClinica.value.frecuencia_respiratoria
    formulario.peso = historiaClinica.value.peso
    formulario.porcentaje_deshidratacion = historiaClinica.value.porcentaje_deshidratacion
    formulario.tiempo_llenado_capilar = historiaClinica.value.tiempo_llenado_capilar
    formulario.presion_arterial = historiaClinica.value.presion_arterial
    formulario.examen_tacto_rectal = historiaClinica.value.examen_tacto_rectal
    formulario.examen_clinico = historiaClinica.value.examen_clinico

    formulario.conformidad_pago = !!historiaClinica.value.conformidad_pago
    formulario.documentacion_firmada = !!historiaClinica.value.documentacion_firmada
    formulario.riesgo_quirurgico = !!historiaClinica.value.riesgo_quirurgico
    formulario.miccion = !!historiaClinica.value.miccion
    formulario.ayuno_previo = !!historiaClinica.value.ayuno_previo
   
    if(historiaClinica.value.diagnostico_mascota && historiaClinica.value.diagnostico_mascota.length > 0){
        defaultValueDianosticoMascota.value = historiaClinica.value.diagnostico_mascota.map((v) => {
            return {
                id: v.diagnostico.id,
                nombre: v.diagnostico.nombre,
                observacion: v.observacion,
                diagnostico_mascota_id: v.id,
            }
        })
    }

    if(historiaClinica.value.examen_auxiliar_mascota && historiaClinica.value.examen_auxiliar_mascota.length > 0){
        defaultValueExamenAuxiliarMascota.value = historiaClinica.value.examen_auxiliar_mascota.map((v) => {
            return {
                id: v.examen_auxiliar.id,
                nombre: v.examen_auxiliar.nombre,
                observacion: v.observacion,
                examen_auxiliar_mascota_id: v.id,
            }
        })
    }


    if(historiaClinica.value.tratamiento_mascota && historiaClinica.value.tratamiento_mascota.length > 0){
        defaultValueTratamientosMascotas.value = getTratamiento(historiaClinica.value.tratamiento_mascota)
    }

    if(historiaClinica.value.vacunas && historiaClinica.value.vacunas.length > 0){
        defaultValueVacunas.value = getTratamiento(historiaClinica.value.vacunas)
    }

    if(historiaClinica.value.antiparasitarios && historiaClinica.value.antiparasitarios.length > 0){
        defaultValueAntiparasitarios.value = getTratamiento(historiaClinica.value.antiparasitarios)
    }


    if(historiaClinica.value.antipulgas && historiaClinica.value.antipulgas.length > 0){
        defaultValueAntipulgas.value = getTratamiento(historiaClinica.value.antipulgas)
    }
}

// observar cambios de formulario

const debouncedEditar = debounce(editarHistorial, 800)

watch(formulario, (value) => {
    if(!aucomplentadoFormulario.value && isEditMode.value){
        debouncedEditar(formulario)
    }
})

const getTratamiento = (value) => {
    return value.map((v) => {
            return {
                id: v.producto.id,
                nombre: v.producto.Producto,
                observacion: v.observacion,
                tratamiento_id : v.id,
            }
    })
}

const guardarTratamiento = async (ref, defaultValue, tipoHistorialClinico) => {
    if(isEditMode.value){
        if(ref?.combos){
            let tratamientos = ref.combos.map((d) => {
                let objeto = {
                    ...d,
                    producto_id : d.id,
                    observacion: d.observacion,
                    mascota_id: mascotaId.value,
                }
                delete objeto.id
                delete objeto.nombre
                return objeto
            })
            
            try {
                const response = await  axios.post(baseUrl + '/api/tratamiento', {
                tratamientos,
                historia_clinica_id: historiaClinica.value.id,
                tipo_historia_clinica_id: tiposHistoriasClinicas.value.find((t) => t.nombre === tipoHistorialClinico).id
                })
                Swal.fire({
                    icon: "success",
                    title: "Guardado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
                defaultValue = getTratamiento(response.data)
                emit('actualizarHistorial')
            } catch (error) {
                console.log(error)
                Swal.fire({
                    icon: "error",
                    title: "No se guardo correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    }
}

const eliminarTratamiento = async (tratamiento) => {
    if(!tratamiento.tratamiento_id){
        return
    }
    try {
        const response = await axios.delete(`${baseUrl}/api/tratamiento/${tratamiento.tratamiento_id}`)
        emit('actualizarHistorial')
    } catch (error) {
        console.log(error)
    }
       
}

const guardarExamenAuxiliarMascota = async () => {
    if(isEditMode.value){
        if(refExamenAuxiliar?.value?.combos){
            let examen_auxiliar_mascota = refExamenAuxiliar.value.combos.map((d) => {
                let objeto = {
                    ...d,
                    examen_auxiliar_id: d.id,
                    observacion: d.observacion,
                    mascota_id: mascotaId.value,
                }
                delete objeto.id
                delete objeto.nombre
                return objeto
            })
           
            try {
                const response = await  axios.post(baseUrl + '/api/examenAuxiliarMascota', {
                examen_auxiliar_mascota,
                historia_clinica_id: historiaClinica.value.id,
                tipo_historia_clinica_id: tiposHistoriasClinicas.value.find((t) => t.nombre === tipoHistorialClinico.value).id
                })
                Swal.fire({
                    icon: "success",
                    title: "Guardado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
                defaultValueExamenAuxiliarMascota.value = response.data.map((v) => {
                    return {
                        id: v.examen_auxiliar.id,
                        nombre: v.examen_auxiliar.nombre,
                        observacion: v.observacion,
                        examen_auxiliar_mascota_id: v.id,
                    }
                    
                })
                emit('actualizarHistorial')
            } catch (error) {
                console.log(error)
                Swal.fire({
                    icon: "error",
                    title: "No se guardo correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    }
}

const eliminarExamenAuxiliarMascota = async (examen) => {
    if(!examen.examen_auxiliar_mascota_id){
        return
    }
    try {
        const response = await axios.delete(`${baseUrl}/api/examenAuxiliarMascota/${examen.examen_auxiliar_mascota_id}`)
        emit('actualizarHistorial')
    } catch (error) {
        console.log(error)
    }
}

const guardarDiagnosticoMascota = async () => {
    if(isEditMode.value){
        if(refDiagnostico?.value?.combos){
            let diagnostico_mascota = refDiagnostico.value.combos.map((d) => {
                let objeto = {
                    ...d,
                    diagnostico_id: d.id,
                    observacion: d.observacion,
                    mascota_id: mascotaId.value,
                }
                delete objeto.id
                delete objeto.nombre
                return objeto
            })
            try {
                const response = await  axios.post(baseUrl + '/api/diagnosticoMascota', {
                diagnostico_mascota,
                historia_clinica_id: historiaClinica.value.id,
                tipo_historia_clinica_id: tiposHistoriasClinicas.value.find((t) => t.nombre === tipoHistorialClinico.value).id
                })
                Swal.fire({
                    icon: "success",
                    title: "Guardado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
                defaultValueDianosticoMascota.value = response.data.map((v) => {
                    return {
                        id: v.diagnostico.id,
                        nombre: v.diagnostico.nombre,
                        observacion: v.observacion,
                        diagnostico_id: v.id,
                    }
                })
                emit('actualizarHistorial')
            } catch (error) {
                console.log(error)
                Swal.fire({
                    icon: "error",
                    title: "No se guardo correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    }
}

const eliminarDiagnosticoMascota = async (diagnostico) => {
    if(!diagnostico.diagnostico_mascota_id){
        return
    }
    try {
        const response = await axios.delete(`${baseUrl}/api/diagnosticoMascota/${diagnostico.diagnostico_mascota_id}`)
        emit('actualizarHistorial')
    } catch (error) {
        console.log(error)
    }
}
    

</script>

<style lang="scss" scoped>

</style>