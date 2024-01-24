<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Cursos</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarCursos.filtrosBusqueda.tipo" @change="listarCurso" >
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
            :columns="listarCursos.columns"
            :rows="listarCursos.data"
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
            <div class="modal fade" id="modal-curso" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                        <strong>Codigo</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.curso.codigo"
                                    class="form-control"
                                    data-vv-as="Codigo"
                                    placeholder="Codigo"
                                    name="codigo"
                                    v-validate="'required|max:10'">
                                    <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Nombre</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.curso.nombre"
                                    class="form-control"
                                    data-vv-as="Nombre"
                                    placeholder="Nombre"
                                    name="nombre"
                                    v-validate="'required|max:60'">
                                    <span class="text-danger">{{errors.first("form_registro.nombre")}}</span>
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
                listarCursos:{
                    data: [],
                    columns:[
                        {label: 'Nombre', field: 'nombre',},
                        {label: 'Codigo', field: 'codigo',},
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
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    nivelID: null,
                    curso:{
                        nombre: '',
                        codigo: '',
                    }
                },

            }
        },
        created(){
           this.listarCurso();
        },
        methods:{
            listarCurso(){
                axios.get("api/curso/listar"+Helper.getFilterURL(this.listarCursos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarCursos.data = data;
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
                    curso:{
                        nombre:'',
                        codigo:'',
                    },
                    deshabilitado: false,
                }
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-curso").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo curso';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-curso").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Ver curso',
                    tipo: 'ver',
                    curso:{
                        nombre: row.nombre,
                        codigo:row.codigo,
                    },
                    deshabilitado: true
                }
            },
            editar(row, index){
                $("#modal-curso").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Editar curso',
                    tipo: 'editar',
                    nivelID: row.id,
                    curso:{
                        nombre: row.nombre,
                        codigo:row.codigo,
                    },
                    deshabilitado: false
                }
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {
                        axios.post("api/curso/crear", this.modal.curso)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-curso").modal('hide');
                            this.listarCurso();
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
                        axios.put("api/curso/modificar/" + this.modal.nivelID, this.modal.curso)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-curso").modal('hide');
                            this.listarCurso();
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
                  axios.put("api/curso/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarCurso();
                });
                
            },
            activar(row, index){
                axios.put("api/curso/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarContenidoPeligroso(){
                this.listarCursos.filtrosBusqueda.contenidoPeligroso = true;
                this.listarCurso();
            },
            obtenerTipo(row){
                if (row.tipo == 1) return 'Inicio';
                else if (row.tipo == 2) return 'Pregunta';
                else if (row.tipo == 1) return 'Publicación';

            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarCursos.filtrosBusqueda);
                window.open(url);
            }

        },
    }
</script>
<style >

</style>
