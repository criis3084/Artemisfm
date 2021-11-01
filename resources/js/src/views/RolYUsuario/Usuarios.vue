<template>
 <vx-card>
     
					<div class = "demo-alignment">
						<h2>Usuarios</h2>
						<vx-tooltip text = "Agregar nuevo registro"> <vs-button radius type = "gradient" icon = "person_add"  color = "primary" size = "large" @click="agregar"></vs-button>  </vx-tooltip>
					</div>
                   
					<vs-divider position="right">ARTEMIS&#174;</vs-divider>
                    <div class = "demo-alignment">
                        <small class="date-label">Filtrar por rol</small>
                         <v-select class="vx-col md:w-1/4 w-full mt-5" label="nombre" :options="Roles" @input="buscarPorRol" v-model="rol" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                         <vs-button icon-pack = "feather" icon = "icon-refresh-cw" color="primary" type="border" @click="VerTodos"> Ver todos</vs-button>
                    </div>
		<vs-prompt title="Exportar a Excel" class="export-options" @cancle="clearFields" @accept="exportToExcel" accept-text="Exportar" cancel-text="Cancelar" @close="clearFields" :active.sync="activePrompt">
        <vs-input v-model="fileName" placeholder="Nombre de archivo" class="w-full" />
        <v-select v-model="selectedFormat" :options="formats" class="my-4" />
        <div class="flex">
          <span class="mr-4">Ancho automatico de celda:</span>
          <vs-switch v-model="cellAutoWidth">Cell Auto Width</vs-switch>
        </div>
			</vs-prompt>

			<vs-table stripe title="Personal" pagination max-items="7" search :data="arrayPersonal" noDataText="No hay datos disponibles">
	   <template slot="header">
          <vs-button @click="activePrompt=true">Exportar</vs-button>
        </template>
				<template slot="thead">
                    <vs-th>Ver</vs-th>
					<!-- <vs-th>Id</vs-th> -->
                    <vs-th>Nombre</vs-th>
					<vs-th>Rol</vs-th>
                    <vs-th>Teléfono</vs-th>
                    <vs-th>Estado</vs-th>
					<vs-th>Acciones</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td>
						    <vx-tooltip text="Información Completa"> <vs-button radius color="dark" type="flat" icon="visibility" size="large" @click="$router.push('/admin/verUsuario/'+data[indextr].id)"></vs-button></vx-tooltip>			
					    </vs-td>
						<!-- <vs-td :data="data[indextr].id">{{data[indextr].id}}</vs-td> -->

						<vs-td>
								<div class="flex items-center">
								<vs-avatar :src="data[indextr].imagen_perfil" color="primary" :text="data[indextr].nombres" class="flex-shrink-0 mr-2" size="30px"/>
								{{data[indextr].nombres + ' '+ data[indextr].apellidos}}
								</div>
						</vs-td>
        			    <vs-td :data="data[indextr].especialidad">{{data[indextr].rol.nombre}}</vs-td>
                        <vs-td :data="data[indextr].telefono">{{data[indextr].numero_telefono}}</vs-td>
						<vs-td>
							<vs-switch color="success" v-model="data[indextr].estado" @click="abrirDialog(data[indextr].id, data[indextr].estado)">
								<span slot="on" >Activo</span>
								<span slot="off">Desactivo</span>
							</vs-switch>
						</vs-td>
						<vs-td>
							<vx-tooltip text="Editar"> <vs-button radius color="dark" type="flat" icon="edit" size="large" @click="$router.push('/admin/editarUsuario/'+data[indextr].id)"> </vs-button>  </vx-tooltip>
						</vs-td>
                        
					</vs-tr>
				</template>
			</vs-table>
		</vx-card>
</template>

<script>
import axios from 'axios'
import vSelect from 'vue-select'


export default {
  data () {
    return {
      arrayData:[],
      Roles:[],
      arrayPersonal:[],
      rol:[],
      activePrompt: false,
	  fileName: '',
	  listadoTutorias:[],
      formats:['xlsx'],
      cellAutoWidth: true,
	  selectedFormat: 'xlsx',
	  headerVal: ['id', 'nombres', 'apellidos', 'CUI', 'numero_telefono', 'direccion'],
	  headerTitle: ['Id', 'Nombre', 'Apellidos', 'No. DPI', 'Telefono', 'Direccion']
    }
  },
  components:{
    vSelect
  },
  methods:{
    agregar () {
      this.$router.push('/admin/nuevoUsuario')
    },
    abrirDialog (id, estado) {
      let titulo = ''
      let color = ''

      if (estado === 0 || estado === false) {
        // cambiar de color al boton
        color = 'success'
        titulo = 'Confirmar activación'
      } else if (estado === 1 || estado === true) {
        color = 'danger'
        titulo = 'Confirmar desactivación'
      }
		
      this.id = id
      this.estado = estado

      this.$vs.dialog({
        type:'confirm',
        color: `${color}`,
        title: `${titulo}`,
        text: '¿Está seguro de llevar a cabo esta acción?',
        accept: this.cambiarEstado,
        cancel: this.close,
			acceptText: 'Aceptar',
			cancelText: 'Cancelar',
      })
    },
    cambiarEstado (color) {
      let titulo = ''
		
      if (this.estado === 0 || this.estado === false) {
        titulo = 'Activado exitósamente'
        axios.put('/api/user/activar', {
          id: this.id
        })
          .then(function (response) {
            console.log(response.data.message)
          })
          .catch(function (error) {
            console.log(error.response.data.message)
          })
      } else if (this.estado === 1 || this.estado === true) {
        titulo = 'Desactivado exitósamente'
        axios.put('/api/user/desactivar', {
          id: this.id
        })
          .then(function (response) {
            console.log(response.data.message)
          })
          .catch(function (error) {
            console.log(error.response.data.message)
          })
      }
      this.$vs.notify({
        color:'success',
        title:`${titulo}`,
        text:'La acción se realizó exitósamente'
      })
    },
    close () {
      	const titulo = 'Cancelado'
      	const texto = 'Cambio de estado cancelado'
      this.$vs.notify({
        color:'danger',
        title:`${titulo}`,
        text:`${titulo}`
      })
      this.VerTodos()
    },
    async VerTodos () { //async para que se llame cada vez que se necesite
      const me = this
      const response = await axios.get(
        '/api/user/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.arrayPersonal = respuesta.users.data
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    exportToExcel () {
        import('@/vendor/Export2Excel').then(excel => {
          const list = this.arrayPersonal
          const data = this.formatJson(this.headerVal, list)
          excel.export_json_to_excel({
            header: this.headerTitle,
            data,
            filename: this.fileName,
            autoWidth: this.cellAutoWidth,
            bookType: this.selectedFormat
          })

          this.clearFields()
        })
    },
    formatJson (filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        // Add col name which needs to be translated
        // if (j === 'timestamp') {
        //   return parseTime(v[j])
        // } else {
        //   return v[j]
        // }

        return v[j]
      }))
    },
    clearFields () {
      this.filename = ''
      this.cellAutoWidth = true
      this.selectedFormat = 'xlsx'
    },
    traerNombre (tabla) {
      tabla.forEach(function (valor, indice, array) {
        valor.nombres = valor.datos.nombres
        valor.apellidos = valor.datos.apellidos
        valor.numero_telefono = valor.datos.numero_telefono
        valor.imagen_perfil = valor.datos.imagen_perfil
        valor.especialidad = valor.profesion.nombre
      }) 
      return tabla
    },
    async importarRoles () { //async para que se llame cada vez que se necesite
      const me = this
      const response = await axios.get(
        '/api/rol/get?completo=true')
        .then(function (response) {
          const respuesta = response.data
          me.Roles = respuesta.roles.data
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    
    async buscarPorRol () {
      if (this.rol !== null) {
        const id_recibido = this.rol.id
        const me = this
        const response = await axios.get(
          `/api/user/get?&criterio=rol_id&buscar=${id_recibido}&completo=true`)
          .then(function (response) {
            const respuesta = response.data
            me.arrayPersonal = respuesta.users.data
          })
          .catch(function (error) {
            console.log(error)
          })
      }
    }

  },
  computed:{

  },
  watch:{

  },
  mounted () {
    this.importarRoles()
    this.VerTodos()
  }
}
</script>