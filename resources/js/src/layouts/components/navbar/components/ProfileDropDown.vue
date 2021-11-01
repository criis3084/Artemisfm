<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.displayName">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ nombre_usuario }}</p>
      <small> {{id_rol == 1 ? 'Directora': id_rol == 2 ? 'Farmacéutica': id_rol == 3 ? 'Secretaria'  :id_rol==4 ? 'Tutora': id_rol==5 ? 'Laboratorista': id_rol==6 ? 'Farmaceutica':'Medico'}} </small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">
        <img key="onlineImg" :src="imagen_perfil" width="40" height="40" class="rounded-full shadow-md cursor-pointer block" />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Cerrar Sesión</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>

import Auth from '../../../../services/auth.js';
import Roles from '../../../../services/roles.js';
import Ls from '../../../../services/ls';

export default {
  data () {
    return {
		id_rol:null,
		imagen_perfil:null,
		nombre_usuario:null,
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    logout () {
      Roles.logout()
      Auth.logout().then(() => {
        location.replace('/pages/login');
      });

      
/* 
      // if user is logged in via auth0
      if (this.$auth.profile) this.$auth.logOut()

      // If JWT login
      if (localStorage.getItem('auth.token')) {
        localStorage.removeItem('auth.token')
        this.$router.push('/pages/login').catch(() => {})
      }

      // Change role on logout. Same value as initialRole of acj.js
      this.$acl.change('admin')
      localStorage.removeItem('userInfo')

      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$router.push('/pages/login').catch(() => {}) */
    }
  },
  mounted() {
	  this.id_rol = parseInt(Ls.get('auth.roles'));
	  this.imagen_perfil = Ls.get('auth.imagen_perfil').replace(/['"]+/g, '');
	  this.nombre_usuario =Ls.get('auth.nombre_usuario').replace(/['"]+/g, '');
  },
}
</script>
