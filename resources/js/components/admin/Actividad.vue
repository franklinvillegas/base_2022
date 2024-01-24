<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Competencias</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarActividades.filtrosBusqueda.tipo" @change="listarActividad" >
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
            :columns="listarActividades.columns"
            :rows="listarActividades.data"
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
                    <button class="btn btn-outline-success btn-sm btn-icon" @click.prevent="agregarCriterio(props.row, props.index)" data-toggle="tooltip" title="Agregar"><i class="fas fa-plus"></i> Criterios
            </button>
                <button class="btn btn-outline-secondary btn-sm btn-icon" @click.prevent="ver(props.row, props.index)" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-info btn-sm btn-icon" @click.prevent="editar(props.row, props.index)" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm btn-icon" @click.prevent="eliminar(props.row, props.index)" data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </span>
            </template>
            </vue-good-table>
        </div>
        <!-- Modal -->
        <template>
            <div class="modal fade" id="modal-actividad" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    v-model="modal.actividad.nombre"
                                    class="form-control"
                                    data-vv-as="Nombre"
                                    placeholder="Nombre"
                                    name="nombre"
                                    v-validate="'required|max:300'">
                                    <span class="text-danger">{{errors.first("form_registro.nombre")}}</span>
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
                                        <select name="id_gracur"
                                        class="form-control"
                                        v-model="modal.actividad.id_gracur "
                                        data-vv-as="id_gracur"
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
        <template>
      <div
        class="modal fade"
        id="modal-agregarCriterio"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5
                class="modal-title"
                id="exampleModalLongTitle"
                v-text="modalAgregar.titulo"
              ></h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form" data-vv-scope="form_registro_criterio">
                <div class="row">
                <div class="form-group col-6">
                    <p class="m-0">
                      <strong>Competencia</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modalAgregar.actividad.actividad"
                      disabled
                      class="form-control"
                      data-vv-as="Nombre"
                      placeholder="Nombre"
                      name="nombre"
                      :id="modalAgregar.actividad.id"
                      v-validate="'required'"
                    />
                  </div>
                  <div class="form-group col-10">
                    <p class="m-0">
                      <strong>Criterios</strong>
                    </p>
                    <input type="text"
                      name="criterio"
                      class="form-control"
                      v-model="modalAgregar.actividad.criterio"
                      data-vv-as="Criterio"
                      placeholder="Criterio"
                      v-validate="'required|max:300'"
                    >
                    <span class="text-danger">{{
                      errors.first("form_registro_criterio.criterio")
                    }}</span>
                  </div>
                  <div class="form-group col-2">
                    <p class="m-0 col-12">
                      <strong> &nbsp;</strong>
                    </p>
                    <button
                      type="button"
                      class="btn btn-success"
                      @click="guardarAgregarCriterio"
                    >
                      Agregar
                    </button>
                  </div>
                </div>
                <div class="table-responsive">
                  <vue-good-table
                    :columns="listarActividadCriterios.columns"
                    :rows="listarActividadCriterios.data"
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

                        <button
                          class="btn btn-outline-danger btn-sm btn-icon"
                          @click.prevent="eliminarGradoCurso(props.row, props.index)"
                          data-toggle="tooltip"
                          title="Eliminar"
                        >
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </span>
                    </template>
                  </vue-good-table>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline-primary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
              <button
                type="button"
                v-if="modal.tipo == 'nuevo'"
                class="btn btn-primary"
                @click="guardar"
              >
                Guardar
              </button>
              <button
                type="button"
                v-else-if="modal.tipo == 'editar'"
                class="btn btn-primary"
                @click="modificar"
              >
                Actualizar
              </button>
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
                listarActividades:{
                    data: [],
                    columns:[
                        {label: 'Nombre', field: 'nombre',},
                        {label: 'F.Creación', field: 'created_at',},
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
                    id_lib_cur: null,
                    actividad:{
                        nombre: '',
                        id_gracur: '',
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
                listarNiveles:[],
                listarGrados: [],
                listarCursos: [],
                listarGradoCurso:[],
                modalAgregar: {
                    tipo: "",
                    titulo: "",
                    curso: null,
                    actividad: {
                        nombre: "",
                        id_actividad: "",
                        id_criterio:"",
                        criterio:'',
                    },
                },
                listarActividadCriterios: {
                    data: [],
                    columns: [
                    { label: "Criterio", field: "nombre" },
                    { label: "Opciones", field: "options" },
                    ],
                    total: 0,
                    filtrosBusqueda: {
                    tipo: "",
                    orden: "asc",
                    ordenPor: "id",
                    regPagina: "10",
                    },
                    deshabilitarEdicion: false,
                },
            }
        },
        created(){
            this.listarActividad();
            this.listarNivel();

        },
        methods:{
            listarActividad(){
                axios.get("api/actividad/listar"+Helper.getFilterURL(this.listarActividades.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarActividades.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarNivel(){
                axios.get("api/nivel/listar"+Helper.getFilterURL(this.listarActividades.filtrosBusqueda))
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
                    nivelID: null,
                    actividad:{
                        nombre:'',
                        id_gracur: '',
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
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-actividad").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nueva competencia';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-actividad").modal('show');
                this.limpiarFormulario();
                console.log(row);
                this.listarGrado(row.grado_curso.grado.id_nivel);
                this.listarCurso(row.grado_curso.id_grado);
                this.modal = {
                    titulo:  'Ver Competencia',
                    tipo: 'ver',
                    nivelID: row.grado_curso.grado.id_nivel,
                    actividad:{
                        nombre: row.nombre,
                        id_gracur: row.id_gracur,
                    },
                    grado_curso: row.grado_curso,
                    deshabilitado: true,
                    deshabilitado: true
                }
            },
            editar(row, index){
                $("#modal-actividad").modal('show');
                this.limpiarFormulario();
                 this.listarGrado(row.grado_curso.grado.id_nivel);
                this.listarCurso(row.grado_curso.id_grado);
                this.modal = {
                    titulo:  'Editar Competencia',
                    tipo: 'editar',
                    id_actividad:row.id,
                    nivelID: row.grado_curso.grado.id_nivel,
                    actividad:{
                        nombre: row.nombre,
                        id_gracur: row.id_gracur,
                    },
                    grado_curso: row.grado_curso,
                      deshabilitado: false
                }
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {
                        axios.post("api/actividad/crear", this.modal.actividad)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-actividad").modal('hide');
                            this.listarActividad();
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
                        axios.put("api/actividad/modificar/" + this.modal.id_actividad, this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-actividad").modal('hide');
                            this.listarActividad();
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
                    axios.put("api/actividad/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarActividad();
                });

            },
            activar(row, index){
                axios.put("api/actividad/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarContenidoPeligroso(){
                this.listarActividades.filtrosBusqueda.contenidoPeligroso = true;
                this.listarActividad();
            },
            obtenerTipo(row){
                if (row.tipo == 1) return 'Inicio';
                else if (row.tipo == 2) return 'Pregunta';
                else if (row.tipo == 1) return 'Publicación';

            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarActividades.filtrosBusqueda);
                window.open(url);
            },
            agregarCriterio(row, index) {
            $("#modal-agregarCriterio").modal("show");
            // this.limpiarFormulario();
            this.modalAgregar = {
                titulo: "Ver Competencia y Criterios",
                tipo: "ver",
                actividad: {
                    nombre: row.nombre,
                    id_actividad:row.id,
                    id_criterio:'',
                    criterio: '',
                },
                deshabilitado: true,
            };
            this.listarActividadCriterio(row.id);

            },
            guardarAgregarCriterio() {
            this.$validator.validateAll("form_registro_criterio").then((result) => {
                if (result) {
                axios
                    .post("api/criterio/crear", this.modalAgregar.actividad)
                    .then((response) => {
                    this.$toastr.s(response.data.message);
                    this.modalAgregar.actividad.criterio = '';
                    this.$validator.reset();
                    this.listarActividadCriterio(this.modalAgregar.actividad.id_actividad);
                    })
                    .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                    });
                }
            });

            },
            listarActividadCriterio(id_actividad) {
            axios
                .get(
                "api/criterio/listar/" +id_actividad
                )
                .then((response) => {
                let data = response.data;
                console.log("sadasd",data);
                this.listarActividadCriterios.data = data;
                })
                .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
                });
            },
            eliminarGradoCurso(row, index) {
                 this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                axios
                .put("api/criterio/eliminar/" + row.id)
                .then((response) => {
                this.$toastr.s(response.data.message);
                row.activo = false;
                this.listarActividadCriterio(this.modalAgregar.actividad.id_actividad);
                })
                .catch((error) => {
                this.$toastr.e(error.response.data.message);
                });
            this.listarGrado();
                });

            },

        },
    }
</script>
<style >

</style>
