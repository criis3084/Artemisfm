<template>
  <div id="item-detail-page">
    <vx-card title="Información del Proveedor">


      <template slot="no-body">
				<vs-divider position="right">ARTEMIS&#174;</vs-divider>

        <div class="item-content">

          <!-- Item Main Info -->
          <div class="product-details p-6">
            <div class="vx-row mt-6">
              

              <div class="vx-col w-full">
                    <vx-tooltip text="Regresar"><vs-button size="small" @click="goBack" class="mr-4" type="border" icon-pack="feather" icon="icon-corner-up-left" radius></vs-button></vx-tooltip>

                <span>Empresa</span>
                <h1 class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.nombre}}</h1>
                
                <span>Nombres y apellidos</span>
                
                
                <h1 class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.nombresProveedor +" " + this.apellidosProveedor }}</h1>
                <!-- <p>{{"Número de CUI"+" "+ this.CUI }}</p> -->
                <span>Número de CUI</span>
                <h1 class="text-2xl leading-none font-medium text-primary mr-4 mt-2">{{ this.CUI}}</h1>

                <vs-divider />
                <span>Contacto</span>
                <p class="flex items-center flex-wrap">
                  <vx-tooltip text="Dirección"><span class="material-icons ">house</span></vx-tooltip>
                  <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.direccionProveedor }}</span>
                </p>
                <p class="flex items-center flex-wrap"> 
                   <vx-tooltip text="Télefono"> <span class="material-icons ">contact_phone </span> </vx-tooltip>
                    <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.numero_telefono }}</span>
                </p>

                <vs-divider />
                <span>Información adicional</span>

                <p class="flex items-center flex-wrap">
                      <vx-tooltip text="Fecha de nacimiento"> <span class="material-icons ">date_range</span> </vx-tooltip>
                <span class="text-2xl leading-none font-medium text-primary mr-4"> {{this.fecha_nacimiento }}</span>
                </p>
                <vs-divider/>
                
                <div class="vx-row">
                  <div class="vx-col flex flex-wrap items-center">
                   <vx-tooltip text="Editar Información"> <vs-button class="mr-4" type="gradient" icon-pack="feather" color="success" icon="icon-edit"  @click="$router.push('/editar/proveedor/'+id_recibido)">Editar Información</vs-button> </vx-tooltip>
                    <vx-tooltip text="Regresar"><vs-button @click="goBack" class="mr-4" type="gradient" icon-pack="feather" icon="icon-corner-up-left">Regresar</vs-button></vx-tooltip>
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
import 'swiper/dist/css/swiper.min.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import algoliasearch from 'algoliasearch/lite'
import StarRating from 'vue-star-rating'
import axios from 'axios'

export default{
  components: {
    swiper,
    swiperSlide,
    StarRating
  },
  data () {
    return {
      algolia_index: algoliasearch(
        'latency',
        '6be0576ff61c053d5f9a3225e2a90f76'
      ).initIndex('instant_search'),
      item_data: null,
      error_occured: false,
      error_msg: '',
      arrayData: [],
      idProveedor:'',
	  id:'',
	  nombre:'',
      nombresProveedor: '',
      apellidosProveedor: '',
      direccionProveedor: '',
      genero:'',
      CUI:'',
      numero_telefono:'',
      correo:'',
      imagen_perfil:'',
      fecha_nacimiento:this.getDate(this.fecha_nacimiento),
      descripcion:'',
      user:'',
      password:'',
      roles: [],
      selected: '1',
      rol:'',
      id_recibido:''

      // Related Products Swiper
      // Below is data which is common in any item
      // Algolia's dataSet don't provide this kind of data. So, here's dummy data for demo
    }
  },
  computed: {
  },
  methods: {
    goBack(){
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
      const response = await axios.get(`/api/proveedor/get?&criterio=id&buscar=${this.id_recibido}&completo=true`)
        .then(function (response) {
          var respuesta =  response.data
          me.arrayData = respuesta.proveedores.data[0]
          me.nombre = me.arrayData.nombre
          me.nombresProveedor = me.arrayData.datos.nombres
          me.apellidosProveedor = me.arrayData.datos.apellidos
          me.direccionProveedor = me.arrayData.datos.direccion
          me.idProveedor = me.arrayData.datos.id
          me.genero = me.arrayData.datos.genero
          me.fecha_nacimiento = me.arrayData.datos.fecha_nacimiento
          me.CUI = me.arrayData.datos.CUI
          me.numero_telefono = me.arrayData.datos.numero_telefono
        })
        .catch(function (error) {
          console.log(error)
        })
    }
  },
  created () {
  },
  mounted () {
    this.index()
  }
}
</script>

<style lang="scss">

@import "@sass/vuexy/_variables.scss";

#item-detail-page {
  .color-radio {
    height: 2.28rem;
    width: 2.28rem;

    > div {
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  }

  .item-features {
    background-color: #f7f7f7;

    .theme-dark & {
      background-color: $theme-dark-secondary-bg;
    }
  }

  .product-sales-meta-list {
    .vs-list--icon {
      padding-left: 0;
    }
  }

  .related-product-swiper {
      // padding-right: 2rem;
      // padding-left: 2rem;

    .swiper-wrapper {
      padding-bottom: 2rem;

      > .swiper-slide {
        background-color: #f7f7f7;
        box-shadow: 0 4px 18px 0 rgba(0,0,0,0.1), 0 5px 12px 0 rgba(0,0,0,0.08) !important;

        .theme-dark & {
          background-color: $theme-light-dark-bg;
        }
      }
    }

    .swiper-button-next,
    .swiper-button-prev {
      transform: scale(.5);
      filter: hue-rotate(40deg);
    }

    .swiper-button-next {
      right: 0
    }

    .swiper-button-prev {
      left: 0;
    }
  }
}
</style>
