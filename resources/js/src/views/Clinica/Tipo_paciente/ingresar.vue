<template>
 <div>
		<div class="demo-alignment">
			<h2>Tipos de pacientes</h2>
			<vx-tooltip text="Agregar nuevo registro"><vs-button radius type="gradient"  icon-pack="feather" icon="icon-plus" @click="activePrompt2 = true" color="primary" size='large' ></vs-button> </vx-tooltip>
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
			<small>Tipo de paciente</small>
		<vs-input placeholder="Tipo de Paciente" v-model="valMultipe.value1" class="mt-4 mb-2 col-1 w-full" />

		
      </div>

		<template>
			<small>Descripción</small>

		<vs-input placeholder="Descripción" v-model="valMultipe.value2" class="mt-4 mb-2 col-1 w-full" />
		</template> 
        <vs-alert :active="!validName" color="danger" vs-icon="new_releases" class="mt-4" >
			LLene todos los campos
		</vs-alert>
	</vs-prompt>


	  </div>
</template>

<script>
import axios from 'axios'

export default {
  components: {
	
  },
  data () {
	return {
	  activePrompt2:false,
	  val:'',
	  valMultipe:{
		value1:'',
		value2:''
	  },
	 aldeasT: [],
	 selected: '',
	  switch2:true,
	  titulo:'Nuevo tipo de paciente'
	}
  },
  computed:{
	validName () {
	  return this.valMultipe.value1.length > 0 && this.valMultipe.value2.length > 0 
	}
  },
  methods:{
	async index2(){ //async para que se llame cada vez que se necesite
		let me = this;
			const response = await axios.get(`/api/tipoPaciente/get?completo=true`)
		.then(function (response) {
			var respuesta= response.data;
			me.tipoPacientesT = respuesta.tipoPacientes.data;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	acceptAlert () {
	axios.post("/api/tipoPaciente/post/",{
		nombre:this.valMultipe.value1,
		descripcion:this.valMultipe.value2
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		})
		
		let titulo = 'Tipo de paciente registrado!';
			this.$vs.notify({
			color:'success',
			title:`${titulo}`,
			text:'La acción se realizo exitósamente'
			});
	   this.valMultipe.value1 = '';
	    this.valMultipe.value2 = '';
	  this.$emit('cerrado','Se cerro el formulario');
	},
	close () {
	  this.$vs.notify({
		color:'danger',
		title:'Cerrado',
		text:'Cerró el formulario!'
	  })
	  this.$emit('cerrado','Se cerro el formulario');
	},
	clearValMultiple () {
	  this.valMultipe.value1 = ''
	  this.valMultipe.value2 = ''
	  this.$emit('cerrado','Se cerro el formulario');
	},
	saveProduct(){
	axios.post("/api/tipoPaciente/post/",{
		nombre:this.valMultipe.value1,
		descripcion:this.valMultipe.value2
	}).then(function(response) {
			console.log(response)
		})
		.catch(function(error) {
		console.log(error)
		});
		
	},
	mostrar(id){
		console.log($id);
	}

  },
  mounted(){
    this.index2();
  }

}
</script>