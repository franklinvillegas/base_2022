<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Videos</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarVideos.filtrosBusqueda.tipo" @change="listarGrado" > 
                        <option value="">-- Todos -- </option>
                        <option value="1">Inicio</option>
                        <option value="2">Pregunta</option>
                        <option value="3">Publicación</option>
                    </select>
                </div>
            </div>  
        </div>
        <hr> -->

        <!-- <hr>
        <button class="btn btn-outline-secondary float-right" type="button" @click="exportar">
            <i class="fas fa-download"></i>
            Exportar 
        </button>
        <br> -->
        <div class="table-responsive">
            <vue-good-table
            :columns="listarVideos.columns"
            :rows="listarVideos.data"
            :search-options="{
                enabled: true,
                placeholder: 'Buscar en la tabla',
            }"
            :pagination-options="{
                enabled: true,
                mode: 'pages',
                nextLabel: 'Sig',
                prevLabel: 'Ant',
                rowsPerPageLabel: 'Registros por página',
                ofLabel: 'de',
                pageLabel: 'Página', // for 'pages' mode
                allLabel: 'Todo',
            }"
            >
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'options'">
                <button class="btn btn-outline-secondary btn-sm btn-icon" @click.prevent="ver(props.row, props.index)" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-info btn-sm btn-icon" @click.prevent="editar(props.row, props.index)" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm btn-icon" @click.prevent="eliminar(props.row, props.index)" data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </span>
            </template>
            </vue-good-table>
        </div>
        <!-- Modal -->
        <template>
            <div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle" v-text="modal.titulo"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form" data-vv-scope="form_registro">
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Nombre</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.video.nombre"
                                    class="form-control"
                                    data-vv-as="Nombre"
                                    placeholder="Nombre"
                                    name="nombre"
                                    v-validate="'required|max:500'">
                                    <span class="text-danger">{{errors.first("form_registro.nombre")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Autor</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.video.autor"
                                    class="form-control"
                                    data-vv-as="Autor"
                                    placeholder="Autor"
                                    name="autor"
                                    v-validate="'required|max:500'">
                                    <span class="text-danger">{{errors.first("form_registro.autor")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Descripción</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.video.descripcion"
                                    class="form-control"
                                    data-vv-as="Descripcion"
                                    placeholder="Descripcion"
                                    name="descripcion"
                                    v-validate="'required|max:5000'">
                                    <span class="text-danger">{{errors.first("form_registro.descripcion")}}</span>
                                </div>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <li class="nav-item" role="presentation" @click="cambiarTipo()">
                                    <button class="nav-link active" id="link-tab" data-toggle="tab" data-target="#link" type="button" role="tab" aria-controls="link" aria-selected="true">Copiar Link de Video</button>
                                  </li>
                                  <li class="nav-item" role="presentation" @click="cambiarTipo()">
                                    <button class="nav-link" id="upload-tab" data-toggle="tab" data-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Subir archivo de Video</button>
                                  </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active" id="link" role="tabpanel" aria-labelledby="link-tab">
                                    <div class="form-group" v-if="!modal.video.subido">
                                        <p class="m-0">
                                            <strong>URL</strong>
                                        </p>
                                        <input type="text"
                                        v-model="modal.video.url"
                                        class="form-control"
                                        data-vv-as="URL"
                                        placeholder="URL"
                                        name="url"
                                        v-validate="'required|max:500'">
                                        <span class="text-danger">{{errors.first("form_registro.url")}}</span>
                                    </div>
                                  </div>
                                  <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                                    <div class="form-group" v-if="modal.video.subido">
                                        <p class="m-0">
                                            <strong>Ubicación</strong>
                                        </p>

                                        <div class="form-group row">
                                            <div class="col-md-12">                                        
                                                <input type="file" name="url" data-vv-as="URL" id="url" class="form-control" accept="video/*" v-validate="'required|max:500'"> 
                                            </div>
                                        </div>
                                        <span class="text-danger">{{errors.first("form_registro.url")}}</span>
                                    </div>
                                  </div>
                                </div>
                               
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <p class="m-0">
                                            <strong>Nivel</strong>
                                        </p>
                                        <select name="nivel"
                                        v-model="modal.nivelID"
                                        class="form-control"
                                        data-vv-as="Nivel"
                                        placeholder="Seleccione nivel"
                                        v-validate="'required'"
                                        @change="listarGrado(modal.nivelID)">
                                            <option v-for="row in listarNiveles" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                                        </select>
                                        <span class="text-danger">{{errors.first("form_registro.nivel")}}</span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p class="m-0">
                                            <strong>Grado</strong>
                                        </p>
                                        <select name="id_grado"
                                        class="form-control"
                                        v-model="modal.grado_curso.id_grado"
                                        data-vv-as="id_grado"
                                        placeholder="Seleccione grado"
                                        v-validate="'required'"
                                        @change="listarCurso(modal.grado_curso.id_grado)"
                                        >
                                            <option v-for="row in listarGrados" :key="row.id" :value="row.id" v-text="row.grado" ></option>
                                        </select>
                                        <span class="text-danger">{{errors.first("form_registro.grado")}}</span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p class="m-0">
                                            <strong>Curso</strong>
                                        </p>
                                        <select name="id_grado_curso"
                                        class="form-control"
                                        v-model="modal.video.id_grado_cur "
                                        data-vv-as="id_grado_curso"
                                        placeholder="Seleccione curso"
                                        v-validate="'required'"
                                        >
                                            <option v-for="row in listarCursos" :key="row.id" :value="row.id" v-text="row.curso.nombre" ></option>
                                        </select>
                                        <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                            <button type="button" v-if="modal.tipo == 'nuevo'" class="btn btn-primary" @click="guardar">Guardar</button>
                            <button type="button" v-else-if="modal.tipo == 'editar'" class="btn btn-primary" @click="modificar">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>

import Helper from "../../services/Helper";
import Multiselect from "vue-multiselect";

    export default {
        name:'Ayudas',
        components:{
            Multiselect,
        },
        data(){
            return{
                listarVideos:{
                    data: [],
                    columns:[
                        {label: 'Nombre', field: 'nombre',},
                        {label: 'Autor', field: 'autor',},
                        {label: 'Descripción', field: 'descripcion',},
                        {label: 'Opciones', field: 'options',},
                    ],
                    total: 0,
                    filtrosBusqueda:{
                        tipo:'',
                        orden: 'asc',
                        ordenPor: 'id',
                        regPagina: '10',
                    },
                    deshabilitarEdicion: false,
                },
                listarGradoCurso:[],
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    id_lib_cur: null,
                    nivelID: null,
                    video:{
                        nombre:  '',
                        autor: '',
                        descripcion:'',
                        url:'',
                        subido: false,
                        id_grado_cur:'',
                    },
                    grado_curso: {
                        id: '',
                        id_grado:'',
                        id_curso:'',
                        curso: {
                            nombre: '',
                        }
                    },
                },
                curso: null,
                listarNiveles:[],
                listarGrados: [],
                listarCursos: [],
                editarDocumento: false,
                documento: '',

            }
        },
        created(){
            this.listarVideo();
            this.listarNivel();
        },
        methods:{
            listarVideo(){
                axios.get("api/video/listar"+Helper.getFilterURL(this.listarVideos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarVideos.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
            listarNivel(){
                axios.get("api/nivel/listar"+Helper.getFilterURL(this.listarVideos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarNiveles = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarGrado(id_nivel) {
                axios.get("api/grado/llenar_combo/" + id_nivel)
                    .then((response) => {
                        let data = response.data;
                        this.listarGrados = data;
                        this.listarCursos = null;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toastr.e(error.response.data.message);
                    });
            },
            listarCurso(id_grado) {
                axios.get("api/grado_curso/llenar_combo/" + id_grado)
                    .then((response) => {
                        let data = response.data;
                        data.map(element => {
                            element.nombre_curso = element.curso.nombre;
                            return element;
                        });
                        this.listarCursos = data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toastr.e(error.response.data.message);
                    });
            },
           
            limpiarFormulario(){
                this.modal = {
                    titulo:  '',
                    id_lib_cur: null,
                    nivelID: null,
                    video:{
                        nombre:  '',
                        autor: '',
                        descripcion:'',
                        url:'',
                        subido: false,
                        id_grado_cur:'',
                    },
                    grado_curso: {
                        id: '',
                        id_grado:'',
                        id_curso:'',
                        curso: {
                            nombre: '',
                        }
                    },
                    deshabilitado: false,   
                }
                this.listarCursos = null;
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-video").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo video';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-video").modal('show');
                this.limpiarFormulario();
                this.listarGrado(row.grado_curso.grado.id_nivel);
                this.listarCurso(row.grado_curso.id_grado);
                this.modal = {
                    titulo:  'Ver video',
                    tipo: 'ver',
                    id_video: row.id,
                    nivelID: row.grado_curso.grado.id_nivel,
                    video:{
                        nombre: row.nombre,
                        autor: row.autor,
                        descripcion: row.descripcion,
                        url: row.url,
                        subido: row.subido,
                        id_grado_cur: row.id_grado_cur,
                    },
                    grado_curso: row.grado_curso,
                    deshabilitado: true,
                }
            },
            editar(row, index){
                $("#modal-video").modal('show');
                this.limpiarFormulario();
                this.listarGrado(row.grado_curso.grado.id_nivel)
                this.listarCurso(row.grado_curso.id_grado);
                this.modal = {
                    titulo:  'Editar video',
                    tipo: 'editar',
                    id_video: row.id,
                    nivelID: row.grado_curso.grado.id_nivel,
                    video:{
                        nombre: row.nombre,
                        autor: row.autor,
                        descripcion: row.descripcion,
                        url: row.url,
                        subido: row.subido,
                        id_grado_cur: row.id_grado_cur,
                    },
                    grado_curso: row.grado_curso,
                    deshabilitado: false
                }
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 
                        if(this.modal.video.subido){
                            let _this = this;
                            let data = new FormData();
                            data.append('url', document.getElementById('url').files[0]);
                            data.append('nombre', _this.modal.video.nombre);
                            data.append('autor', _this.modal.video.autor);
                            data.append('descripcion', _this.modal.video.descripcion);
                            data.append('subido', _this.modal.video.subido);
                            data.append('id_grado_cur', _this.modal.video.id_grado_cur);
                            axios.post("api/video/crear", data)
                            .then((response) => {
                                this.$toastr.s(response.data.message);
                                $("#modal-video").modal('hide');
                                this.listarVideo();
                            })
                            .catch((error) => {
                                console.log(error);
                                this.$toastr.e(error.response.data.message);
                            });
                        } else {
                            if(!this.modal.video.subido){
                            this.modal.video.url = 'https://www.youtube.com/embed/'+this.modal.video.url.split('=')[1]?.split('&')[0];
                            }
                            axios.post("api/video/crear", this.modal.video)
                            .then((response) => {
                                this.$toastr.s(response.data.message);
                                $("#modal-video").modal('hide');
                                this.listarVideo();
                            })
                            .catch((error) => {
                                console.log(error);
                                this.$toastr.e(error.response.data.message);
                            });
                        }
                    }
                }); 
            },
            modificar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {  
                        if(!this.modal.video.subido && this.modal.video.url.search('embed') == -1) {
                            this.modal.video.url = 'https://www.youtube.com/embed/'+this.modal.video.url.split('=')[1]?.split('&')[0];
                        }
                        axios.put("api/video/modificar/" + this.modal.id_video, this.modal.video)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-video").modal('hide');
                            this.listarVideo();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            eliminar(row, index){
                 this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios.put("api/video/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarVideo();
                });
                
            },
            activar(row, index){
                axios.put("api/video/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
           
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarVideos.filtrosBusqueda);
                window.open(url);
            },
            
            cambiarTipo(){
                this.modal.video.subido = !this.modal.video.subido;
                this.modal.video.url = ''
            },

            cambiarDocumento(){

            }
        },
    }
</script>
<style >

#myTabContent{
    border: 1px solid;
    border-top: none;
    border-color: #dee2e6;
    padding: 1rem 1rem 0 1rem;
    margin-bottom: 1rem;
}

</style>