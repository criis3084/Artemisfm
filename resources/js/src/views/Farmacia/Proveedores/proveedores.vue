<template>
	<div>
		<vx-card>
					<div class = "demo-alignment">
						<h2>Proveedores</h2>
						<vx-tooltip text = "Agregar nuevo registro"> <vs-button radius type = "gradient" icon = "person_add" @click="aNuevo" color = "primary" size = "large" ></vs-button>  </vx-tooltip>
					</div>
									<vs-divider position="right">ARTEMIS&#174;</vs-divider>

		<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
          <span class="mr-4">Ancho automatico de celda:</span>
          <vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
			</vs-prompt>

			<vs-table title="Proveedores" stripe pagination max-items="7" search :data="arrayData" noDataText="No hay datos disponibles">
	   <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
				<template slot="thead">
                    <vs-th>Ver</vs-th>
                    <vs-th>Nombre Empresa</vs-th>
                    <vs-th>Nombre Proveedor</vs-th>
                    <!-- <vs-th>Apellidos</vs-th> -->
                    <vs-th>Teléfono</vs-th>
                    <vs-th>Estado</vs-th>
					 <vs-th>Acciones</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td>
						    <vx-tooltip text="Información Completa"> <vs-button radius color="dark" type="flat" icon="visibility" size="large" @click="$router.push('/ver/proveedor/'+data[indextr].id)"></vs-button></vx-tooltip>			
					    </vs-td>
                        <vs-td>{{data[indextr].nombre}}</vs-td>
						<vs-td>{{data[indextr].datos.nombres + " " + data[indextr].datos.apellidos}}</vs-td>
		            	<!-- <vs-td>{{data[indextr].datos.apellidos}}</vs-td> -->
                        <vs-td>{{data[indextr].datos.numero_telefono}}</vs-td>
						<vs-td>
							<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
								<span slot="on" >Activo</span>
								<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td>
							<div class="flex items-center">
							<vx-tooltip text="Editar"> <vs-button radius color="dark" type="flat" icon="edit" size="large" @click="$router.push('/editar/proveedor/'+data[indextr].id)"> </vs-button>  </vx-tooltip>
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
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from '@/components/ChangeTimeDurationDropdown.vue'
import VxTimeline from '@/components/timeline/VxTimeline'
import vSelect from 'vue-select'
import axios from 'axios'

export default {
  data () {
    return {
      //Aqui van a guardar todas su variables.
      pagination : {
        'total' : 0,
        'current_page' : 0,
        'per_page' : 0,
        'last_page' : 0,
        'from' : 0,
        'to' : 0
      },
      offset : 3,
      search : '',
      arrayData: [],
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
	  headerVal: ['id','nombre', 'nombres', 'apellidos','CUI','direccion', 'numero_telefono'],
	  headerTitle: ['Id','Empresa', 'Nombre', 'Apellidos','CUI','Lugar', 'Telefono']
    }
  },
  components: {
    VueApexCharts,
    StatisticsCardLine,
    ChangeTimeDurationDropdown,
    VxTimeline,
    vSelect
  },
  methods: {
    openAlert(color,proveedor){
		this.listado(proveedor)
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
		axios.put('/api/proveedor/activar', {
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
			axios.put('/api/proveedor/desactivar', {
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
    async index () { //async para que se llame cada vez que se necesite
		const me = this
		const response = await axios.get(
		`/api/proveedor/get?completo=true`)
		.then(function (response) {
			const respuesta = response.data
			me.arrayData = respuesta.proveedores.data
			me.proveedor = me.traerNombre(me.arrayData)
		})
		.catch(function (error) {
			console.log(error)
		})
    },
    aNuevo () {
		 this.$router.push('/ingresar/proveedor')
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
        // Add col name which needs to be translated
        // if (j === 'timestamp') {
        //   return parseTime(v[j])
        // } else {
        //   return v[j]
        // }

        return v[j]
      }))
    },
    clearFields () {
		this.filename = ''
		this.cellAutoWidth = true
		this.selectedFormat = 'xlsx'
	},
	traerNombre (tabla) {
		tabla.forEach(function (valor, indice, array) {
			valor.nombres = valor.datos.nombres
			valor.apellidos = valor.datos.apellidos
			valor.numero_telefono = valor.datos.numero_telefono
			valor.CUI = valor.datos.CUI
			valor.direccion= valor.datos.direccion
		})
		return tabla
	}
  },
  mounted () {
    this.index()
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
/*! rtl:end:ignore */
</style>
