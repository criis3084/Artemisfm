<template>
  	<vx-card>
		<div class = "demo-alignment">
			<div class="vx-col md:w-1/3 w-full mt-5">
				<router-link  to="/salida/medicamentos"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
			</div>
			<div class="flex-1 ">
				<h2>Salida de medicamentos</h2>
			</div>
		</div>
		<form>

		<div class="vx-col w-full">
			<vs-divider position="center">Datos del paciente</vs-divider>

			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="w-full">
						<small class="date-label">Paciente:</small>
						<v-select v-validate="'required'" label="nombre_completo" :options="listado_pacientes" v-model="paciente_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('paciente') }}</span>
					</div>
				</div>
				<div class="vx-col md:w-1/2 w-full mt-6">
					<div class="vx-col w-full">
						<small class="date-label">Destino:</small>
						<v-select :disabled="paciente_select == null" name="destino" v-validate="'required'" label="nombre" :options="tipo_salida" v-model="tipo_salida_select" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
						<span class="text-danger">{{ errors.first('destino') }}</span>
					</div>
				</div>
			</div>
			<div class="vx-col md:w-1/2 w-full mt-6" v-if="detalleSalida">
				<div class="w-full">
					<small class="date-label">Opciones:</small>
					<v-select label="mostrar" :options="listado_pendientes" v-model="opcion_selected" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
				</div>
			</div>
		</div>
		<div>
		<vs-divider position="center">Medicamentos</vs-divider>
			<div class="vx-col md:w-1/2 w-full mt-3">
				<div class="vx-col w-full">
					<small class="date-label">Lista de medicamentos:</small>
					<v-select :disabled="paciente_select == null" v-if="this.carrito.length==0" name="medicamento" v-validate="'required'" label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<v-select :disabled="paciente_select == null" v-if="this.carrito.length>0" name="medicamento" label="nombre_completo" :options="listado_medicamentos" class="mt-1"  v-model="medicamento_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('medicamento') }}</span>
					<small class="date-label" v-if="medicamento_id != null"><p class="text-danger">Existencia: {{stockId}}</p></small>
				</div>
			</div>

			<vs-alert v-if="verCarritSin"
			 color="danger" title="Medicamento insuficiente o inexistente" active="true" class="mt-8" style="width: 75%"
			 >
				<table style="width: 80%" class="border-collapse">
						<tr>
							<th class="pointer-events-none text-center text-warning">Nombre del medicamento</th>
							<th class="pointer-events-none text-center text-warning">Cantidad de beneficio</th>
							<th class="pointer-events-none text-center text-warning">Motivo de error</th>
						</tr>
						<tr v-for="(producto,index) in carritoSin" :key="index">
							<td class="pointer-events-none text-center text-dark"> {{producto.nombre}}</td>
							<td class="pointer-events-none text-center text-dark"> {{producto.cantidad}}</td>
							<td class="pointer-events-none text-center text-dark"> {{producto.motivo == 1 ? 'Stock insuficiente': 'No hay en existencia'}}</td>
						</tr>
				</table>
			</vs-alert>

			<vs-divider position="center">Lista de entrega</vs-divider>
			<vs-list>
				<div class="vx-col w-full mb-base">
					<table style="width:100%" class="border-collapse">
						<tr>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Eliminar</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
							<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad</th>
						</tr>
						<tr v-for="(producto,index) in carrito" :key="index">
							<td class="border border-solid d-theme-border-grey-light flex items-center">
								<vs-button color="danger" type="border" icon-pack="feather" class="center" icon="icon-x-circle" @click="borrarIntegrante(index)"></vs-button>
							</td>
							<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.nombre_completo}}<small class="date-label"><p class="text-warning">(Stock: {{producto.stock_general}})</p></small></td>
							<td class="border border-solid d-theme-border-grey-light flex items-center">
								<vs-input name="cantidad" v-validate="'required|max:5|numeric'" style="text-align:right" v-model="listaCantidades[index]" />
							</td>
						</tr>
					</table>
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
          		<div class="vx-col sm:w-2/3 w-full ml-auto vs-align-right">
            		<vs-button type="gradient" icon-pack="feather" icon="icon-save" class="mr-3 mb-2" :disabled="paciente_select == null" @click="registrarSalida">Registrar Salida</vs-button>
            		<!-- <vs-button color="warning" type="border" class="mb-2" @click="limpiar">Limipiar</vs-button> -->
          		</div>
	        </div>
		</div>
		</form>
	</vx-card>
</template>
<script>
import axios from 'axios'
import vSelect from 'vue-select'
import { Validator } from 'vee-validate';
import Ls from '../../../services/ls';

const dict = {
  custom: {
	paciente: {
	  required: 'El campo paciente es requerido',
	},
	destino: {
	  required: 'El campo destino es requerido',
	},
	medicamento: {
	  required: 'El campo medicamento es requerido',
	},
	descripcion: {
      required: 'El campo descripción es requerido',
	    max: 'Este campo solo acepta hasta 150 caracteres',
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
			listado_pacientes:[],
			listado_pendientes:[],
			listado_medicamentos:[],
			tipo_salida:[],
			carrito:[],
			listaCantidades:[],
			carritoSin:[],
			detalleReceta:[],
			tipo_salida_select:null,
			paciente_select:null,
			opcion_selected:null,
			medicamento_id:null,
			opcionesSalidas:false,
			detalleSalida:false,
			verCarritSin:false,
			stockId:0,
			descripcion:'',
			fechaSiguiente:'',
			pacienteBeneficio:0,
		}
	},
	components: {
		vSelect,
	},
	watch:{ 
		tipo_salida_select(){
			if(this.tipo_salida_select !=null)
			{
				if ( this.tipo_salida_select.id !=0)
				{
					if(this.tipo_salida_select.id== 1)
					{
						this.detalleSalida=true
						this.listado_pendientes =this.paciente_select.lista_recetas
					}
					if(this.tipo_salida_select.id== 2)
					{
						this.detalleSalida=true
						this.listado_pendientes =this.paciente_select.beneficios
						this.buscarDetalleBeneficios(this.paciente_select)
					}
					this.opcion_selected=null
				}
			}
			if(this.tipo_salida_select==null){
				this.detalleSalida=false
				this.verCarritSin=false
				this.carritoSin=[]
			}
			else if(this.tipo_salida_select.id==0)
			{
				this.detalleSalida=false
				this.verCarritSin=false
				this.carritoSin=[]
			}
		},
    	paciente_select(){
			this.tipo_salida=[];
			if(this.paciente_select != null)
			{
				this.opcionesSalidas=true;
				let primero = {id:0,nombre:'Normal'}
				this.tipo_salida.push(primero);
				if (this.paciente_select.tipo_paciente_id != 1) {
					if (this.paciente_select.lista_recetas.length >0) {
						this.tipo_salida.push({id:1,nombre:'Receta'})
					}
					if (this.paciente_select.beneficios.length >0) {
						this.tipo_salida.push({id:2,nombre:'Apoyo Mensual'})
					}
				}
				else{
					if (this.paciente_select.lista_recetas.length >0) {
						this.tipo_salida.push({id:1,nombre:'Receta'})
					}
				}
				this.tipo_salida_select=primero
			}
			if(this.paciente_select ==null)
			{
				this.carrito=[]
				this.listaCantidades=[]
				this.opcionesSalidas=false
				this.detalleSalida=false
			}
		},
		medicamento_id(){
			this.stockId = this.medicamento_id.stock_general
			if (this.medicamento_id != null)
			{
				this.carrito.push(this.medicamento_id)
			}
		},
		opcion_selected(){
			if (this.opcion_selected!= null)
			{
				if (this.tipo_salida_select.id == 1){
					this.traerDetalle(this.opcion_selected.id)
				}
			}
			else{
				this.limpiarLlenado()
			}
		}
	},
	methods: {
		traerDetalle(idReceta){
			const me = this
			axios.get(
			`/api/asignacionMedicamento/get?criterio=receta_id&buscar=${idReceta}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.detalleReceta = respuesta.asignacionMedicamentos.data
				me.llenadoCarrito(me.detalleReceta);
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		buscarDetalleBeneficios(paciente){
			let me = this;
			axios.get(
				`/api/detalleBeneficio/get?criterio=beneficio_id&buscar=${paciente.primerBeneficio}&completo=false`)
			.then(function (response) {
				const respuesta = response.data
				me.llenadoCarrito(respuesta.detalleBeneficios.data)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		limpiarLlenado(){
			this.carrito=[]
			this.carritoSin=[]
			this.listaCantidades =[]
			this.verCarritSin=false
		},
		llenadoCarrito(lista){
			this.limpiarLlenado()
			for (let i in lista){
				let elemento = lista[i]
				const resultado = this.listado_medicamentos.find( medicamento => medicamento.id === elemento.medicamento_id );
				if(resultado != undefined){
					if(resultado.stock_general>elemento.cantidad)
					{
						this.carrito.push(resultado)
						this.listaCantidades.push(elemento.cantidad)

					}else{
						this.verCarritSin=true
						this.carritoSin.push({nombre: elemento.medicamento.nombre,cantidad:elemento.cantidad,motivo:1})
					}
				}
				else{
					this.verCarritSin=true
					this.carritoSin.push({nombre: elemento.medicamento.nombre,cantidad:elemento.cantidad,motivo:0})
				}
			}
		},
		borrarIntegrante (index) {
			this.carrito.splice(index, 1)
			this.listaCantidades.splice(index, 1)
		},
		validarStock(){
			let validado=true
			let cantidades = this.listaCantidades
			for (let x in this.carrito) {
				let v1 = parseInt(this.carrito[x].stock_general)
				let v2 = parseInt(cantidades[x])
				if (v1 < v2)
				{
					validado=false
				}
			}
			return validado
		},
		registroDetalle(idSalida){
			let cantidades = this.listaCantidades
			for (let x in this.carrito) {
				let elemento =  this.carrito[x]
				let cantidadStock = parseInt(elemento.stock_general)
				let cantidadIngreso = parseInt(cantidades[x])
				let estadoT=1
				if (cantidadStock >= cantidadIngreso)
				{
					let cuentaSaldada = false
					for (let i in elemento.lotes){
						let lote = elemento.lotes[i]
						if (cuentaSaldada ==false)
						{
							if(lote.stock > cantidadIngreso)
							{
								cuentaSaldada = true
								let ingresar  = lote.stock - cantidadIngreso
								lote.stock  = lote.stock - cantidadIngreso
								axios.put("/api/lote/update/",{
									id:lote.id,
									stock:ingresar
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
								axios.post("/api/detalleSalida/post/",{
									cantidad:cantidadIngreso,
									salida_medicamento_id:idSalida,
									lote_id:lote.id
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
							else if(lote.stock < cantidadIngreso){
								cantidadIngreso = cantidadIngreso-lote.stock
								axios.put("/api/lote/update/",{
									id:lote.id,
									stock:0,
									estado:0
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
								axios.post("/api/detalleSalida/post/",{
									cantidad:lote.stock,
									salida_medicamento_id:idSalida,
									lote_id:lote.id
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
							else{
								cuentaSaldada = true
								lote.stock  = lote.stock - cantidadIngreso
								axios.put("/api/lote/update/",{
									id:lote.id,
									stock:0,
									estado:0
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
								axios.post("/api/detalleSalida/post/",{
									cantidad:lote.stock,
									salida_medicamento_id:idSalida,
									lote_id:lote.id
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
						}
					}
					if ( cuentaSaldada== true){
							if (cantidadStock == cantidadIngreso)
							{
								estadoT=0
							}
							axios.put("/api/medicamento/update/",{
								id:elemento.id,
								stock_general:elemento.stock_general - cantidades[x],
								estado:estadoT
							}).then(function(response) {
								console.log(response)
							})
							.catch(function(error) {
								console.log(error)
							});

						if(this.tipo_salida_select.id != 0){
							if(this.tipo_salida_select.id == 1){
								axios.put("/api/receta/activar/",{
									id:this.opcion_selected.id,
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
							if(this.tipo_salida_select.id == 2){
								axios.put("/api/beneficio/activar/",{
									id:this.opcion_selected.id,
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
								if (this.listado_pendientes.length == 1){
									this.fechaSiguiente=this.opcion_selected.fecha_entrega
									this.pacienteBeneficio=this.opcion_selected.paciente_id
									this.$vs.dialog({
										type:'confirm',
										color: `success`,
										title: `Nuevo Beneficio`,
										text: '¿El paciente recibirá apoyo el mes siguiente al entregado?',
										accept: this.nuevoApoyo,
										cancel: this.close,
										acceptText: 'Aceptar',
										cancelText: 'Cancelar',
									})
								}
							}
							if(this.tipo_salida_select.id == 1){
								axios.put("/api/receta/desactivar/",{
									id:this.opcion_selected.id,
								}).then(function(response) {
									console.log(response)
								})
								.catch(function(error) {
									console.log(error)
								});
							}
						}
					}
					this.$router.push('/salida/medicamentos')
					this.$vs.notify({
					color:'success',
					title:'Salida de medicamento registrada!',
					text:'La acción se realizo exitósamente'
				});
				}
			}
		},
		getNow(){
			let fecha_pago=''
			let ultima_fecha = this.fechaSiguiente
			const todaySin = new Date(parseInt(ultima_fecha.split('-',3)[0]),parseInt(ultima_fecha.split('-',3)[1]),parseInt(ultima_fecha.split('-',3)[2]))
			todaySin.setMonth(todaySin.getMonth())
			return this.getDate(todaySin)
		},
		nuevoApoyo(){
			let fechaT = this.getNow()
			let me2=this
			axios.post('/api/beneficio/post/', {
				fecha_entrega:fechaT,
				descripcion:'Beneficio del nuevo mes',
				paciente_id:me2.paciente_select.id
			}).then(function (response){
				console.log(response)
			})
		},
		close(){
			let titulo = "Cancelado"
			let texto = "El paciente no recibira apoyo el siguiente mes del entergado"
			this.$vs.notify({
				color:'danger',
				title:`${titulo}`,
				text:`${texto}`
			})
		},
		registrarSalida(){
			this.$validator.validateAll().then(result => {
			if(result) {

				let val = this.validarStock()
				if(val == true)
				{
					let me = this
					const today = new Date()
					const fecha_salida = me.getDate(today)
					axios.post('/api/salidaMedicamento/post/', {
						fecha_salida: fecha_salida,
						tipo_salida: me.tipo_salida_select.id,
						descripcion: me.descripcion,
						// **************************************************
						user_id:parseInt(Ls.get('auth.id_usuario')),
						paciente_id: me.paciente_select.id,

					}).then(function (response) {
						console.log(response)
						me.registroDetalle(response.data.id)
					})
					.catch(function (error) {
						console.log(error)
						alert('Error al ingresar')
						
					})
				}
				else{
					alert('Error al ingresar')
				}	
			}else{
			this.$vs.notify({
				color:'danger',
				title:`Error en validación!`,
				text:'Ingrese correctamente todos los datos'
			})
        }
      })
		},
		getDate (datetime) {
			const date = new Date(datetime)
			const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
			return dateString
		},
		limpiarRecetas(tabla){
			tabla.forEach(function(valor, indice, array){
				let recetasAcivas=[]
				valor.lista_recetas.forEach(function(elemento, indice2, array2){
					if(elemento.estado == 1)
					{
						const date = new Date(elemento.created_at)
						const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
						elemento.mostrar = 'Receta: ' + elemento.id + ' de el: ' + dateString
						recetasAcivas.push(elemento)
					}
				});
				valor.lista_recetas = recetasAcivas
				console.log('------------------')
				console.log(valor.lista_recetas.length)
				console.log('------------------')
			});

			return tabla
		},
		limpiarBeneficios(tabla){
			let idPrimerBeneficio =null
			tabla.forEach(function(valor, indice, array){
				let contador=0
				let beneficiosActivos=[]
				valor.beneficios.forEach(function(elemento, indice2, array2){
					contador +=1
					if (contador == 1)
					{
						valor.primerBeneficio = elemento.id
					}
					if(elemento.estado == 0)
					{
						let numero = parseInt(elemento.fecha_entrega.split('-',3)[1])
						let nombre=''
						switch (numero) {
							case 1:
								nombre='enero' 
								break;
							case 2:
								nombre='febrero'
								break;
							case 3:
								nombre='marzo'
								break;
							case 4:
								nombre='abril' 
								break;
							case 5:
								nombre='mayo' 
								break;
							case 6:
								nombre='junio' 
								break;
							case 7:
								nombre='julio' 
								break;
							case 8:
								nombre='agosto' 
								break;
							case 9:
								nombre='septiembre' 
								break;
							case 10:
								nombre='octubre'
								break;
							case 11:
								nombre='noviembre'
								break;
							case 12:
								nombre='diciembre'
								break;
						
							default:
								nombre ='Nulo'
								break;
						}
						elemento.mostrar='Entrega de '+nombre + ' del ' + elemento.fecha_entrega.split('-',3)[0]
						beneficiosActivos.push(elemento)
					}
				});
				valor.beneficios = beneficiosActivos
			});
			return tabla
		},
		traerNombreMedicamento(tabla){
			for (let i in tabla) {
				let valor = tabla[i]
				tabla[i].nombre_completo = valor.nombre + ' - ' + valor.casa_medica.nombre
				if (valor.lotes.length >0){
					let lotesActivos=[]
					for (let j in valor.lotes) {
						let elemento = valor.lotes[j]
						if(elemento.estado == 1)
						{
							elemento.fecha_expiracion = new Date(parseInt(elemento.fecha_expiracion.split('-',3)[0]),parseInt(elemento.fecha_expiracion.split('-',3)[1]),parseInt(elemento.fecha_expiracion.split('-',3)[2]))
							lotesActivos.push(elemento)
						}
					}
					let n = lotesActivos.length
					let aux=0
					    for (let k = 1; k < n; k++) {
							for (let i = 0; i < (n - k); i++) {
								if (lotesActivos[i].fecha_expiracion > lotesActivos[i + 1].fecha_expiracion) {
									aux = lotesActivos[i];
									lotesActivos[i] = lotesActivos[i + 1];
									lotesActivos[i + 1] = aux;
								}
							}
						}
					tabla[i].lotes =lotesActivos
				}
			}
			return tabla
		},
		traerNombre(tabla){
			tabla.forEach(function(valor, indice, array){
				valor.nombres = valor.datos.nombres
				valor.apellidos = valor.datos.apellidos
				valor.nombre_completo = valor.datos.nombres + ' '+ valor.datos.apellidos
			});
			return tabla			
		},
		async importarPacientes() {
			let me = this;
			const response = await axios.get(
				`/api/paciente/get?completo=false`)
			.then(function (response) {
				const respuesta = response.data
				me.listado_pacientes = me.traerNombre(respuesta.pacientes.data)
				me.listado_pacientes = me.limpiarRecetas(me.listado_pacientes)
				me.listado_pacientes = me.limpiarBeneficios(me.listado_pacientes)
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
	},
	mounted(){
		this.importarPacientes()
		this.importarMedicamentos()
	}
}
</script>