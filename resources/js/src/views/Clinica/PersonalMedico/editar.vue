<template>
	<div>
		<vx-card>
      <div class="vx-col md:w-1/3 w-full mt-5">
	<router-link to="/clinica/PersonalMedico"><vs-button type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border></vs-button></router-link>
    </div>
			<form-wizard color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZACIÓN DE PERSONAL MÉDICO" subtitle="" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" enctype="multipart/form-data">
				<vs-divider position="right">ARTEMIS&#174;</vs-divider>
				
        <tab-content title="Paso 1" class="mb-5" icon="feather icon-user-plus" :before-change="validateStep1">

				<!-- tab 1 content -->
					<form data-vv-scope="step-1" >
						<div class="vx-row">

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Nombres" name="nombres" v-model="nombres" v-validate="'required|alpha_spaces|max:30'"/>
									<span class="text-danger">{{ errors.first('step-1.nombres') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" v-model="apellidos" name="apellidos" v-validate="'required|alpha_spaces|max:30'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>


							<div class="vx-col md:w-1/2 w-full mt-1">
								<div class="my-4">
									<small class="date-label">Fecha de nacimiento</small>
									<datepicker :format="dateFormat" :language="$vs.rtl ? langEn : langEn" name="fecha" v-validate="'required'" v-model="fecha_nacimiento"></datepicker>
									<span class="text-danger">{{ errors.first('step-1.fecha') }}</span>
				                </div>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-6">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" v-model="CUI" name="cui" v-validate="'numeric|max:13'"/>
									<span class="text-danger">{{ errors.first('step-1.cui') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-2">
								<small class="date-label">Género</small>
								<ul class="demo-alignment">
										<li>
											<vs-radio name="radio" v-validate="'required|included:1,0'" color="rgb(0, 170, 228)" v-model="genero" vs-value="1" selected>Masculino</vs-radio>
										</li>
										<li>
											<vs-radio name="radio" color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
										</li>
								</ul>
									<span class="text-danger">{{ errors.first('step-1.radio') }}</span>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-2">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono" name="numero_telefono" v-validate="'numeric|max:15'" />
                                    <span class="text-danger">{{errors.first('step-1.numero_telefono') }}</span>
								</div>
							</div>
							<div class="vx-col w-full mt-3">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-map-pin" icon-no-border label-placeholder="Dirección" name="direccion" v-model="direccion" v-validate="'required|max:254'" />
									<span class="text-danger">{{errors.first('step-1.direccion') }}</span>
								</div>
							</div>
							
							<div class="vx-col md:w-1/2 w-full mt-4">
								<div class="vx-col w-full">
									<small class="date-label">Profesión</small>
									<v-select name="profesion" v-validate="'required'" label="nombre" :options="Profesiones"  v-model="profesion_id" :dir="$vs.rtl ? 'rtl' : 'ltr'"/>
                  					<span class="text-danger">{{ errors.first('step-1.profesion') }}</span>
								</div>
							</div>

                            <div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-award" icon-no-border label-placeholder="No. Colegiado" v-model="colegiado" name="colegiado"/>
									<span class="text-danger">{{ errors.first('step-1.colegiado') }}</span>
								</div>
							</div>

						</div>
					</form>
				</tab-content>

    <!-- tab 2 content -->
    <tab-content title="Paso 2" class="mb-5" icon="feather icon-file-plus" :before-change="validateStep2">
		<form data-vv-scope="step-2">
			<div class="vx-row">
				<div class="vx-col md:w-1/2 w-full mt-5">
					<template>
						<img :src="imagen_perfil_antigua"  width="100" height="100" class="responsive">
						<vx-tooltip text="Editar Imagen"> <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-edit" radius  @click="editarImagen"></vs-button> </vx-tooltip>
						<!-- <vs-upload v-if="mostrarEditar" automatic action="/api/nino/imagen" limit='1' :headers="head" fileName='photos' @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil" /> -->
						<vs-upload automatic  v-if="mostrarEditar" action="/api/clinico/imagen" limit="1" :headers="head" fileName="photos" @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil"/>
					</template>
				</div>
			</div>
			
            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label-placeholder="Correo" v-model="correo" name="correo" v-validate="'email|max:150'"/>
					<span class="text-danger">{{ errors.first('step-2.correo') }}</span>
				</div>
			</div>

			<div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
                    <small>Descripción</small>
					<textarea name="descripcion" v-validate="'max:254'" class="w-full" icon-no-border label-placeholder="Descripción" v-model="descripcion"/>
						<span class="text-danger">{{ errors.first('descripcion') }}</span>
        </div>
			</div>

		</form>
    </tab-content>

    <!-- tab 3 content -->
    <tab-content title="Paso 3" class="mb-5" icon="feather icon-lock" :before-change="validateStep3">
		<form data-vv-scope="step-3">

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="User" v-model="user" v-validate="'required|min:5|max:15'" name="user"/>
					<span class="text-danger">{{ errors.first('step-3.user') }}</span>
        </div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<div class="vx-col w-full">
					<vs-input type="password" class="w-full" icon-pack="feather" icon="icon-lock" icon-no-border label-placeholder="Contraseña" v-model="password" name="password" v-validate="'required|min:6|max:15'"/>
					<span class="text-danger">{{ errors.first('step-3.password') }}</span>
				</div>
			</div>

            <div class="vx-col md:w-1/2 w-full mt-5">
				<small class="date-label">Rol</small>
				<v-select name="rol" v-validate="'required'" label="nombre" :options="roles" v-model="rol_id" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
					<span class="text-danger">{{ errors.first('step-3.rol') }}</span>
			</div>

        </form>
    </tab-content>
  </form-wizard>

    <div class="vx-col md:w-1/3 w-full mt-5">
	<router-link to="/clinica/PersonalMedico"><vs-button type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border>Regresar</vs-button></router-link>
    </div>

</vx-card>
</div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
// For custom error message
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    cui: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 13 dígitos',
    },
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
    direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres',
    },
    fecha: {
      required: 'El campo fecha de nacimiento es requerido',
	},
    numero_telefono: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 15 caracteres',
	},
	radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción',
	},
	especialidad: {
	  max: 'Este campo solo acepta hasta 150 caracteres',
	},
	correo:{
	  email:'Ingrese un correo válido ',
	  max: 'Este campo solo acepta hasta 100 caracteres',
	  
	},
	descripcion: {
	  max: 'Este campo solo acepta hasta 254 caracteres',
    },
	user:{
	  required: 'El campo user es requerido',
	  min: 'Su user no puede tener menos de 5 caracteres',
	  max: 'Su user no puede tener más de 15 caracteres',
	},
	password:{
	  required: 'El campo contraseña es requerido',
	  min: 'Su contraseña no puede tener menos de 6 caracteres',
	  max: 'Su contraseña no puede tener más de 15 caracteres',
	},
	rol:{
	  required: 'El campo rol es requerido',
	},
    profesion :{
      required: 'El campo profesión es requerido',
    },
  }
}

Validator.localize('en', dict)
import { es } from 'vuejs-datepicker/src/locale'
export default {
  data () {
    return {
      arrayData: [],
      idPersonal:'',
      id:'',
      nombres: '',
      apellidos: '',
      direccion: '',
      profesion_id:'',
      Profesiones:[],
      genero:'',
      CUI:'',
      numero_telefono:'',
      correo:'',
      imagen_perfil_antigua:'',
      imagen_perfil:'',
      fecha_nacimiento:this.getDate(this.fecha_nacimiento),
      descripcion:'',
      user:'',
      password:'',
      roles: [],
      selected: '1',
      rol_id:'',
	  langEn: es,
	  colegiado:'',
      head:{
        'imagenanterior':''	
      },
      mostrarEditar:false,
      id_recibido:'',
      titulo:'Registrado exitosamente!',
      waterMark : 'Select a date',
      dateVal : new Date(),
	  dateFormat : 'yyyy-MM-dd'
	  
    }
  },
  methods: {
    goBack () {
      this.$router.go(-1)
    },
    editarImagen () {
      this.mostrarEditar = true
    },
    vaciar () {
      this.imagen_perfil = ''
    },
    respuesta (e) {
      this.imagen_perfil = e.currentTarget.response.replace(/['"]+/g, '')
      this.head.imagenanterior = this.imagen_perfil
	  this.$vs.notify({
				color:'success',
				title:'Imagen subida',
				text:'Acción realizada exitósamente!'
			});
    },
    getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
	},
    formSubmitted () {
      const me = this
      if (this.imagen_perfil === '') {
        this.imagen_perfil = this.imagen_perfil_antigua
      } else {
        this.imagen_perfil = `/storage/public/personalClinico/${  this.imagen_perfil}`
      }
      axios.put('/api/clinico/update/', {
        id:this.id_recibido,
        nombres:this.nombres,
        apellidos:this.apellidos,
        especialidad:this.profesion,
        CUI:this.CUI,
        genero:this.genero,
        numero_telefono:this.numero_telefono,
        correo:this.correo,
        imagen_perfil:this.imagen_perfil,
        profesion_id:this.profesion_id.id,
        colegiado:this.colegiado,
        user:this.user,
        password:this.password,
        descripcion:this.descripcion,
        fecha_nacimiento:this.getDate(this.fecha_nacimiento),
        direccion:this.direccion,
        rol_id:this.rol_id.id
      }).then(function (response) {
        console.log(response)
        // alert('Cambios guardados')
        me.$vs.notify({
					color:'success',
					title:'Éxito',
					text:'Datos actualizados correctamente'
				})
      })
        .catch(function (error) {
          console.log(error)
          me.$vs.notify({
					color:'danger',
					title:'Error',
					text:'No se pudieron actualizar los datos'
				})
        })
      this.$emit('cerrado', 'Se cerró el formulario')
      this.$router.push('/clinica/PersonalMedico')
    },
    async index () { //async para que se llame cada vez que se necesite
      const me = this
      this.id_recibido = this.$route.params.id
      const response = await axios.get(`/api/clinico/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta =  response.data
          me.arrayData = respuesta.clinicos.data[0]
          me.nombres = me.arrayData.datos.nombres
          me.apellidos = me.arrayData.datos.apellidos
          me.direccion = me.arrayData.datos.direccion
          me.profesion_id = me.arrayData.profesion.id
          me.idPersonal = me.arrayData.datos.id
          me.genero = me.arrayData.datos.genero
          me.fecha_nacimiento = me.arrayData.datos.fecha_nacimiento
          me.CUI = me.arrayData.datos.CUI
          me.numero_telefono = me.arrayData.datos.numero_telefono
          me.correo = me.arrayData.datos.correo
          me.imagen_perfil_antigua = me.arrayData.datos.imagen_perfil
          me.descripcion = me.arrayData.datos.descripcion
          me.rol_id = me.arrayData.datos.rol_id
          me.user = me.arrayData.datos.user
          me.password = me.arrayData.datos.password
          me.colegiado = me.arrayData.colegiado
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async importarRoles () { //async para que se llame cada vez que se necesite
      const me = this
      let encontrado = false
      let elementoE = {}
      const response = await axios.get(
        '/api/rol/get?completo=select')
        .then(function (response) {
          const respuesta = response.data
          me.roles = respuesta.roles.data
          me.roles.forEach(function (elemento, indice, array) {
            if (elemento.id == me.rol_id) {
              elementoE = elemento
              encontrado = true
            }
          })
          me.rol_id = encontrado == true ? elementoE : {id:me.rol_id, nombre:'Rol desactivado'} 
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async importarProfesiones () { 
      const me = this
      let encontrado = false
      let elementoE = {}
      const response = await axios.get(
        `/api/profesion/get?completo=select`)
        .then(function (response) {
          const respuesta = response.data
          me.Profesiones = respuesta.profesiones.data
          me.Profesiones.forEach(function (elemento, indice, array) {
            if (elemento.id === me.profesion_id) {
              elementoE = elemento
              encontrado = true
            }
          })
          me.profesion_id = encontrado === true ? elementoE : {id:me.profesion_id, nombre:'Profesion desactivada'}
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    successUpload () {
      this.$vs.notify({color:'success', title:'Fotografía', text:'Fotografía importada'})
    },
    validateStep1 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-1').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject('correct all values')
            this.$vs.notify({
			color:'danger',
			title:'Error en validación!',
			text:'Ingrese todos los campos correctamente'
			});
          }
        })
      })
    },
    validateStep2 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-2').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject('correct all values')
            this.$vs.notify({
			color:'danger',
			title:'Error en validación!',
			text:'Ingrese todos los campos correctamente'
			});
          }
        })
      })
    },
    validateStep3 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-3').then(result => {
          if (result) {
            this.formSubmitted()
            resolve(true)
          } else {
            reject('correct all values')
            this.$vs.notify({
			color:'danger',
			title:'Error en validación!',
			text:'Ingrese todos los campos correctamente'
			});
          }
        })
      })

    }
  },
  components: {
    FormWizard,
    TabContent,
    Datepicker,
    vSelect
  },
  mounted () {
		
    this.index()
    this.importarRoles()
    this.importarProfesiones()
  }
}
</script>