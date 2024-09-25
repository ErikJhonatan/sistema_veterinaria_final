
<template>
    <div>
        <h3 class="text-lg font-semibold">Listado de usuarios</h3>
        <div
         v-if="puedeCrear"
        >
            <button
            @click="abrirCrearUsuario"
            class="btn btn-primary"
            >
                Crear usuario
            </button>
        </div>
        <DataTable 
        :data="usuarios"
        :columns="columns"
        class="table"
        :options="{
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            search: 'Buscar'
        }
        }"
        >
        <template #action="props">
            <div class="d-flex flex-row" >  
                <button
                v-if="puedeEditar"
                @click="abrirEditarUsuario(props.rowData)"
                class="mr-2"
                >
                    <i class="fas fa-fw fa-pen"></i>
                </button>
                <button
                v-if="puedeEliminar"
                @click="eliminarUsuario(props.rowData)"
                class="danger"
                >
                    <i class="fas fa-fw fa-trash text-red"></i>
                </button>
            </div>
        </template>
        </DataTable>

        <!-- Modal -->
        <div
        v-if="mostrarModalGuardar"
        class="modal fade show d-block" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" >Guardar </h1>
                    <button 
                    type="button"
                    class="btn-close" 
                    @click="mostrarModalGuardar = false"
                    >
                    </button>
                </div>
                <div class="modal-body">

                    <!-- name -->
                    <div class="mb-3">
                        <label class="form-label"> Nombre </label>
                        <input 
                        type="text" 
                        class="form-control" 
                        v-model="formulario.name"
                        >
                    </div>
                    <!-- email -->
                    <div class="mb-3">
                        <label class="form-label"> Email</label>
                        <input 
                        type="email" 
                        class="form-control" 
                        v-model="formulario.email"
                        >
                    </div>
                    <!-- password -->
                    <div class="mb-3">
                        <label class="form-label"> Contraseña</label>
                        <input 
                        type="password" 
                        class="form-control" 
                        autocomplete="new-password"
                        v-model="formulario.password"
                        >
                    </div>
                    <!-- rol_id -->
                    <div class="mb-3">
                        <label  class="form-label">Rol</label>
                        <select  
                        v-model="formulario.rol_id"
                        class="form-select">
                            <option
                            v-for="(item, index) in roles"
                            :key="index"
                            :value="item.id"
                            >
                                {{ item.nombre }}
                            </option>
                        </select>
                    </div>
                    <!-- sede_id -->
                    <div class="mb-3">
                        <label  class="form-label">Sede</label>
                        <select  
                        v-model="formulario.sede_id"
                        class="form-select">
                            <option
                            v-for="(item, index) in sedes"
                            :key="index"
                            :value="item.id"
                            >
                                {{ item.nombre }}
                            </option>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button 
                    type="button" 
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal"
                    @click="mostrarModalGuardar = false"
                    >
                    Cerrar
                    </button>
                    <button 
                    type="button" 
                    class="btn btn-primary"
                    @click="!isEditMode ? crearUsuario() : editarUsuario()"
                    :disabled="guardandoUsuario || formularioInvalido"
                    >
                    {{ guardandoUsuario ? 'Guardando...' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>
        </div>

          
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, toRefs, onMounted, defineProps, reactive, computed } from 'vue'
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import DataTableBs5 from 'datatables.net-bs5';
import Swal from 'sweetalert2'

DataTable.use(DataTableBs5);
DataTable.use(DataTablesCore);

const props = defineProps({
    puedeEditar: Boolean,
    puedeEliminar: Boolean,
    puedeCrear: Boolean,
    roles: Array,
    sedes: Array
})

const { puedeCrear, puedeEditar, puedeEliminar, roles, sedes } = toRefs(props)


onMounted(() => {
    getUsuarios()
})

const usuarios = ref([])
const cargandoUsuarios = ref(false)
const getUsuarios = async () => {
    try {
        cargandoUsuarios.value = true
        const response = await axios.get('/api/usuarios')
        if(response.data){
            usuarios.value = response.data
        }
    } catch (error) {
        
    } finally {
        cargandoUsuarios.value = false
    }
}

const columns = [
{
        data: 'created_at',
        title: 'Fecha registro',
      
    },
    {
        data: 'name',
        title: 'Nombre'
    },
    {
        data: 'email',
        title: 'Email'
    },
    {
        data: 'rol.nombre',
        title: 'Rol'
    },
    {
        data: 'sede.nombre',
        title: 'Sede'
    },
    
    {
        data: null,
        render: '#action',
        title: 'Action'
    },
    
]

const formulario = reactive({
    name: '',
    email: '',
    password: '',
    rol_id: '',
    sede_id: '',
    password: ''
})

const formularioInvalido = computed(() => {
    return !formulario.name || 
            !formulario.email || 
            !formulario.rol_id || 
            !formulario.sede_id ||
            (!isEditMode.value && !formulario.password)
})

const mostrarModalGuardar = ref(false);
const abrirCrearUsuario = () => {
    mostrarModalGuardar.value = true;
}

const guardandoUsuario = ref(false);
const crearUsuario = async () => {
    try {
        guardandoUsuario.value = true;
        const response = await axios.post('/api/usuarios', formulario)
        if(response.data){
            getUsuarios()
            Swal.fire({
                title: 'Realizado correctamente',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            })
            mostrarModalGuardar.value = false
            resetearFormulario()
        }

    } catch (error) {
        Swal.fire({
            title: 'Ha ocurrido un error',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
        })
        
    } finally {
        guardandoUsuario.value = false
    }
}

const resetearFormulario = () => {
    formulario.name = ''
    formulario.email = ''
    formulario.password = ''
    formulario.rol_id = ''
    formulario.sede_id = ''
}

const eliminarUsuario = async (usuario) => {

    Swal.fire({
    title: "Estas seguro",
    showCancelButton: true,

    confirmButtonText: "Si"
    }).then( async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.delete(`/api/usuarios/${usuario.id}`)
                if(response.data){
                    getUsuarios()
                    Swal.fire({
                        title: 'Eliminado correctamente',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            } catch (error) {
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }

    });

    

   
}

const isEditMode = ref(false);
const usuarioEditando = ref(null);
const abrirEditarUsuario = (usuario) => {
    isEditMode.value = true;
    formulario.name = usuario.name
    formulario.email = usuario.email
    formulario.rol_id = usuario.rol_id
    formulario.sede_id = usuario.sede_id
    formulario.password = ''
    usuarioEditando.value = usuario
    mostrarModalGuardar.value = true
}

const editarUsuario = async () => {
    try {
        guardandoUsuario.value = true;
        const response = await axios.patch(`/api/usuarios/${usuarioEditando.value.id}`, formulario)
        if(response.data){
            getUsuarios()
            Swal.fire({
                title: 'Realizado correctamente',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            })
            usuarioEditando.value =  null
            resetearFormulario()
            mostrarModalGuardar.value = false
        }

    } catch (error) {
        console.log(error)
        Swal.fire({
            title: 'Ha ocurrido un error',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
        })
        
    } finally {
        guardandoUsuario.value = false
    }
}

</script>

<style>
@import 'bootstrap';
@import 'datatables.net-bs5';



</style>

