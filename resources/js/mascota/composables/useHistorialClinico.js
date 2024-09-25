
import { ref, onMounted, onUnmounted, computed } from 'vue'


export function useHistorialClinico() {

    const tipoHistorialClinicoComposable = ref(null)

    const mostrarFechaAtencion = computed(() => 
        ['Consulta','Control', 'Cirugia', 'Vacuna', 'Antiparasito','Antipulgas'].includes(tipoHistorialClinicoComposable.value)
    )
    const mostrarMotivoAtencion = computed(() => 
        ['Consulta','Control', 'Cirugia'].includes(tipoHistorialClinicoComposable.value)
    )
    const mostrarDescripcion = computed(() => 
        ['Consulta','Control', 'Vacuna'].includes(tipoHistorialClinicoComposable.value)
    )
    const mostrarDiagnostico = computed(() => 
        ['Consulta','Control'].includes(tipoHistorialClinicoComposable.value)
    )  
    const mostrarExamenAuxiliar = computed(() => 
        ['Consulta','Control'].includes(tipoHistorialClinicoComposable.value)
    )  
    const mostrarTratamiento = computed(() => 
        ['Consulta','Control'].includes(tipoHistorialClinicoComposable.value)
    )  
    const mostrarVacuna = computed(() => 
        ['Vacuna'].includes(tipoHistorialClinicoComposable.value)
    )  
    const mostrarAntiparasitarios = computed(() => 
        ['Antiparasitario'].includes(tipoHistorialClinicoComposable.value)
    ) 
    const mostrarAntipulgas = computed(() => 
        ['Antipulgas'].includes(tipoHistorialClinicoComposable.value)
    )  
    const mostrarExamenClinico = computed(() => 
        ['Consulta','Control'].includes(tipoHistorialClinicoComposable.value)
    )
 
  return {

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
  }
}