<template>
<div class="w-full">
  <!-- COLUMN CHART -->
            
			<vs-divider position="right">ARTEMIS&#174;</vs-divider>
			<div>
                <vx-card title="Salida de medicamentos mensuales">
					 <div class = "demo-alignment">
                        <small class="date-label">Seleccione un año</small>
                         <v-select class="vx-col md:w-1/2 w-full mt-5" label="anio" :options="anioSalidas"  v-model="fechasalida" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                    </div>
					<div class = "demo-alignment">
                        <small class="date-label">Seleccione un medicamento</small>
                         <v-select class="vx-col md:w-1/2 w-full mt-5" label="nombre" :options="medicamentos" @input="BuscarSalidas"  v-model="medicamento" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                    </div>
                    <vue-apex-charts type="bar" width="1000" height="300" :options="options" :series="medicamentosPorMes"></vue-apex-charts>
                </vx-card>
            </div>
<vs-divider position="right">ARTEMIS&#174;</vs-divider>
			<div>
                <vx-card title="Ingreso de medicamentos mensuales">
					 <div class = "demo-alignment">
                        <small class="date-label">Seleccione un año</small>
                         <v-select class="vx-col md:w-1/2 w-full mt-5" label="anio" :options="anioIngresos"  v-model="fechaingreso" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                    </div>
					<div class = "demo-alignment">
                        <small class="date-label">Seleccione un medicamento</small>
                         <v-select class="vx-col md:w-1/2 w-full mt-5" label="nombre" :options="medicamentos" @input="BuscarIngresos"  v-model="medicamentoI" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                    </div>
                    <vue-apex-charts type="bar" width="1000" height="300" :options="options" :series="medicamentoIngreso"></vue-apex-charts>
                </vx-card>
            </div>

            </div>
			
</div>
</template>

<script>
import ChartjsBarChart from '@/views/charts-and-maps/charts/chartjs/charts-components/ChartjsComponentBarChart.vue'
import ChartjsComponentPieChart from '@/views/charts-and-maps/charts/chartjs/charts-components/ChartjsComponentPieChart.vue'
import ChartjsComponentDoughnutChart from '@/views/charts-and-maps/charts/chartjs/charts-components/ChartjsComponentDoughnutChart.vue'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
import 'swiper/dist/css/swiper.min.css'
import VueApexCharts from 'vue-apexcharts'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import axios from 'axios'
import vSelect from 'vue-select'
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    anio: {
      	  required: 'El campo es requerido',
      	  numeric: 'El campo solo debe de contener números',
      max: 'Este campo solo acepta hasta 4 dígitos'
    }
  }
}
Validator.localize('es', dict)
export default {
  data () {
    return {
	  medicamento:'',
	  medicamentoI:'',
	  arrayData: [],
	  arrayTutorias:[],
	  arrayCitas:[],
	  arrayMedicamentosPorMes:[],
	  arrayMedicamentosIngreso:[],
	  cantidad:0,
	  anio:[],
	  fechas:{},
	  fechatutoria:'',
	  fechacita:'',
	  anioTutorias:[],
	  tutorias:[],
	  anioCitas:[],
	  citas:[],
	  anioSalidas:[],
	  fechasalida:'',
	  medicamentos:[],
	  medicamentosPorMes:[],
	  anioIngresos:[],
	  fechaingreso:'',
	  medicamentoIngreso:[],
	  arraViviendas:[],
	  estadoVivienda:'',
	  fechaViviendas:{},
	  anioViviendas:[],
	  estado:[
		  {
			  nombre: 'Pago terminado',
			  estado: 0
		  },
		  {
			  nombre: 'Pago aún pendiente',
          estado: 1
		  }
	  ],

	  options: {
		  chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        }
	  }
    }
	
  },
  methods: {
	   async index () {
      const me = this
      this.abrir_editar = false
      const response = await axios
        .get('/api/nino/apadrinamientos')
        .then(function (response) {
          const respuesta = response
		  me.arrayData = respuesta.data
		  //console.log(me.arrayData)
		  me.buscar()
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    buscar () {
	  const valores = []
	  const fechas = []
      if (this.arrayData !== undefined) {
        this.arrayData.forEach(function (valor, indice) {
		  valores.unshift(valor.total)
		  fechas.unshift(valor.Anio)
        })
	  }
	  const series =
	  [
	    {
	      name: 'Cantidad por año',
	      data: valores
	    }
	  ]
	  const options = {
		  chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: fechas
        }
	  }
	  this.anio = series
	  this.fechas = options
    },
	 async Buscartutorias () {
		 if (this.anioTutorias != null) {
        const anio_recibido = this.fechatutoria.anio
        const me = this
        const response = await axios
          .get(`/api/tutoria/tutoriasmen?&anio=${anio_recibido}&completo=true`)
          .then(function (response) {
            const respuesta = response
		  me.arrayTutorias = respuesta.data
          })
          .catch(function (error) {
		  })
		  me.tutorias = me.datosporanio(me.arrayTutorias)
		 }
    }, 
    async anioTurorias () {
      const me = this
      const response = await axios
        .get('/api/tutoria/tutoriasmen?&completo=true')
        .then(function (response) {
          const respuesta = response
          me.anioTutorias = respuesta.data
        })
        .catch(function (error) {
        })
    },
    datosporanio (arreglo) {
	  const valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
	  const mes = []
      if (arreglo !== undefined) {
		  arreglo.forEach(function (valor, indice) {
			  if (valor.mes === 1) {
            valores.splice(0, 1, valor.total)	  
			  }
			  if (valor.mes === 2) {
            valores.splice(1, 1, valor.total)	  	  
			  }
			  if (valor.mes === 3) {
            valores.splice(2, 1, valor.total)	  	  
			  }
			  if (valor.mes === 4) {
            valores.splice(3, 1, valor.total)	  	  
			  }
			  if (valor.mes === 5) {
            valores.splice(4, 1, valor.total)	  	  
			  }
			  if (valor.mes === 6) {
            valores.splice(5, 1, valor.total)	  	  
			  }
			  if (valor.mes === 7) {
            valores.splice(6, 1, valor.total)	  	  
			  }
			  if (valor.mes === 8) {
            valores.splice(7, 1, valor.total)	  	  
			  }
			  if (valor.mes === 9) {
            valores.splice(8, 1, valor.total)	  	  
			  }
			  if (valor.mes === 10) {
            valores.splice(9, 1, valor.total)	  	  
			  }
			  if (valor.mes === 11) {
            valores.splice(10, 1, valor.total)	  	  
			  }
			  if (valor.mes === 12) {
            valores.splice(11, 1, valor.total)	  	  
			  }
		  })
      }
      const series = [
        {
          name:'Cantidad por mes',
          data : valores
        }
	  ]
      return series
    },
	 async BuscarCitas () {
		 if (this.anioCitas != null) {
        const anio_recibido = this.fechacita.anio
        const me = this
        const response = await axios
          .get(`/api/cita/reporteCitas?&anio=${anio_recibido}&completo=true`)
          .then(function (response) {
            const respuesta = response
		  me.arrayCitas = respuesta.data
          })
          .catch(function (error) {
		  })
		  me.citas = me.datosporanio(me.arrayCitas)
		 }
    }, 
    async anioCita () {
      const me = this
      const response = await axios
        .get('/api/cita/reporteCitas?&completo=true')
        .then(function (response) {
          const respuesta = response
          me.anioCitas = respuesta.data
        })
        .catch(function (error) {
        })
    },
	
    async anioSalidasM () {
	  const me = this
      const response = await axios
        .get('/api/salidaMedicamento/reporteSalidas?&completo=true')
        .then(function (response) {
          const respuesta = response
          me.anioSalidas = respuesta.data
        })
        .catch(function (error) {
        })
    },
    async BuscarSalidas () {
		 if (this.anioSalidas != null) {
        const anio_recibido = this.fechasalida.anio
        const id_medicamento = this.medicamento.id
        const me = this
        const response = await axios
          .get(`/api/salidaMedicamento/reporteSalidas?&anio=${anio_recibido}&medicamento=${id_medicamento}&completo=true`)
          .then(function (response) {
            const respuesta = response
		  me.arrayMedicamentosPorMes = respuesta.data
          })
          .catch(function (error) {
		  })
		  me.medicamentosPorMes = me.datosporanio(me.arrayMedicamentosPorMes)
		 }
    },
    async importarMedicamentos () {
      const me = this
      const response = await axios
        .get('api/medicamento/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.medicamentos = respuesta.medicamentos.data
        })
        .catch(function (error) {
        })
    },
	 async anioIngresosM () {
	  const me = this
      const response = await axios
        .get('/api/ingresoMedicamento/reporteIngreso?&completo=true')
        .then(function (response) {
          const respuesta = response
          me.anioIngresos = respuesta.data
        })
        .catch(function (error) {
        })
    },
    async BuscarIngresos () {
		 if (this.anioIngresos !== null) {
        const anio_recibido = this.fechaingreso.anio
        const id_medicamento = this.medicamentoI.id
        const me = this
        const response = await axios
          .get(`/api/ingresoMedicamento/reporteIngreso?&anio=${anio_recibido}&medicamento=${id_medicamento}&completo=true`)
          .then(function (response) {
            const respuesta = response
		  me.arrayMedicamentosIngreso = respuesta.data
          })
          .catch(function (error) {
		  })
		  me.medicamentoIngreso = me.datosporanio(me.arrayMedicamentosIngreso)
		 }
    },
    async viviendas () {
	  const me = this
	  const estado = this.estadoVivienda.estado
      const response = await axios
        .get(`/api/vivienda/reporteViviendas?&estado=${estado}`)
        .then(function (response) {
          const respuesta = response
		  me.arraViviendas = respuesta.data
		  me.buscarViviendas()
        })
        .catch(function (error) {
          console.log(error)
        })
    },
	
    buscarViviendas () {
	  const valores = []
	  const fechas = []
      if (this.arraViviendas !== undefined) {
        this.arraViviendas.forEach(function (valor, indice) {
		  valores.unshift(valor.total)
		  fechas.unshift(valor.anio)
        })
	  }
	  const series =
	  [
	    {
	      name: 'Cantidad por año',
	      data: valores
	    }
	  ]
	  const options = {
		  chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: fechas
        }
	  }
	  this.anioViviendas = series
	  this.fechaViviendas = options
    }
  },

  components: {
    VueApexCharts,
    swiper,
    swiperSlide,
    ChartjsComponentPieChart,
    ChartjsComponentDoughnutChart,
    StatisticsCardLine,
    ChartjsBarChart,
    vSelect
  },
  mounted () {
	  this.index()
	  this.anioTurorias()
	  this.anioCita()
	  this.anioSalidasM()
	  this.importarMedicamentos()
	  this.anioIngresosM()
  }
}
</script>