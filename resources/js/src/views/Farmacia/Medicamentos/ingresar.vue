<template>
 <div>
		<div class="demo-alignment">
			<h2>Medicamentos</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient" icon-pack="feather" icon="icon-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
		</div>

  
    <vs-prompt
      @cancel="close"
      @accept="acceptAlert"
      @close="close"
	  accept-text="Aceptar"
	  cancel-text="Cancelar"
      :is-valid="validName"
	  :title= "titulo"
      :active.sync="activePrompt2">
      <div class="con-exemple-prompt">
        <b></b>

		<small>Nombre</small>
		<vs-input name="nombre" v-validate="'required|max:50'" placeholder="Nombre del Medicamento: " v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />
		<span class="text-danger">{{ errors.first('nombre') }}</span>
		<small>Descripción</small>
    <vs-input name="descripcion" v-validate="'required|max:150'" placeholder="Descripción del Medicamento: " v-model="valMultipe.value2" class="mt-4 mb-2 col-1 w-full" />
		<span class="text-danger">{{ errors.first('descripcion') }}</span>
		<br>
      </div>
		<template>
      <small class="date-label">Categoría</small>
		<v-select name="categoria" v-validate="'required'" label="nombre" :options="categoria" v-model="valMultipe.value4" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		<span class="text-danger">{{ errors.first('categoria') }}</span>
		
    <br>
    <small class="date-label">Casa Médica</small>
		<v-select name="casa" v-validate="'required'" label="nombre" :options="casa_medica" v-model="valMultipe.value5" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
		<span class="text-danger">{{ errors.first('casa') }}</span>
		
    
    <vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>

		</template> 
	</vs-prompt>


	  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import axios from "axios";
//C:\laragon\www\PFV1\resources\js\src\views\components\vuesax\dropdown\Dropdown.vue
import Dropdown from "@/views/components/vuesax/dropdown/Dropdown.vue";
import vSelect from "vue-select";
import { Validator } from 'vee-validate';


const dict = {
  custom: {
    nombre: {
      required: 'El campo nombre de medicamento es requerido',
	    max: 'Este campo solo acepta hasta 50 caracteres',
    },
    descripcion: {
      required: 'El campo descripción es requerido',
	    max: 'Este campo solo acepta hasta 150 caracteres',
    },
	categoria: {
      required: 'El campo categoria es requerido',
	},
	casa:{
	  required: 'El campo casa médica es requerido',
	},
	
  }
}

// register custom messages
Validator.localize('es', dict)
export default {
  components: {
    Dropdown,
    Datepicker,
    vSelect,
  },
  data() {
    return {
      activePrompt2: false,
      val: "",
      valMultipe: {
        value1: "",
		value2: "",
		 fecha: "",
        value4: "",
        value5: "",
      },
	  nino: [],
	  datosNinos:[],
	  tutor: [],
      selected: "",
	  switch2: true,
	  casa_medica:[],
	  categoria:[],
	 
	  disabledDates:{
        to: new Date(Date.now() - 8640000)
      },

	  titulo: "Nuevo medicamento",
	  dateFormat : 'yyyy-MM-dd',
    };
  },
  computed: {
    validName() {
      return this.valMultipe.value1.length > 0 && this.valMultipe.value2.length > 0 && this.valMultipe.value4 != 0 && this.valMultipe.value5 != 0;
    },
  },
  methods: {
    async index2() {
      let me = this;
      const response = await axios
        .get(`/api/casaMedica/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.casa_medica = respuesta.casaMedicas.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    async index3() {
      let me = this;
      const response = await axios
        .get(`/api/categoriaMedicamento/get?completo=false`)
        .then(function(response) {
          var respuesta = response.data;
		  me.categoria = respuesta.categoriaMedicamentos.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    acceptAlert() {
		this.$validator.validateAll().then(result => {
		if(result) {
			axios.post("/api/medicamento/post/", {
			nombre: this.valMultipe.value1,
        	  descripcion: this.valMultipe.value2,
		  	categoria_medicamento_id: this.valMultipe.value4.id,
          	casa_medica_id: this.valMultipe.value5.id,
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
		this.valMultipe.value1 = "";
		this.valMultipe.value2 = "";
		this.valMultipe.value4 = "";
		this.valMultipe.value5 = "";
		this.$emit("cerrado", "Se cerro el formulario");
		this.$vs.notify({
				color:'success',
				title:'Medicamento registrado!',
				text:'La acción se realizo exitósamente'
			});
		}else{
			this.$vs.notify({
					color:'danger',
					title:`Error en validación!`,
					text:'Ingrese correctamente todos los datos'
				})
		}
      })  
    },
    close() {
      this.$vs.notify({
        color: "danger",
        title: "Cerrado",
        text: "Diálogo cerrado!",
      });
    
      this.$emit("cerrado", "Se cerro el formulario");
    },
    clearValMultiple() {
      this.valMultipe.value1 = "";
      this.valMultipe.value2 = "";
      this.valMultipe.value4 = "";
	  this.valMultipe.value5 = "";
	  this.valMultipe.fecha = "";
      this.fechaN = "";
      this.$emit("cerrado", "Se cerro el formulario");
    },
  },
  mounted() {
    this.index2();
    this.index3();
  },
};
</script>