<template>
    <div>
        <div class="mb-2">
            <autocomplete
            :search="search"
            placeholder="Buscar"
            result-list-label="nombre"
            :getResultValue="result => result.nombre"
            @submit="onSubmit"
            ref="refAutocomplete"
            ></autocomplete>
        </div>
        <div v-for="(combo, index) in combos" :key="index">
            <div class="input-group mb-3">
                <input 
                type="text" 
                class="form-control mr-1" 
                placeholder="Nombre" 
                v-model="combos[index].nombre"
                >
                <input 
                type="text" 
                class="form-control mr-1" 
                placeholder="Descripcion | Indicacion" 
                v-model="combos[index].observacion"
                >
                <!-- agregar botton eliminar bootstrap -->
                <button 
                type="button" 
                class="btn btn-outline-danger"
                @click="removerCombo(index)"
                >X
                </button>
            </div>
            
        </div>
    </div>
</template>

<script setup>
import { ref, toRefs, onMounted, watch } from 'vue';
import Autocomplete from '@trevoreyre/autocomplete-vue'
import Swal from 'sweetalert2'


const props = defineProps({
  defaultValue: {
    type: Array,
    default: null,
    required: false,
  },
  titulo: {
    type: String,
    required: false,
  },
  options: {
    type: Array,
    required: false,
  },
  confirmarAntesDeEliminar: {
    type: Boolean,
    default: false,
    required: false,
  }
});

const emit = defineEmits(['submit', 'remover'])

const { defaultValue, options, confirmarAntesDeEliminar } = toRefs(props);

onMounted(() => {
    if(defaultValue.value){
        combos.value = [...defaultValue.value]
    }

})

watch(defaultValue, (value) => {
    if (value) {
        combos.value = [...value]
    }
})

const refAutocomplete = ref(null);

const search = (value) => {
    return options.value.filter((option) => {
        return option.nombre.toLowerCase().includes(value.toLowerCase());
    });
}

const onSubmit = (value) => {
    let nuevoValor = {
        id: value.id,
        nombre: value.nombre,
        observacion: ''
    }
    combos.value.push(nuevoValor)
    refAutocomplete.value.value = ''
    emit('submit', nuevoValor)
}

const combos = ref([])

const removerCombo = (index) => {
    if(confirmarAntesDeEliminar.value){
        Swal.fire({
            title: "Estas seguro",
            showCancelButton: true,
            confirmButtonText: "Si"
        }).then( async (result) => {
            if (result.isConfirmed) {
                let combo = {...combos.value[index]}
                combos.value.splice(index, 1)
                emit('remover', combo)
            }
        })  
    } else {
        let combo = {...combos.value[index]}
        combos.value.splice(index, 1)
        emit('remover', combo)
    }
    
}

defineExpose({
    combos
})

</script>

<style lang="scss" scoped>

</style>