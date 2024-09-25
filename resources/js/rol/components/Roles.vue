<template>
    <div class="d-flex flex-column">
        <div
        v-for="(role, index) in roles"
        :key="index"
        >
            <div class="card">
                <div class="card-body d-flex flex-column p-4">
                    <h5 class="card-title mb-2"><strong>{{ role.nombre }}</strong></h5>

                    <div
                    class="d-flex flex-row flex-wrap gap-2"
                    >
                        <div
                        v-for="(permiso, i) in permisos"
                        style="min-width: 180px;"
                        >
                        <input 
                        class="form-check-input" 
                        type="checkbox" 
                        :value=permiso 
                        :checked="rolTienePermiso(role, permiso)"
                        @change="togglePermiso($event, role, permiso)"
                        >
                            {{ permiso.nombre }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2'

onMounted(() => {
    getPermisos();
    getRoles();

});

const roles = ref([]);
const getRoles = async () => {
    try {
        const response = await axios.get('api/roles');
        roles.value = response.data;
        console.log(response);
    } catch (error) {
        console.error(error);
    }
}

const permisos = ref([]);
const getPermisos = async () => {
    try {
        const response = await axios.get('api/permisos');
        permisos.value = response.data;
        console.log(response);
    } catch (error) {
        console.error(error);
    }
}

const rolTienePermiso = (rol, permiso) => {
    return rol.permisos.includes(permiso.id);
}

const togglePermiso = (event, role, permiso) => {
    if (event.target.checked) {
        agregarPermiso(role, permiso);
    } else {
        eliminarPermiso(role, permiso);
    }
}

const agregarPermiso = async (role, permiso) => {
    
    try {
        await axios.post('api/permisos-roles', {
            rol_id: role.id,
            permiso_id: permiso.id
        });

        Swal.fire({
            title: 'Realizado correctamente',
            icon: 'success',
            showConfirmButton: false,
            timer: 500
        })
    } catch (error) {
        Swal.fire({
            title: 'Error',
            text: 'No se pudo realizar la operación',
            icon: 'error',
            showConfirmButton: false,
            timer: 500
        })
        console.error(error);
    }
}

const eliminarPermiso = async (role, permiso) => {
    try {
        await axios.delete(`api/permisos-roles/${role.id}/${permiso.id}`);
        Swal.fire({
            title: 'Realizado correctamente',
            icon: 'success',
            showConfirmButton: false,
            timer: 500
        })
    } catch (error) {
        Swal.fire({
            title: 'Error',
            text: 'No se pudo realizar la operación',
            icon: 'error',
            showConfirmButton: false,
            timer: 500
        })
        console.error(error);
    }
}


</script>

<style >

</style>