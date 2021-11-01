<template>
  <div>
    <vs-input
    
        data-vv-validate-on="blur"
        name="email"
        icon-no-border
        icon="icon icon-user"
        icon-pack="feather"
        label-placeholder="Usuario"
        v-model="loginData.user"
        class="w-full"/>
    <span class="text-danger text-sm">{{ errors.first('email') }}</span>

    <vs-input
        data-vv-validate-on="blur"
        v-validate="'required|min:6|max:25'"
        type="password"
        name="password"
        icon-no-border
        icon="icon icon-lock"
        icon-pack="feather"
        label-placeholder="Contraseña"
        v-model="loginData.password"
        class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

    <div class="flex flex-wrap justify-between my-5">
       <!--   <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Recuerdame</vs-checkbox>
        <router-link to="/pages/forgot-password">¿Olvidó su contraseña?</router-link> -->
    </div>
    <div class="flex flex-wrap justify-between mb-3">
      <!-- <vs-button  type="border" @click="registerUser">Register</vs-button> -->
      <vs-button :disabled="!validateForm" @click="validateBeforeSubmit">Login</vs-button>
      
    </div>
  </div>
</template>

<script>

import Auth from '../../../services/auth.js';
import Roles from '../../../services/roles.js';


export default {
  data () {
    return {      
      checkbox_remember_me: false,
      loginData: {
        
      }
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.loginData.user !== '' && this.loginData.password !== ''
    }
  },
  methods: {
    checkLogin () {
      // If user is already logged in notify
      if (this.$store.state.auth.isUserLoggedIn()) {

        // Close animation if passed as payload
        // this.$vs.loading.close()

        this.$vs.notify({
          title: 'Login Attempt',
          text: 'You are already logged in!',
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'warning'
        })

        return false
      }
      return true
    },
    /* loginJWT () {

      if (!this.checkLogin()) return

      // Loading
      this.$vs.loading()

      const payload = {
        checkbox_remember_me: this.checkbox_remember_me,
        userDetails: {
          user: this.user,
          password: this.password
        }
      }

      this.$store.dispatch('auth/loginJWT', payload)
        .then(() => { this.$vs.loading.close() })
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
    }, */

    validateBeforeSubmit () {
      if (!this.checkLogin()) return

     

      else {
        this.$vs.loading();
        Roles.login(this.loginData).then((res) => {
          if(res) {
            Auth.login(this.loginData).then((res) => {
              if (res) {

				//this.$router.push('/bienvenido')
				location.replace('/bienvenido');
                this.$vs.loading.close();
              }
              
            })
          }
          else{
                this.$vs.loading.close();
                this.$vs.notify({
                  title: 'Intento de Login ha fracasado!',
                  text: 'Credenciales incorrectas',
                  iconPack: 'feather',
                  icon: 'icon-alert-circle',
                  color: 'warning'
                })
              }
        })
      }
    },

    /* registerUser () {
      if (!this.checkLogin()) return
      this.$router.push('/pages/register').catch(() => {})
    } */
  }
}

</script>

