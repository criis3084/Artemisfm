<template>
<div id="item-detail-page">
    <vx-card title="Información del personal médico">
      <template slot="no-body">
        <!-- <h2>Información del niño</h2> -->
				<vs-divider position="right">ARTEMIS&#174;</vs-divider>
        <div class="item-content">

          <!-- Item Main Info -->
          <div class="product-details p-6">
            <div class="vx-row mt-6">
              <div class="vx-col md:w-2/5 w-full flex items-center justify-center">
                <div class="product-img-container w-3/5 mx-auto mb-10 md:mb-0">
                  <img :src="this.ruta_imagenT" class="responsive">

                  <!--
                    UnComment Below line for true flow
                    <img :src="item_data.image" :alt="item_data.name" class="responsive">

                    Remove above img tag which is for demo purpose in actual flow
                  -->
                </div>
              </div>

              <!-- Item Content -->
              <div class="vx-col md:w-3/5 w-full">
                    <vs-button @click="goBack" class="mr-4" type="border" radius icon-pack="feather" size="small" color="primary" icon="icon-corner-up-left"></vs-button>

                <span>Nombres y apellidos</span>
                <h1 class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.nombresT +" " + this.apellidosT }}</h1>
                 <p>{{"Número de CUI"+" "+ this.CUI }}</p>
              
                <vs-divider />
                <span>Datos Personales</span>
                <p class="flex items-center flex-wrap">
                  <vx-tooltip text="Dirección"><span><vs-icon icon="house" size="medium" color="dark"></vs-icon></span></vx-tooltip>
                  <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.direccionT }}</span>
                </p>

                <p class="flex items-center flex-wrap">
                      <vx-tooltip text="Fecha de nacimiento"> <span> <vs-icon icon="cake" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.fecha_nacimientoT}}</span>
                </p>

                <p class="flex items-center flex-wrap">
                      <vx-tooltip text="Edad"> <span> <vs-icon icon="perm_contact_calendar" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{calculateAge}} Años</span>
                </p>

                <vs-divider />
                <span>Información adicional</span>
                <p class="flex items-center flex-wrap">
                      <vx-tooltip text="Fecha de ingreso"> <span> <vs-icon icon="work" size="medium" color="dark"></vs-icon></span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4">{{profesion}} </span>
                </p>
                <p class="flex items-center flex-wrap">
                <span class="text-2xl leading-none font-medium text-primary mr-4">Ver pacientes</span>
                </p>
                
                <vs-divider/>
                
                <div class="vx-row">
                  <div class="vx-col flex flex-wrap items-center">
                   <vs-button class="mr-4" type="gradient" icon-pack="feather" color="success" icon="icon-edit" @click="$router.push('/clinica/editarPersonal/'+id_recibido)">Editar Información</vs-button>  
                    <vs-button @click="goBack" class="mr-4" type="gradient" icon-pack="feather" color="primary" icon="icon-corner-up-left"> Regresar</vs-button>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>

      </template>
    </vx-card>
  </div>
</template>

<script>


import axios from 'axios'

export default {

  computed:{
    calculateAge () {
      const currentDate = new Date()
      const fecha_nacimientoTt = new Date(this.fecha_nacimientoT) 
      const difference = currentDate - fecha_nacimientoTt
      const age = Math.floor(difference / 31557600000)
      return age
    }
  },
  data () {
    return {
      nombresT: '',
      apellidosT: '',
      direccionT: '',
      fecha_nacimientoT: '',
      fecha_ingresoT: '',
      ruta_imagenT:'',
      edad: '',
	  generoT:'',
	  especialidad:'',
      escuela_idT:'',
      arrayData:[],
      profesion:'',
      numero_telefono:'',
      id_recibido:'',
      CUI:'',
      age:''
    }
  },
  methods: {
    goBack () {
      this.$router.go(-1)
    },
	  getDate (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },
    async index () { //async para que se llame cada vez que se necesite
      const me = this
      this.id_recibido = this.$route.params.id
      const response = await axios.get(
        `/api/clinico/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          
          const respuesta = response.data
          me.arrayData = respuesta.clinicos.data[0]
          me.nombresT = me.arrayData.datos.nombres
          me.apellidosT = me.arrayData.datos.apellidos
          me.direccionT = me.arrayData.datos.direccion
          me.numero_telefono = me.arrayData.datos.numero_telefono
          me.CUI = me.arrayData.datos.CUI
          me.idT = me.arrayData.datos.id
          me.generoT = me.arrayData.datos.genero
          me.ruta_imagenT = me.arrayData.datos.imagen_perfil
          me.fecha_nacimientoT = me.arrayData.datos.fecha_nacimiento
          me.profesion = me.arrayData.profesion.nombre          
        })
        .catch(function (error) {
          console.log(error)
        })
    }

  
  },
  mounted () {
    this.index()
  }
}
</script>