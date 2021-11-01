/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


//Aqui en el router es donde se montan todos los componentes de Vue que se estaran utilizando.

import Vue from 'vue'
import Router from 'vue-router'
import auth from '@/auth/authService'

import firebase from 'firebase/app'
import 'firebase/auth'

Vue.use(Router)

import Ls from '../src/services/ls';
var id = 0;

id = parseInt(Ls.get('auth.roles'));

const router = new Router({
	mode: 'history',
	base: '/',
	scrollBehavior () {
	return { x: 0, y: 0 }
	},
	routes: 
		id == 1 ?
		[
			{
				// =============================================================================
				// MAIN LAYOUT ROUTES
				// =============================================================================
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					// =============================================================================
					// Theme Routes
					// =============================================================================
					{
					path: '/',
					redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					

					// =============================================================================
					// =============================================================================
					// SALUD
					// =============================================================================
					// =============================================================================
					
					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					
					//paciente

					{
						path: '/clinica/pacientes',
						name: 'clinica-pacientes',
						component: () => import('./views/Clinica/Pacientes/pacientes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{			
						path: '/ingresar/paciente',
						name: 'ingresar-paciente',
						component: () => import('./views/Clinica/Pacientes/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/paciente/:id',
						name: 'ver-paciente',
						component: () => import('./views/Clinica/Pacientes/ver_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/paciente/:id',
						name: 'editar-paciente',
						component: () => import('./views/Clinica/Pacientes/editar_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/beneficios/:id',
						name: 'ver-beneficios',
						component: () => import('./views/Clinica/Pacientes/ver_beneficios.vue'),
						meta: {
						rule: 'editor'
						}
					},
					
					// =============================================================================
					// Rol y Usuario
					// =============================================================================
					{
						path: '/admin/roles',
						name: 'roles',
						component: () => import('./views/RolYUsuario/roles.vue'),
						meta: {
						rule: 'admin'
						}
					},
					
					{
						path: '/admin/usuarios',
						name: 'usuarios',
						component: () => import('./views/RolYUsuario/Usuarios.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/nuevoUsuario',
						name: 'nuevoUsuario',
						component: () => import('./views/RolYUsuario/ingresar.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/editarUsuario/:id',
						name: 'editarUsuario',
						component: () => import('./views/RolYUsuario/editar.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/verUsuario/:id',
						name: 'verUsuario',
						component: () => import('./views/RolYUsuario/verUsuario.vue'),
						meta: {
						rule: 'admin'
						}
					},

				]
			},
			// =============================================================================
			// FULL PAGE LAYOUTS
			// =============================================================================
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 2 ?
		[
			{
				// =============================================================================
				// MAIN LAYOUT ROUTES
				// =============================================================================
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					// =============================================================================
					// Theme Routes
					// =============================================================================
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},

					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					
					//paciente

					{
						path: '/clinica/pacientes',
						name: 'clinica-pacientes',
						component: () => import('./views/Clinica/Pacientes/pacientes.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
					{			
						path: '/ingresar/paciente',
						name: 'ingresar-paciente',
						component: () => import('./views/Clinica/Pacientes/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/paciente/:id',
						name: 'ver-paciente',
						component: () => import('./views/Clinica/Pacientes/ver_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/paciente/:id',
						name: 'editar-paciente',
						component: () => import('./views/Clinica/Pacientes/editar_paciente.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/beneficios/:id',
						name: 'ver-beneficios',
						component: () => import('./views/Clinica/Pacientes/ver_beneficios.vue'),
						meta: {
						rule: 'editor'
						}
					},
					
				]
			},

			
			
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 3 ?
		[
			{
				path: '/',
				redirect: '/bienvenido'
			},
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},

					
					{
						path: '/admin/roles',
						name: 'roles',
						component: () => import('./views/RolYUsuario/roles.vue'),
						meta: {
						rule: 'admin'
						}
					},
					
					{
						path: '/admin/usuarios',
						name: 'usuarios',
						component: () => import('./views/RolYUsuario/Usuarios.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/nuevoUsuario',
						name: 'nuevoUsuario',
						component: () => import('./views/RolYUsuario/ingresar.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/editarUsuario/:id',
						name: 'editarUsuario',
						component: () => import('./views/RolYUsuario/editar.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/admin/verUsuario/:id',
						name: 'verUsuario',
						component: () => import('./views/RolYUsuario/verUsuario.vue'),
						meta: {
						rule: 'admin'
						}
					},
					
				]
			},
			

			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 4 ?
		[
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 5 ?
		[
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
				
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 6 ?
		[
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 

				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]: id == 7 ?
		[
			{
				path: '/',
				redirect: '/bienvenido'
			},
			{
				path: '',
				component: () => import('./layouts/main/Main.vue'),
				children: 
				[
					{
						path: '/',
						redirect: '/bienvenido'
					},
					{
						path: '/bienvenido',
						name: 'inicio',
						component: () => import('./views/pages/Bienvenido.vue'),
						meta: {
							rule: 'editor'
						}
					},
					// =============================================================================
					// =============================================================================
					// SALUD
					// =============================================================================
					// =============================================================================
					
					// FARMACIA
					// =============================================================================
					{
						path: '/farmacia/medicamentos',
						name: 'farmacia-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/medicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/salida/medicamentos',
						name: 'salida-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/salidamedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/ingreso/medicamentos',
						name: 'ingreso-medicamentos',
						component: () => import('./views/Farmacia/Medicamentos/ingresomedicamentos.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{			
						path: '/ingresar/ingresomedi',
						name: 'ingresar-ingresomedi',
						component: () => import('./views/Farmacia/Medicamentos/formularioingresomedi.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/salida/:id',
						name: 'ver-detalleSalida',
						component: () => import('./views/Farmacia/Medicamentos/detallesalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/salidamedi',
						name: 'ingresar-salidamedi',
						component: () => import('./views/Farmacia/Medicamentos/ingresarsalida.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/ver/entrada/:id',
						name: 'ver-detalleEntrada',
						component: () => import('./views/Farmacia/Medicamentos/detalleentrada.vue'),
						meta: {
							rule: 'editor'
						}
					},
					{
						path: '/farmacia/proveedores',
						name: 'farmacia-proveedores',
						component: () => import('./views/Farmacia/Proveedores/proveedores.vue'),
						meta: {
						rule: 'admin'
						}
					},
					// =============================================================================
					// PROVEEDOR
					// =============================================================================

					{
						path: '/ver/proveedor/:id',
						name: 'ver-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ver.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{			
						path: '/ingresar/proveedor',
						name: 'ingresar-proveedor',
						component: () => import('./views/Farmacia/Proveedores/ingresar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/editar/proveedor/:id',
						name: 'datos-proveedor',
						component: () => import('./views/Farmacia/Proveedores/editar.vue'),
						meta: {
						rule: 'editor'
						}
					},
					// =============================================================================
					// CASAS
					// =============================================================================

					{
						path: '/farmacia/casas',
						name: 'farmacia-casas',
						component: () => import('./views/Farmacia/Casa_medica/casaMedica.vue'),
						meta: {
						rule: 'admin'
						}
					},
					{
						path: '/farmacia/categoria',
						name: 'farmacia-categoria',
						component: () => import('./views/Farmacia/Categorias/categorias.vue'),
						meta: {
						rule: 'admin'
						}
					}, 
				
				]
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]:[
			{
				path: '/',
				redirect: '/pages/login'
			},
			{
				path: '',
				component: () => import('@/layouts/full-page/FullPage.vue'),
				children: [
					// =============================================================================
					// PAGES
					// =============================================================================
					{
						path: '/callback',
						name: 'auth-callback',
						component: () => import('@/views/Callback.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/login',
						name: 'page-login',
						component: () => import('@/views/pages/login/Login.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/register',
						name: 'page-register',
						component: () => import('@/views/pages/register/Register.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/forgot-password',
						name: 'page-forgot-password',
						component: () => import('@/views/pages/ForgotPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/reset-password',
						name: 'page-reset-password',
						component: () => import('@/views/pages/ResetPassword.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/lock-screen',
						name: 'page-lock-screen',
						component: () => import('@/views/pages/LockScreen.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/comingsoon',
						name: 'page-coming-soon',
						component: () => import('@/views/pages/ComingSoon.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-404',
						name: 'page-error-404',
						component: () => import('@/views/pages/Error404.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/error-500',
						name: 'page-error-500',
						component: () => import('@/views/pages/Error500.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/not-authorized',
						name: 'page-not-authorized',
						component: () => import('@/views/pages/NotAuthorized.vue'),
						meta: {
						rule: 'editor'
						}
					},
					{
						path: '/pages/maintenance',
						name: 'page-maintenance',
						component: () => import('@/views/pages/Maintenance.vue'),
						meta: {
						rule: 'editor'
						}
					}
				]
			},
			// Redirect to 404 page, if no match found
			{
				path: '*',
				redirect: '/pages/error-404'
			}
		]
})

router.afterEach(() => {
	// Remove initial loading
	const appLoading = document.getElementById('loading-bg')
	if (appLoading) {
	appLoading.style.display = 'none'
	}
})

router.beforeEach((to, from, next) => {
	firebase.auth().onAuthStateChanged(() => {

	// get firebase current user
	const firebaseCurrentUser = firebase.auth().currentUser

	// if (
	//     to.path === "/pages/login" ||
	//     to.path === "/pages/forgot-password" ||
	//     to.path === "/pages/error-404" ||
	//     to.path === "/pages/error-500" ||
	//     to.path === "/pages/register" ||
	//     to.path === "/callback" ||
	//     to.path === "/pages/comingsoon" ||
	//     (auth.isAuthenticated() || firebaseCurrentUser)
	// ) {
	//     return next();
	// }

	// If auth required, check login. If login fails redirect to login page
	if (to.meta.authRequired) {
		if (!(auth.isAuthenticated() || firebaseCurrentUser)) {
		router.push({ path: '/pages/login', query: { to: to.path } })
		}
	}

	return next()
	// Specify the current path as the customState parameter, meaning it
	// will be returned to the application after auth
	// auth.login({ target: to.path });

	})
})

export default router
