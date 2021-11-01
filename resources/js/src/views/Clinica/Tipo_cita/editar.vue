<template>
	<div>
		<vs-prompt
			@cancel="close"
			@accept="actualizarEscuela"
			@close="close"
			accept-text="Aceptar"
			cancel-text="Cancelar"
			:is-valid="copia"
			:title= "titulo"
			:active.sync="identificador"
		>
			<div class="con-exemple-prompt">
				<b></b> 
				<small>Tipo de cita</small>
				<vs-input name="nombre" v-validate="'required|max:35'" placeholder="Nombre del tipo de cita: " v-model="nombreT" class="mt-4 mb-2 col-1 w-full" />
				<span class="text-danger">{{ errors.first('nombre') }}</span><br>
				
				<small>Descripción</small>
				<vs-input name="descripcion" v-validate="'required|max:150'" placeholder="Descripción" v-model="descripcionT" class="mt-4 mb-2 col-1 w-full" />
				<span class="text-danger">{{ errors.first('descripcion') }}</span><br>
				
				<!-- <vs-alert color="danger" vs-icon="new_releases" class="mt-4" >
					LLene todos los campos
				</vs-alert> -->
			</div>
		</vs-prompt>
	</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import axios from 'axios'
//C:\laragon\www\PFV1\resources\js\src\views\components\vuesax\dropdown\Dropdown.vue
import Dropdown from '@/views/components/vuesax/dropdown/Dropdown.vue'
import vSelect from 'vue-select'
import { Validator } from 'vee-validate';
const dict = {
  custom: {
	nombre:{
		required: 'El campo nombre de tipo de cita es requerido',
		max: 'Este campo solo acepta hasta 35 caracteres',
	},
	descripcion:{
		required: 'El campo descripción es requerido',

		max: 'Este campo solo acepta hasta 150 caracteres',
	},
  }
};
Validator.localize('en', dict);
export default {
	props:{
		identificador:{
			default:false
		},
	    id:{default: 0},
		nombre:String,
		descripcion:String,
	},
	components: {
	Dropdown,
	Datepicker,
	vSelect,
  },
  data () {
	return {
	  val:'',
	  valMultipe:{
		value1:'',
		value2:''
	  },
	  idT:0,
      nombreT:'',
      descripcionT:'',
	  selected: '',
	  switch2:true,
	  titulo:'Actualizar tipo de cita'
	}
  },
  computed:{
	copia() {
        this.nombreT =this.$props.nombre;
        this.descripcionT =this.$props.descripcion;
		this.idT =this.$props.id;
		return true;	
	}
  },
  methods:{
	actualizarEscuela () {
this.$validator.validateAll().then(result => {
if(result) {
	axios.put("/api/tipoCita/update/",{
		id:this.idT,
        nombre:this.nombreT,
        descripcion:this.descripcionT,
		}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
			console.log(error)
		});
		this.$emit('cerrado','Se cerró el formulario');
		this.$vs.notify({
				color:'success',
				title:'Actualización registrada!',
				text:'La acción se realizo exitósamente'
		})
}
	else{
		this.$vs.notify({
		color:'danger',
		title:'Error en validación!',
		text:'Ingrese todos los campos correctamente'
		});
	}
})
	},
	close () {
		this.$emit('cerrado','Se cerró el formulario');
		this.$vs.notify({
			color:'danger',
			title:'Cerrado',
			text:'Diálogo cerrado!'
	  	})
	},
	clearValMultiple () {
		this.$emit('cerrado','Se cerró el formulario');
	},
  },
  mounted(){
  },
}
</script>