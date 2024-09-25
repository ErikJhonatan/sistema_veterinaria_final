<template>
   <div>
        <div v-if="cargandoHistorial">
            Cargando Historial...
        </div>
        <div class="flex flex-row justify-end " >
            <div class="dropdown items-end">
              
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ tipoHistorialClinico ? tipoHistorialClinico : 'Nuevo registro'  }} 
                </button>
                <ul class="dropdown-menu cursor-pointer">
                    <li
                    v-for="(item, index) in tiposHistoriasClinicasFiltradas"
                    :key="index"
                    @click="mostrarTipoDeHistorial(item)"
                    >
                        <div class="dropdown-item" >
                            {{ item.nombre }}
                        </div>
                    </li>
                
                </ul>
            </div>
        </div>

        <template v-if="tipoHistorialClinico && tipoHistorialClinico">
            <form-historial
            :diagnosticos="diagnosticos"
            :examenes-auxiliares="examenesAuxiliares"
            :productos="productos"
            :tipoHistorialClinico="tipoHistorialClinico"
            :tiposHistoriasClinicas="tiposHistoriasClinicas"
            :mascota-id="mascota.id"
            @actualizarHistorial="getHistorialClinico"
            @salir="tipoHistorialClinico = null"
            />
            
        </template>

        <div 
        v-else-if="historiasClinicas && historiasClinicas.length > 0 && !cargandoHistorial" 
        class="flex flex-col">
            <div 
            v-for="(item, index) in historiasClinicas"
            :key="index"
            class="bg-white border border-gray-200 p-4 mt-1 mb-3 "
            >
                <card-historial-clinico
                :historialClinico="item"
                @eliminarHistorial="eliminarHistorial"
                @editarHistorial="mostrarModalEditar($event)"
                />
               
            </div>
        </div>
        <div style="height: 200px; padding: 5px;margin-top: 5px;" class="bg-white" v-else-if="historiasClinicas.length === 0 && !cargandoHistorial">
            No hay historial clinico
        </div>

        <div 
        v-if="abrirModalEditar"
        class="modal fade show dialog-historial block modal-dialog-scrollable"  
        tabindex="-1" 
        id="exampleModalLong" 
        role="dialog" 
        aria-labelledby="exampleModalLongTitle" 
        aria-hidden="true"
        >
            <div class="modal-dialog overflow-auto" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><span class="font-semibold mr-2" >Guardar</span> {{ historialActual.tipo_historia_clinica.nombre }}</h5>
                    <button @click="cerrarModalEditar()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form-historial
                :diagnosticos="diagnosticos"
                :examenes-auxiliares="examenesAuxiliares"
                :productos="productos"
                :tipoHistorialClinico="historialActual.tipo_historia_clinica.nombre"
                :tiposHistoriasClinicas="tiposHistoriasClinicas"
                :mascota-id="mascota.id"
                :historia-clinica="historialActual"
                @actualizarHistorial="getHistorialClinico"
                />
                </div>
                <div class="modal-footer mb-4">
                    <button @click="cerrarModalEditar()" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup >

import { ref, watch, toRefs, onMounted } from 'vue';
import FormHistorial from './HistorialClinico/FormHistorial.vue';
import CardHistorialClinico from './HistorialClinico/CardHistorialClinico.vue';
import axios from 'axios';
import baseUrl from '../../baseUrl';
import Swal from 'sweetalert2'

const props =  defineProps({
  tiposHistoriasClinicas: Array,
  diagnosticos: Array,
  examenesAuxiliares: Array,
  productos: Array,
  mascota: Object
})

const { tiposHistoriasClinicas,  diagnosticos ,examenesAuxiliares, mascota  } = toRefs(props);

const historiasClinicas = ref([])

const tipoHistorialClinico = ref(null);
const tiposHistoriasClinicasFiltradas = ref(tiposHistoriasClinicas.value.filter(
    (t) => t.nombre !== 'Tratamiento')
)

onMounted(() => {
    getHistorialClinico()
})
const cargandoHistorial = ref(false)
const getHistorialClinico = async () => {
    tipoHistorialClinico.value = null
    cargandoHistorial.value = true
    const response = await axios.get(`${baseUrl}/api/historiaClinica?mascota_id=${mascota.value.id}`)
    historiasClinicas.value = response.data
    cargandoHistorial.value = false
}

const eliminarHistorial = (historial) => {
    historiasClinicas.value = historiasClinicas.value.filter((h) => h.id !== historial.id)
    Swal.fire({
        title: 'Realizado correctamente',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500
    })

}


const historialActual = ref(null)
const abrirModalEditar = ref(false)
const mostrarModalEditar = (historial) => {
    historialActual.value = historial
    abrirModalEditar.value = true
}

const cerrarModalEditar = () => {
    abrirModalEditar.value = false
}

const mostrarTipoDeHistorial = (item) => {
    tipoHistorialClinico.value = item.nombre
}


</script>

<style scoped>

.dialog-historial .modal-dialog {
   max-width: 100%;
    max-height: 100%;
}

</style>