<template>
	<vx-card>
		<div class = "demo-alignment">
		<div class="vx-col md:w-1/3 w-full mt-5">
			<router-link  to="/ingreso/medicamentos"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
		</div>
			<div class="flex-1 ">
				<h2>Ingreso de medicamentos</h2>
			</div>
		</div>


		<form>
		<vs-divider position="center">Datos de Ingreso</vs-divider>

		<div class="vx-col md:w-1/2 w-full mt-3">
			<div class="vx-col w-full">
				<small>Proveedor:</small>
				<v-select name="proveedor" v-validate="'required'" label="nombre" :options="lista_proveedores" v-model="proveedor_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				<span class="text-danger">{{ errors.first('proveedor') }}</span>
			</div>
		</div>

		<div class="vx-col md:w-1/2 w-full">
			<div class="my-4">
				<small class="date-label">Fecha de ingreso</small>
				<datepicker name="fecha" v-validate="'required'" :language="$vs.rtl ? langEn : langEn" v-model="fecha_ingreso"></datepicker>
				<span class="text-danger">{{ errors.first('fecha') }}</span>
			</div>
		</div>

		<br>

		<vs-divider position="center">Listado de Medicamentos</vs-divider>

			<div class="vx-col md:w-1/2 w-full mt-3">
				<div class="vx-col w-full">
					<small>Lista de medicamentos:</small>
					<v-select name="medicamento" v-validate="'required'" label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('medicamento') }}</span>
				</div>
			</div>

			<br>

			<vs-list>
				<div class="vx-col w-full mb-base">
						<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fecha de Expiración</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Numero de Lote/Referencia</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad de entrada</th>
								</tr>
								<tr v-for="(producto,index) in listado_entrada" :key="index">
									<td class="border border-solid d-theme-border-grey-light">
										<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
									</td>
									<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}</td>
									
									<td class="border border-solid d-theme-border-grey-light">
										<datepicker name="fecha_expiracion" v-validate="'required'" :language="$vs.rtl ? langEn : langEn" v-model="listaFechas[index]"></datepicker>
									</td>

									<td class="border border-solid d-theme-border-grey-light">
										<vs-input name="lote" v-validate="'required|max:20'" style="text-align:right" v-model="listaReferencias[index]"/>
									</td>

									<td class="border border-solid d-theme-border-grey-light">
										<vs-input name="cantidad" v-validate="'required|max:5|numeric'" style="text-align:right" v-model="listaCantidades[index]" />
									</td>

								</tr>
						</table>
						<span class="text-danger">{{ errors.first('fecha_expiracion') }}</span>
						<br>
						<span class="text-danger">{{ errors.first('lote') }}</span>
						<br>
						<span class="text-danger">{{ errors.first('cantidad') }}</span>

				</div>
		</vs-list>

		<div class="vx-row mb-6">
			<div class="vx-col w-full">
				<small>Descripción</small>
				<vs-textarea name="descripcion" v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-user" icon-no-border v-model="descripcion"/>
				<span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
			</div>
		</div>

		<div class="vx-row">
			<div class="vx-col sm:w-2/3 w-full ml-auto">
				<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-3 mb-2" @click="guardarIngreso">Guardar</vs-button>
				<!-- <vs-button color="warning" type="border" class="mb-2" @click="limpiar">Limpiar</vs-button> -->
			</div>
		</div>
		</form>
	</vx-card>
</template>

<script>

import Datepicker from 'vuejs-datepicker'
import vSelect from 'vue-select'
import axios from "axios";
import { es } from 'vuejs-datepicker/src/locale'
import { Validator } from 'vee-validate';
import Ls from '../../../services/ls';

const dict = {
  custom: {
	proveedor: {
	  required: 'El campo proveedor es requerido',
	},
	fecha: {
	  required: 'El campo fecha de ingreso es requerido',
	},
	medicamento: {
	  required: 'El campo medicamento es requerido',
	},
	descripcion: {
      required: 'El campo descripción es requerido',
	    max: 'Este campo solo acepta hasta 150 caracteres',
    },
	fecha_expiracion: {
      required: 'Todos los campos de fecha de Expiración son requeridos',
    },
	lote: {
      required: 'Todos los campos de lote son requeridos',
	    max: 'Los campos de lote solo aceptan hasta 20 caracteres',
    },
	cantidad: {
	  required: 'Todos los campos de cantidad son requeridos',
	  numeric: 'Los campos de cantidad solo deben de contener números',
	    max: 'Los campos de cantidad solo aceptan hasta 5 caracteres',
    },	
  }
}

// register custom messages
Validator.localize('es', dict)
export default {
	data() {
		return {
			listado_medicamentos:[],
			lista_proveedores:[],

			listado_entrada:[],
			listaCantidades:[],
			listaFechas:[],
			listaReferencias:[],
			
			medicamento_id:null,
			proveedor_id:null,
			
			fecha_ingreso:'',
			descripcion:'',
			langEn: es,
		}
	},
	components: {
		vSelect,
		Datepicker,
	},
	watch: {
		medicamento_id(){
			if (this.medicamento_id != null)
			{
				this.listado_entrada.push(this.medicamento_id)
				this.listaFechas.push('')
				this.listaReferencias.push('')
			}
		}
	},	
	methods: {
		borrarIntegrante(index) {
			this.listado_entrada.splice(index, 1)
			this.listaCantidades.splice(index, 1)
			this.listaFechas.splice(index, 1)
			this.listaReferencias.splice(index, 1)
		},
		getDate(datetime) {
			let date = new Date(datetime);
			let dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;
			return dateString;
		},
		async importarProveedores () {
			this.fecha_ingreso= new Date()
			const me = this
			const response = await axios.get(
			`/api/proveedor/get?completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.lista_proveedores = respuesta.proveedores.data
				me.lista_proveedores = me.traerNombre(me.lista_proveedores)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async importarMedicamentos() {
			let me = this;
			const response = await axios
			.get(`/api/medicamento/get?completo=false`)
			.then(function(response) {
				var respuesta = response.data;
				me.listado_medicamentos = respuesta.medicamentos.data;
				me.listado_medicamentos = me.traerNombreMedicamento(me.listado_medicamentos)
			})
			.catch(function(error) {
				console.log(error);
			});
		},
		traerNombre (tabla) {
			tabla.forEach(function (valor, indice, array) {
				valor.nombre_completo = valor.datos.nombres + ' ' + valor.datos.apellidos
			})
			return tabla
		},
		traerNombreMedicamento(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
			});
			return tabla
		},
		guardarIngreso(){

		this.$validator.validateAll().then(result => {
        if(result) {
			let me = this
			axios.post("/api/ingresoMedicamento/post/",{
				proveedor_id:me.proveedor_id.id,
				fecha_ingreso:me.getDate(me.fecha_ingreso),
				descripcion:me.descripcion,
				user_id:parseInt(Ls.get('auth.id_usuario'))
			}).then(function(response) {
				me.guardarLote(response.data.id)
			})
			.catch(function(error) {
				console.log(error)
			});
		}else{
        this.$vs.notify({
				color:'danger',
				title:`Error en validación!`,
				text:'Ingrese correctamente todos los datos'
			})
        }
		})  
		},
		guardarLote(idIngreso){
			let me = this
			for (let x in me.listado_entrada) {
				let elemento =  me.listado_entrada[x]
				axios.post("/api/lote/post/",{
					stock:me.listaCantidades[x],
					fecha_expiracion:me.getDate(me.listaFechas[x]),
					numero_referencia:me.listaReferencias[x],
					medicamento_id:elemento.id ,
				}).then(function(response) {
					me.guardarDetalle(idIngreso,response.data.id)
					me.$router.push('/ingreso/medicamentos')
				})
				.catch(function(error) {
					console.log(error)
				});
				axios.put("/api/medicamento/update/",{
					id:elemento.id,
					stock_general:parseInt(elemento.stock_general) + parseInt(me.listaCantidades[x])
				}).then(function(response) {
					console.log(response)
				})
				.catch(function(error) {
					console.log(error)
				});

			}
			
		},
		guardarDetalle(idIngreso,lote){
			axios.post("/api/detalleIngreso/post/",{
				ingreso_medicamento_id:idIngreso,
				lote_id:lote ,
			}).then(function(response) {
				console.log(response)
			})
			.catch(function(error) {
				console.log(error)
			});
			this.$vs.notify({
					color:'success',
					title:'Medicamento registrado!',
					text:'La acción se realizo exitósamente'
				});
		}
	},
	mounted(){
		this.importarProveedores()
		this.importarMedicamentos()
	}
}
</script>