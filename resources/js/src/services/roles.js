import Ls from './ls'
import axios from 'axios'

export default {
  async login (loginData) {
      try {
      let response = await axios.post('/api/auth/roles', loginData)
	   Ls.set('auth.roles', JSON.stringify(response.data.u[0].rol.id)) 
	   Ls.set('auth.imagen_perfil', JSON.stringify(response.data.u[0].imagen_perfil)) 
	   Ls.set('auth.nombre_usuario', JSON.stringify(response.data.u[0].user)) 
	   Ls.set('auth.id_usuario', JSON.stringify(response.data.u[0].id)) 
      //toastr['success']('Sesión iniciada', 'Éxito')
       return 'todo bien'
    } catch (error) {
      if (error.response.status === 401) {
        console.log(error)
       // toastr['error']('Credenciales incorrectas', 'Error')
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message)
      }
    } 
  },

  async logout () {
    try {
      //await axios.get('/api/auth/logout')

      Ls.remove('auth.roles')
      Ls.remove('auth.imagen_perfil')
      Ls.remove('auth.id_usuario')
      Ls.remove('auth.nombre_usuario')
      //toastr['success']('Sesión finalizada', 'Éxito')
    } catch (error) {
      console.log('Error', error.message)
    }
  }
}