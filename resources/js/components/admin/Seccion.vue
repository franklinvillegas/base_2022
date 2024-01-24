<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Secciones</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarSecciones.filtrosBusqueda.tipo" @change="listarSeccion" >
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
            :columns="listarSecciones.columns"
            :rows="listarSecciones.data"
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
            <div class="modal fade" id="modal-seccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Grado</strong>
                                    </p>
                                    <select name="grado"
                                    class="form-control"
                                    v-model="modal.seccion.id_grado"
                                    data-vv-as="Grado"
                                    placeholder="Seleccione grado"
                                    v-validate="'required'">
                                        <option v-for="row in listarGrados" :key="row.id" :value="row.id" v-text="row.grado" ></option>
                                    </select>
                                    <span class="text-danger">{{errors.first("form_registro.grado")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Sección</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.seccion.seccion"
                                    class="form-control"
                                    data-vv-as="Sección"
                                    placeholder="Seleccione sección"
                                    name="seccion"
                                    v-validate="'required|max:10'">
                                    <span class="text-danger">{{errors.first("form_registro.seccion")}}</span>
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

    export default {
        name:'Ayudas',
        components:{
        },
        data(){
            return{
                listarSecciones:{
                    data: [],
                    columns:[
                        {label: 'Sección', field: 'seccion',},
                        {label: 'Grado', field: 'grado.grado',},
                        {label: 'Nivel', field: 'grado.nivel.nombre',},
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
                listarNiveles:[],
                listarGrados:[],
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    nivelID: null,
                    seccion:{
                        seccion: '',
                        id_grado: '',
                    }
                },

            }
        },
        created(){
           this.listarSeccion();
           this.listarNivel();
        },
        methods:{
            listarSeccion(){
                axios.get("api/seccion/listar"+Helper.getFilterURL(this.listarSecciones.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarSecciones.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarNivel(){
                axios.get("api/nivel/listar"+Helper.getFilterURL(this.listarSecciones.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarNiveles = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarGrado(id_nivel){
                axios.get("api/grado/llenar_combo/"+id_nivel)
                .then((response) => {
                    let data = response.data;
                    this.listarGrados = data;
                    console.log(this.listarGrados);

                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },

            limpiarFormulario(){
                this.modal = {
                    titulo:  '',
                    nivelID: null,
                    seccion:{
                        seccion:'',
                    },
                    deshabilitado: false,
                }
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-seccion").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nueva seccion';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-seccion").modal('show');
                this.limpiarFormulario();
                console.log('row',row);
                this.listarGrado(row.grado.id_nivel);
                this.modal = {
                    titulo:  'Ver seccion',
                    tipo: 'ver',
                    nivelID:row.grado.id_nivel,
                    seccion:{
                        seccion: row.seccion,
                        id_grado: row.id_grado,
                    },
                    deshabilitado: true,
                }
            },
            editar(row, index){
                $("#modal-seccion").modal('show');
                this.limpiarFormulario();
                this.listarGrado(row.grado.id_nivel);

                this.modal = {
                    titulo:  'Editar seccion',
                    tipo: 'editar',
                    nivelID:row.grado.id_nivel,
                    seccion:{
                        seccion: row.seccion,
                        id_grado: row.id_grado,
                    },
                    deshabilitado: false
                }
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {
                        axios.post("api/seccion/crear", this.modal.seccion)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-seccion").modal('hide');
                            this.listarSeccion();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                });
            },
            modificar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {
                        axios.put("api/seccion/modificar/" + this.modal.nivelID, this.modal.seccion)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-seccion").modal('hide');
                            this.listarSeccion();
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
                  axios.put("api/seccion/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarSeccion();
                });
                
            },
            activar(row, index){
                axios.put("api/seccion/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarContenidoPeligroso(){
                this.listarSecciones.filtrosBusqueda.contenidoPeligroso = true;
                this.listarSeccion();
            },
            obtenerTipo(row){
                if (row.tipo == 1) return 'Inicio';
                else if (row.tipo == 2) return 'Pregunta';
                else if (row.tipo == 1) return 'Publicación';

            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarSecciones.filtrosBusqueda);
                window.open(url);
            }

        },
    }
</script>
<style >

</style>
