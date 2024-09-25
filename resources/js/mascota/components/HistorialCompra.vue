<template>
    <div>
        <h3 class="text-lg font-semibold">Historial de compras</h3>
        <DataTable 
        :data="historialCompra"
        :columns="columns"
         class="table"
        />
          
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, toRefs, onMounted, defineProps } from 'vue'
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import DataTableBs5 from 'datatables.net-bs5';
import { moneda } from '../../utils/moneda';

DataTable.use(DataTableBs5);
DataTable.use(DataTablesCore);

const props = defineProps({
    mascota: {
        type: Object,
        required: true
    }
})

const {  mascota } = toRefs(props)

onMounted(() => {
    getHistorialCompra()
})

const historialCompra = ref([])
const cargandoHistorialCompra = ref(false)
const getHistorialCompra = async () => {
    try {
        cargandoHistorialCompra.value = true
        const response = await axios.get('/api/historial-compras', { params: { mascota_id: mascota.value.id } })
        if(response.data){
            historialCompra.value = response.data
        }
    } catch (error) {
        
    } finally {
        cargandoHistorialCompra.value = false
    }
}

const columns = [
    {
        data: 'producto.Producto',
        title: 'Producto'
    },
    {
        data: 'servicio.Servicio',
        title: 'Servicio'
    },
    {
        data: 'cantidad',
        title: 'Cantidad'
    },
    {
        data: 'total',
        title: 'Total',
        render: function(data, type, row) {
            return moneda()+' '+ data; // Reemplaza '$' con el símbolo de tu moneda
        }
    },
    {
        data: 'created_at_transformado',
        title: 'Fecha',
      
    },
]



</script>

<style >

@import 'datatables.net-bs5';

.table {
    background: white;
}

</style>