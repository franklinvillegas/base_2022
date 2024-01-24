<template>
    <div class="p-3 pt-5">
        <h4 class="text-color-2 mb-3">Contenido Digital</h4>
        <hr>
        <div class="row justify-content-md-center">
            <div class="col-md-5">
                <div class="row mb-1">
                    <div class="form-group col-md-6">
                      <p class="m-0">
                          <strong>Nivel</strong>
                      </p>
                      <select name="nivel"
                      v-model="id_nivel"
                      class="form-control"
                      data-vv-as="Nivel"
                      placeholder="Seleccione nivel"
                      @change="listarGrado(id_nivel)">
                          <option v-for="row in listarNiveles" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                      </select>
                      <span class="text-danger">{{errors.first("form_registro.nivel")}}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <p class="m-0">
                            <strong>Grado</strong>
                        </p>
                        <select name="id_grado"
                        class="form-control"
                        v-model="id_grado"
                        data-vv-as="id_grado"
                        placeholder="Seleccione grado"
                        @change="listarCurso(id_grado)"
                        >
                            <option v-for="row in listarGrados" :key="row.id" :value="row.id" v-text="row.grado" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.grado")}}</span>
                    </div>
                    <div class="form-group col-md-12">
                        <p class="m-0">
                            <strong>Curso</strong>
                        </p>
                        <select name="id_grado_curso"
                        class="form-control"
                        v-model="id_curso "
                        data-vv-as="id_grado_curso"
                        placeholder="Seleccione curso"
                        @change="listarVideo(id_curso)"
                        >
                            <option v-for="row in listarCursos" :key="row.id" :value="row.id" v-text="row.curso.nombre" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
                    </div>
                </div>
                <div class="form-group shadow-sm">
                    <div id="accordion">
                        <div class="table-responsive" id="table-media">
                            <vue-good-table :columns="listaVideos.columns" :rows="listaVideos.data" :search-options="{
                            enabled: true,
                            placeholder: 'Buscar Video',
                            }" :pagination-options="{
                                enabled: true,
                                mode: 'pages',
                                nextLabel: 'Sig',
                                prevLabel: 'Ant',
                                perPage: 8,
                                perPageDropdownEnabled: false,
                                rowsPerPageLabel: '',
                                ofLabel: '',
                                pageLabel: '', // for 'pages' mode
                                allLabel: 'Todo',
                            }">
                                <template slot="table-row" slot-scope="props">
                                    <div class="card" :key="props.index">
                                        <div class="card-header mouse-pointer-click position-relative" :class="{ 'btn-select': props.index == select_content }" @click="selectContent(props.index)">
                                            <a class="card-link">
                                                {{props.row.nombre}}
                                            </a>
                                            <button class="btn btn-light position-absolute top-0 right-0 h-100"
                                                type="button" data-toggle="collapse" :href="'#collapse'+props.index">
                                                <i class="fas fa-caret-down"></i>
                                            </button>
                                        </div>
                                        <div :id="'collapse'+props.index" class="collapse" data-parent="#accordion">
                                            <div class="card-body py-2">
                                                <p class="mb-2">Autor: {{props.row.autor}}</p>
                                                <p class="mb-2">Descripción: {{props.row.descripcion}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">

                
                <div class="form-group text-center bg-white"  v-if="listaVideos.data[select_content]">
                    <video v-if="listaVideos.data[select_content].subido" :src="getVideoPath(listaVideos.data[select_content].url)" controls controlsList="nodownload"  width="100%" class="max-h-full"></video>
                    <iframe v-else :src="listaVideos.data[select_content] ? listaVideos.data[select_content].url : ''" title="YouTube video player" frameborder="0" height="450" width="100%" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Helper from "../../services/Helper";
    import Chart from '../charts/Chart.vue'
    import Multiselect from "vue-multiselect";

    export default {
        name: 'BibliotecaVirtual',
        components: {
            Chart,
            Multiselect,
        },
        data() {
            return {
                listaVideos: {
                    data: [],
                    columns: [
                        { label: 'Videos', field: 'nombre', },
                    ],
                    total: 0,
                    filtrosBusqueda: {
                        tipo: '',
                        orden: 'asc',
                        ordenPor: 'id',
                        regPagina: '10',
                    },
                    deshabilitarEdicion: false,
                },
                id_nivel: null,
                id_grado: null,
                id_curso: null,
                listarNiveles: [],
                listarGrados: [],
                listarCursos: [],
                select_content: 0,
            }
        },
        created() {
            this.listarNivel();
        },
        mounted() {
        },
        methods: {
            listarVideo(id_grado_cur){
                console.log(id_grado_cur);
                axios.get("api/video/listar_filtro/"+id_grado_cur+Helper.getFilterURL(this.listaVideos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listaVideos.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
            listarNivel(){
                axios.get("api/nivel/listar"+Helper.getFilterURL(this.listaVideos.filtrosBusqueda))
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
                        console.log(data);
                        data.map(element => {
                            element.nombre_curso = element.curso.nombre;
                            return element;
                        });
                        this.listarCursos = data;
                        console.log(this.listarCursos);
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toastr.e(error.response.data.message);
                    });
            },
            selectContent(index){
                this.select_content = index;
            },

            getVideoPath (url) {
                console.log('ingreso path');
                return '../../recursos/videos/'+url;
            }
        },
    }
</script>
<style>
    #table-media table.vgt-table td {
        padding: 0 !important;
     }

    #table-media .card {
        border: none;
    }
</style>