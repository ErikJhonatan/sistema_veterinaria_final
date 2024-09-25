<template>
    <div>
        <form ref="refForm" class="mb-4">
            <div class="form-group">
                <label for="exampleFormControlFile1">Galeria</label>
                <input 
                type="file" 
                class="form-control-file" 
                @input="getArchivo"
                >
            </div>
            <div
            v-if="archivosAgregados.length > 0"
            >
                <button 
                type="button" 
                class="btn btn-success btn-sm"
                @click="guardarGaleria"
                :disabled="guardandoGaleria"
                >
                    Guardar 
                </button>
            </div>
        </form>
        <div v-if="galeria.length > 0"  class="flex flex-row flex-wrap gap-2">
            <div
            v-for="(imagen, key) in galeria"
            :key="key"
            class="relative"
            >
                <div style="position: absolute;top: 0px;right: 0;" >
                  
                    <button 
                    type="button" 
                    class="btn btn-danger btn-sm"
                    @click.stop="eliminarImagen(imagen)"
                    :disabled="eliminandoImagen"
                    >
                        X
                    </button>
                </div>
                <img 
                @click="abrirImagen(imagen)"
                :src="baseUrl + '/storage/' + imagen.path"
                style="max-width: 200px;height: 100%;"
                class="rounded img-thumbnail" 
                >
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import { ref, toRefs, onMounted } from 'vue'
import baseUrl from '../../baseUrl';
import Swal from 'sweetalert2'


const props = defineProps({
    producto: {
        type: Object,
        required: true
    }
})

const { producto } = toRefs(props)

const archivosAgregados = ref([])
const getArchivo = (data) => {
    if(data.target?.files && data.target.files.length > 0){
        archivosAgregados.value = data.target.files
    }
}

const refForm = ref(null)
const guardandoGaleria = ref(false)
const guardarGaleria = async () => {
    
    const formData = new FormData();
    for(let i = 0; i < archivosAgregados.value.length; i++) {
        formData.append('galeria[]', archivosAgregados.value[i]);
    }
    formData.append('producto_id', producto.value.id)

    try {
        guardandoGaleria.value = true
        const response = await axios.post(baseUrl + '/api/producto-galeria', formData)
        refForm.value.reset()
        getGaleria()
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "No se guardo correctamente, verifique el tipo de archivo y el tamaño max 2MB",
            showConfirmButton: false,
            timer: 2000
        });
    } finally {
        guardandoGaleria.value = false
    }
}

const eliminandoImagen = ref(false)
const eliminarImagen = async (imagen) => {

    Swal.fire({
        title: "Estas seguro",
        showCancelButton: true,
        confirmButtonText: "Si"
    }).then( async (result) => {
        if (result.isConfirmed) {
            try {
                eliminandoImagen.value = true
                const response = await axios.delete(baseUrl + '/api/producto-galeria/' + imagen.id)
                if(response.data){
                    getGaleria()
                }
            } catch (error) {
                console.log(error)
            } finally {
                eliminandoImagen.value = false
            }  
        }
    })  
}

onMounted(() => {
    getGaleria()
})

const galeria = ref([])
const getGaleria = async () => {
    try {
        const response = await axios.get(baseUrl + '/api/producto-galeria',{
            params: {
                producto_id: producto.value.id
            }
        })
        if(response.data && response.data.length > 0){
            galeria.value = response.data
        }
        
    } catch (error) {


     
    }
}

const abrirImagen = (imagen) => {
    window.open(baseUrl + '/storage/' + imagen.path, '_blank');
}


</script>

<style lang="scss" scoped>

</style>