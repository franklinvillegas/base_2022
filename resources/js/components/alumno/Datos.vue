<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;">
        <h4 class="text-color-2 mb-3">Información de Alumno</h4></div>
        <template>
            <div class="row p-t">
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
                                    readonly
                                    >
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
                                    name="num_docid" readonly>
                                    <span class="text-danger">{{errors.first("form_registro.num_docid")}}</span>
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
                                    readonly>
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
                                    readonly>
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
                                    readonly>
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
                                    readonly>
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
                                    readonly>
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
                                    readonly>
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
                                    readonly>
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
                                    name="fecha_nac"
                                    readonly>
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
                                    readonly>
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
                                    readonly>
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
                        {label: 'Grado', field: 'grado',},
                        {label: 'Seccion', field: 'seccion',},
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
            this.ver(2);
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
            ver($id){
                axios.get("api/alumno/ver/"+$id)
                .then((response) => {
                    let data = response.data;
                    this.modal.alumno = data;
                    this.modal.persona=data.persona;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
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
                            this.limpiarFormularioBuscar()
                            this.modal.tipo='nuevo';
                            }
                            else{
                            this.modal.persona=response.data;
                            this.modal.alumno.id_per=response.data.id;
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
