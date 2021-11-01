<template>
	<vx-card>
			<form>
				<div class="vx-row" v-if="pacienteExterno">
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
							<v-select name="sector" v-validate="'required'" label="nombre" :options="listado_sectores" class="mt-1"  v-model="sector_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('sector') }}</span>
						</div>
					</div>
				</div>
			</form>
				<div class="vx-row" v-if="!pacienteExterno">
					<div class="vx-col md:w-1/2 w-full mt-10">
						<h3 class="ml-6"><b>Nombre:</b> {{paciente.nombre_completo}} </h3>
					</div>
					<div class="vx-col md:w-1/2 w-full mt-4">
						<small class="date-label">Tipo de paciente</small>
						<v-select name="tipo" v-validate="'required'" label="nombre" :options="listado_tipos" class="mt-1"  v-model="tipo_paciente_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('tipo') }}</span>
					</div>
				</div>
				<div v-if="editarBeneficio">
					<vs-divider position="center">Detalle de beneficios</vs-divider>
					<div class="vx-col md:w-1/2 w-full mt-3">
						<small class="date-label mt-6">Día de entrega de beneficios</small>
							<v-select name="dia" v-validate="'required'" style="width:30%" label="mostrar" :options="dia_del_mes" v-model="dia_apoyo" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
							<span class="text-danger">{{ errors.first('dia') }}</span>
						<br>
					</div>
					<div class="vx-col md:w-1/2 w-full mt-3">
						<div class="vx-col w-full">
							<small class="date-label">Agregar medicamento de entrega</small>
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
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad de entrega</th>
								</tr>
								<tr v-for="(producto,index) in carrito" :key="index">
									<td class="border border-solid d-theme-border-grey-light flex items-center">
										<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
									</td>
									<!-- <td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}</td> -->
									<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}<small class="date-label"><p class="text-warning">(Stock actual: {{producto.stock_general}})</p></small></td>
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
	data(){
		return {
			paciente:[],
			id_recibido:null,
			id_persona:null,
			pacienteExterno:false,
			tipo_paciente_id:null,
			tipo_paciente_id_original:null,
			listado_tipos:[],
			listado_sectores:[],
			listaCantidades:[],
			listaCantidadesOriginal:[],
			nombres:'',
			apellidos:'',
			CUI:'',
			genero:null,
			fecha_nacimiento:false,
			direccion:'',
			sector_id:'',
			langEn: es,
			primerBeneficio:null,
			carrito:[],
			descripcion:'',
			descripcionOriginal:'',
			carrito_original:[],
			medicamento_id:null,
			listado_medicamentos:[],
			editarBeneficio:false,
			dia_del_mes:[],
			dia_apoyo:null,
			objVacio:{}
		}
	},
	watch: {
		medicamento_id(){
			this.stockId = this.medicamento_id.stock_general
			if (this.medicamento_id != null)
			{
				this.carrito.push(this.medicamento_id)
			}
		},
		tipo_paciente_id(){
			if (this.tipo_paciente_id != null && this.tipo_paciente_id.id != null && this.tipo_paciente_id.id != 1)
			{
				if(this.tipo_paciente_id.id ==2){
					this.editarBeneficio=false
				}
				else{
					if (this.dia_apoyo == null){
						this.diaMes(1)
					}
					this.editarBeneficio=true
				}
			}
		}
	},
	components:{
		Datepicker,
	    vSelect
	},
	methods:{
		getNow(){
			let fecha_pago=''
			const today = new Date()
			const todaySin = new Date(today.getFullYear(),today.getMonth(),today.getDate())
			const datePago =  new Date(today.getFullYear(),today.getMonth(),today.getDate())
			datePago.setDate(this.dia_apoyo.id)
			if (todaySin >= datePago) {
				const datePago2 =  new Date(today.getFullYear(),today.getMonth()+1,datePago.getDate())
				fecha_pago=datePago2
			}
			else{
				fecha_pago=datePago
			}
			return fecha_pago
		},
		diaMes(dia){
			let elementoE=null
			let encontrado=false
			for (let i = 1; i <= 28; i++) {
				this.dia_del_mes.push({id:i,mostrar:i})
			}
			//me.dia_apoyo.id = me.paciente.dia_apoyo
			this.dia_del_mes.forEach(function(elemento, indice, array) {
				if (elemento.id==dia)
				{
					elementoE=elemento
					encontrado=true
				}
			})
			this.dia_apoyo = encontrado == true ? elementoE : {id:dia,mostrar:'No es aceptable el dia de apoyo'} 
		},
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombre_completo = valor.datos.nombres + ' ' + valor.datos.apellidos
				valor.cui = valor.datos.CUI
				valor.fecha_nacimiento = valor.datos.fecha_nacimiento
				valor.direccion = valor.datos.direccion
				valor.numero_telefono = valor.datos.numero_telefono
			}); 
			return tabla
		},
		async importarPaciente() {
			let me = this;
	        me.id_recibido = parseInt(this.$route.params.id);
			const response = await axios.get(
				`/api/paciente/get?criterio=id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.paciente = me.traerNombre(respuesta.pacientes.data)
				me.paciente = me.paciente[0]
				me.tipoPaciente =  me.paciente.tipo_paciente_id
				if (me.tipoPaciente==1)
				{
					me.pacienteExterno=true
					me.id_persona = me.paciente.datos.id
					me.nombres = me.paciente.datos.nombres
					me.apellidos = me.paciente.datos.apellidos
					me.CUI = me.paciente.datos.CUI
					me.genero = me.paciente.datos.genero
					me.fecha_nacimiento = me.paciente.datos.fecha_nacimiento
					me.direccion = me.paciente.datos.direccion
					me.numero_telefono = me.paciente.datos.numero_telefono
					me.sector_id = me.paciente.datos.sector_id
					me.importarSectores()
				}
				else if (me.tipoPaciente ==2){
					me.editarBeneficio=false
				}
				else{
					me.diaMes(me.paciente.dia_apoyo)
					me.descripcion= me.paciente.beneficios[0].descripcion
					me.descripcionOriginal= me.paciente.beneficios[0].descripcion
					me.primerBeneficio=me.paciente.beneficios[0]
					me.idBeneficio = me.paciente.beneficios[0].id
					me.buscarDetalleBeneficios(me.primerBeneficio)
					me.tipo_paciente_id=me.paciente.tipo_paciente_id
					me.editarBeneficio=true
				}
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		borrarIntegrante(index) {
			this.carrito.splice(index, 1)
			this.listaCantidades.splice(index, 1)
		},
		buscarDetalleBeneficios(primerBeneficio){
			let me = this;
			axios.get(
				`/api/detalleBeneficio/get?criterio=beneficio_id&buscar=${primerBeneficio.id}&completo=false`)
			.then(function (response) {
				const respuesta = response.data
				me.llenadoCarrito(respuesta.detalleBeneficios.data)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		llenadoCarrito(lista){
			for (let i in lista){
				let elemento = lista[i]
				const resultado = this.listado_medicamentos.find( medicamento => medicamento.id === elemento.medicamento_id );
				if(resultado != undefined){
					this.carrito.push(resultado)
					this.listaCantidades.push(elemento.cantidad)
					this.carrito_original.push(resultado)
					this.listaCantidadesOriginal.push(elemento.cantidad)
				}
			}
		},
		async importarTiposPaciente(){
			let me = this;
			let encontrado = false
			let elementoE={}
			const response = await axios.get(
				`/api/tipoPaciente/get?completo=false`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_tipos = respuesta.tipoPacientes.data;

				me.listado_tipos.forEach(function(elemento, indice, array) {
					if (elemento.id==me.tipoPaciente)
					{
						elementoE=elemento
						encontrado=true
					}
				})
				me.listado_tipos.splice(me.listado_tipos.length-1, 1);
				me.tipo_paciente_id_original = encontrado == true ? elementoE : {id:me.tipo_paciente_id,nombre:'Tipo de paciente desactivado'} 
				me.tipo_paciente_id = encontrado == true ? elementoE : {id:me.tipo_paciente_id,nombre:'Tipo de paciente desactivado'} 
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		guardarPersona(){
			this.$validator.validateAll().then(result => {
				if(result) {
					let me = this
					let pagoT = '';
					if(me.pacienteExterno){
						axios.put("/api/personaSinAcceso/update/",{
							id:me.id_persona,
							nombres:me.nombres,
							apellidos:me.apellidos,
							CUI:me.CUI,
							genero:me.genero,
							fecha_nacimiento:me.getDate(me.fecha_nacimiento),
							direccion:me.direccion,
							numero_telefono:me.numero_telefono,
							sector_id:me.sector_id.id
						}).then(function (response){
							me.$router.push('/clinica/pacientes/');
									me.$vs.notify({
									color:'success',
									title:'Actualización registrada!',
									text:'Acción realizada exitósamente'
								});
						}).catch(function(error) {
							console.log(error)
						});
					}
					else{
						pagoT= me.getDate(me.getNow());
						let boolCarrito = me.arraysEqual(me.carrito_original,me.carrito)
						let boolCantidades = me.arraysEqual(me.listaCantidades,me.listaCantidadesOriginal)
						let boolTipo = me.tipo_paciente_id == me.tipo_paciente_id_original
						let boolDescripcion = me.descripcion == me.descripcionOriginal
						if (!boolCarrito || !boolCantidades || !boolTipo || !boolDescripcion)
						{
							axios.put("/api/paciente/update/",{
								id:me.id_recibido,
								dia_apoyo:me.dia_apoyo.id,
								tipo_paciente_id:me.tipo_paciente_id.id,
								id_beneficio:me.idBeneficio,
								detalle:true,
								id_beneficio:me.idBeneficio,
								descripcion:me.descripcion,
								fecha_pago:pagoT,
								carrito:me.carrito,
								cantidades:me.listaCantidades
							}).then(function (response){
								me.$router.push('/clinica/pacientes/');
									me.$vs.notify({
									color:'success',
									title:'Actualización registrada!',
									text:'Acción realizada exitósamente'
								});
							}).catch(function(error) {
								console.log(error)
							});
						}
						else{
							me.$router.push('/clinica/pacientes/');
						}
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
		arraysEqual(a,b) {
			if (a instanceof Array && b instanceof Array) {
				if (a.length!=b.length)
					return false;
				for(var i=0; i<a.length; i++)
					if (!this.arraysEqual(a[i],b[i]))
						return false;
				return true;
			} else {
				return a==b;
			}
		},
		async importarSectores(){
			let me = this;
			let encontrado=false;
			let elementoE={}
			const response = await axios.get(
			`/api/sector/get?&completo=select`)
			.then(function (response) {
				var respuesta= response.data;
				me.listado_sectores = respuesta.sectores.data;
				me.listado_sectores.forEach(function(elemento, indice, array) {
					if (elemento.id==me.sector_id)
					{
						elementoE=elemento
						encontrado=true
					}
				})
				me.sector_id = encontrado == true ? elementoE : {id:me.sector_id,nombre:'Sector desactivado'} 
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
		traerNombreMedicamento(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
			});
			return tabla
		},
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
	},
	mounted(){
		this.importarPaciente()
		this.importarTiposPaciente()
		this.importarMedicamentos()
	},
}
</script>