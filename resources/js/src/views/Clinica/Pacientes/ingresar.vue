<template>
	<vx-card>
		<div class = "demo-alignment">
		<div class="vx-col md:w-1/3 w-full mt-5">
			<router-link  to="/clinica/pacientes"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
		</div>
		<h3>INGRESO DE PACIENTE</h3>
		</div>
			<vs-divider position="right">ARTEMIS&#174;</vs-divider>
		<div class="vx-col md:w-1/2 w-full mt-5">
			<!-- <small class="date-label">Información</small> -->
			<ul class="demo-alignment">
				<li>
					<vs-radio color="success" v-model="tipo_lectura" vs-value="1">Paciente común</vs-radio>
				</li>
					<vs-radio color="success" v-model="tipo_lectura" vs-value="2">Paciente de Módulo de apadrinamiento</vs-radio>
				<li>
				</li>
			</ul>
		</div>

		<div v-if="tipo_lectura==1">
			<form>
				<div class="vx-row">

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombres" v-validate="'required|alpha_spaces|max:30'"/>
							<span class="text-danger">{{ errors.first('nombres') }}</span>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos" v-validate="'required|alpha_spaces|max:30'"/>
							<span class="text-danger">{{ errors.first('apellidos') }}</span>
						</div>
					</div>
					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" v-model="CUI" name="cui" v-validate="'max:15|numeric'"/>
							<span class="text-danger">{{ errors.first('cui') }}</span>
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<small class="date-label">Género</small>
						<ul class="demo-alignment">
								<li>
									<vs-radio name="radio" v-validate="'required|included:1,0'" color="rgb(0, 170, 228)" v-model="genero" vs-value="1">Masculino</vs-radio>
								</li>
								<li>
									<vs-radio name="radio" color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
								</li>
						</ul>
						<span class="text-danger">{{ errors.first('radio') }}</span>

					</div>

					<div class="vx-col md:w-1/2 w-full mt-1">
						<div class="my-4">
							<small class="date-label">Fecha Nacimiento</small>
							<datepicker name="fecha" v-validate="'required'" :language="$vs.rtl ? langEn : langEn" v-model="fecha_nacimiento"></datepicker>
							<span class="text-danger">{{ errors.first('fecha') }}</span>

						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-map-pin" icon-no-border label-placeholder="Dirección" v-model="direccion" name="direccion" v-validate="'required|max:254'"  />
						</div>
					</div>

					<div class="vx-col md:w-1/2 w-full mt-5">
						<div class="vx-col w-full">
							<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono" name="telefono" v-validate="'max:15|numeric'"/>
							<span class="text-danger">{{ errors.first('telefono') }}</span>
						
						</div>
					</div>

					
					<div class="vx-col md:w-1/2 w-full mt-3">
						<div class="vx-col w-full">
							<small class="date-label">Sector de Vivienda</small>
							<v-select name="sector" v-validate="'required'" label="nombre" :options="sectores" class="mt-1"  v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('sector') }}</span>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div v-else>
		<form>
				<div class="vx-col md:w-1/2 w-full mt-3">
					<div class="vx-col w-full">
						<small class="date-label">Personas en el programa</small>
						<v-select name="persona" v-validate="'required'" label="nombreCompleto" :options="listado_personas" class="mt-1"  v-model="persona_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('persona') }}</span>
					</div>
				</div>

				<div v-if="persona_id!==null">
					<div class="vx-col md:w-1/2 w-full mt-5">
						<small class="date-label">Tipo de paciente</small>
						<v-select name="tipo" v-validate="'required'" label="nombre" :options="listado_tipos" class="mt-1"  v-model="tipo_paciente_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('tipo') }}</span>
					</div>

					<div v-if="tipo_paciente_id.id!=2" class="mt-8">
						<div class="vx-col md:w-1/2 w-full mt-3">
							<small class="date-label mt-6">Día de entrega de beneficios</small>
								<v-select name="dia" v-validate="'required'" style="width:30%" label="mostrar" :options="dia_del_mes" v-model="dia_apoyo" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
								<span class="text-danger">{{ errors.first('dia') }}</span>
							<br>
						</div>
						<div class="vx-col md:w-1/2 w-full mt-3">
							<div class="vx-col w-full">
								<small class="date-label">Listado de medicamento de entrega</small>
								<v-select name="medicamento" v-validate="'required'" label="nombre" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
								<span class="text-danger">{{ errors.first('medicamento') }}</span>
							
							</div>
						</div>

						<vs-divider position="center">Lista de entrega mensual</vs-divider> 

						<vs-list>
								<div class="vx-col w-full mb-base">
										<table style="width:100%" class="border-collapse">
												<tr>
													<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar</th>
													<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
													<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad de entrega</th>
												</tr>
												<tr v-for="(producto,index) in carrito" :key="index">
													<td class="border border-solid d-theme-border-grey-light flex items-center">
														<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
													</td>
													<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}</td>
													<td class="border border-solid d-theme-border-grey-light flex items-center">
														<vs-input style="text-align:right" v-model="listaCantidades[index]" name="cantidad" v-validate="'required|max:5|numeric'"/>
													</td>
												</tr>
										</table>
						<span class="text-danger">{{ errors.first('cantidad') }}</span>

								</div>
						</vs-list>

						<div class="vx-col w-full mt-6">
							<div class="vx-col w-full">
								<small class="date-label">Descripción de los beneficios</small>
								<vs-textarea name="descripcion" v-validate="'required|max:150'" class="w-full" icon-pack="feather" icon="icon-edit" icon-no-border v-model="descripcion"/>
								<span class="text-danger text-sm" v-show="errors.has('descripcion')">{{ errors.first('descripcion') }}</span>
							</div>
						</div>
					</div>
				</div>
		</form>
		</div>
		<br>
			<div class="vx-row">
          		<div class="vx-col sm:w-2/3 w-full ml-auto">
            		<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-3 mb-2" @click="guardarPersona">Guardar</vs-button>
          		</div>
	        </div>
	</vx-card>
</template>

<script>
import axios from 'axios'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import { es } from 'vuejs-datepicker/src/locale'
// For custom error message
import { Validator } from 'vee-validate'
const dict = {
 custom: {
    nombres: {
      required: 'El campo nombres es requerido',
	  alpha_spaces: 'El campo solo debe de contener letras y espacios',
	  max: 'Este campo solo acepta hasta 30 caracteres',
    },
    apellidos: {
      required: 'El campo apellidos es requerido',
	  alpha_spaces: 'El campo solo debe de contener letras y espacios',
	  max: 'Este campo solo acepta hasta 30 caracteres',
    },
    correo: {
      required: 'El campo correo es requerido',
	  email: 'Ingrese un correo válido',
	  max: 'Este campo solo acepta hasta 50 caracteres',
    },
    cui: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 15 caracteres',
	},
	fecha: {
      required: 'El campo fecha de nacimiento es requerido',
	},
	direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
	},
	telefono: {
	  max: 'Este campo solo acepta hasta 15 caracteres',
	  numeric: 'El campo solo debe de contener números',
	},
	radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
    },
	sector:{
	  required: 'El campo sector es requerido',
	},
	persona:{
	  required: 'El campo persona en el programa es requerido',
	},
	tipo:{
	  required: 'El campo tipo de paciente es requerido',
	},
	dia:{
	  required: 'El campo día de entrega es requerido',
	},
	medicamento:{
	  required: 'El campo medicamento es requerido',
	},
	cantidad: {
	  required: 'Todos los campos de cantidad son requeridos',
	  numeric: 'Los campos de cantidad solo deben de contener números',
	    max: 'Los campos de cantidad solo aceptan hasta 5 caracteres',
	},	
	descripcion: {
      required: 'El campo descripción es requerido',
	    max: 'Este campo solo acepta hasta 150 caracteres',
    },
  }
}

// register custom messages
Validator.localize('en', dict)

export default {
	data() {
		return {
			nombres:'',
			apellidos:'',
			CUI:'',
			genero:'',
			fecha_nacimiento:'',
			direccion:'',
			numero_telefono:'',
			descripcion:'',
			sectores:[],
			listado_ninos:[],
			listado_encargados:[],
			listado_personas:[],
			listado_tipos:[],
			listado_pacientes:[],
			listado_relaciones:[],
			listadoNinos:[],
			listadoFamilia:[],
			sector_id:null,
			persona_id:null,
			medicamento_id:null,
			tipo_paciente_id:null,
			langEn: es,
			tipo_lectura:1,
			tipo_paciente:1,
			dia_del_mes:[],
			dia_apoyo:null,
			fecha_apoyo:'',
			listado_medicamentos:[],
			carrito:[],
			listaCantidades:[]
		}
	},
	watch: {
		medicamento_id(){
			if (this.medicamento_id != null)
			{
				this.carrito.push(this.medicamento_id)
			}
		}
	},
	methods: {
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		getNow(){
			let fecha_pago=''
			const today = new Date()
			const todaySin = new Date(today.getFullYear(),today.getMonth(),today.getDate())
			const datePago =  new Date(today.getFullYear(),today.getMonth(),today.getDate())
			datePago.setDate(this.dia_apoyo.id)
			if (todaySin >= datePago) {
				fecha_pago=datePago.setMonth(datePago.getMonth()+1)
			}
			else{
				fecha_pago=datePago
			}
			return fecha_pago
		},
		guardarDetalleBeneficios(beneficios){
			let me=this
			for (let x in me.carrito){
				let v1 = parseInt(me.listaCantidades[x])
				let idMedicamento = me.carrito[x].id
				axios.post('/api/detalleBeneficio/post/', {
					cantidad:v1,
					beneficio_id:beneficios,
					medicamento_id:idMedicamento,
				}).then(function (response){
					me.$router.push('/clinica/pacientes/');
					me.$vs.notify({
					color:'success',
					title:'Paciente registrado',
					text:'Acción realizada exitósamente'
				});
				})
			}
		},
		guardarBeneficios(paciente){
			let me2=this
			let pagoT= me2.getDate(me2.getNow());
			axios.post('/api/beneficio/post/', {
				fecha_entrega:pagoT,
				descripcion:me2.descripcion,
				paciente_id:paciente,
			}).then(function (response){
				me2.guardarDetalleBeneficios(response.data.id)
			})
		},
		guardarPaciente(persona){
			let tipoT=0
			if (this.tipo_lectura == 1){
				tipoT = 1
			}
			else if (this.tipo_lectura == 2){
				tipoT = this.tipo_paciente_id.id
			}
			if (tipoT==1 || tipoT ==2)
			{
				axios.post('/api/paciente/post/', {
					dia_apoyo:0,
					persona_sin_acceso_id:persona,
					tipo_paciente_id:tipoT,
				}).then(function (response){
					console.log(response)
				})
					this.$router.push('/clinica/pacientes/');
					this.$vs.notify({
					color:'success',
					title:'Paciente registrado',
					text:'Acción realizada exitósamente'
					});
			}
			else if (tipoT !== 2 && tipoT !=1 ){
				let me=this
				axios.post('/api/paciente/post/', {
					dia_apoyo:me.dia_apoyo.id,
					persona_sin_acceso_id:persona,
					tipo_paciente_id:tipoT,
				}).then(function (response){
					me.guardarBeneficios(response.data.id)
				})
			}
		},
		guardarPersona(){
			this.$validator.validateAll().then(result => {
        	if(result) {
				let me = this
				if(this.tipo_lectura==1){
					axios.post('/api/personaSinAcceso/post/', {
						nombres:me.nombres,
						apellidos:me.apellidos,
						CUI:me.CUI,
						genero:me.genero,
						direccion:me.direccion,
						numero_telefono:me.numero_telefono,
						sector_id:me.sector_id.id,
						fecha_nacimiento:me.getDate(me.fecha_nacimiento),
					}).then(function (response){
						me.guardarPaciente(response.data.id)
					})
				}else{
					me.guardarPaciente(this.persona_id.persona_sin_acceso_id)
				}
			}else{
				this.$vs.notify({
					color:'danger',
					title:'Error en validación!',
					text:'Ingrese todos los campos correctamente'
					});
				}
			})
		},
		diaMes(){
			for (let i = 1; i <= 28; i++) {
				this.dia_del_mes.push({id:i,mostrar:i})
			}
		},
		traerNombre(tabla) {
			tabla.forEach(function (valor, indice, array){
				valor.id_encargado = null
				valor.nombres = valor.datos.nombres
				valor.apellidos = valor.datos.apellidos
				valor.nombreCompleto = valor.datos.nombres + ' '+ valor.datos.apellidos
				valor.fecha_nacimiento = valor.datos.fecha_nacimiento
			})
			return tabla
		},
		traerNombreE(tabla) {
			tabla.forEach(function (valor, indice, array) {
				valor.id_encargado = valor.id
				valor.id = valor.id+100000
				valor.apellidos = valor.datos.apellidos
				valor.nombreCompleto = valor.datos.nombres + ' '+ valor.datos.apellidos
				valor.fecha_nacimiento = valor.datos.fecha_nacimiento
			}) 
			return tabla
		},
		async importarSectores(){
			let me = this;
			const response = await axios.get(
			`/api/sector/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.sectores = respuesta.sectores.data;
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarNinos(encargados)
		{
			let me = this;
			const response = await axios.get(
				`/api/nino/get?completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_ninos = respuesta.ninos.data;
				me.nino = me.traerNombre(me.listado_ninos)
				me.importarRelaciones(encargados,me.nino)
			})
			.catch(function (error) {
				console.log(error);
			});
		},

		async importarRelaciones(encargados,ninos){
			let hash = {};
			let me = this;
			let ninosActivos = ninos.slice();
			let ninosPlus =[]
			let encargadosPlus=[]
			let listadoCompleto=[]
			const response = await axios.get(`/api/relacion/get?completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_relaciones = respuesta.relaciones.data;
				ninosActivos = ninosActivos.filter(nino => nino.estado == 1);
				me.listado_relaciones = me.codigosPlus(ninosActivos,me.listado_relaciones)
				me.listadoFamilia = me.listado_relaciones.filter(o => hash[o.encargado_id] ? false : hash[o.encargado_id] = true);
				me.listadoNinos	  = me.listado_relaciones.filter(o => hash[o.nino_id] ? false : hash[o.nino_id] = true);
				ninosPlus = me.ninosFamilia(ninos,me.listadoNinos)
				encargadosPlus = me.encargadosFamilia(encargados,me.listadoFamilia)
				listadoCompleto = listadoCompleto.concat(ninosPlus,encargadosPlus);
				me.importarPacientes(listadoCompleto)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		ninosFamilia(ninos,codigos){
			let listaNinosPlus=[]
			codigos.forEach(function(elemento, indice, array) {
				const resultado = ninos.find( nino => nino.id === elemento.nino_id );
				if(resultado!==undefined)
				{
					listaNinosPlus.push(resultado)
				}
			})
			return listaNinosPlus
		},
		encargadosFamilia(encargados,codigos){
			let listaEncargadosPlus=[]
			codigos.forEach(function(elemento, indice, array) {
				const resultado = encargados.find( encargado => encargado.id_encargado === elemento.encargado_id );
				if(resultado!==undefined)
				{
					listaEncargadosPlus.push(resultado)
				}
			})
			return listaEncargadosPlus
		},
		codigosPlus(ninos,relaciones){
			let listaRelaciones=[]
			ninos.forEach(function(elemento, indice, array) {
				const resultado = relaciones.find( relacion => relacion.nino_id === elemento.id );
				if(resultado!==undefined)
				{
					listaRelaciones.push(resultado)
				}
			})
			let hash = {};
			listaRelaciones = listaRelaciones.filter(o => hash[o.codigo] ? false : hash[o.codigo] = true);
			
			let listaRelacionesPlus=[]
			relaciones.forEach(function(elemento, indice, array) {
				const resultado = listaRelaciones.find( relacionA => relacionA.codigo === elemento.codigo );
				if(resultado!==undefined)
				{
					listaRelacionesPlus.push(elemento)
				}
			})
			return listaRelacionesPlus

		},
		async importarTiposPaciente(){
			let me = this;
			const response = await axios.get(
				`/api/tipoPaciente/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_tipos = respuesta.tipoPacientes.data;
				me.listado_tipos.splice(me.listado_tipos.length-1, 1);
				me.tipo_paciente_id=me.listado_tipos[me.listado_tipos.length-1]
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		importarEncargados(){
			let me = this;
			let listadoCompleto=[]
			axios.get(`/api/encargado/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_encargados = respuesta.encargados.data;
				me.listado_encargados = me.traerNombreE(me.listado_encargados)
				me.importarNinos(me.listado_encargados)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		importarPacientes(personas){
			let me3=this
			let hash2 = {}
			axios.get(`/api/paciente/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me3.listado_pacientes = respuesta.pacientes.data
				me3.listado_pacientes = me3.listado_pacientes.filter(o => hash2[o.persona_sin_acceso_id] ? false : hash2[o.persona_sin_acceso_id] = true)
				me3.listadoPlus(me3.listado_pacientes,personas)
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarMedicamentos() {
			let me = this;
			const response = await axios
			.get(`/api/medicamento/get?completo=true`)
			.then(function(response) {
				var respuesta = response.data;
				me.listado_medicamentos = me.traerNombreMedicamento(respuesta.medicamentos.data);
			})
			.catch(function(error) {
				console.log(error);
			});
		},
		listadoPlus (pacientes,personas) {
			var encontrado =''
			const nuevasPersonas = []
			personas.forEach(function (elemento, indice, array) {
				encontrado = pacientes.find(element => element.persona_sin_acceso_id === elemento.persona_sin_acceso_id)
				if (encontrado == undefined) {
					nuevasPersonas.push(elemento)
				}
			})
			this.listado_personas=nuevasPersonas
		},
		traerNombreMedicamento(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
			});
			return tabla
		},
	},
	mounted() {
		this.diaMes();
		this.importarEncargados();
		this.importarMedicamentos();
		this.importarSectores();
		this.importarTiposPaciente();
	},
	components:{
		Datepicker,
	    vSelect
	}
}
</script>