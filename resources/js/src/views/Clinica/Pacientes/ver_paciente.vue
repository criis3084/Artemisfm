<template>
		<div class="vx-row">
				<div class="vx-col w-full sm:w-1/2 mb-base lg:w-1/5">
					<vx-card>
						<div class="text-center">
							<h4> <b> {{nombreCompleto}} </b></h4>
							<div v-if ="fotoPerfil != null">
								<vs-avatar class="mx-auto my-6 block" size="80px" :src="fotoPerfil"/>
							</div>
							<div v-if ="codigoPersona != null">
								<p>Código: {{codigoPersona}} </p>
							</div>
							<br>
						</div>
						<div class="flex justify-between text-center">
							<span>
								<p class="text-xl font-semibold">  {{ genero == 1 ? 'Masculino' : 'Femenino'}}  </p>
								<small class="text-grey">Género</small>
							</span>
							<span>
								<p class="text-xl font-semibold"> {{tipoPaciente}} </p>
								<small class="text-grey">Tipo de Paciente</small>
							</span>
						</div>
					</vx-card>
					<br>
					<vx-card
						title="Información Personal"
						title-color="primary"
						collapse-action
						:open="false"
					>
						<div v-if="informacion !== null">
							<div class="flex items-center mt-0">
								<vs-button color="warning" icon="cake" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-warning">Edad:</h5>
								<div class="vx-col w-full text-right text-warning mt-0"><h6>{{calculateAge(informacion)}}</h6></div>
							</div>
							<vs-divider class="mt-0"/>
								<div class="flex items-center mt-0" v-if="informacion.CUI !== null">
									<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-credit-card" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">DPI:</h5>
									<div class="vx-col w-full text-right text-warning mt-0"><h6> {{informacion.CUI}} </h6></div>
								</div>
								<vs-divider class="mt-0" v-if="informacion.CUI != null"/>
								<div class="flex items-center mt-0" v-if="informacion.numero_telefono != null">
									<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-phone-call" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">Telefono:</h5>
									<div class="vx-col w-full text-right text-warning mt-0"><h6> {{informacion.numero_telefono}} </h6></div>
								</div>
								<vs-divider class="mt-0" v-if="informacion.numero_telefono != null"/>
							<div class="flex items-center mt-0">
								<vs-button type="flat" radius color="warning" icon-pack="feather" icon="icon-map-pin" size="large" class="mt-0" disabled ></vs-button><h5 class="text-warning">Dirección:</h5>
							</div>
							<h6> {{ informacion.direccion }} </h6>
						</div>
					</vx-card>
					<br>
						<vx-card
						title="Información Medica"
						title-color="primary"
						collapse-action
						v-if="!primero"
						>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="filter_center_focus" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Peso:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0" ><h6> {{ultimo_peso}} <small> lb.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="vertical_align_top" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Talla:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6> {{ultima_talla}} <small> cm. </small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="favorite" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Pulso:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultimo_pulso}} <small> p.p.m.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button type="flat" radius color="success" icon-pack="feather" icon="icon-thermometer" size="large" class="mt-0" disabled ></vs-button><h5 class="text-success">Temperatura:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_temperatura}} <small> °C</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="directions_run" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Respiración:</h5>
								<div v-if="ultima_presion!=null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_respiracion}} <small> r.p.m.</small></h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0">
								<vs-button color="success" icon="timer" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-success">Presión arterial:</h5>
								<div v-if="ultima_presion != null" class="vx-col w-full text-right text-success mt-0"><h6>{{ultima_presion}}</h6></div>
								<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
							</div>
							<vs-divider class="mt-0"/>
							<div class="flex items-center mt-0" v-if="ultima_semanas != null">
								<vs-button color="danger" icon="pregnant_woman" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-danger">Semanas de embarazo:</h5>
								<div class="vx-col w-full text-right text-danger mt-0"><h6>{{ultima_semanas}}<small> Semanas</small></h6> </div>
							</div>
							<vs-divider class="mt-0" v-if="ultima_semanas != null"/>
							<div class="flex items-center mt-0" v-if="ultima_glicemia != null">
								<vs-button color="danger" icon="local_pharmacy" radius type="flat" size="large" class="mt-0" disabled></vs-button><h5 class="text-danger">Glicemia:</h5>
								<div class="vx-col w-full text-right text-danger mt-0"><h6>{{ultima_glicemia}} <small> mg/dl</small></h6></div>
							</div>
							<vs-divider class="mt-0" v-if="ultima_glicemia != null"/>
						</vx-card>
					<br>
				</div>
				<div class="vx-col w-full sm:w-1/2 mb-base lg:w-2/5">
					<vx-card
						title="Historial Médico"
						title-color="primary"
						>
							<template slot="actions">
								<vx-tooltip text = "Agregar registro"> <router-link to="/clinica/consultorio"> <vs-button radius type="gradient" icon="add" color = "primary" size="large" ></vs-button> </router-link>  </vx-tooltip>
							</template>
							<div v-if="primerHistorial">
								<ul class="vx-timeline">
									<li v-for="historial in historialCompleto" :key="historial.id">
										<div v-if="historial.tipoH==1">
											<div class="timeline-icon bg-warning">
												<feather-icon icon="FilterIcon" svgClasses="text-white stroke-current w-5 h-5" />
											</div>
											<div class="timeline-info">
												<h5 class="text-dark"> <b class="text-warning">Descripción: </b> {{ historial.examen.descripcion }}</h5>
												<span class="activity-desc"><b>Tipo: </b>{{ historial.tipo_examen[0].nombre }}</span>
												<span class="activity-desc"><b>Resultado: </b>{{ historial.examen.resultado }}</span>
											</div>
											<span class="text-grey activity-e-time">Fecha: {{ historial.fecha_consulta }}</span>
											<vs-button color="primary" type="border" icon="visibility" class="mr-base mb-2" size="small" v-if="historial.examen.ruta_imagen!==null" @click="openFotografia(historial.examen)">Ver Fotografia</vs-button>
											<vs-divider class="mt-5"/>
										</div>
										<div v-else>
											<div class="timeline-icon bg-primary">
												<feather-icon icon="FileTextIcon" svgClasses="text-white stroke-current w-5 h-5" />
											</div>
											<div class="timeline-info">
												<h5 class="text-dark"> <b class="text-primary">Descripción: </b> {{ historial.descripcion }}</h5>
												<span class="activity-desc"><b>Médico encargado: </b>{{ historial.doctor[0].nombres + ' ' + historial.doctor[0].apellidos }}</span>
												<br>
												<span class="activity-desc"><b>Objetivo: </b>{{ historial.objetivo }}</span>
												<br>
												<span class="activity-desc"><b>Subjetivo: </b>{{ historial.subjetivo }}</span>
											</div>
											<span class="text-grey activity-e-time">Fecha: {{ historial.fecha_consulta }}</span>
											<div class="flex flex-wrap items-center justify-between mt-3">
												<vs-button color="primary" type="border" icon="visibility" size="small" class="mr-base mb-2" @click="openDetalle(historial)">Ver consulta</vs-button>
												<div class="flex items-center">
													<vs-button color="primary" type="border" icon="visibility" class="mr-base mb-2" size="small" v-if="historial.receta.length>0" @click="openCita(historial.receta[0],historial.doctor[0])">Ver receta</vs-button>
												</div>
											</div>
											<vs-divider class="mt-4"/>
										</div>
									</li>
								</ul>
								<vs-prompt
									:buttons-hidden="true"
									title="Detalle de la receta"
									:active.sync="abrirReceta">
									<vs-list>
										<h5> <b> Doctor: </b> {{doctorReceta.nombres + ' ' + doctorReceta.apellidos}}</h5>
										<div class="vx-col w-full mb-base mt-4">
											<table style="width:100%" class="border-collapse">
												<tr>
													<th class="p-2 border border-solid d-theme-border-grey-light text-center">Nombre Medicamento</th>
													<th class="p-2 border border-solid d-theme-border-grey-light text-center">Cantidad</th>
													<th class="p-2 border border-solid d-theme-border-grey-light text-center">Frecuencia</th>
												</tr>
												<tr v-for="(producto,index) in carritoReceta" :key="index">
													<td class="border border-solid d-theme-border-grey-light text-center">{{producto.medicamento.nombre}}</td>
													<td class="border border-solid d-theme-border-grey-light text-center">{{producto.cantidad}}</td>
													<td class="border border-solid d-theme-border-grey-light text-center">{{producto.frecuencia}}</td>
												</tr>
											</table>
										</div>
										<h5> <b> Anotaciones: </b> {{listadoReceta}}</h5>
									</vs-list>
								</vs-prompt>
								<vs-prompt
									:buttons-hidden="true"
									title="Detalle de la consulta"
									:active.sync="abrirDetalle">
										<div v-if="detalleConsulta!= null">
											<h5> <b> Doctor: </b> {{detalleConsulta.doctor[0].nombres + ' ' + detalleConsulta.doctor[0].apellidos}}</h5>
											<h5> <b> Descripción: </b> {{detalleConsulta.descripcion}}</h5>
											<h5> <b> Objetivo: </b> {{detalleConsulta.objetivo}}</h5>
											<h5> <b> Subjetivo: </b> {{detalleConsulta.subjetivo}}</h5>
											<br>
											<h4 class="text-center text-primary"> <b> Signos Vitales Medidos: </b></h4>
											<br>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="filter_center_focus" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Peso:</h6>
												<div v-if="detalleConsulta.peso_actual != null" class="vx-col w-full text-right text-success mt-0"><h6> {{detalleConsulta.peso_actual}} <small> lb.</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="vertical_align_top" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Talla:</h6>
												<div v-if="detalleConsulta.talla != null" class="vx-col w-full text-right text-success mt-0"><h6> {{detalleConsulta.talla}} <small> cm. </small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="favorite" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Pulso:</h6>
												<div v-if="detalleConsulta.pulso != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.pulso}} <small> p.p.m.</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button type="flat" radius color="success" icon-pack="feather" icon="icon-thermometer" size="large" class="mt-0" disabled ></vs-button><h6 class="text-success">Temperatura:</h6>
												<div v-if="detalleConsulta.temperatura != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.temperatura}} <small> °C</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="directions_run" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Respiración:</h6>
												<div v-if="detalleConsulta.respiracion != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.respiracion}} <small> r.p.m.</small></h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0">
												<vs-button color="success" icon="timer" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-success">Presión arterial:</h6>
												<div v-if="detalleConsulta.presion_arterial != null" class="vx-col w-full text-right text-success mt-0"><h6>{{detalleConsulta.presion_arterial}} </h6></div>
												<div v-else class="vx-col w-full text-right text-success mt-0"><h6> No Medido </h6></div>
											</div>
											<vs-divider class="mt-0"/>
											<div class="flex items-center mt-0" v-if="detalleConsulta.semanas_embarazo != null">
												<vs-button color="danger" icon="pregnant_woman" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-danger">Semanas de embarazo:</h6>
												<div class="vx-col w-full text-right text-danger mt-0"><h6>{{detalleConsulta.semanas_embarazo}}<small> Semanas</small></h6> </div>
											</div>
											<vs-divider class="mt-0" v-if="detalleConsulta.semanas_embarazo != null"/>

											<div class="flex items-center mt-0" v-if="detalleConsulta.glicemia != null">
												<vs-button color="danger" icon="local_pharmacy" radius type="flat" size="large" class="mt-0" disabled></vs-button><h6 class="text-danger">Glicemia:</h6>
												<div class="vx-col w-full text-right text-danger mt-0"><h6>{{detalleConsulta.glicemia}} <small> mg/dl</small></h6></div>
											</div>
											<vs-divider class="mt-0" v-if="detalleConsulta.glicemia != null"/>
										</div>
								</vs-prompt>

								<vs-prompt
									:buttons-hidden="true"
									title="Fotografia de resultado de examen"
									:active.sync="abrirFotografia">
									<div v-if="detalleExamen!= null">
										<img :src="detalleExamen.ruta_imagen"  width="100" height="100" class="responsive">
									</div>
								</vs-prompt>

								</div>
								<div v-else>
									<h3>El paciente no tiene registros en su historial médico</h3>
								</div>
					</vx-card>
				</div>
				<div class="vx-col w-full mb-base lg:w-2/5">
					<vx-card
						title="Citas Programadas"
						title-color="primary"
					>
						<template slot="actions">
								<vx-tooltip text = "Agregar registro"> <router-link to="/clinica/citas"> <vs-button radius type="gradient" icon="add" color = "primary" size="large" ></vs-button> </router-link>  </vx-tooltip>
						</template>
						<div v-if="!conCitas"> 
						<vx-card v-for="(cita) in citas" :key="cita.id" class="mt-2" >
							<div class="">
								<div slot="no-body">
									<div class="vx-row no-gutter justify-center">
										<div class="vx-col hidden lg:block lg:w-1/4 text-center" >
											<vx-card card-background="cornflowerblue">
													<p class="calender-day text-white text-center">
														<b>
														{{cita.dia}}
														</b>
													</p>
													<p class="calender-date text-white text-center">
														<b>
														{{cita.fecha.split('-',3)[2]}}
														</b>
													</p>
													<p class="calender-month-year text-white text-center">
														<b>
															{{cita.mes}}
														</b>
													</p>
													<p><small class="text-white text-center">{{cita.fecha.split('-',3)[0]}}</small></p>
											</vx-card>
										</div>
										<div class="vx-col sm:w-full md:w-full lg:w-3/4 calendar2">
											<div class="px-4 pt-4">
												<b> Descripcion: </b> {{cita.descripcion}}
												<p>
													<small> 
														<b> Médico: </b> {{cita.datos_clinico[0].nombres + ' ' + cita.datos_clinico[0].apellidos}}
													</small>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</vx-card>						
						</div>
						<div v-else>
							<h3>El paciente no tiene citas en su historial</h3>
						</div>
					</vx-card>
				</div>
		</div>
</template>
<script>
import axios from 'axios'
import VxTimeline from '@/components/timeline/VxTimeline.vue'
export default {
	data() {
		return {
			active:true,
			url:'/clinica/consultorio',
			id_recibido:null,
			informacion:null,
			paciente_normal:false,
			informacion_completa:null,
			historiales:null,
			primero:true,
			ultimo_historial:null,
			citas:null,
			conCitas:true,
			amplio:true,
			examenes:null,
			primerExamen:false,
			historialCompleto:null,
			primerHistorial:true,
			nombreCompleto:'',
			tipoPaciente:'',
			genero:0,
			fotoPerfil:null,
			codigoPersona:null,
			detalleConsulta:null,
			abrirDetalle:false,
			abrirReceta:false,
			//--------- Ultimos -------/
			ultimo_peso:null,
			ultima_talla:null,
			ultimo_pulso:null,
			ultima_temperatura:null,
			ultima_presion:null,
			ultima_glicemia:null,
			ultima_semanas:null,
			ultima_respiracion:null,
			carritoReceta:[],
			doctorReceta:{},
			listadoReceta:'',
			abrirFotografia:false,
			detalleExamen:null,
		}
	},
	components:{
		VxTimeline
	},
	methods: {
		abrir(){
			this.amplio=!this.amplio	
		},
		openDetalle(detalleC){
			this.abrirDetalle=true;
			this.detalleConsulta=detalleC
		},
		openFotografia(examen){
			this.abrirFotografia=true;
			this.detalleExamen = examen
		},
		openCita(detalleC,medico){
			this.listadoReceta = detalleC.listado
			this.doctorReceta=medico
			const me = this
			axios.get(
			`/api/asignacionMedicamento/get?criterio=receta_id&buscar=${detalleC.id}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.detalleReceta = respuesta.asignacionMedicamentos.data
				me.carritoReceta = me.detalleReceta
			})
			.catch(function (error) {
				console.log(error)
			})
			this.abrirReceta=true;

		},
		async traerPaciente(){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/paciente/get?criterio=id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.informacion_completa = respuesta.pacientes.data[0]
				me.informacion = me.informacion_completa.datos

				if (me.informacion_completa.tipo_paciente_id==1){
					me.paciente_normal=true
				}
				me.buscarNino(me.informacion.id)
				me.nombreCompleto = me.informacion.nombres + ' ' + me.informacion.apellidos
				me.genero = me.informacion.genero
				me.tipoPaciente = me.informacion_completa.tipo_paciente.nombre
			})
			.catch(function (error) {
			console.log(error)
			})
		},
		buscarNino(idPersona){
			let me = this
			axios.get(
			`/api/nino/get?criterio=persona_sin_acceso_id&buscar=${idPersona}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				let buscador = respuesta.ninos.data
				if (buscador.length==0){
					me.buscarEncargado(idPersona)
				}
				else{
					me.fotoPerfil=buscador[0].ruta_imagen
					me.codigoPersona=buscador[0].codigo
				}
			})
			.catch(function (error) {
			console.log(error)
			})
		},
		buscarEncargado(idPersona){
			let me = this
			axios.get(
			`/api/encargado/get?criterio=persona_sin_acceso_id&buscar=${idPersona}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				let buscador = respuesta.encargados.data
				if (buscador.length==0){
					me.fotoPerfil=null
				}
				else{
					me.fotoPerfil=buscador[0].ruta_imagen
					me.buscarRelacion(buscador[0].id)
				}
			})
			.catch(function (error) {
			console.log(error)
			})
		},
		buscarRelacion(idPersona){
			let me = this
			axios.get(
			`/api/relacion/get?criterio=encargado_id&buscar=${idPersona}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				let buscador = respuesta.relaciones.data
				if (buscador.length==0){
					me.codigoPersona=null
				}
				else{
					me.codigoPersona=buscador[0].codigo
				}
			})
			.catch(function (error) {
			console.log(error)
			})
		},

		calculateAge(fechaN) {
			if (fechaN != null)
			{
				let fechaNacimiento = fechaN.fecha_nacimiento
				let currentDate = new Date();
				let fecha_nacimientoTt = new Date(fechaNacimiento); 
				let difference = currentDate - fecha_nacimientoTt;
				let age = Math.floor(difference/31557600000);
				return age
			}
		},
		async traerHistorial(){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/historialClinico/get?criterio=paciente_id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.historiales = respuesta.historialClinicos.data
				if (me.historiales.length>0){
					me.primero=false
				}
				for (let i in me.historiales) {
					me.historiales[i].tipoH = 0
				}
				me.traerExamenes(me.historiales)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		traerExamenes(listaMedica){
			const me = this
			me.id_recibido = me.$route.params.id
			axios.get(
			`/api/historialExamen/get?criterio=paciente_id&buscar=${me.id_recibido}&completo=false`)
			.then(function (response) {
				const respuesta = response.data
				me.examenes = respuesta.historialExamenes.data
				if (me.examenes.length > 0){
					me.primerExamen=true
				}
				for (let i in me.examenes) {
					me.examenes[i].tipoH = 1
				}

				me.unionExamenes(listaMedica,me.examenes)
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		async traerCitas(){
			const me = this
			me.id_recibido = me.$route.params.id
			const response = await axios.get(
			`/api/cita/get?criterio=paciente_id&buscar=${me.id_recibido}&completo=true`)
			.then(function (response) {
				const respuesta = response.data
				me.citas = me.toFecha(respuesta.citas.data)
				if (me.citas.length>0){
					me.conCitas=false
				}
			})
			.catch(function (error) {
				console.log(error)
			})
		},
		unionExamenes(clinico,examenes){
			for (let i in examenes) {
				let elemento=examenes[i]
				examenes[i].id = elemento.id +10000
				examenes[i].fecha_consulta=elemento.examen.fecha_examen
			}
			const tabla = clinico.concat(examenes);
			if (tabla.length !=0){
				for (let i in tabla) {
					let elemento = tabla[i]
					tabla[i].fechaH = new Date(parseInt(elemento.fecha_consulta.split('-',3)[0]),parseInt(elemento.fecha_consulta.split('-',3)[1]),parseInt(elemento.fecha_consulta.split('-',3)[2]))
				}
				for (let i in tabla) {
					let elemento = tabla[i]
					let n = tabla.length
					let aux={}
					for (let k = 1; k < n; k++) {
						for (let i = 0; i < (n - k); i++) {
							if (tabla[i].fechaH < tabla[i + 1].fechaH) {
								aux = tabla[i];
								tabla[i] = tabla[i + 1];
								tabla[i + 1] = aux;
							}
						}
					}
				}
				let masReciente=false
				for (let i in tabla) {
					if (tabla[i].tipoH == 0 && masReciente ==false){
						this.ultimo_historial = tabla[i]
						this.ultimo_peso = tabla[i].peso_actual
						this.ultima_talla=tabla[i].talla
						this.ultimo_pulso=tabla[i].pulso
						this.ultima_temperatura=tabla[i].temperatura
						this.ultima_presion=tabla[i].presion_arterial
						this.ultima_glicemia=tabla[i].glicemia
						this.ultima_semanas=tabla[i].semanas_embarazo
						this.ultima_respiracion=tabla[i].respiracion
						masReciente = true
					}
				}
				this.primerHistorial=true
				this.historialCompleto = tabla
			}
			else{
				this.primerHistorial=false
			}
		},
		nombreMes(numero){
			numero = parseInt(numero)+1
			let nombre=''
			switch (numero) {
				case 1:
					nombre='Enero' 
					break;
				case 2:
					nombre='Febrero'
					break;
				case 3:
					nombre='Marzo'
					break;
				case 4:
					nombre='Abril' 
					break;
				case 5:
					nombre='Mayo' 
					break;
				case 6:
					nombre='Junio' 
					break;
				case 7:
					nombre='Julio' 
					break;
				case 8:
					nombre='Agosto' 
					break;
				case 9:
					nombre='Septiembre' 
					break;
				case 10:
					nombre='Octubre'
					break;
				case 11:
					nombre='Noviembre'
					break;
				case 12:
					nombre='Diciembre'
					break;
			
				default:
					nombre ='Nulo'
					break;
			}
			return nombre
		},
		toFecha(tabla){
			for (let i in tabla) {
				let valor = tabla[i]
				const todaySin = new Date(parseInt(valor.fecha.split('-',3)[0]),parseInt(valor.fecha.split('-',3)[1])-1,parseInt(valor.fecha.split('-',3)[2]))
				valor.dia = this.diaEspaniol(todaySin.getDay())
				valor.mes = this.nombreMes(todaySin.getMonth())
			};
			return tabla
		},
		diaEspaniol(dia){
			dia = parseInt(dia)
			let nombre=''
			switch (dia) {
				case 0:
					nombre='Domingo'
					break;
				case 1:
					nombre='Lunes'
					break;
				case 2:
					nombre='Martes'
					break;
				case 3:
					nombre='Miercoles'
					break;
				case 4:
					nombre='Jueves'
					break;
				case 5:
					nombre='Viernes'
					break;
				case 6:
					nombre='Sabado'
					break;
				default:
					nombre ='Nulo'
				break;
			}
			return nombre
		}
	},
	mounted(){
		this.traerHistorial()
		this.traerPaciente()
		this.traerCitas()
	},
	
}
</script>
<style lang="scss">
@import "@sass/vuexy/components/vxTimeline.scss";
</style>
<style>
	.calendar2{
		background-color: #FFFCFC;
	}
	.calender{
		position: absolute;
		transform: translate(-50%,-50%);
		width: 70px;
		height: 80px;
		background-color: cornflowerblue;
		border:#fff;
		border-radius: 5%;
		box-shadow: 0 4px 4px 0 rgba(50,50,50,0.4);
	}
	.calender>p{
		font-family: Verdana, Geneva, Tahoma, sans-serif;
		padding: 0px 0;
		margin: 0;
		color:#fff;
		text-align: center;
	}
	.calender-day{
		font-size:9px;
	}
	.calender-month-year{
		font-size: 9px;
	}
	.calender-date{
		font-size:25px;
		padding-top:0px;
		padding-bottom: 0;
	}
	
</style>
<style lang="scss">
.login-tabs-container {
  min-height: 15px;

  .con-tab {
    padding-bottom: 1px;
  }

  .con-slot-tabs {
    margin-top: 1rem;
  }
}
</style>
