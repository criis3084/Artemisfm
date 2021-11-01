<template>
	<div>
		<vx-card>
			<div class = "demo-alignment">
				<h2>Pacientes</h2>
				<vx-tooltip text = "Agregar nuevo registro"> <vs-button radius type = "gradient" icon = "person_add" @click="aNuevo" color = "primary" size = "large" ></vs-button>  </vx-tooltip>
			</div>
		<vs-divider position="right">ARTEMIS&#174;</vs-divider>
		<div class = "demo-alignment">
			<small class="font-bold text-primary">Filtrar por tipo de paciente</small>
			<v-select class="vx-col md:w-1/4 w-full mt-5" label="nombre" :options="TipoPacientes" @input="buscarPorTipo" v-model="tipoP" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
			<vs-button icon-pack = "feather" icon = "icon-refresh-cw" color="primary" type="border" @click="index"> Ver todos</vs-button>
        </div>
		<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
			<vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
			<v-select v-model="selectedFormat" :options="formats" class="my-4" />
			<div class="flex">
				<span class="mr-4">Ancho automatico de celda:</span>
				<vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
			</div>
		</vs-prompt>

			<vs-table stripe title="Pacientes" pagination max-items="7" search :data="arrayData" noDataText="No hay datos disponibles">
				<template slot="header">
					<vs-button @click="activePrompt=true">Exportar</vs-button>
				</template>
				<template slot="thead">
                    <vs-th>Ver</vs-th>
                    <vs-th>Nombre</vs-th>
                    <vs-th>Teléfono</vs-th>
                    <vs-th>Tipo de Paciente</vs-th>
                    <vs-th>Día Apoyo</vs-th>
                    <vs-th>Estado de Apoyo</vs-th>
                    <vs-th>Estado</vs-th>
					<vs-th>Acciones</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td>
						    <vx-tooltip text="Información Completa"> <vs-button radius color="dark" type="flat" icon="visibility" size="large" @click="$router.push('/ver/paciente/'+data[indextr].id)"></vs-button></vx-tooltip>			
					    </vs-td>
						<vs-td>{{data[indextr].datos.nombres + " " + data[indextr].datos.apellidos}}</vs-td>
                        <vs-td>{{data[indextr].datos.numero_telefono}}</vs-td>
                        <vs-td>{{data[indextr].tipo_paciente.nombre}}</vs-td>
                        <vs-td>{{data[indextr].dia_apoyo}}</vs-td>
                        <vs-td>
							<vs-chip v-if="data[indextr].tipo_paciente.id == 2" class="ag-grid-cell-chip" color="dark">
								<span >{{'Sin beneficios'}}</span>
							</vs-chip>
							<vs-chip v-else class="ag-grid-cell-chip" :color="data[indextr].beneficio.estado == 0 ? 'warning' : data[indextr].beneficio.estado == 1 ? 'success': data[indextr].beneficio.estado == 2 ? 'danger' : data[indextr].beneficio.estado == 3 ?'dark':'primary'">
								<span>{{data[indextr].beneficio.estado == 0 ? 'Sin entregar' : data[indextr].beneficio.estado == 1 ? 'Entregado': data[indextr].beneficio.estado == 2 ? 'Atrasado' :data[indextr].beneficio.estado == 3 ? 'Sin beneficios':'No Recibe este mes'}}</span>
							</vs-chip>
						</vs-td>
						<vs-td>
							<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
								<span slot="on" >Activo</span>
								<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td>
							<div class="flex items-center">
							<vx-tooltip text="Editar"> <vs-button radius color="dark" type="flat" icon="edit" size="large" @click="$router.push('/editar/paciente/'+data[indextr].id)"> </vs-button></vx-tooltip>
							<div v-if="data[indextr].beneficio.estado !== 3">
							<vx-tooltip text="Beneficios"> <vs-button radius color="dark" type="flat" icon="list" size="large" @click="$router.push('/ver/beneficios/'+data[indextr].id)"> </vs-button></vx-tooltip>
							</div>
							</div>
						</vs-td>
					</vs-tr>
				</template>
			</vs-table>
		</vx-card>
	</div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from '@/components/timeline/VxTimeline'
import vSelect from 'vue-select'
import axios from 'axios'

export default {
  data () {
    return { 
      offset : 3,
      search : '',
      arrayData: [],
	  estadoBeneficios: [],
	  listaBeneficiosxMes:[],
	  TipoPacientes:[],
	  tipoP:'',
      nombre: '',
	  switch2:false,
	  id: 0,
	  estado: null,
	  activePrompt: false,
	  abrirListado: false,
	  fileName: '',
	  listadoConstrucciones:[],
      formats:['xlsx', 'csv', 'txt'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id', 'dia_apoyo', 'nombres', 'apellidos', 'numero_telefono', 'nombre_tp'],
	  headerTitle: ['Id', 'Día Apoyo', 'Nombre', 'Apellidos', 'Telefono', 'Tipo Paciente']
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
    vSelect
  },
  watch: {
	  tipoP(){
		  if (this.tipoP==null){
			  this.index();
		  }
	  }
  },
  methods: {
    openAlert (color, constructor) {
      this.listado(constructor)
    },
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}-${date.getMonth() + 1}`
      return dateString
    },
    abrirDialog (id, estado) {
      let titulo = ''
      let color = ''

      if (estado === 0 || estado === false) {
        // cambiar de color al boton
        color = 'success'
        titulo = 'Confirmar activación'
      } else if (estado === 1 || estado === true) {
        color = 'danger'
        titulo = 'Confirmar desactivación'
      }
		
      this.id = id
      this.estado = estado

      this.$vs.dialog({
        type:'confirm',
        color: `${color}`,
        title: `${titulo}`,
        text: '¿Está seguro de llevar a cabo esta acción?',
        accept: this.cambiarEstado,
        cancel: this.close,
			acceptText: 'Aceptar',
			cancelText: 'Cancelar',
      })
    },
    cambiarEstado (color) {
      let titulo = ''
		
      if (this.estado === 0 || this.estado === false) {
        titulo = 'Activado exitósamente'
        axios.put('/api/paciente/activar', {
          id: this.id
        })
          .then(function (response) {
            console.log(response.data.message)
          })
          .catch(function (error) {
            console.log(error.response.data.message)
          })
      } else if (this.estado === 1 || this.estado === true) {
        titulo = 'Desactivado exitósamente'
        axios.put('/api/paciente/desactivar', {
          id: this.id
        })
          .then(function (response) {
            console.log(response.data.message)
          })
          .catch(function (error) {
            console.log(error.response.data.message)
          })
      }
      this.$vs.notify({
        color:'success',
        title:`${titulo}`,
        text:'La acción se realizó exitósamente'
      })
    },
    close () {
      	const titulo = 'Cancelado'
      	const texto = 'Cambio de estado cancelado'
      this.$vs.notify({
        color:'danger',
        title:`${titulo}`,
        text:`${titulo}`
      })
      this.index()
    },
    async index () {
	  const me = this
	  me.tipoP = null
      const response = await axios.get(
        '/api/paciente/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.pacientes.data
          me.arrayData = me.traerNombre(me.arrayData)
          me.arrayData = me.traerDatos(me.arrayData)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async buscarPorTipo () {
	  if (this.tipoP != null)
	  {
	  const id_recibido = this.tipoP.id
      const me = this
      const response = await axios.get(
		  `/api/paciente/get?&criterio=tipo_paciente_id&buscar=${id_recibido}&completo=true`)
        .then(function (response) {
			const respuesta = response.data
          me.arrayData = respuesta.pacientes.data
          me.arrayData = me.traerNombre(me.arrayData)
        })
        .catch(function (error) {
			console.log(error)
        })
	  }
    },
    async importarTipoPaciente () {
      const me = this
      const response = await axios.get(
        '/api/tipoPaciente/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
		  me.TipoPacientes = respuesta.tipoPacientes.data
        })
        .catch(function (error) {
          console.log(error)
        })
    },
	
    aNuevo () {
		 this.$router.push('/ingresar/paciente')
    },    
    exportToExcel () {
		import('@/vendor/Export2Excel').then(excel => {
		  const list = this.arrayData
		  const data = this.formatJson(this.headerVal, list)
		  excel.export_json_to_excel({
		    header: this.headerTitle,
		    data,
		    filename: this.fileName,
		    autoWidth: this.cellAutoWidth,
		    bookType: this.selectedFormat
		  })

		  this.clearFields()
		})
    },
    formatJson (filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        return v[j]
      }))
    },
    clearFields () {
      this.filename = ''
      this.cellAutoWidth = true
      this.selectedFormat = 'xlsx'
    },
    traerDatos(tabla){
			tabla.forEach(function(valor, indice, array){
                valor.nombre_tp=valor.tipo_paciente.nombre
			}); 
			return tabla
		},
    traerNombre (tabla) {
      const encontrado = ''
      const diaEntrega = 0

      const today = new Date()
      const mesActual = this.getDate(today)
      const diadeHoy = today.getDate()
		
      let fechaString = ''
      tabla.forEach(function (valor, indice, array) {
        valor.nombres = valor.datos.nombres
        valor.apellidos = valor.datos.apellidos
        valor.numero_telefono = valor.datos.numero_telefono
        if (valor.beneficios.length == 0) {
          valor.beneficio = {estado:3}
        } else {
          valor.beneficios.forEach(function (benefi, indice2, array2) {
            fechaString = benefi.fecha_entrega.slice(0, 7)
            if (fechaString == mesActual) {
              if (benefi.estado == 0) {
                if (valor.dia_apoyo > diadeHoy) {
                  benefi.estado = 0
                } else if (valor.dia_apoyo < diadeHoy) {
                  benefi.estado = 2
                }
              }
              valor.beneficio = benefi
            }
            if (valor.beneficio == undefined) {
				valor.beneficio = {estado:4}
            }
          }) 
        }
      })
      return tabla
    }
  },
  mounted () {
    this.index()
    this.importarTipoPaciente()
  }
}
</script>

<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
  .greet-user{
    position: relative;

    .decore-left{
      position: absolute;
      left:0;
      top: 0;
    }
    .decore-right{
      position: absolute;
      right:0;
      top: 0;
    }
  }

  @media(max-width: 576px) {
    .decore-left, .decore-right{
      width: 140px;
    }
  }
}
.ag-grid-cell-chip {
  &.vs-chip-success {
    background: rgba(var(--vs-success),.15);
    color: rgba(var(--vs-success),1) !important;
    font-weight: 500;
  }
  &.vs-chip-warning {
    background: rgba(var(--vs-warning),.15);
    color: rgba(var(--vs-warning),1) !important;
    font-weight: 500;
  }
  &.vs-chip-danger {
    background: rgba(var(--vs-danger),.15);
    color: rgba(var(--vs-danger),1) !important;
    font-weight: 500;
  }
  &.vs-chip-dark {
    background: rgba(var(--vs-dark),.15);
    color: rgba(var(--vs-dark),1) !important;
    font-weight: 500;
  }
  &.vs-chip-primary {
    background: rgba(var(--vs-primary),.15);
    color: rgba(var(--vs-primary),1) !important;
    font-weight: 500;
  }
}
/*! rtl:end:ignore */
</style>
