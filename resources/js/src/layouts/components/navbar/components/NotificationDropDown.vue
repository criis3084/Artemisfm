<template>
  <!-- NOTIFICATIONS -->
  <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
    <feather-icon icon="BellIcon" class="cursor-pointer mt-1 sm:mr-6 mr-2" :badge="medicamentos.length" />

    <vs-dropdown-menu class="notification-dropdown dropdown-custom vx-navbar-dropdown">

      <div class="notification-top text-center p-5 bg-primary text-white">
        <h3 class="text-white">{{ medicamentos.length }}</h3>
        <p class="opacity-75">Notificaciones</p>
      </div>

      <component :is="scrollbarTag" ref="mainSidebarPs" class="scroll-area--nofications-dropdown p-0 mb-10" :settings="settings" :key="$vs.rtl">
        <ul class="bordered-items">
          <li v-for="(ntf,index) in medicamentos" :key="ntf.id" class="flex justify-between px-4 py-4 notification cursor-pointer">
            <div class="flex items-start" @click="alerta(ntf.nombre, ntf.cantidad, index)">
              <feather-icon :icon="ntf.icon" :svgClasses="[`text-${ntf.categoria}`, 'stroke-current mr-1 h-6 w-6']"></feather-icon>
              <div class="mx-2">
                <span class="font-medium block notification-title" :class="[`text-${ntf.categoria}`]" >{{ ntf.titulo }}</span>
                <small >{{ntf.msj + ' ' + ntf.nombre}}</small>
              </div>
            </div>
            <small class="mt-1 whitespace-no-wrap"></small>
          </li>
        </ul>
      </component>

      <div class="
        checkout-footer
        fixed
        bottom-0
        rounded-b-lg
        text-primary
        w-full
        p-2
        font-semibold
        text-center
        border
        border-b-0
        border-l-0
        border-r-0
        border-solid
        d-theme-border-grey-light
        cursor-pointer">
        <span @click="vaciar()">Eliminar</span>
      </div>
    </vs-dropdown-menu>
  </vs-dropdown>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import axios from 'axios'
export default {
  components: {
    VuePerfectScrollbar
  },
  data () {
    return {
      arrayData:[],
      medicamentos:[],
      nombre:'',
      cantidad:'',

      unreadNotifications: [
        {
          index    : 0,
          title    : 'New Message',
          msg      : 'Are your going to meet me tonight?',
          icon     : 'MessageSquareIcon',
          time     : this.randomDate({sec: 10}),
          category : 'primary'
        },
        { index    : 1,
          title    : 'New Order Recieved',
          msg      : 'You got new order of goods.',
          icon     : 'PackageIcon',
          time     : this.randomDate({sec: 40}),
          category : 'success'
        },
        { index    : 2,
          title    : 'Server Limit Reached!',
          msg      : 'Server have 99% CPU usage.',
          icon     : 'AlertOctagonIcon',
          time     : this.randomDate({min: 1}),
          category : 'danger'
        },
        { index    : 3,
          title    : 'New Mail From Peter',
          msg      : 'Cake sesame snaps cupcake',
          icon     : 'MailIcon',
          time     : this.randomDate({min: 6}),
          category : 'primary'
        },
        { index    : 4,
          title    : 'Bruce\'s Party',
          msg      : 'Chocolate cake oat cake tiramisu',
          icon     : 'CalendarIcon',
          time     : this.randomDate({hr: 2}),
          category : 'warning'
        }
      ],
      settings: {
        maxScrollbarLength: 60,
        wheelSpeed: .60
      }
    }
  },
  computed: {
    scrollbarTag () { return this.$store.getters.scrollbarTag }
    
  },
  methods: {
    elapsedTime (startTime) {
      const x        = new Date(startTime)
      const now      = new Date()
      let timeDiff = now - x
      timeDiff    /= 1000

      const seconds = Math.round(timeDiff)
      timeDiff    = Math.floor(timeDiff / 60)

      const minutes = Math.round(timeDiff % 60)
      timeDiff    = Math.floor(timeDiff / 60)

      const hours   = Math.round(timeDiff % 24)
      timeDiff    = Math.floor(timeDiff / 24)

      const days    = Math.round(timeDiff % 365)
      timeDiff    = Math.floor(timeDiff / 365)

      const years   = timeDiff

      if (years > 0) {
        return `Hace ${years + (years > 1 ? ' Años ' : ' Año ')}`
      } else if (days > 0) {
        return `Hace ${days + (days > 1 ? ' Dias ' : ' Dias ')}`
      } else if (hours > 0) {
        return `Hace ${hours + (hours > 1 ? ' Horas ' : ' Hora ')}`
      } else if (minutes > 0) {
        return `Hace ${minutes + (minutes > 1 ? ' Mins ' : ' Min ')}`
      } else if (seconds > 0) {
        return seconds + (seconds > 1 ? ' segundos' : 'Ahora')
      }

      return 'Ahora'
    },


    // Method for creating dummy notification time
    randomDate ({ hr, min, sec }) {
      const date = new Date()

      if (hr) date.setHours(date.getHours() - hr)
      if (min) date.setMinutes(date.getMinutes() - min)
      if (sec) date.setSeconds(date.getSeconds() - sec)

      return date
    },
    vaciar () {
      this.medicamentos = []
    },
    alerta (nombre, cantidad, index) {
      this.nombre = nombre  
      this.cantidad = cantidad
      this.medicamentos.splice(index, 1) 
      this.$vs.notify({
        time:7000,
        title:`Se recomienda la compra del medicamento ${this.nombre}, cuenta con pocas unidades`,
        text:`Cantidad actual: ${this.cantidad}`,
        color:'primary',
        icon:'local_grocery_store',
        position:'top-center'
      })
      //this.popupActive = true
    },
    async StockMedicamentos () {
      const me = this
      const response = await axios.get(
        '/api/medicamento/get?completo=false')
        .then(function (response) {
          const respuesta = response.data
          me.arrayData = respuesta.medicamentos.data
          me.FaltaStock()
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    FaltaStock () {
      const medicamentos = []
      let cont = 0
      this.arrayData.forEach(function (elemento) {
        cont++
        elemento.cantidad = elemento.stock_general
        elemento.nombre = elemento.nombre
        if (elemento.cantidad <= 25) {
          medicamentos.push({idex:cont,
            icon:'AlertOctagonIcon',
            titulo:'Alerta de medicamento',
            msj:'Se requiere comprar el medicamento',
            categoria:'danger',
            nombre:elemento.nombre,
            cantidad:elemento.cantidad})
        }

      })
      this.medicamentos = medicamentos
    }
  },
  mounted () {
    this.StockMedicamentos()
  }
}

</script>

