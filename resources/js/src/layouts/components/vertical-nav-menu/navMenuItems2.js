import Ls from '../../../services/ls';
var id = 0;

id = Ls.get('auth.roles');

//1 = Directora
//2 = Trabajadora social
//3 = Secretaria
//4 = Tutora
//5 = Laboratorista
//6 = Farmaceutica
//7 = Medico 

export default [
  

  
  // =============================================================================
  // APADRINAMIENTOS
  // =============================================================================
  {
    
    header: 'Apps',
    icon: 'PackageIcon',
    i18n: 'Social',
    items: [
    {
      url: null,
      name: 'Apadrinamiento',
      icon: 'UsersIcon',
      i18n: 'Esta mierda funciona',
      submenu: [
        {
              url: '/apadrinamiento/nino',
              name: 'nino',
              slug: 'apadrinamiento-nino',
              i18n: 'Esta mierda funciona',
            },
            {
              url: '/apadrinamiento/ninono',
              name: 'ninono',
              slug: 'apadrinamiento-ninono',
              i18n: 'Niños no apadrinados',
        },
        {
          url: '/apadrinamiento/padrino',
          name: 'padrino',
          slug: 'apadrinamiento-padrino',
          i18n: 'Padrinos'
        },
        {
          url: '/apadrinamiento/apadrinamiento',
          name: 'apadrinamiento',
          slug: 'apadrinamiento-apadrinamiento',
          i18n: 'Apadrinamientos'
        },
        {
          url: '/apadrinamiento/familia',
          name: 'familia',
          slug: 'apadrinamiento-familia',
          i18n: 'Familias'
        },
        {
          url: '/apadrinamiento/encargado',
          name: 'encargado',
          slug: 'apadrinamiento-encargado',
          i18n: 'Familiares'
        },
        // {
        //   url: '/dashboard/ecommerce',
        //   name: 'eCommerce',
        //   slug: 'dashboard-ecommerce',
        //   i18n: 'Hola eCommerce'
        // }
      ]
    },
  // =============================================================================
  // Tutoria
  // =============================================================================
  {
    url: null,
    name: 'Tutorias',
    icon: 'BookIcon',
    i18n: 'Tutorías',
    submenu: [
      {
        url: '/tutoria/tutoria',
        name: 'tutoria',
        slug: 'tutoria-tutoria',
        i18n: 'Tutorías'
      },
      {
        url: '/tutoria/tutor',
        name: 'tutor',
        slug: 'tutoria-tutor',
        i18n: 'Tutores'
      },
    ]
  },
   // =============================================================================
  // MICROPRESTAMOS
  // =============================================================================
  {
    url: null,
    name: 'Microprestamo',
    icon: 'DollarSignIcon',
    i18n: 'Micropréstamos',
    submenu: [
      {
        url: '/microprestamo/microprestamo',
        name: 'microprestamo',
        slug: 'microprestamo-microprestamo',
        i18n: 'Micropréstamos'
      },
      {
        url: '/microprestamo/abono',
        name: 'abono',
        slug: 'microprestamo-abono',
        i18n: 'Abonos'
      },
      {
        url: '/microprestamo/grupo',
        name: 'grupo',
        slug: 'microprestamo-grupo',
        i18n: 'Grupos'
      },
      // {
      //   url: '/microprestamo/integrante',
      //   name: 'integrante',
      //   slug: 'microprestamo-integrante',
      //   i18n: 'Integrantes'
      // },
      {
        url: '/microprestamo/destino',
        name: 'destino',
        slug: 'microprestamo-destino',
        i18n: 'Destinos de inversión'
      },
    ]
  },
   // =============================================================================
  // VIVIENDA
  // =============================================================================
  {
    url: null,
    name: 'Vivienda',
    icon: 'HomeIcon',
    i18n: 'Viviendas',
    submenu: [
      {
        url: '/vivienda/vivienda',
        name: 'vivienda',
        slug: 'vivienda-vivienda',
        i18n: 'Viviendas'
      },
      {
        url: '/vivienda/abono',
        name: 'abono',
        slug: 'vivienda-abono',
        i18n: 'Abonos'
      },
      {
        url: '/vivienda/constructor',
        name: 'constructor',
        slug: 'vivienda-constructor',
        i18n: 'Constructores'
      },
      {
        url: '/vivienda/tipo',
        name: 'tipo',
        slug: 'vivienda-tipo',
        i18n: 'Tipos de vivienda'
      },
    ]
  },
  // =============================================================================
  // Datos Generales
  // =============================================================================
  {
    url: null,
    name: 'DatosGenerales',
    icon: 'LayersIcon',
    i18n: 'Datos Generales',
    submenu: [
      {
        url: '/general/escuela',
        name: 'escuela',
        slug: 'general-escuela',
        i18n: 'Escuelas'
      },
      {
        url: '/general/sector',
        name: 'sector',
        slug: 'general-sector',
        i18n: 'Sectores'
      },
      {
        url: '/general/aldea',
        name: 'aldea',
        slug: 'general-aldea',
        i18n: 'Aldeas'
      },
    ]
  },
]},
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////   SALUD
///////////////////////////////////////////////////////////////////////////////////////////
{header: 'Salud',
    icon: 'PackageIcon',
    i18n: 'Salud',
    items: [
  {
    url: null,
    name: 'Farmacia',
    icon: 'PlusCircleIcon',
    i18n: 'Farmacia',
    submenu: [
      {
            url: '/farmacia/medicamentos',
            name: 'medicamentos',
            slug: 'farmacia-medicamentos',
            i18n: 'Medicamentos',
      },
      {
        url: '/ingreso/medicamentos',
        name: 'medicamentos',
        slug: 'ingreso-medicamentos',
        i18n: 'Ingreso Medicamentos',
      },
      {
        url: '/salida/medicamentos',
        name: 'medicamentos',
        slug: 'salida-medicamentos',
        i18n: 'Salida Medicamentos',
      },
      {
            url: '/farmacia/proveedores',
            name: 'proveedores',
            slug: 'farmacia-proveedores',
            i18n: 'Proveedores',
      },
      {
        url: '/farmacia/casas',
        name: 'casas',
        slug: 'farmacia-casas',
        i18n: 'Casas médicas',
      },
      {
        url: '/farmacia/categoria',
        name: 'categoria',
        slug: 'farmacia-categoria',
        i18n: 'Categorías',
      },
    ]
  },
  {
    url: null,
    name: 'clinica',
    icon: 'ThermometerIcon',
    i18n: 'Clínica',
    submenu: [
      {
        url: '/clinica/consultorio',
        name: 'consultorio',
        slug: 'clinica-consultorio',
        i18n: 'Consultorio'
      },
      {
        url: '/clinica/pacientes',
        name: 'pacientes',
        slug: 'clinica-pacientes',
        i18n: 'Pacientes'
      },
      {
        url: '/clinica/citas',
        name: 'citas',
        slug: 'clinica-citas',
        i18n: 'Citas'
      },
      {
        url: '/clinica/tipoC',
        name: 'tipo',
        slug: 'clinica-tipo',
        i18n: 'Tipo de citas'
      },
      {
        url: '/clinica/tipoP',
        name: 'tipo',
        slug: 'clinica-tipo',
        i18n: 'Tipo de pacientes'
      },
    ]
  },
  {
    url: null,
    name: 'laboratorio',
    icon: 'FilterIcon',
    i18n: 'Laboratorio',
    submenu: [
      {
        url: '/laboratorio/examen',
        name: 'examen',
        slug: 'laboratorio-examen',
        i18n: 'Examenes'
      },
      {
        url: '/laboratorio/tipo',
        name: 'tipo',
        slug: 'laboratorio-tipo',
        i18n: 'Tipos de examenes'
      },
    ]
  },
  {
    url: '/clinica/PersonalMedico',
    name: 'PersonalMedico',
    icon: 'UserPlusIcon',
    i18n: 'Personal Médico',
  }
]},
        // =============================================================================
        // ADMINISTRACION
        // =============================================================================
{header: 'Administración',
    icon: 'PackageIcon',
    i18n: 'Administración',
    items: [
    {
      url: null,
      name: 'Admin',
      icon: 'UserIcon',
      i18n: 'Admin',
      submenu: [
        {
              url: '/admin/user',
              name: 'user',
              slug: 'admin-user',
              i18n: 'Users',
        },
        {
              url: '/admin/rol',
              name: 'rol',
              slug: 'admin-rol',
              i18n: 'Roles',
        },
      ]
    },
]}
]

