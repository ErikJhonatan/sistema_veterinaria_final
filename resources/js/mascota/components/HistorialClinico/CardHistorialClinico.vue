<template>
   <div class="flex flex-col ">
        <div class="flex flex-row justify-between">
            <div class="flex flex-col">
                <div>
                <span>{{ historialClinico.tipo_historia_clinica.nombre }}</span>
                </div>
                <div v-if="mostrarFechaAtencion">
                    <span>{{ historialClinico.created_at.substr(0, 10) }}</span>
                </div>
            </div>
            <div class="flex flex-row gap-2">
                <button @click="emit('editarHistorial', historialClinico)" type="button" class="btn btn-outline-primary btn-sm">Editar</button>
                <button @click="eliminarHistorial(historialClinico)" type="button" class="btn btn-outline-danger btn-sm">Eliminar</button>
            </div>
        </div>

        <!-- motivo_atencion -->
        <div
        v-if="mostrarMotivoAtencion"
        class="flex flex-col"
        >
            <div class="font-semibold"> 
                Motivo:
            </div>
            <div>
                {{ historialClinico.motivo_atencion}}
            </div>
        </div>

        <!-- descripcion -->
        <div
        v-if="mostrarDescripcion"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Descripcion | Anamnesis:
            </div>
            <div>
                {{ historialClinico.descripcion}}
            </div>
        </div>

        <!-- examen_clinico -->
        <div
        v-if="mostrarExamenClinico"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Examen clinico:
            </div>
            <div>
                {{ historialClinico.examen_clinico}}
            </div>
        </div>

        <!-- constantes fisiologicas -->
        <div
        class="flex flex-col"
        >
            <div class="font-semibold">
                Constantes Fisiologicas
            </div>
            <div class="flex flex-row flex-wrap gap-2 pl-2">
                <div>
                    <span> Temperatura: </span>{{ historialClinico.temperatura}}
                </div>
                <div>
                    <span> Frecuencia Cardiaca: </span>{{ historialClinico.frecuencia_cardiaca}}
                </div>
                <div>
                    <span> Frecuencia Respiratoria: </span>{{ historialClinico.frecuencia_respitatoria}}
                </div>
                <div>
                    <span> Peso: </span>{{ historialClinico.peso}}
                </div>
                <div>
                    <span> Porcentaje deshidratacion: </span>{{ historialClinico.porcentaje_deshidratacion}}
                </div>
                <div>
                    <span> Tiempo llenado capital: </span>{{ historialClinico.tiempo_llenado_capilar}}
                </div>
                <div>
                    <span> Presion arterial: </span>{{ historialClinico.presion_arterial}}
                </div>
                <div>
                    <span> Examen tacto rectal: </span>{{ historialClinico.examen_tacto_rectal}}
                </div>
            </div>
            
        </div>

        <!-- cirugia -->

        <div
        v-if="tipoHistorialClinicoComposable === 'Cirugia'"
        class="flex flex-row flex-wrap gap-2"
        >
            <div class="font-semibold">
                Conformidad de pago: {{ historialClinico.conformidad_pago ? 'Si' : 'No' }}
            </div>
            <div class="font-semibold">
                Documentacion firmada: {{ historialClinico.documentacion_firmada ? 'Si' : 'No' }}
            </div>
            <div class="font-semibold">
                Riesgo quirurgico: {{ historialClinico.riesgo_quirurgico ? 'Si' : 'No' }}
            </div>
            <div class="font-semibold">
                Miccion - Deposición: {{ historialClinico.miccion ? 'Si' : 'No' }}
            </div>
            <div class="font-semibold">
                Ayuno previo: {{ historialClinico.ayuno_previo ? 'Si' : 'No' }}
            </div>
        </div>

        <!-- diagnostico_mascota -->
        <div
        v-if="mostrarDiagnostico && historialClinico.diagnostico_mascota"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Diagnostico:
            </div>
            <div class="flex flex-col">
                <div
                v-for="(item, index) in historialClinico.diagnostico_mascota"
                :key="index"
                class="flex flex-row gap-2"
                >
                    <span>{{ item.diagnostico.nombre }}</span>
                    <span>{{ item.observacion }}</span>
                </div>
            </div>
        </div>

        <!-- examen_auxiliar_mascota -->

        <div
        v-if="mostrarExamenAuxiliar && historialClinico.examen_auxiliar_mascota"
        >
            <div class="font-semibold">
                Examen Auxiliar:
            </div>
            <div class="flex flex-col">
                <div
                v-for="(item, index) in historialClinico.examen_auxiliar_mascota"
                :key="index"
                class="flex flex-row gap-2"
                >
                    <span>{{ item.examen_auxiliar.nombre }}</span>
                    <span>{{ item.observacion }}</span>
                </div>
            </div>

        </div>

        <!-- tratamiento_mascota -->
        <div
        v-if="mostrarTratamiento && historialClinico.tratamiento_mascota"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Tratamiento:
            </div>
            <div class="flex flex-col">
                <div
                v-for="(item, index) in historialClinico.tratamiento_mascota"
                :key="index"
                class="flex flex-row gap-2"
                >
                    <span>{{ item.producto.Producto }}</span>
                    <span>{{ item.observacion }}</span>
                </div>
            </div>
        </div>

        <!-- vacuna -->
        <div
        v-if="mostrarVacuna && historialClinico.vacunas"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Vacuna:
            </div>
            <div class="flex flex-col">
                <div
                v-for="(item, index) in historialClinico.vacunas"
                :key="index"
                class="flex flex-row gap-2"
                >
                    <span>{{ item.producto.Producto }}</span>
                    <span>{{ item.observacion }}</span>
                </div>
            </div>
        </div>

        <!-- antiparasitario -->
        <div
        v-if="mostrarAntiparasitarios && historialClinico.antiparasitarios && historialClinico.antiparasitarios.length > 0"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Antiparasitario:
            </div>
            <div class="flex flex-col">
                <div
                v-for="(item, index) in historialClinico.antiparasitarios"
                :key="index"
                class="flex flex-row gap-2"
                >
                    <span>{{ item.producto.Producto }}</span>
                    <span>{{ item.observacion }}</span>
                </div>
            </div>
        </div>

        <!-- antipulgas -->
        <div
        v-if="mostrarAntipulgas && historialClinico.antipulgas"
        class="flex flex-col"
        >
            <div class="font-semibold">
                Antipulgas:
            </div>
            <div class="flex flex-col">
                <div
                v-for="(item, index) in historialClinico.antipulgas"
                :key="index"
                class="flex flex-row gap-2"
                >
                    <span>{{ item.producto.Producto }}</span>
                    <span>{{ item.observacion }}</span>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>

import { ref, watch, toRefs, onMounted, defineProps } from 'vue';
import { useHistorialClinico } from '../../composables/useHistorialClinico';
import Swal from 'sweetalert2'
import baseUrl from '../../../baseUrl';
import axios from 'axios';

const props =  defineProps({
  historialClinico: Object,

})

const { historialClinico } = toRefs(props);

const emit = defineEmits(['eliminarHistorial', 'editarHistorial'])

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

onMounted(() => {
    tipoHistorialClinicoComposable.value = historialClinico.value.tipo_historia_clinica.nombre
})

watch(historialClinico, (value) => {
    if(value){
        tipoHistorialClinicoComposable.value = value.tipo_historia_clinica.nombre
    }
   
})

const eliminarHistorial = (historial) => {
    Swal.fire({
    title: "Estas seguro",
    showCancelButton: true,

    confirmButtonText: "Si"
    }).then( async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.delete(`${baseUrl}/api/historiaClinica/${historial.id}`)
                emit('eliminarHistorial', historial)
            } catch (error) {
                console.log(error)
            }
        }

    });
}

</script>

<style lang="scss" scoped>

</style>