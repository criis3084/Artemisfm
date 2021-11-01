<template>
	<div>
		<vx-card>
			<div class="vx-col md:w-1/3 w-full mt-5">
				<vs-button @click="goBack" type="border" radius class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border ></vs-button>
			</div>
			<form-wizard  color="rgba(var(--vs-primary), 1)" errorColor="rgba(var(--vs-danger), 1)" title="ACTUALIZACIÓN DE USUARIO" subtitle="" finishButtonText="Enviar" back-button-text="Atrás" next-button-text="Siguiente" @on-complete="formSubmitted">
				<vs-divider position="right">ARTEMIS&#174;</vs-divider>
				<tab-content title="Paso 1" class="mb-5" icon="feather icon-user" :before-change="validateStep1">
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
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Apellidos" name="apellidos" v-model="apellidos" v-validate="'required|alpha_spaces|max:30'"/>
									<span class="text-danger">{{ errors.first('step-1.apellidos') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-hash" icon-no-border label-placeholder="CUI" name="cui" v-model="CUI" v-validate="'numeric|max:13'"/>
									<span class="text-danger">{{ errors.first('step-1.cui') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="my-4">
									<small class="date-label">Fecha de nacimiento</small>
									<datepicker :format="dateFormat" :language="$vs.rtl ? langEn : langEn" name="fecha" v-validate="'required'" v-model="fecha_nacimiento"></datepicker>
									<span class="text-danger">{{ errors.first('step-1.fecha') }}</span>

								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Género</small>
								<ul class="demo-alignment">
									<li>
										<vs-radio name="radio" v-validate="'required|included:1,0'" color="rgb(0, 170, 228)" v-model="genero" vs-value="1" selected>Masculino</vs-radio>
									</li>
									<li>
										<vs-radio name="radio" color="rgb(255, 0, 128)" v-model="genero" vs-value="0">Femenino</vs-radio>
									</li>
								</ul>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-phone" icon-no-border label-placeholder="Número de teléfono" v-model="numero_telefono" name="numero_telefono" v-validate="'numeric|max:15'"/>
									<span class="text-danger">{{errors.first('step-1.numero_telefono') }}</span>

								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-home" icon-no-border label-placeholder="Dirección" name="direccion" v-model="direccion" v-validate="'required|max:254'"/>
									<span class="text-danger">{{errors.first('step-1.direccion') }}</span>
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
										<img :src="imagen_perfil_antigua"  width="100" height="100" class="responsive">
										<vx-tooltip text="Editar Imagen"> <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-edit" radius  @click="editarImagen"></vs-button> </vx-tooltip>
										<vs-upload v-if="mostrarEditar" automatic action="/api/user/imagen" limit="1" :headers="head" fileName="photos" @on-success="respuesta" @on-delete="vaciar" text="Imagen de perfil"/>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label-placeholder="Correo" v-model="correo" name="correo" v-validate="'email|max:50'"/>
									<span class="text-danger">{{ errors.first('step-2.correo') }}</span>
								</div>
							</div>

							<div class="vx-col md:w-1/2 w-full mt-5">
								<div class="vx-col w-full">
									<vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label-placeholder="Descripción" v-model="descripcion" name="descripcion" v-validate="'max:254'"/>
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
									<vs-input class="w-full" type="password" icon-pack="feather" icon="icon-lock" icon-no-border label-placeholder="Contraseña" v-model="password" name="password" v-validate="'required|min:6|max:15'"/>
									<span class="text-danger">{{ errors.first('step-3.password') }}</span>
								</div>
							</div>
							<div class="vx-col md:w-1/2 w-full mt-5">
								<small class="date-label">Rol</small>
								<v-select label="nombre" :options="roles"  v-model="rol_id"  :dir="$vs.rtl ? 'rtl' : 'ltr'" v-validate="'required'" name="rol"/>
								<span class="text-danger">{{ errors.first('step-3.rol') }}</span>
							</div>
						</form>
					</tab-content>
			</form-wizard>
			<div class="vx-col md:w-1/3 w-full mt-5">
				<vs-button @click="goBack" type="gradient" class="w-full" icon-pack="feather" icon="icon-corner-up-left" icon-no-border >Regresar</vs-button>
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
	  max: 'Este campo solo acepta hasta 13 dígitos'
    },
    nombres: {
	  required: 'El campo nombres es requerido',
	  alpha_spaces: 'El campo solo debe de contener letras y espacios',
	  max: 'Este campo solo acepta hasta 30 caracteres'
    },
    apellidos: {
	  required: 'El campo apellidos es requerido',
	  alpha_spaces: 'El campo solo debe de contener letras y espacios',
	  max: 'Este campo solo acepta hasta 30 caracteres'
    },
    direccion: {
	  required: 'El campo dirección es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres'
    },
    fecha: {
      required: 'El campo fecha es requerido'
    },
    numero_telefono: {
	  numeric: 'El campo solo debe de contener números',
	  max: 'Este campo solo acepta hasta 15 caracteres'
    },
    radio: {
	  required: 'Seleccione una opción',
	  included: 'Seleccione una opción'
    },
    especialidad: {
	  max: 'Este campo solo acepta hasta 150 caracteres'
    },
    correo:{
	  email:'Ingrese un correo válido ',
	  max: 'Este campo solo acepta hasta 50 caracteres'
	  
    },
    descripcion: {
	  max: 'Este campo solo acepta hasta 254 caracteres'
    },
    user:{
	  required: 'El campo user es requerido',
	  min: 'Su user no puede tener menos de 5 caracteres',
	  max: 'Su user no puede tener más de 15 caracteres'
    },
    password:{
	  required: 'El campo contraseña es requerido',
	  min: 'Su contraseña no puede tener menos de 6 caracteres',
	  max: 'Su contraseña no puede tener más de 15 caracteres'
    },
    rol:{
	  required: 'El campo rol es requerido'
    }
  }
}

// register custom messages
Validator.localize('en', dict)
import { es } from 'vuejs-datepicker/src/locale'
export default {
  data () {
    return {
      arrayData: [],
      idTutor:'',
      id:'',
      
      nombres: '',
      apellidos: '',
      direccion: '',
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
      rol_id:null,
      langEn: es,
      head:{
        'imagenanterior':''	
      },
      mostrarEditar:false,
      id_recibido:'',
      titulo:'Actualización registrada!',
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
        this.imagen_perfil = `/storage/public/usuarios/${  this.imagen_perfil}`
      }
      axios.put('/api/user/update/', {
        id:this.id_recibido,
        nombres:this.nombres,
        apellidos:this.apellidos,
        CUI:this.CUI,
        genero:this.genero,
        numero_telefono:this.numero_telefono,
        correo:this.correo,
        imagen_perfil:this.imagen_perfil,
        user:this.user,
        password:this.password,
        descripcion:this.descripcion,
        fecha_nacimiento:this.getDate(this.fecha_nacimiento),
        direccion:this.direccion,
        rol_id:this.rol_id.id
      }).then(function (response) {
        console.log(response)
        me.$vs.notify({
          color:'success',
          title:'Exito!',
          text:'Datos actualizados exitósamente'
        })	
        me.$router.push('/admin/usuarios')
      })
        .catch(function (error) {
          console.log(error)
          me.$vs.notify({
            color:'danger',
            title:'Error!',
            text:'Error al actualizar los datos'
          })	
        })
    
     
    },
    async index () { //async para que se llame cada vez que se necesite
      const me = this
      this.id_recibido = this.$route.params.id
      const response = await axios.get(`/api/user/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          const respuesta =  response.data
          me.arrayData = respuesta.users.data
          me.nombres = me.arrayData[0].nombres
          me.apellidos = me.arrayData[0].apellidos
          me.direccion = me.arrayData[0].direccion
          me.id = me.arrayData[0].id
          me.genero = me.arrayData[0].genero
          me.fecha_nacimiento = me.arrayData[0].fecha_nacimiento
          me.CUI = me.arrayData[0].CUI
          me.numero_telefono = me.arrayData[0].numero_telefono
          me.correo = me.arrayData[0].correo
          me.imagen_perfil_antigua = me.arrayData[0].imagen_perfil
          me.descripcion = me.arrayData[0].descripcion
          me.user = me.arrayData[0].user
		  me.password = me.arrayData[0].password
		  me.importarRoles(me.arrayData[0].rol_id)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async importarRoles (rolBuscar) {
      const me = this
      let encontrado = false
      let elementoE = {}
      const response = await axios.get(
        '/api/rol/get?completo=select')
        .then(function (response) {
          const respuesta = response.data
          me.roles = respuesta.roles.data
          me.roles.forEach(function (elemento, indice, array) {
            if (elemento.id == rolBuscar) {
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
            })
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
            })
          }
        })
      })
    },
    validateStep3 () {
      return new Promise((resolve, reject) => {
        this.$validator.validateAll('step-3').then(result => {
          if (result) {
            resolve(true)
          } else {
            reject('correct all values')
            this.$vs.notify({
              color:'danger',
              title:'Error en validación!',
              text:'Ingrese todos los campos correctamente'
            })
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
  }
}
</script>