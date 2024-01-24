import Vue from 'vue'
import Router from 'vue-router'
import auth from './services/auth'

//login
import MainAuth from './components/layouts/MainAuth';
import MainBlank from './components/layouts/MainBlank';
import Login from './components/auth/Login';
import Register from './components/auth/Register';
//pages
import Main from './components/layouts/Main';
import Inicio from './components/pages/Inicio';

//admin
import MainAdmin from './components/layouts/MainAdmin';
import InicioAdmin from './components/admin/Inicio';
import Usuarios from './components/admin/Usuarios';
import InformacionDocente from './components/admin/InformacionDocente';


///Gestion
import Nivel from './components/admin/Nivel';
import Grado from './components/admin/Grado';
import Seccion from './components/admin/Seccion';
import Curso from './components/admin/Curso';
import Actividad from './components/admin/Actividad';
import Datos from './components/admin/Datos';
import Matricula from './components/admin/Matricula';
import Notas from './components/admin/Notas';
import Asistencia from './components/admin/Asistencia';

//Alumno
import MainAlumno from './components/layouts/MainAlumno';
import InicioAlumno from './components/alumno/Inicio';
import DatosAlumno from './components/alumno/Datos';

//Docente
import MainDocente from './components/layouts/MainDocente';
import InicioDocente from './components/docente/Inicio';
import Evaluacion from './components/docente/Evaluacion';
import RpteAsistencia from './components/docente/RpteAsistencia';
import RpteNotas from './components/docente/RpteNotas';


//Campus
import MainCampus from './components/layouts/MainCampus';
import InicioCampus from './components/campus/Inicio';
import BibliotecaVirtual from './components/campus/BibliotecaVirtual';
import ContenidoDigital from './components/campus/ContenidoDigital';
import Libro from './components/campus/Libro';
import Video from './components/campus/Video';
import SalaReunion from './components/campus/SalaReunion';
import ReunionVirtual from './components/campus/ReunionVirtual';
import EvaluacionVirtual from './components/campus/EvaluacionVirtual';
import IniciarEvaluacionVirtual from './components/campus/IniciarEvaluacionVirtual';
import EvaluacionPregunta from './components/campus/EvaluacionPregunta';

Vue.use(Router)

let routes = [
    // {
    //     path: '*', 
    //     redirect: '/inicio',
    // },

    {
        path: '/auth',
        meta: { requiresAuth: true },
        component: MainBlank,
        children: [
            { path: 'register', name: 'Register', component: Register },
        ]
    },

    {
        path: '/',
        component: MainBlank,
        redirect: '/inicio',
        children: [
            { path: 'login', name: 'Login', component: Login },

        ]
    },

    {
        path: '/',
        meta: { requiresAuthAdmin: true },
        component: Main,
        redirect: '/inicio',
        children: [
            { path: 'inicio', name: 'Inicio', component: Inicio },
        ]
    },

    {
        path: '/alumno',
        component: MainAlumno,
        meta: { requiresAuthAlumno: true },
        redirect: '/alumno/inicio',
        children: [
            { path: 'inicio', name: 'InicioAlumno', component: InicioAlumno },
            { path: 'datosalumno', name: 'DatosAlumno', component: DatosAlumno },
            { path: 'matricula', name: 'MatriculaAlumno', component: Matricula },
            { path: 'asistencia', name: 'AsistenciaAlumno', component: Asistencia },
            { path: 'notas', name: 'NotasAlumno', component: Notas },
        ]
    },

    {
        path: '/docente',
        component: MainDocente,
        meta: { requiresAuthDocente: true },
        redirect: '/docente/inicio',
        children: [
            { path: 'inicio', name: 'InicioDocente', component: InicioDocente },
            { path: 'asistencia', name: 'AsistenciaDocente', component: Asistencia },
            { path: 'notas', name: 'NotasDocente', component: Notas },
            { path: 'salaReunion', name: 'SalaReunionDocente', component: SalaReunion },
            { path: 'evaluacion', name: 'EvaluacionDocente', component: Evaluacion },
            { path: 'reporteAsistencia', name: 'RpteAsistencia', component: RpteAsistencia },
            { path: 'reporteNotas', name: 'RpteNotas', component: RpteNotas },
        ]
    },

    {
        path: '/campus',
        component: MainCampus,
        meta: { requiresAuthCampus: true },
        redirect: '/campus/inicio',
        children: [
            { path: 'inicio', name: 'InicioCampus', component: InicioCampus },
            { path: 'bibliotecaVirtual', name: 'BibliotecaVirtual', component: BibliotecaVirtual },
            { path: 'contenidoDigital', name: 'ContenidoDigital', component: ContenidoDigital },
            { path: 'reunionVirtual', name: 'ReunionVirtual', component: ReunionVirtual },
            { path: 'evaluacionVirtual', name: 'EvaluacionVirtual', component: EvaluacionVirtual },
            { path: 'iniciarEvaluacionVirtual', name: 'IniciarEvaluacionVirtual', component: IniciarEvaluacionVirtual },
            { path: 'evaluacion', name: 'EvaluacionPregunta', component: EvaluacionPregunta },
        ]
    },

    {
        path: '/admin',
        component: MainAdmin,
        meta: { requiresAuthAdmin: true },
        redirect: '/admin/inicio',
        children: [
            { path: 'inicio', name: 'InicioAdmin', component: InicioAdmin },
            { path: 'usuarios', name: 'Usuarios', component: Usuarios },
            // { path: 'mensajes/:usuario_id/:nombre', name: 'Mensajes', component: Mensajes },
            { path: 'nivel', name: 'Nivel', component: Nivel },
            { path: 'grado', name: 'Grado', component: Grado },
            { path: 'seccion', name: 'Seccion', component: Seccion },
            { path: 'curso', name: 'Curso', component: Curso },
            { path: 'competencia', name: 'Actividad', component: Actividad },
            { path: 'datos', name: 'Datos', component: Datos },
            { path: 'matricula', name: 'Matricula', component: Matricula },
            { path: 'notas', name: 'Notas', component: Notas },
            { path: 'asistencia', name: 'Asistencia', component: Asistencia },
            { path: 'informacionDocente', name: 'InformacionDocente', component: InformacionDocente },
            { path: 'libro', name: 'Libro', component: Libro },
            { path: 'video', name: 'Video', component: Video },
            { path: 'salaReunion', name: 'SalaReunion', component: SalaReunion },
            { path: 'evaluacion', name: 'Evaluacion', component: Evaluacion },
            
 
        ]
    },
    
];

const router = new Router({
    mode: 'history', // history is production an validate app_url in .env
    //base: process.env.MIX_APP_URL,
    //base: __dirname,
	routes,
});

router.beforeEach((to, from, next) => {

    if (to.matched.some(m => m.meta.requiresAuthAdmin)) {
        return auth.check().then(response => {
            if (response) {
                return next()
            }
            return next({ path: '/login' })
        })
    }

    return next()
});

export default router;