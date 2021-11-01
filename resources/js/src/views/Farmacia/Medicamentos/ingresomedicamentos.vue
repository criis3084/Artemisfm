<template>
	<div>
		<vx-card>
			<div class = "demo-alignment">
						<h2>Ingreso de medicamentos</h2>
						<vx-tooltip text = "Agregar nuevo registro"> <vs-button radius type = "gradient" icon-pack = "feather" icon = "icon-plus" @click="aNuevo" color = "primary" size = "large" ></vs-button>  </vx-tooltip>
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
			<vs-table stripe pagination max-items="7" search :data="arrayData" noDataText="No hay datos disponibles">
				<template slot="header">
					<vs-button @click="activePrompt=true">Exportar</vs-button>
				</template>
				<template slot="thead">
					<vs-th>Ver</vs-th>
					<vs-th>Nombres de Usuario</vs-th>
					<vs-th>Nombre Proveedor</vs-th>
					<vs-th>Fecha</vs-th>
					<vs-th>Descripción</vs-th>
					<vs-th>Estado</vs-th>
					<vs-th>Acciones</vs-th>
				</template>

				<template slot-scope="{ data }">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
						<vs-td>
							<vx-tooltip text="Detalle de entrada"> <vs-button radius color="dark" type="flat" icon="visibility" size="large"  @click="$router.push('/ver/entrada/'+data[indextr].id)" ></vs-button></vx-tooltip>
						</vs-td>
						<vs-td>{{ data[indextr].user_nombres + " " +  data[indextr].user_apellidos}}</vs-td>
						<vs-td>{{ data[indextr].proveedor_nombres + " " + data[indextr].proveedor_apellidos}}</vs-td>
						<vs-td>{{ data[indextr].fecha_ingreso }}</vs-td>
						<vs-td>{{ data[indextr].descripcion }}</vs-td>
						<vs-td :data="data[indextr].estado">
							<vs-switch
							color="success"
							v-model="data[indextr].estado"
							@click="abrirDialog(data[indextr].id, data[indextr].estado)"
							>
							<span slot="on">Activo</span>
							<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td>
							<vx-tooltip text="Editar"> <vs-button @click="cambiar(data[indextr])" radius color="dark" type="flat" icon="edit" size="large"> </vs-button>  </vx-tooltip>	
						</vs-td>
					</vs-tr>
				</template>
			</vs-table>
		</vx-card>
	</div>
</template>

   
<script>
import VueApexCharts from "vue-apexcharts";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
//import analyticsData from './ui-elements/card/analyticsData.js'
import ChangeTimeDurationDropdown from "@/components/ChangeTimeDurationDropdown.vue";
import VxTimeline from "@/components/timeline/VxTimeline";
import ingresaringreso from "./formularioingresomedi.vue";
import vSelect from 'vue-select'
import axios from "axios";
export default {
  data() {
		return {
			arrayData: [],
			fileName: '',
			formats:['xlsx', 'csv', 'txt'],
			cellAutoWidth: true,
			selectedFormat: 'xlsx',
			headerVal: ['id', 'user_nombres', 'user_apellidos', 'proveedor_nombres','proveedor_apellidos','fecha_ingreso','descripcion', 'estado' ],
			headerTitle: ['Id', 'Nombre del Usuario', 'Apellido del Usuario', 'Nombres del Paciente', 'Apellidos del paciente', 'Fecha de salida','Descripcion','Estado'],
			activePrompt: false,
			nombre: "",
			fecha: "",
			switch2: false,
			nino_id:0,
			tutor_id:0,
			abrir_editar:false,
			id: 0,
			estado: null
		};
	},
	components: {
		VueApexCharts,
		StatisticsCardLine,
		ChangeTimeDurationDropdown,
		VxTimeline,
		ingresaringreso,
		vSelect,
		
	},
	methods: {
		traerDatos(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.user_nombres=valor.user.nombres
				valor.user_apellidos=valor.user.apellidos
				valor.proveedor_nombres=valor.datos_proveedor[0].nombres
				valor.proveedor_apellidos=valor.datos_proveedor[0].apellidos
			}); 
			return tabla
		},
		
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},

		abrirDialog(id, estado) {
			let titulo = "";
			let color = "";
			if (estado === 0 || estado === false) {
				// cambiar de color al boton
				color = "success";
				titulo = "Confirmar activación";
			} else if (estado === 1 || estado === true) {
				color = "danger";
				titulo = "Confirmar desactivación";
			}
			this.id = id;
			this.estado = estado;
			this.$vs.dialog({
				type: "confirm",
				color: `${color}`,
				title: `${titulo}`,
				text: "¿Está seguro de llevar a cabo esta acción?",
				accept: this.cambiarEstado,
				cancel: this.close,
			acceptText: 'Aceptar',
			cancelText: 'Cancelar',
			});
		},
		cambiarEstado(color) {
			let titulo = "";
			if (this.estado === 0 || this.estado === false) {
			titulo = "Activado exitósamente";
			axios
				.put("/api/ingresoMedicamento/activar", {
				id: this.id
				})
				.then(function(response) {
				console.log(response.data.message);
				})
				.catch(function(error) {
				console.log(error.response.data.message);
				});
			} else if (this.estado === 1 || this.estado === true) {
			titulo = "Desactivado exitósamente";
			axios
				.put("/api/ingresoMedicamento/desactivar", {
				id: this.id
				})
				.then(function(response) {
				console.log(response.data.message);
				})
				.catch(function(error) {
				console.log(error.response.data.message);
				});
			}

			this.$vs.notify({
			color: "success",
			title: `${titulo}`,
			text: "La acción se realizo exitósamente"
			});
		},
		close() {
			let titulo = "Cancelado";
			let texto = "Cambio de estado cancelado";
			this.$vs.notify({
				color: "danger",
				title: `${titulo}`,
				text: `${titulo}`
			});
			this.index();
		},
		async index() {
			//async para que se llame cada vez que se necesite
			let me = this;
			this.abrir_editar=false
			const response = await axios
			.get(`/api/ingresoMedicamento/get?completo=true`)
			.then(function(response) {
				var respuesta = response.data;
                me.arrayData = respuesta.ingresoMedicamentos.data;
				me.arrayData = me.traerDatos(me.arrayData);
                
               
			})
			.catch(function(error) {
				console.log(error);
			});
		},
 		aNuevo () {
		 this.$router.push('/ingresar/ingresomedi')
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
	},
	mounted() {
    	this.index();
	}
};
</script>

<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
  .greet-user {
    position: relative;

    .decore-left {
      position: absolute;
      left: 0;
      top: 0;
    }
    .decore-right {
      position: absolute;
      right: 0;
      top: 0;
    }
  }

  @media (max-width: 576px) {
    .decore-left,
    .decore-right {
      width: 140px;
    }
  }
}
/*! rtl:end:ignore */
</style>
