<template>
 <div >
     <h1>Roles en el sistema</h1>
     <vs-divider position="right">ARTEMIS&#174;</vs-divider>
     <div class="vx-row">
         <div class="vx-col w-1/2 md:w-1/3 xl:w-1/3" v-for="(rol, index) in arrayData" :key="index" >
                <statistics-card-line
                  hideChart
                  class="mb-base"
                  icon="UsersIcon"
                  :statistic="rol.nombre"
                  statisticTitle="Rol" 
                  />
         </div>
     </div>
 </div>
</template>

<script>
import StatisticsCardLine from '@/components/statistics-cards/StatisticsCardLine.vue'
import axios from 'axios'
export default {
  components: {
    StatisticsCardLine
  },
  data () {
    return {
      arrayData:[]
    }
  },
  methods:{
    exportToExcel () {
      import('@/vendor/Export2Excel').then(excel => {
        const list = this.arrayData
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
    async index () { //async para que se llame cada vez que se necesite
      const me = this
      const response = await axios.get('/api/rol/get?completo=true')
        .then(function (response) {			
          const respuesta = response.data
          me.arrayData = respuesta.roles.data
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

<style>

</style>