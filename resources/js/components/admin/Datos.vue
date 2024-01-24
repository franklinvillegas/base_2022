<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Alumnos</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listaAlumnos.filtrosBusqueda.tipo" @change="listarAlumnos" > 
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
            :columns="listaAlumnos.columns"
            :rows="listaAlumnos.data"
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
            <div class="modal fade" id="modal-Alumno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                                        <option value="FEMENINO" selected>FEMENINO</option>
                                        <option value="MASCULINO">MASCULINO</option>
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
                                <div class="form-group col-md-12">
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
                                    <p class="m-0">
                                        <strong>Talla (m)</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.alumno.talla"
                                    class="form-control"
                                    data-vv-as="Talla"
                                    placeholder="Talla"
                                    name="talla"
                                    v-validate="'required|decimal:2|max:5'">
                                    <span class="text-danger">{{errors.first("form_registro.talla")}}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <p class="m-0">
                                        <strong>Peso (Kg)</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.alumno.peso"
                                    class="form-control"
                                    data-vv-as="Peso"
                                    placeholder="Peso"
                                    name="peso"
                                    v-validate="'required|decimal:2|max:5'">
                                    <span class="text-danger">{{errors.first("form_registro.peso")}}</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <!-- <p class="m-0">
                                        <strong>Alergias</strong>
                                    </p>
                                    <input type="text"
                                    
                                   
                                    data-vv-as="Alergias"
                                    placeholder="Alergias"
                                    name="alergias"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.alergias")}}</span> -->
                                    <div class="custom-control custom-checkbox mb-05">
                                        <input type="checkbox" class="custom-control-input"  name="alergias" id="alergias" v-model="modal.alumno.alergias">
                                        <label class="custom-control-label" for="alergias">Alergias</label>
                                    </div>
                                    <!-- <p class="m-0">
                                        <strong>Detalle Alergias</strong>
                                    </p> -->
                                    <div v-if="modal.alumno.alergias==true">
                                        <textarea type="text"
                                        v-model="modal.alumno.detalle_alergia"
                                        class="form-control"
                                        data-vv-as="Detalle de Alergias"
                                        placeholder="Detalle de alergias"
                                        name="detalle_alergia"
                                        v-validate="'required'"></textarea>
                                        <span class="text-danger">{{errors.first("form_registro.detalle_alergia")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <!-- <p class="m-0">
                                        <strong>Discapacidad</strong>
                                    </p>
                                    <input type="text"
                                    
                                    class="form-control"
                                    data-vv-as="Discapacidad"
                                    placeholder="Discapacidad"
                                    
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.discapacidad")}}</span> -->
                                    <div class="custom-control custom-checkbox mb-05">
                                        <input type="checkbox" class="custom-control-input" name="discapacidad" id="discapacidad" v-model="modal.alumno.discapacidad">
                                        <label class="custom-control-label" for="discapacidad">Discapacidad</label>
                                    </div>
                                    <div v-if="modal.alumno.discapacidad==true">
                                        <textarea type="text"
                                        v-model="modal.alumno.detalle_discapacidad"
                                        class="form-control"
                                        data-vv-as="Detalle de Discapacidad"
                                        placeholder="Detalle de discapacidad"
                                        name="detalle_discapacidad"
                                        v-validate="'required'"></textarea>
                                        <span class="text-danger">{{errors.first("form_registro.detalle_discapacidad")}}</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <!-- <p class="m-0">
                                        <strong>Enfermedad</strong>
                                    </p>
                                    <input type="text"
                                    
                                    class="form-control"
                                    data-vv-as="Enfermedad"
                                    placeholder="Enfermedad"
                                    name="enfermedad"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.enfermedad")}}</span> -->
                                    <div class="custom-control custom-checkbox mb-05">
                                        <input type="checkbox" class="custom-control-input" name="enfermedad" id="enfermedad" v-model="modal.alumno.enfermedad">
                                        <label class="custom-control-label" for="enfermedad">Enfermedad</label>
                                    </div>
                                    <div v-if="modal.alumno.enfermedad==true">
                                        <textarea type="text"
                                        v-model="modal.alumno.detalle_enfermedad"
                                        class="form-control"
                                        data-vv-as="Nombre"
                                        placeholder="Detalle de enfermedad"
                                        name="detalle_enfermedad"
                                        v-validate="'required'"></textarea>
                                        <span class="text-danger">{{errors.first("form_registro.detalle_enfermedad")}}</span>
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

    export default {
        name:'Ayudas',
        components:{
        },
        data(){
            return{
                listaAlumnos:{
                    data: [],
                    columns:[
                        {label: 'N° Doc', field: 'persona.num_docid',},
                        {label: 'Apellidos y Nombres', field: 'nombre_completo' ,},
                        {label: 'Grado', field: 'matricula.seccion.grado.grado',},
                        {label: 'Seccion', field: 'matricula.seccion.seccion',},
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
                listarTipoDocs:[],
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    tipo_documento: null,
                    existe:null,
                    alumno:{
                        talla:'',
                        peso:'',
                        alergias:'',
                        detalle_alergia:'',
                        discapacidad:'',
                        detalle_discapacidad:'',
                        enfermedad:'',
                        detalle_enfermedad:'',
                        otros:'',
                        estado:'',
                        id_per:'',   
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:'',
                        direccion:'',
                        id_docid:'',
                        id_dist:'1', 
                    },
                },

            }
        },
        created(){
            this.listarAlumnos();
            this.listarTipoDoc();

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
            listarAlumnos(){
                axios.get("api/alumno/listar"+Helper.getFilterURL(this.listaAlumnos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    data.map(element => {
                        element.nombre_completo = element.persona.apellido_pat + " " + element.persona.apellido_mat + " " + element.persona.nombres;
                        return element;
                    });
                    this.listaAlumnos.data = data;
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
                    alumno:{
                        talla:'',
                        peso:'',
                        alergias:false,
                        detalle_alergia:'',
                        discapacidad:false,
                        detalle_discapacidad:'',
                        enfermedad:false,
                        detalle_enfermedad:'',
                        otros:'',
                        estado: 1,
                        id_per:'',   
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
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
                    titulo:  'Nuevo Alumno',
                    alumno:{
                        talla:'',
                        peso:'',
                        alergias:false,
                        detalle_alergia:'',
                        discapacidad:false,
                        detalle_discapacidad:'',
                        enfermedad:false,
                        detalle_enfermedad:'',
                        otros:'',
                        estado: 1,
                        id_per:'',   
                    },
                    persona:{
                        id_docid:'',
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:this.modal.persona.num_docid,
                        direccion:'',
                        id_dist:'1', 
                    },
                
                    deshabilitado: false,   
                },
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-Alumno").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo Alumno';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-Alumno").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Ver Alumno',
                    tipo: 'ver',
                    alumno:{
                        id:row.id,
                        talla:row.talla,
                        peso:row.peso,
                        alergias:row.alergias,
                        detalle_alergia:row.detalle_alergia,
                        discapacidad:row.discapacidad,
                        detalle_discapacidad:row.detalle_discapacidad,
                        enfermedad:row.enfermedad,
                        detalle_enfermedad:row.detalle_enfermedad,
                        otros:row.otros,
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
                    deshabilitado: true
                }
            },
            editar(row, index){
                $("#modal-Alumno").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Editar Alumno',
                    tipo: 'editar',
                    // nivelID: row.id,
                     alumno:{
                         id:row.id,
                        talla:row.talla,
                        peso:row.peso,
                        alergias:row.alergias,
                        detalle_alergia:row.detalle_alergia,
                        discapacidad:row.discapacidad,
                        detalle_discapacidad:row.detalle_discapacidad,
                        enfermedad:row.enfermedad,
                        detalle_enfermedad:row.detalle_enfermedad,
                        otros:row.otros,
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
                        axios.post("api/alumno/crear", this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-Alumno").modal('hide');
                            this.listarAlumnos();
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
                        axios.put("api/alumno/modificar/"+this.modal.alumno.id+"/"+this.modal.persona.id,this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-Alumno").modal('hide');
                            this.listarAlumnos();
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
                  axios.put("api/alumno/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                console.log('si deberioa borrar');
                this.listarAlumnos();
                });
                
            },
            activar(row, index){
                axios.put("api/alumno/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            listarContenidoPeligroso(){
                this.listaAlumnos.filtrosBusqueda.contenidoPeligroso = true;
                this.listarAlumnos();
            },
            obtenerTipo(row){
                if (row.tipo == 1) return 'Inicio';
                else if (row.tipo == 2) return 'Pregunta';
                else if (row.tipo == 1) return 'Publicación';

            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listaAlumnos.filtrosBusqueda);
                window.open(url);
            },
            buscar(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra, continue con el registro');
                            this.limpiarFormularioBuscar();
                            this.modal.tipo='nuevo';
                            }
                            else{
                            this.limpiarFormularioBuscar();
                            this.modal.persona=response.data;  
                            this.modal.alumno.id_per=response.data.id;
                            this.modal.existe=response.data.id;
                            this.modal.tipo='nuevo';
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