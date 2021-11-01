<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">
      <calendar-view
        ref="calendar"
        :displayPeriodUom="calendarView"
        :show-date="showDate"
        :events="simpleCalendarEvents"
        enableDragDrop
        :eventTop="windowWidth <= 400 ? '2rem' : '3rem'"
        eventBorderHeight="0px"
        eventContentHeight="1.65rem"
        class="theme-default holiday-us-traditional holiday-us-official"
        @click-date="openAddNewEvent"
        @click-event="openEditEvent"
        @drop-on-date="eventDragged">

        <div slot="header" class="mb-4">

          <div class="vx-row no-gutter">

            <!-- Month Name -->
            <div class="vx-col w-1/3 items-center sm:flex hidden">
              <!-- Add new event button -->
              <vs-button icon-pack="feather" icon="icon-plus" @click="promptAddNewEvent(new Date())">Nueva Cita</vs-button>
            </div>

            <!-- Current Month -->
            <div class="vx-col sm:w-1/3 w-full sm:my-0 my-3 flex sm:justify-end justify-center order-last">
              <div class="flex items-center">
                <feather-icon
                  :icon="$vs.rtl ? 'ChevronRightIcon' : 'ChevronLeftIcon'"
                  @click="updateMonth(-1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />

                <span class="mx-3 text-xl font-medium whitespace-no-wrap">{{ getDate(showDate)  }}</span>

                <feather-icon
                  :icon="$vs.rtl ? 'ChevronLeftIcon' : 'ChevronRightIcon'"
                  @click="updateMonth(1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />
              </div>
            </div>

            <div class="vx-col sm:w-1/3 w-full flex justify-center">
              <template v-for="(view, index) in calendarViewTypes">
                <vs-button
                  v-if="calendarView === view.val"
                  :key="String(view.val) + 'filled'"
                  type="filled"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
                <vs-button
                  v-else
                  :key="String(view.val) + 'border'"
                  type="border"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
              </template>

            </div>
          </div>
        </div>
      </calendar-view>
    </div>

    <!-- ADD EVENT -->
    <vs-prompt
        class="calendar-event-dialog"
        title="Nueva cita"
        accept-text= "Aceptar"
        cancel-text= "Cancelar"
        @accept="guardar"
        @cancel="close"
        :is-valid="validForm"
        :active.sync="activePromptAddEvent">

           <!-- ADD EVENT  -->

        
         <div class="my-4">
            <small class="date-label">Fecha</small>
            <datepicker :language="$vs.rtl ? langHe : langEn" :disabledDates="disabledDatesTo" name="end-date" v-model="endDate"></datepicker>
        </div>
        <div class="my-4">
        <small class="date-label">Descripción</small>
        <vs-input name="event-name" v-validate="'required'" class="w-full"  v-model="title"></vs-input>
        </div>
        <div class="my-4">
            <small class="date-label">Tipo de cita</small>
            <v-select  label="nombre" :options="arrayTipoCitas"  v-model="TipoCita" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        </div>
        <div class="my-4">
            <small class="date-label">Médico</small>
            <v-select  label="nombre_completo" :options="arrayPersonal"  v-model="Medico" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        </div>
         <div class="my-4">
            <small class="date-label">Paciente</small>
            <v-select  label="nombre_completo" :options="arrayPaciente"  v-model="Paciente" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        </div> 
        <vs-alert :active="!validForm" color="danger" vs-icon="new_releases" class="mt-4" >
          LLene todos los campos
        </vs-alert>

    </vs-prompt>

    <!-- EDIT EVENT -->
    <vs-prompt
        class="calendar-event-dialog"
        title="Detalles"
        accept-text= "Editar"
        cancel-text = "Cerrar"
        button-cancel = "border"
        @cancel="removeEvent"
        @accept="editEvent"
        :active.sync="activePromptEditEvent">

        <!-- EDIT EVENT -->
        <small class="date-label">Fecha</small>
        <datepicker :language="$vs.rtl ? langHe : langEn" :disabledDates="disabledDatesTo" name="end-date" v-model="endDate"></datepicker>
        <small class="date-label">Descripción</small>
        <vs-input name="descripcion" v-validate="'required'" class="w-full" v-model="descripcion"></vs-input>
						<span class="text-danger">{{ errors.first('descripcion') }}</span><br>
        <small class="date-label">Tipo de cita</small>
        <v-select  label="nombre" :options="arrayTipoCitas"  v-model="TipoCita" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <small class="date-label">Paciente</small>
        <v-select  label="nombre_completo" :options="arrayPaciente"  v-model="Paciente" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
        <small class="date-label">Médico</small>
        <v-select  label="nombre_completo" :options="arrayPersonal"  v-model="Medico" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
    </vs-prompt>
  </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from 'vue-simple-calendar'
import moduleCalendar from '@/store/calendar/moduleCalendar.js'
require('vue-simple-calendar/static/css/default.css')

import Datepicker from 'vuejs-datepicker'
import { es } from 'vuejs-datepicker/src/locale'
import vSelect from 'vue-select'
import axios from 'axios'
import { Validator } from 'vee-validate'
const dict = {
  custom: {
    descripcion: {
	  required: 'El campo user es requerido',
	  max: 'Este campo solo acepta hasta 254 caracteres'
    }
  }
}

Validator.localize('en', dict)
export default {
  components: {
    CalendarView,
    CalendarViewHeader,
    Datepicker,
    vSelect
  },
  data () {
    return {
      showDate: new Date(),
      disabledFrom: false,
      simpleCalendarEvent:'',
      arrayPersonal:[],
      arrayPaciente:[],
      arrayTipoCitas:[],
      fecha2:'',
      arrayCitas:[],
      arrayCitasNuevo:[],
      Medico:'',
      TipoCita:'',
      Paciente:'',
      id: 0,
      title: '',
      startDate: '',
      endDate: '',
      labelLocal: 'none',

      langHe: es,
      langEn: es,

      url: '',
      calendarView: 'month',

      activePromptAddEvent: false,
      activePromptEditEvent: false,

      calendarViewTypes: [
        {
          label: 'Mes',
          val: 'month'
        },
        {
          label: 'Semana',
          val: 'week'
        }
	  ],
	  descripcion:null,
	  medico_id:null,
	  paciente_id:null,
      tipoPaciente:null,
      idT:''
    }
  },
  computed: {
    simpleCalendarEvents () {
      return this.$store.state.calendar.events
    },
    validForm () {
      return this.Medico !== '' && this.TipoCita !== '' && this.Paciente !== '' && this.title !== '' && this.startDate !== '' && this.endDate !== '' && Date.parse(this.endDate) - Date.parse(this.startDate) >= 0 && !this.errors.has('event-url')
    },
    validName () {
      return this.valMultipe.value1.length > 0 && this.valMultipe.value3 != 0 && this.valMultipe.value4 != 0 && this.valMultipe.fecha != ''
    },
    disabledDatesTo () {
      return { to: new Date(this.startDate) }
    },
    disabledDatesFrom () {
      return { from: new Date(this.endDate) }
    },
    calendarLabels () {
      return this.$store.state.calendar.eventLabels
    },
    labelColor () {
      return (label) => {
        if      (label === 'General') return 'success'
        else if (label === 'Desnutricion')     return 'warning'
        else if (label === 'Diabetico') return 'danger'
        else if (label === 'Prenatal')     return 'primary'
      }
    },
    windowWidth () {
      return this.$store.state.windowWidth
    }
  },
  methods: {
    close () {
      this.$vs.notify({
        color: 'danger',
        title: 'Cerrado',
        text: 'Diálogo cerrado!'
      })
    
      this.$emit('cerrado', 'Se cerro el formulario')
    },
    addEvent () {
      const obj = { descripcion: this.title, fecha: this.endDate, label: this.labelLocal}
      obj.classes = `event-${  this.labelColor(this.labelLocal)}`
      this.$store.dispatch('calendar/addEvent', obj)
    },
    updateMonth (val) {
      
      this.showDate = this.$refs.calendar.getIncrementedPeriod(val)
    },
    clearFields () {
      this.descripcion = this.paciente_id = this.medico_id = this.tipoPaciente = ''
      this.id = 0
      this.labelLocal = 'none'
      this.TipoCita = this.Medico = this.Paciente = this.title = ''
    },
    promptAddNewEvent (date) {
      this.disabledFrom = false
      this.addNewEventDialog(date)
    },
    addNewEventDialog (date) {
      this.clearFields()
      this.startDate = date
      this.endDate = date
      this.activePromptAddEvent = true
    },
    openAddNewEvent (date) {
      this.disabledFrom = true
      this.addNewEventDialog(date)
    },
    openEditEvent (event) {
     
	  const e = this.$store.getters['calendar/getEvent'](event.id)
	  this.idT = parseInt(e.url)
      const resultado = this.arrayCitasNuevo.find(cita => cita.id === this.idT)
      if (resultado != undefined) {
        this.fecha2 = new Date(resultado.fecha)
        this.fecha2.setDate(this.fecha2.getDate() + 1)
        this.endDate = this.fecha2
        this.descripcion = resultado.descripcion			
        this.Paciente = resultado.paciente.id
        this.Medico = resultado.clinico.id
        this.TipoCita = resultado.tipo_cita.id
        
        const resultadoPacientes = this.arrayPaciente.find(paciente => paciente.id === this.Paciente)
        if (resultadoPacientes != undefined) {
          this.Paciente = resultadoPacientes     
        }

        const resultadoClinico = this.arrayPersonal.find(clinico => clinico.id === this.Medico)
        if (resultadoClinico != undefined) {
          this.Medico = resultadoClinico     
        }

        const resultadoTipoC = this.arrayTipoCitas.find(tcitas => tcitas.id === this.TipoCita)
        if (resultadoTipoC != undefined) {
          this.TipoCita = resultadoTipoC     
        }
        this.activePromptEditEvent = true
      }
	     return this.idT
    },
    editEvent () {
      const me = this
      this.$validator.validateAll().then(result => {
        if (result) {
          /*const obj = { id: this.id, title: this.title, startDate: this.startDate, endDate: this.endDate, label: this.labelLocal, url: this.url }
      obj.classes = `event-${  this.labelColor(this.labelLocal)}`
      this.$store.dispatch('calendar/editEvent', obj)*/
          axios.put('/api/cita/update/', {
            id:this.idT,
            fecha: this.formatoFecha(this.endDate),
            descripcion: this.descripcion,
            clinico_id: this.Medico.id,
            paciente_id: this.Paciente.id,
            tipo_cita_id: this.TipoCita.id
		   
          }).then(function (response) {
            console.log(response)
            me.$store.state.calendar.events = []
            me.Citas()
            me.$vs.notify({
              color:'success',
              title:'Cita registrado!',
              text:'La cita se actualizo exitósamente'
            })
        
          })
            .catch(function (error) {
              console.log(error)
              me.$vs.notify({
                color:'Danger',
                title:'Error!',
                text:'Error al actualizar la cita'
              })
            })
          /**/
          
        } else {
          this.$vs.notify({
            color:'danger',
            title:'Error en validación!',
            text:'Ingrese todos los campos correctamente'
          })
        }
      })
    },
    removeEvent () {
      this.$store.dispatch('calendar/removeEvent', this.id)
      this.$vs.notify({
        color: 'danger',
        title: 'Cerrado',
        text: 'Diálogo cerrado!'
      })
    },
    eventDragged (event, date) {
      this.$store.dispatch('calendar/eventDragged', {event, date})
    }, 
    formatoFecha (datetime) {
      const date = new Date(datetime)
      const dateString = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`
      return dateString
    },
    getDate (datetime) {
      const MESES = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
      ]
      
      const date = new Date(datetime)
      const dateString = `${MESES[date.getMonth()]}  ${date.getFullYear()}`
      return dateString
    },
    traerNombre (tabla) {
      tabla.forEach(function (valor, indice, array) {
        valor.nombres = valor.datos.nombres
        valor.apellidos = valor.datos.apellidos
        valor.nombre_completo = `${valor.nombres  } ${  valor.apellidos}`
    
      }) 
      return tabla
	  },
    async PersonalMedico () { //async para que se llame cada vez que se necesite
      const me = this
      const response = await axios.get(
        '/api/clinico/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.arrayPersonal = respuesta.clinicos.data
          me.arrayPersonal = me.traerNombre(me.arrayPersonal)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async indexPacientes () {
	  const me = this
      const response = await axios.get(
        '/api/paciente/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.arrayPaciente = respuesta.pacientes.data
          me.arrayPaciente = me.traerNombre(me.arrayPaciente)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async TipoCitas () {
	  const me = this
      const response = await axios.get(
        '/api/tipoCita/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.arrayTipoCitas = respuesta.tipoCitas.data
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    async Citas () {
      const me = this
      const response = await axios.get(
        '/api/cita/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
		  me.arrayCitasNuevo = respuesta.citas.data
		  me.exportarCitas(me.arrayCitasNuevo)
		  
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    exportarCitas (tabla) {
      const citas = []
      const objTemporal = []
      for (const x in tabla) {
        const fechaT = tabla[x].fecha
        let diaT = parseInt(fechaT.split('-', 3)[2]) + 1
        diaT = diaT < 11 ? `0${  String(diaT)}` : String(diaT)
        //let fechaInicio = fechaT.split('-',3)[0] + fechaT.split('-',3)[1] + '-' + fechaT.split('-',3)[2] + 'T00:00:01.410Z'
        //let fechaFinal = fechaT.split('-',3)[0] + fechaT.split('-',3)[1] + '-' + fechaT.split('-',3)[2] + 'T00:00:01.410Z'
        const fechaInicio = `${fechaT.split('-', 3)[0]}-${  fechaT.split('-', 3)[1]  }-${  fechaT.split('-', 3)[2]  }T00:00:01.410Z`
        const fechaFinal = `${fechaT.split('-', 3)[0]}-${  fechaT.split('-', 3)[1]  }-${  fechaT.split('-', 3)[2]  }T23:59:00.410Z`
        citas.push({ title: `${tabla[x].datos_paciente[0].nombres  } ${  tabla[x].datos_paciente[0].apellidos}`, startDate:fechaInicio, endDate: fechaFinal, label: 'business', url: String(tabla[x].id)})
      }
      for (const x in citas) {
        citas[x].classes = `event-${'success'}`
        this.$store.dispatch('calendar/addEvent', citas[x])
      }	  
    },
    guardar () {
      const me = this
      axios.post('/api/cita/post/', {
        descripcion:this.title,
        fecha: this.formatoFecha(this.endDate),
        clinico_id: this.Medico.id,
        paciente_id: this.Paciente.id,
        tipo_cita_id: this.TipoCita.id
      }).then(function (response) {
        console.log(response)
         me.$store.state.calendar.events = []
         me.Citas()
        me.$vs.notify({
          color:'success',
          title:'Cita',
          text:'Cita registrada correctamente'
        })
      })
        .catch(function (error) {
          console.log(error)
          alert('Error al ingresar')
          me.$vs.notify({
            color:'danger',
            title:'Error',
            text:'Error al registrar cita'
          })
        })
      
    }
    
  },
  created () {
	  this.$store.registerModule('calendar', moduleCalendar)
    this.$store.dispatch('calendar/fetchItems')
    this.$store.dispatch('calendar/fetchEventLabels')
    this.Citas()
  },
  beforeDestroy () {
    this.$store.unregisterModule('calendar')
  },
  mounted () {
    this.PersonalMedico()
    this.indexPacientes()
    this.TipoCitas()
    //this.Citas()
  }
}
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";
</style>
