<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -10px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevoUsuario"> Nuevo </button>
        <h4 class="text-color-2 mb-3 ">Mantenimiento Usuarios</h4></div>
        <hr>
        <div class="row p-t">
            <div class="col-md-5">
                <label for="" class="form-label">Tipo</label>
                <select class="form-control" v-model="listaUsuarios.filtrosBusqueda.tipo" @change="listarUsuarios">
                    <option value="">-- Todos --</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Docente">Docente</option>
                    <option value="Alumno">Alumno</option>
                </select>
            </div>
            <div class="col-md-7">
                <label for="" class="form-label">Fecha de creación</label>
                <template>
                    <date-range-picker
                        style="width: 100%;height:40px;"
                        v-model="dateRange"
                        :locale-data="{
                            direction: 'ltr',
                            format: 'yyyy/mm/dd',
                            separator: ' - ',
                            applyLabel: 'Apply',
                            cancelLabel: 'Cancel',
                            weekLabel: 'W',
                            customRangeLabel: 'Custom Range',
                            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                            monthNames: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dec'],
                            firstDay: 0
                        }"
                        :auto-apply="true"
                        :show-dropdowns="true"
                        :show-week-numbers="false"
                        :linked-calendars="false"
                        :single-date-picker="'range'"
                        :always-show-calendars="true"
                        :range="false"
                        :append-to-body="true"
                        @update="seleccionoFecha"
                    ></date-range-picker>
                </template>
            </div>
        </div>
        <br>    
        <button class="btn btn-outline-secondary float-right" type="button" @click="exportar">
            <i class="fas fa-download"></i>
            Exportar 
        </button><br>
        <div class="table-responsive m-t">
            <vue-good-table
            :columns="listaUsuarios.columns"
            :rows="listaUsuarios.data"
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
                <button v-if="props.row.es_admin == false" class="btn btn-outline-success mt btn-sm btn-icon" @click.prevent="enviarMensaje(props.row, props.index)" data-toggle="tooltip" title="Enviar Mensaje"><i class="fas fa-envelope"></i></button>
                <button v-if="props.row.activo == true" class="btn btn-outline-danger mt btn-sm btn-icon" @click.prevent="inactivar(props.row, props.index)" data-toggle="tooltip" title="Inactivar"><i class="fas fa-trash-alt"></i></button>
                <button v-else class="btn btn-outline-success btn-sm btn-icon" @click.prevent="activar(props.row, props.index)" data-toggle="tooltip" title="Activar"><i class="fas fa-check"></i></button>
                </span>
            </template>
            </vue-good-table>
        </div>
        <!-- Modal -->
        <template>
            <div class="modal fade" id="modal-administrador" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                        <strong>Usuario</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.usuario.email"
                                    class="form-control"
                                    data-vv-as="Usuario"
                                    name="email"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.email")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Contraseña</strong>
                                        <template v-if="modal.tipo=='editar'">
                                            <br>
                                            <input type="checkbox" id="editar-password" v-model="modal.usuario.editarPassword">
                                            <label for="editar-password">Editar contraseña</label>
                                        </template>
                                    </p>
                                    <input type="text" v-if="modal.usuario.editarPassword"
                                    v-model="modal.usuario.password"
                                    class="form-control"
                                    data-vv-as="Contraseña"
                                    name="password"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.password")}}</span>
                                </div>  
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Tipo Usuario</strong>
                                    </p>
                                    <select name="tipo_usuario" v-model="modal.usuario.tipo_usuario" class="form-control">
                                        <option value="">--Seleccione--</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Docente</option>
                                        <option value="3">Alumno</option>
                                    </select>
                                    <span class="text-danger">{{errors.first("form_registro.tipo_usuario")}}</span>
                                </div>  
                                <hr> 
                                <div class="form-group col-md-4">
                                    <div>
                                    <p class="m-0">
                                        <strong>Documento</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.usuario.num_docid"
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
                                    <button type="button"  class="btn btn-secondary" :disabled="modal.usuario.num_docid==''" @click="buscar(modal.usuario.num_docid)"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>                         
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Nombres</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.usuario.nombres"
                                    class="form-control"
                                    data-vv-as="Nombres"
                                    name="nombres"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.nombres")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Apellidos</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.usuario.apellidos"
                                    class="form-control"
                                    data-vv-as="Apellidos"
                                    name="apellidos"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro.apellidos")}}</span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                            <button type="button" v-if="modal.tipo =='nuevo'" class="btn btn-primary" @click="guardar">Guardar</button>
                            <button type="button" v-else-if="modal.tipo =='editar'" class="btn btn-primary" @click="modificar">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

         <template>
            <div class="modal fade" id="modal-usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle" v-text="modalUsuario.titulo"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form" data-vv-scope="form_registro_usuario">
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Usuario</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modalUsuario.usuario.email"
                                    class="form-control"
                                    data-vv-as="Correo electrónico"
                                    name="email"
                                    v-validate="'required'"
                                    disabled>
                                    <span class="text-danger">{{errors.first("form_registro_usuario.email")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Usuario</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modalUsuario.usuario.usuario"
                                    class="form-control"
                                    data-vv-as="Usuario"
                                    name="usuario"
                                    v-validate="'required'"
                                    >
                                    <span class="text-danger">{{errors.first("form_registro_usuario.usuario")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>ocupacion</strong>
                                    </p>
                                    <multiselect
                                        v-model="modalUsuario.usuarioOcupacionSel"
                                        :options="comboOcupacion"
                                        data-vv-as="Ocupación"
                                        name="ocupacion"
                                        v-validate="'required'"
                                        placeholder="-- Seleccione --"
                                        label="nombre"
                                        track-by="id"
                                        :close-on-select="true"
                                        :searchable="true"
                                        :show-labels="false"
                                        :multiple="false"
                                    >
                                    </multiselect>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Nombres</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modalUsuario.usuario.nombres"
                                    class="form-control"
                                    data-vv-as="Nombres"
                                    name="nombres"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro_usuario.nombres")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Apellidos</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modalUsuario.usuario.apellidos"
                                    class="form-control"
                                    data-vv-as="Apellidos"
                                    name="apellidos"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro_usuario.apellidos")}}</span>
                                </div>
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Puesto actual</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modalUsuario.usuario.puesto_actual"
                                    class="form-control"
                                    data-vv-as="Puesto actual"
                                    name="puesto_actual"
                                    v-validate="'required'">
                                    <span class="text-danger">{{errors.first("form_registro_usuario.puesto_actual")}}</span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                            <button type="button" v-if="modalUsuario.tipo =='editar'" class="btn btn-primary" @click="modificarUsuario">Actualizar</button>
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
import DateRangePicker from 'vue2-daterange-picker'

import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

    export default {
        name:'Usuarios',
        components:{
            Multiselect, DateRangePicker,
        },
        data(){
            return{
                listaUsuarios:{
                    data: [],
                    columns:[
                        {label: 'Usuario', field: 'email',},
                        {label: 'Num Doc.', field: 'persona.num_docid',},
                        {label: 'Nombres', field: 'persona.nombres',},
                        {label: 'Apellido Pat', field: 'persona.apellido_pat',},
                        {label: 'Apellido Mat', field: 'persona.apellido_mat',},
                        {label: 'Tipo', field: 'tipo_usuario',},
                        {label: 'U.visita', field: 'ult_visita',},
                        {label: 'F.Creación', field: 'created_at',},
                        {label: 'Opciones', field: 'options',},
                    ],
                    total: 0,
                    filtrosBusqueda:{
                        tipo:'',
                        ocupacion:'',
                        fechaIni: '',
                        fechaFin: '',
                        orden: 'asc',
                        ordenPor: 'id',
                        regPagina: '10',
                    },
                    deshabilitarEdicion: false,
                },
                desabilitado: false,
                botonesActive: {
                    todos: true,
                    misMenciones: false,
                },
                mensaje: {
                    mensaje: '',
                },
                modal:{
                    tipo:  '',
                    titulo:  '',
                    usuarioID: null,
                    usuario:{
                        email: '',
                        num_docid: '',
                        nombres: '',
                        apellidos: '',
                        password: '',
                        tipo_usuario: '',
                        editarPassword: true,
                        es_admin: true
                    }
                },
                modalUsuario:{
                    tipo:  '',
                    titulo:  '',
                    usuarioID: null,
                    usuarioOcupacionSel: null,
                    usuario:{
                        email: '',
                        id_per: '',
                        nombres: '',
                        apellidos: '',
                        password: '',
                        tipo_usuario: '',
                        editarPassword: true,
                        es_admin: true
                    }
                },
                dateRange: {
                    startDate: '',
                    endDate: '', //endDate: '2019-12-28',
                },
                comboOcupacion:[],
                ocupacionesSel: null,
            }
        },
        created(){
           this.listarUsuarios();
        },
        methods:{
            listarUsuarios(){
                axios.get("api/usuario/listar"+Helper.getFilterURL(this.listaUsuarios.filtrosBusqueda))
                .then((response) => {
                    this.listaUsuarios.data =  response.data;
                
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
           
            seleccionoFecha(evt){
                this.listaUsuarios.filtrosBusqueda.fechaIni = Helper.formatearSoloFechaGenerico(evt.startDate);
                this.listaUsuarios.filtrosBusqueda.fechaFin = Helper.formatearSoloFechaGenerico(evt.endDate);
                this.listarUsuarios();
            },
            seleccionoOcupacion(){
                this.listaUsuarios.filtrosBusqueda.ocupacion = (this.ocupacionesSel.map((elem) => elem.id)).join(',');
                this.listarUsuarios();
            },
            limpiarFormulario(){
                this.modal = {
                    tipo:  '',
                    titulo:  '',
                    usuarioID: null,
                    usuario:{
                        email: '',
                        nombres: '',
                        num_docid: '',
                        apellidos: '',
                        password: '',
                        tipo_usuario: '',
                        editarPassword: true,
                        es_admin: true
                    }
                },
                this.$validator.reset();
            },
            nuevoUsuario(){
                $("#modal-administrador").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo usuario';
                this.modal.tipo = 'nuevo';
                
            },
            ver(row, index){
                if(row.es_admin == true){
                    $("#modal-administrador").modal('show');
                    this.limpiarFormulario();
                    this.modal = {
                        tipo: 'ver',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuario:{
                            email: row.email,
                            nombres: row.persona.nombres,
                            apellidos: row.persona.apellido_pat+' '+row.persona.apellido_pat,
                            tipo_usuario: row.tipo_usuario,
                            num_docid:row.persona.num_docid,
                            es_admin: true,
                            editarPassword: true,
                        }
                    }
                }
                else{
                    $("#modal-usuario").modal('show');
                    this.limpiarFormulario();
                    this.modalUsuario = {
                        tipo: 'ver',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuarioOcupacionSel: this.comboOcupacion.find(item => item.id == row.ocupacion_id),
                        usuario:{
                            email: row.email,
                            nombres: row.persona.nombres,
                            apellidos: row.persona.apellido_pat+' '+row.persona.apellido_pat,
                            tipo_usuario: row.tipo_usuario,
                            num_docid:row.persona.num_docid,
                            es_admin: true,
                            editarPassword: true,
                        }
                    }
                }


            },
            editar(row, index){
                if(row.es_admin == true){
                    $("#modal-administrador").modal('show');
                    this.limpiarFormulario();
                    this.modal = {
                        tipo: 'editar',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuario:{
                            email: row.email,
                            nombres: row.persona.nombres,
                            apellidos: row.persona.apellido_pat+' '+row.persona.apellido_pat,
                            tipo_usuario: row.tipo_usuario,
                            num_docid:row.persona.num_docid,
                            es_admin: true,
                            editarPassword: true,
                        }
                    }
                }
                else{
                    $("#modal-usuario").modal('show');
                    this.limpiarFormulario();
                    this.modalUsuario = {
                        tipo: 'editar',
                        titulo:  'Editar usuario',
                        usuarioID: row.id,
                        usuarioOcupacionSel: this.comboOcupacion.find(item => item.id == row.ocupacion_id),
                        usuario:{
                            email: row.email,
                            nombres: row.nombres,
                            apellidos: row.apellidos,
                            puesto_actual: row.puesto_actual,
                            usuario: row.usuario,
                        }
                    }
                }

            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    console.log(this.modal.usuario);
                    if (result) {  
                        axios.post("api/usuario/crear", this.modal.usuario)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-administrador").modal('hide');
                            this.listarUsuarios();
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
                        axios.put("api/usuario/modificar/" + this.modal.usuarioID, this.modal.usuario)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-administrador").modal('hide');
                            this.listarUsuarios();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            modificarUsuario(){
                this.$validator.validateAll('form_registro_usuario').then(result => {
                    if (result) {  
                        axios.put("api/usuario/modificar/" + this.modalUsuario.usuarioID, this.modalUsuario.usuario)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-usuario").modal('hide');
                            this.listarUsuarios();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            inactivar(row, index){
                axios.put("api/usuario/inactivar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    this.listarUsuarios();
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            activar(row, index){
                axios.put("api/usuario/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            enviarMensaje(row, index){
               this.$router.push({
                    name: "Mensajes",
                    params: {
                        usuario_id: row.id,
                        nombre: row.nombres + ' ' + row.apellidos,
                    }
                });
            },
             buscar(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra');
                            this.limpiarFormularioBuscar()
                            this.modal.tipo='nuevo';
                            }
                            else{
                                console.log(response.data);
                            this.modal.usuario.nombres=response.data.nombres;
                            this.modal.usuario.apellidos=response.data.apellido_pat+' '+response.data.apellido_mat;  

                            this.modal.usuario.id_per=response.data.id;
                        
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                   
            },
            exportar(){
                if(this.listaUsuarios.filtrosBusqueda.fechaIni){
                    this.listaUsuarios.filtrosBusqueda.fechaIni
                    this.listaUsuarios.filtrosBusqueda.fechaFin
                }

                let url = process.env.MIX_APP_URL + '/exportar/usuarios' + Helper.getFilterURL(this.listaUsuarios.filtrosBusqueda);
                window.open(url);
            }
        },
    }
</script>
<style >
.calendars > .ranges {
      padding-left: 0%;
      padding-right: 0%;
      max-width: 23%;
} 
.daterangepicker.show-calendar .ranges {
    margin-top: 8px;
    width: 23%;
    max-width: 23%;
}
</style>