//1 = Directora
//2 = Trabajadora social
//3 = Secretaria
//4 = Tutora
//5 = Laboratorista
//6 = Farmaceutica
//7 = Medico 
import Ls from '../../../services/ls';
var id = 0;

id = parseInt(Ls.get('auth.roles'));

let regresar = false
const id1= {multi:'f'};
export default 
	//1 = Directora
	id==1 ?
	[
		{

		///////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////   SALUD
		///////////////////////////////////////////////////////////////////////////////////////////
			header: 'Salud',
			icon: 'PackageIcon',
			items: 
			[
				{
					url: null,
					name: 'Farmacia',
					icon: 'PlusCircleIcon',
					submenu:
					[
						{
								url: '/farmacia/medicamentos',
								name: 'Medicamentos',
								slug: 'farmacia-medicamentos',
						},
						{
							url: '/ingreso/medicamentos',
							name: 'Ingreso Medicamentos',
							slug: 'ingreso-medicamentos',
						},
						{
							url: '/salida/medicamentos',
							name: 'Salida Medicamentos',
							slug: 'salida-medicamentos',
						},
						{
							url: '/farmacia/proveedores',
							name: 'Proveedores',
							slug: 'farmacia-proveedores',
						},
						{
							url: '/farmacia/casas',
							name: 'Casas médicas',
							slug: 'farmacia-casas',
						},
						{
							url: '/farmacia/categoria',
							name: 'Categorías',
							slug: 'farmacia-categoria',
						}
					]
				},
				
			]
		},
		// =============================================================================
		// ADMINISTRACION
		// =============================================================================
		{
			header: 'Administración',
			icon: 'PackageIcon',
			items: 
			[
				{
					url: null,
					name: 'Admin',
					icon: 'UserIcon',
					submenu:
					[
						{
							url: '/admin/usuarios',
							name: 'Usuarios',
							slug: 'admin-user',
						},
						
						{
							url: '/admin/roles',
							name: 'Roles',
							slug: 'admin-rol',
						},

					]
				},

			]
		}
	]
			//2= Farmaceutica
				
						:id == 2 ?
						[
							///////////////////////////////////////////////////////////////////////////////////////////
							///////////////////////////   SALUD
							///////////////////////////////////////////////////////////////////////////////////////////
							{
								header: 'Salud',
								icon: 'PackageIcon',
								items: 
								[
									{
										url: null,
										name: 'Farmacia',
										icon: 'PlusCircleIcon',
										submenu:
										[
											{
												url: '/farmacia/medicamentos',
												name: 'Medicamentos',
												slug: 'farmacia-medicamentos',
											},
											{
												url: '/ingreso/medicamentos',
												name: 'Ingreso Medicamentos',
												slug: 'ingreso-medicamentos',
											},
											{
												url: '/salida/medicamentos',
												name: 'Salida Medicamentos',
												slug: 'salida-medicamentos',
											},
											{
												url: '/farmacia/proveedores',
												name: 'Proveedores',
												slug: 'farmacia-proveedores',
											},
											{
												url: '/farmacia/casas',
												name: 'Casas médicas',
												slug: 'farmacia-casas',
											},
											{
												url: '/farmacia/categoria',
												name: 'Categorías',
												slug: 'farmacia-categoria',
											},
										]
									}
								]
							}
						//3 = Secretaria 
						]:[
							// =============================================================================
		// ADMINISTRACION
		// =============================================================================
		{
			header: 'Administración',
			icon: 'PackageIcon',
			items: 
			[
				{
					url: null,
					name: 'Admin',
					icon: 'UserIcon',
					submenu:
					[
						{
							url: '/admin/usuarios',
							name: 'Usuarios',
							slug: 'admin-user',
						},
						
						{
							url: '/admin/roles',
							name: 'Roles',
							slug: 'admin-rol',
						},

					]
				},

			]
		}
	]
