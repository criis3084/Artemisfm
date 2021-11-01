<template>
	<vx-card>

	<div class = "demo-alignment">
	<div class="vx-col md:w-1/3 w-full mt-5">
	<router-link to="/ingreso/medicamentos"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
    </div>
	<h2> Ingreso de medicamento {{numero_id}}</h2>
	</div>
					<vs-divider position="right">ARTEMIS&#174;</vs-divider>

		<div class="vx-row leading-loose p-base">
			<div class="vx-col w-1/2">
				<h3><b>Datos del proveedor:</b></h3>
				<h4><b>Nombre:   </b> {{nombre_proveedor}} </h4>
				<h4><b>Teléfono: </b> 	{{telefono_proveedor}} </h4>
			</div>
			<div class="vx-col w-1/2 text-right">
				<h3><b>Número de Entrada:   </b> {{numero_id}}</h3>
					<!-- <h4>  </h4> -->
				<h4> <b>Fecha de Ingreso:</b> </h4>
					<h4> {{fecha_ingreso}} </h4>
			</div>

			<br>
			<table style="width:100%" class="border-collapse mt-8">
				<tr>
					<th class="p-2 border border-solid d-theme-border-grey-light text-center"> <h5><b>Descripción del ingreso: </b> </h5></th>
				</tr>
				<tr>
					<th class="p-2 border border-solid d-theme-border-grey-light text-center"> {{descripcion_ingreso}} </th>
				</tr>
			</table>
			<br>
			<br>
			<vs-divider position="center">Listado de Medicamentos</vs-divider>

			<vs-list>
				<div class="vx-col w-full mb-base">
						<table style="width:100%" class="border-collapse">
								<tr>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Medicamento</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Fecha de Expiración</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Numero de Lote/Referencia</th>
									<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad de entrada</th>
								</tr>
								<tr v-for="(producto,index) in detalleIngreso" :key="index">
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.datos_medicamento[0].nombre}}</td>
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.lote.fecha_expiracion}}</td>
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.lote.numero_referencia}}</td>
										<td class="border border-solid d-theme-border-grey-light text-center"> {{producto.lote.stock}}</td>
								</tr>
						</table>
				</div>
		</vs-list>

		</div>
		<div class="vx-col md:w-1/3 w-full mt-5">
	<router-link to="/ingreso/medicamentos"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
    </div>
	</vx-card>
</template>
<script>
import axios from 'axios';
export default {
	data() {
		return {
			detalleIngreso:[],
			proveedor:[],
			fecha_ingreso:'',
			descripcion_ingreso:'',
			numero_id:0,
			nombre_proveedor:'',
			telefono_proveedor:'',
		}
	},
	methods: {
		async index(){
			let datos = this.$route.params.id;
			let me = this;
 			const response = await axios.get(`/api/detalleIngreso/get?criterio=ingreso_medicamento_id&buscar=${datos}&completo=true`)
			.then(function (response) {
				var respuesta= response.data;
				me.detalleIngreso = respuesta.detalleIngresos.data;
				me.importarProveedores(me.detalleIngreso[0].ingreso_medicamento.proveedor_id)
				me.fecha_ingreso=me.detalleIngreso[0].ingreso_medicamento.fecha_ingreso
				me.numero_id = me.detalleIngreso[0].ingreso_medicamento.id
				me.descripcion_ingreso=me.detalleIngreso[0].ingreso_medicamento.descripcion
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		async importarProveedores(idProveedor){
			let me2 = this
			const response = await axios.get(
			`/api/proveedor/get?criterio=id&buscar=${idProveedor}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me2.arrayData = respuesta.proveedores.data
				me2.proveedor = me2.traerNombre(me2.arrayData)
				me2.nombre_proveedor=me2.proveedor[0].nombre_completo
				me2.telefono_proveedor=me2.proveedor[0].datos.numero_telefono
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async importarUser(idUser){
			let me2 = this
			const response = await axios.get(
			`/api/proveedor/get?criterio=id&buscar=${idProveedor}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me2.arrayData = respuesta.proveedores.data
				me2.proveedor = me2.traerNombre(me2.arrayData)
				me2.nombre_proveedor=me2.proveedor[0].nombre_completo
				me2.telefono_proveedor=me2.proveedor[0].datos.numero_telefono
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		traerNombre (tabla) {
			tabla.forEach(function (valor, indice, array) {
				valor.nombre_completo = valor.datos.nombres + ' ' + valor.datos.apellidos
			}) 
			return tabla
		}
	},
	mounted() {
		this.index()
	},
}
</script>