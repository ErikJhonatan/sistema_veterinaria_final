import { createApp, ref } from 'vue';
import HistorialClinico from './components/HistorialClinico.vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '@trevoreyre/autocomplete-vue/dist/style.css'


const app =  createApp({
    components: {
      HistorialClinico
    },
    setup() {

     }
   })

app.use(VueSweetalert2);
app.mount('#app')