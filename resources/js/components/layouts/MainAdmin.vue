<template>
    <div class="principal">
        <nav class="navbar navbar-expand-lg fixed-top shadow header-personal">
        <!-- <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light shadow" style="border: 3px solid #2FEAF0"> -->
            <a class="navbar-brand" href="#"  @click.prevent="redireccionar('Inicio')">

                <img :src="$baseUrlVue('img/logo/logotipo-version-5.png')"  height="40" class="d-inline-block align-top" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mr-auto ml-2">

                </ul>

                <div class="row">
                    <span class="row col-6 col-sm-6 col-md-6 col-lg-9 text-right">
                        <strong class="col-12 align-self-center"  v-text="getUserName('nombres')"></strong>
                    </span>
                    <div class="btn-group ml-0 col-6 col-sm-6 col-md-6 col-lg-3 text-center">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-online">
                            <img :src="$baseUrlVue(getAvatar())" class="rounded-circle" alt="avatar" width="40" height="40"/>
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button" @click="cerrarSesion">Cerrar sesión</button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row flex-xl-nowrap">

                <div class="col-12 col-md-3 col-xl-2 bd-sidebar p-0">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header p-0" id="headingOne">
                                <h6 class="mb-0">
                                    <button class="btn btn-light w-100 text-left font-weight-bold p-menu" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="font-size:20px;">
                                        <i class="fa fa-indent w-ico me-3"></i>Gestión educativa
                                    </button>
                                </h6>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <ul class="list-unstyled ps-0" style="font-size:20px;">
                                    <!-- <li class="mb-1" >
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('InicioAdmin')">
                                            <i class="fa fa-home  me-3"></i>Inicio
                                        </a>
                                    </li> -->
                                    
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Nivel')">
                                            <i class="fas fa-tag me-3"></i>Nivel
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Grado')">
                                            <i class="fas fa-tag me-3"></i>Grado
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Seccion')">
                                            <i class="fas fa-tag me-3"></i>Sección
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Curso')">
                                            <i class="fas fa-tag me-3"></i>Cursos
                                        </a>
                                    </li>
                                   <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Actividad')">
                                            <i class="fas fa-tag me-3"></i>Competencias
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-0" id="headingTwo">
                                <h6 class="mb-0">
                                    <button class="btn btn-light w-100 text-left font-weight-bold p-menu" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="font-size:20px;">
                                        <i class="fa fa-lock w-ico me-3"></i>Accesos
                                    </button>
                                </h6>
                            </div>

                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <ul class="list-unstyled ps-0" style="font-size:20px;">
                                    <!-- <li class="mb-1" >
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('InicioAdmin')">
                                            <i class="fa fa-home  me-3"></i>Inicio
                                        </a>
                                    </li> -->

                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('Usuarios')">
                                            <i class="fas fa-user me-3"></i>Usuarios
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-0" id="headingThree">
                            <h6 class="mb-0">
                                <button class="btn btn-light w-100 text-left font-weight-bold p-menu collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree " style="font-size:20px;">
                                    <i class="fa fa-child w-ico me-3"></i>Alumno
                                </button>
                            </h6>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <ul class="list-unstyled ps-0" style="font-size:20px;">

                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('Datos')">
                                            <i class="fas fa-address-card me-3"></i>Información
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Matricula')">
                                            <i class="fas fa-edit me-3"></i>Matricula
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Notas')">
                                            <i class="fas fa-file-alt me-3"></i>Notas
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Asistencia')">
                                            <i class="fa fa-check-square me-3"></i>Asistencia
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-0" id="headingFour">
                            <h6 class="mb-0">
                                <button class="btn btn-light w-100 text-left font-weight-bold p-menu collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="font-size:20px;">
                                    <i class="fa fa-chalkboard-teacher w-ico me-3"></i>Docente
                                </button>
                            </h6>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <ul class="list-unstyled ps-0" style="font-size:20px;">
                                    <li class="mb-1" >
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('InformacionDocente')">
                                            <i class="fas fa-address-card me-3"></i>Información
                                        </a>
                                    </li>
                                    <!-- <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#" @click.prevent="redireccionar('Usuarios')">
                                            <i class="fa fa-calendar me-3"></i>Horario
                                        </a>
                                    </li> -->
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Notas')">
                                            <i class="fas fa-file-alt me-3"></i>Notas
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Asistencia')">
                                            <i class="fa fa-check-square me-3"></i>Asistencia
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-0" id="headingFive">
                            <h6 class="mb-0">
                                <button class="btn btn-light w-100 text-left font-weight-bold p-menu collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" style="font-size:20px;">
                                    <i class="fa fa-laptop w-ico me-3"></i>Campus Virtual
                                </button>
                            </h6>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <ul class="list-unstyled ps-0" style="font-size:20px;">

                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Video')">
                                            <i class="fa fa-file-video me-3"></i>Videos
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Libro')">
                                            <i class="fas fa-book me-3"></i>Libros
                                        </a>
                                    </li>
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('SalaReunion')">
                                        <i class="fa fa-users me-3"></i>Sala reunión
                                         </a>
                                     </li>
                                  
                                    <li class="mb-1" v-if="validarPermisos(1)">
                                        <a class="nav-link" href="#"  @click.prevent="redireccionar('Evaluacion')">
                                            <i class="fas fa-pencil-alt me-3"></i>Evaluación
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="d-none d-xl-block col-xl-2 bd-toc">
                    <sidebar-aportar></sidebar-aportar>
                </div> -->
                <main class="col-12 col-md-9 col-xl-10 bd-content" role="main">
                    <router-view :key="$route.params.id"> </router-view>
                </main>
            </div>

        </div>

    </div>
</template>

<script>

import Crypt from "../../services/Crypt";

export default {
    name: 'Main',
    data(){
        return {
            usuario: '',
            infoAyuda:{
                    mostrar: false,
                    titulo: 'Ayuda',
                    contenido: [
                        {titulo: 'Recuerda ir al grano con la solución', imagen:'ayuda_inicio.png', descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis augue ac porttitor interdum. Aenean cursus eros imperdiet ante aliquet imperdiet.', activo:'active',},
                        {titulo: 'Recuerda ir al grano con la solución v2', imagen:'ayuda_inicio.png', descripcion: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In convallis augue ac porttitor interdum.', activo:'false',},
                    ]
                }
        }
    },
    mounted(){
        this.init();
    },
    methods:{
        init(){
            if(!this.$store.getters.getAuthUser('identificador')){
                axios.get("api/auth/user")
                .then((response) => {
                    console.log(response);
                    let usuario = response.data;
                    this.$store.dispatch('setAuthUserDetail',{//aqui extrae la info el usuario y lo asigno a la variable
                        identificador: Crypt.encrypt(usuario.id),
                        email: usuario.email,
                        nombres: usuario.persona.nombres,
                        apellidos: usuario.persona.apellido_pat+' '+usuario.persona.apellido_mat,
                        usuario: usuario.usuario,
                        avatar: usuario.avatar,
                        rol: usuario.tipo_usuario
                    });

                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                    this.cerrarSesion();
                    return false;
                });
            } 
        },
        validarPermisos(rol){
            if(this.$store.getters.getAuthUser('rol') == rol){
                return true;
            }
            return false;
        },
        redireccionar(name){
            this.$router.push({name: name})
        },
        getUserName(name){
            return this.$store.getters.getAuthUserNameComplete();
        },
        getAvatar(){
            let avatar = this.$store.getters.getAuthUser('avatar');
            if(avatar)
                return 'user/users/' + avatar;
            return 'img/auth/user-alt.png';
        },
        cerrarSesion(){
            axios.post('api/auth/logout').then(response => {
                localStorage.removeItem('token_linkedin');
                localStorage.removeItem('token_laravel');
                this.$store.dispatch('resetAuthUserDetail');
                this.$router.push('/login');
                axios.defaults.headers.common['Authorization'] = null;
                this.$toastr.s(response.data.message);
                return true;
            }).catch(error => {
                console.log(error);
                return false;
            });
        },

    }
}
</script>

<style>

    .p-menu{
        padding: 1rem 0.5rem 1rem 1rem;
    }
    .w-ico{
        width: 1em!important;
    }
  
</style>
