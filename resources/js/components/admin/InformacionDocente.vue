<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Docentes</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listaDocentes.filtrosBusqueda.tipo" @change="listarDocentes" > 
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
            :columns="listaDocentes.columns"
            :rows="listaDocentes.data"
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
                    <button class="btn btn-outline-success btn-sm btn-icon" @click.prevent="agregarCurso(props.row, props.index)" data-toggle="tooltip" title="Agregar"
                    >
                        <i class="fas fa-plus"></i> Cursos
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
            <div class="modal fade" id="modal-Docente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle" v-text="modal.titulo"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form d-flex flex-wrap" data-vv-scope="form_registro">
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Tipo de Documento</strong>
                                    </p>
                                    <select name="tipo_documento" 
                                    v-model="modal.persona.id_docid" 
                                    class="form-control" 
                                    data-vv-as="Tipo de documento"
                                    v-validate="'required'"> 
                                        <option v-for="row in listarTipoDocs" :key="row.id" :value="row.id" v-text="row.tipo" ></option>
                                    </select>
                                    <span class="text-danger">{{errors.first("form_registro.tipo_documento")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Documento</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.num_docid"
                                    class="form-control"
                                    data-vv-as="Documento"
                                    placeholder="Documento"
                                    name="num_docid"
                                    v-validate="'required|digits:8'">
                                    <span class="text-danger">{{errors.first("form_registro.num_docid")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div v-if="modal.tipo == 'nuevo'">
                                    <p class="m-0">
                                        <strong>Buscar persona</strong>
                                    </p>
                                    <button type="button"  class="btn btn-secondary" :disabled="modal.persona.num_docid==''" @click="buscar(modal.persona.num_docid)"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Apellido Paterno</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.apellido_pat"
                                    class="form-control"
                                    data-vv-as="Apellido Paterno"
                                    placeholder="Apellido Paterno"
                                    name="apellido_pat"
                                    :disabled="modal.existe"
                                    v-validate="'required|alpha_spaces|max:50'">
                                    <span class="text-danger">{{errors.first("form_registro.apellido_pat")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Apellido Materno</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.apellido_mat"
                                    class="form-control"
                                    data-vv-as="Apellido_mat"
                                    :disabled="modal.existe"
                                    placeholder="Apellido Materno"
                                    name="apellido_mat"
                                    v-validate="'required|alpha_spaces|max:50'">
                                    <span class="text-danger">{{errors.first("form_registro.apellido_mat")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Nombres</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.nombres"
                                    class="form-control"
                                    data-vv-as="Nombres"
                                    placeholder="Nombres"
                                    name="nombres"
                                    :disabled="modal.existe"
                                    v-validate="'required|alpha_spaces|max:200'">
                                    <span class="text-danger">{{errors.first("form_registro.nombres")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Sexo</strong>
                                    </p>
                                    <select
                                    v-model="modal.persona.sexo"
                                    class="form-control"
                                    data-vv-as="Sexo"
                                    placeholder="Sexo"
                                    name="sexo"
                                    :disabled="modal.existe"
                                    v-validate="'required'"> 
                                        <option value="Femenino">Femenino</option>
                                        <option value="Masculino">Masculino</option>
                                    </select>
                                    <span class="text-danger">{{errors.first("form_registro.sexo")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Telefono 1</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.telefono1"
                                    class="form-control"
                                    data-vv-as="Telefono1"
                                    placeholder="Telefono 1"
                                    name="telefono1"
                                    v-validate="'digits:9'"
                                    :disabled="modal.existe">
                                    <span class="text-danger">{{errors.first("form_registro.telefono1")}}</span>                                                                        
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Telefono 2</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.telefono2"
                                    class="form-control"
                                    data-vv-as="Telefono2"
                                    placeholder="Telefono 2"
                                    name="telefono2"
                                    v-validate="'digits:9'"
                                    :disabled="modal.existe">
                                    <span class="text-danger">{{errors.first("form_registro.telefono2")}}</span>
                                    
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Fecha de Nacimiento</strong>
                                    </p>
                                    <input type="date"
                                    v-model="modal.persona.fecha_nac"
                                    class="form-control"
                                    data-vv-as="Fecha_nac"
                                    placeholder="Fecha_nac"
                                    name="fecha_nac"
                                    v-validate="'required'"
                                    :disabled="modal.existe">
                                    <span class="text-danger">{{errors.first("form_registro.fecha_nac")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Dirección</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.persona.direccion"
                                    class="form-control"
                                    data-vv-as="direccion"
                                    placeholder="direccion"
                                    name="direccion"
                                    v-validate="'max:200'"
                                    :disabled="modal.existe">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="m-0">
                                        <strong>Especialidad</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.docente.especialidad"
                                    class="form-control"
                                    data-vv-as="Especialidad"
                                    placeholder="Especialidad"
                                    name="especialidad"
                                    v-validate="'required|max:30'">
                                    <span class="text-danger">{{errors.first("form_registro.especialidad")}}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="m-0">
                                        <strong>Grado</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.docente.grado_academico"
                                    class="form-control"
                                    data-vv-as="Grado"
                                    placeholder="Grado"
                                    name="grado_academico"
                                    v-validate="'required|max:100'">
                                    <span class="text-danger">{{errors.first("form_registro.grado_academico")}}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="m-0">
                                        <strong>Contrato</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.docente.contrato"
                                    class="form-control"
                                    data-vv-as="Contrato"
                                    placeholder="Contrato"
                                    name="contrato"
                                    v-validate="'required|max:30'">
                                    <span class="text-danger">{{errors.first("form_registro.contrato")}}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="m-0">
                                        <strong>Estado</strong>
                                    </p>
                                    <div class="custom-control custom-checkbox mb-05">
                                        <input type="checkbox" class="custom-control-input" name="estado" id="estado" v-model="modal.docente.estado">
                                        <label v-if="modal.docente.estado==true" class="custom-control-label" for="estado">Activo</label>
                                        <label v-else class="custom-control-label" for="estado">Inactivo</label>
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

         <!-- Modal agregar Cursos -->
        <template>
            <div
            class="modal fade"
            id="modal-agregarCurso"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
            >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5>Asignar Cursos a Docente</h5>  
                    <h5
                    class="modal-title"
                    id="exampleModalLongTitle"
                    v-text="modal.titulo"
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
                    <form class="form" data-vv-scope="form_registro_docente_curso">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <p class="m-0">
                                <strong>Año</strong>
                            </p>
                            <input type="text"
                            v-model="modalAgregar.docente_curso.anio"
                            class="form-control"
                            data-vv-as="Año"
                            placeholder="Año"
                            name="anio">
                            <span class="text-danger">{{
                              errors.first("form_registro_docente_curso.anio")
                            }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <p class="m-0">
                                <strong>Fecha inicio</strong>
                            </p>
                            <input type="date"
                            v-model="modalAgregar.docente_curso.fecha_inicio"
                            class="form-control"
                            data-vv-as="Inicio"
                            placeholder="Inicio"
                            name="fecha_inicio">
                            <span class="text-danger">{{
                              errors.first("form_registro_docente_curso.fecha_inicio")
                            }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <p class="m-0">
                                <strong>Fecha fin</strong>
                            </p>
                            <input type="date"
                            v-model="modalAgregar.docente_curso.fecha_fin"
                            class="form-control"
                            data-vv-as="Fin"
                            placeholder="Fin"
                            name="fecha_fin">
                            <span class="text-danger">{{errors.first("form_registro_docente_curso.fecha_fin")}}</span>
                        </div>
                        <div class="form-group col-4">
                            <p class="m-0">
                                <strong>Nivel</strong>
                            </p>
                            <select
                                name="id_nivel"
                                class="form-control"
                                v-model="modalAgregar.id_nivel"
                                data-vv-as="Nivel"
                                placeholder="Seleccione Nivel"
                                v-validate="'required'"
                                @change="listarGrado(modalAgregar.id_nivel)"
                            >
                                <option
                                v-for="row in listarNiveles"
                                :key="row.id"
                                :value="row.id"
                                v-text="row.nombre"
                                ></option>
                            </select>
                            <span class="text-danger">{{
                                errors.first("form_registro_docente_curso.id_nivel")
                            }}</span>
                        </div>
                        <div class="form-group col-4">
                            <p class="m-0">
                                <strong>Grado</strong>
                            </p>
                            <select
                                name="id_grado"
                                class="form-control"
                                v-model="modalAgregar.id_grado"
                                data-vv-as="Grado"
                                placeholder="Seleccione Grado"
                                v-validate="'required'"
                                @change="listarComponentes(modalAgregar.id_grado)"
                            >
                                <option
                                v-for="row in listarGrados"
                                :key="row.id"
                                :value="row.id"
                                v-text="row.grado"
                                ></option>
                            </select>
                            <span class="text-danger">{{
                                errors.first("form_registro_docente_curso.id_grado")
                            }}</span>
                        </div>
                        <div class="form-group col-4">
                            <p class="m-0">
                                <strong>Sección</strong>
                            </p>
                            <select
                                name="id_seccion"
                                class="form-control"
                                v-model="modalAgregar.docente_curso.id_seccion"
                                data-vv-as="Sección"
                                placeholder="Seleccione Sección"
                                v-validate="'required'"
                            >
                                <option
                                v-for="row in listarSecciones"
                                :key="row.id"
                                :value="row.id"
                                v-text="row.seccion"
                                ></option>
                            </select>
                            <span class="text-danger">{{
                                errors.first("form_registro_docente_curso.id_seccion")
                            }}</span>
                        </div>
                        <div class="form-group col-10">
                        <p class="m-0">
                            <strong>Cursos</strong>
                        </p>
                        <select
                            name="curso"
                            class="form-control"
                            v-model="modalAgregar.docente_curso.id_curso"
                            data-vv-as="Curso"
                            placeholder="Seleccione Curso"
                            v-validate="'required'"
                        >
                            <option
                            v-for="row in listarCursos"
                            :key="row.id_curso"
                            :value="row.id_curso"
                            v-text="row.curso.nombre"
                            ></option>
                        </select>
                        <span class="text-danger">{{
                            errors.first("form_registro_docente_curso.curso")
                        }}</span>
                        </div>
                        <div class="form-group col-2">
                        <p class="m-0 col-12">
                            <strong> &nbsp;</strong>
                        </p>
                        <button
                            type="button"
                            class="btn btn-success"
                            @click="guardarAgregarCurso"
                        >
                            Agregar
                        </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <vue-good-table
                        :columns="listarDocenteCursos.columns"
                        :rows="listarDocenteCursos.data"
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
                                @click.prevent="eliminarDocenteCurso(props.row, props.index)"
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
                listaDocentes:{
                    data: [],
                    columns:[
                        {label: 'N° Doc', field: 'persona.num_docid',},
                        {label: 'Apellidos y Nombres', field: 'nombre_completo' ,},
                        {label: 'Especialidad', field: 'especialidad',},
                        {label: 'Grado', field: 'grado_academico',},
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
                listarDocenteCursos: {
                    data: [],
                    columns: [
                    { label: "Curso", field: "curso.nombre" },
                    { label: "Sección", field: "seccion.seccion" },
                    { label: "Año", field: "anio" },
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
                listarTipoDocs:[],
                listarNiveles: [],
                listarGrados:[],
                listarSecciones:[],
                listarCursos:[],
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    tipo_documento: null,
                    existe:null,
                    docente:{
                        especialidad:'',
                        grado_academico:'',
                        contrato:'',
                        estado:'',
                        id_per:'',
                        estado:'',  
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:'',
                        direccion:'',
                        id_docid:'',
                        id_dist:'1', 
                    },
                },
                modalAgregar: {
                    tipo: "",
                    titulo: "",
                    id_nivel: null,
                    id_grado: null,
                    docente_curso: {
                        anio: new Date().getFullYear(),
                        fecha_inicio: null,
                        fecha_fin: null,
                        id_curso: '',
                        id_seccion: '',
                        id_docente: '',
                    },
                },
            }
        },
        created(){
            this.listarDocentes();
            this.listarTipoDoc();
            this.listarNivel();
        },
        methods:{
            listarTipoDoc(){
                axios.get("api/documento/listar")
                .then((response) => {
                    let data = response.data;
                    this.listarTipoDocs = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
            listarNivel() {
            axios
                .get(
                "api/nivel/listar" +
                    Helper.getFilterURL(this.listarGrados.filtrosBusqueda)
                )
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
            listarDocentes(){
                axios.get("api/docente/listar"+Helper.getFilterURL(this.listaDocentes.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    data.map(element => {
                        element.nombre_completo = element.persona.apellido_pat + " " + element.persona.apellido_mat + " " + element.persona.nombres;
                        return element;
                    });
                    this.listaDocentes.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
           
            limpiarFormulario(){
                console.log('entro limpiar');
                this.modal={
                    tipo: '',
                    titulo:  '',
                    existe:null,
                    tipo_documento: null,
                    docente:{
                        especialidad:'',
                        grado_academico:'',
                        contrato:'',
                        estado:'',
                        id_per:'', 
                        estado:'',  
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'Femenino',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:'',
                        direccion:'',
                        id_docid:'',
                        id_dist:'1', 
                    },
                
                    deshabilitado: false,   
                },
                this.$validator.reset();
            },
            limpiarFormularioBuscar(){
                console.log('entro limpiar buscar');
                this.modal={
                    tipo: '',
                    existe:null,
                    titulo:  'Nuevo Docente',
                    docente:{
                        especialidad:'',
                        grado_academico:'',
                        contrato:'',
                        estado:'',
                        id_per:'',    
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'Femenino',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:this.modal.persona.num_docid,
                        // direccion:'',
                        id_dist:'1', 
                    },
                
                    deshabilitado: false,   
                },
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-Docente").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo Docente';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-Docente").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Ver Docente',
                    tipo: 'ver',
                    docente:{
                        id_per:'1',
                    },
                    persona:{
                        id_docid:'',
                        num_docid:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        nombres:'',
                        sexo:'',

                    },
                    deshabilitado: true
                }
            },
            editar(row, index){
                $("#modal-Docente").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Editar Docente',
                    tipo: 'editar',
                    // nivelID: row.id,
                     docente:{
                         id:row.id,
                        especialidad:row.especialidad,
                        grado_academico:row.grado_academico,
                        contrato:row.contrato,
                        estado:row.estado,
                        id_per:row.id_per,   
                    },
                    persona:{
                        id:row.persona.id,
                        id_docid:row.persona.id_docid,
                        nombres:row.persona.nombres,
                        apellido_pat:row.persona.apellido_pat,
                        apellido_mat:row.persona.apellido_mat,
                        sexo:row.persona.sexo,
                        telefono1:row.persona.telefono1,
                        telefono2:row.persona.telefono2,
                        fecha_nac:row.persona.fecha_nac,
                        num_docid:row.persona.num_docid,
                        direccion:row.persona.direccion,
                        id_docid:row.persona.id_docid,
                        id_dist:row.persona.id_dist, 
                    },
                    deshabilitado: false
                }
              
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 
                        axios.post("api/docente/crear", this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-Docente").modal('hide');
                            this.listarDocentes();
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
                        axios.put("api/docente/modificar/"+this.modal.docente.id+"/"+this.modal.persona.id,this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-Docente").modal('hide');
                            this.listarDocentes();
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
                   axios.put("api/docente/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarDocentes();
                });
               
            },

            agregarCurso(row, index) {
                $("#modal-agregarCurso").modal("show");
                this.limpiarFormulario();
                this.modalAgregar = {
                    tipo: "Ver cursos",
                    titulo: "ver",
                    id_nivel: null,
                    id_grado: null,
                    docente_curso: {
                        anio: new Date().getFullYear(),
                        fecha_inicio: null,
                        fecha_fin: null,
                        id_curso: '',
                        id_seccion: '',
                        id_docente: row.id,
                    },
                    deshabilitado: true,
                },
                this.listarDocenteCurso(row.id);
            },

            listarDocenteCurso(id_docente) {
            axios
                .get(
                "api/docente_curso/listar/" +id_docente
                )
                .then((response) => {
                let data = response.data;
                console.log("sadasd",data);
                this.listarDocenteCursos.data = data;
                })
                .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
                });
            },

            guardarAgregarCurso() {
                this.$validator.validateAll("form_registro_docente_curso").then((result) => {
                    if (result) {
                    axios
                        .post("api/docente_curso/crear", this.modalAgregar.docente_curso)
                        .then((response) => {
                        this.$toastr.s(response.data.message);
                        this.listarDocenteCurso(this.modalAgregar.docente_curso.id_docente);
                        })
                        .catch((error) => {
                        console.log(error);
                        this.$toastr.e(error.response.data.message);
                        });
                    }
                });
            },

            listarComponentes(id_grado){
                this.listarSeccion(id_grado);
                this.listarCurso(id_grado);
            },

            listarSeccion(id_grado){
                axios.get("api/seccion/llenar_combo/"+id_grado)
                .then((response) => {
                    let data = response.data;
                    this.listarSecciones = data;
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

            eliminarDocenteCurso(row, index) {
                 this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios
                .put("api/docente_curso/eliminar/" + row.id)
                .then((response) => {
                this.$toastr.s(response.data.message);
                row.activo = false;
                this.listarDocenteCurso(row.id_docente);
                })
                .catch((error) => {
                this.$toastr.e(error.response.data.message);
                });
            this.listarGrado();
                });
            
            },

            activar(row, index){
                axios.put("api/docente/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarContenidoPeligroso(){
                this.listaDocentes.filtrosBusqueda.contenidoPeligroso = true;
                this.listarDocentes();
            },
            obtenerTipo(row){
                if (row.tipo == 1) return 'Inicio';
                else if (row.tipo == 2) return 'Pregunta';
                else if (row.tipo == 1) return 'Publicación';

            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listaDocentes.filtrosBusqueda);
                window.open(url);
            },
            buscar(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra, continue con el registro');
                            this.limpiarFormularioBuscar()
                            this.modal.tipo='nuevo';
                            }
                            else{
                            this.modal.persona=response.data;  
                            this.modal.docente.id_per=response.data.id;
                            this.modal.existe=response.data.id;
                        
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                   
            },
            
        },
    }
</script>
<style >
  .modal-dialog{
      max-width: 800px;
  }
</style>