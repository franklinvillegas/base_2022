<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;">
        <h4 class="text-color-2 mb-3">Notas de alumno</h4></div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarSecciones.filtrosBusqueda.tipo" @change="listarNivel" > 
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

        
            <div class="tab-pane fade show active" id="paso1" role="tabpanel" aria-labelledby="paso1-tab">
                <div class="row">
                    <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Año</strong>
                        </p>
                        <select name="anio"
                        v-model="modal.anio"
                        class="form-control"
                        data-vv-as="Año"
                        placeholder="Seleccione año"
                        v-validate="'required'">
                            <option v-for="row in listarAnios" :key="row" :value="row" v-text="row" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.anio")}}</span>
                    </div>
                    <div class="form-group col-3">
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
                    <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Grado</strong>
                        </p>
                        <select name="grado"
                        class="form-control"
                        v-model="modal.seccion.id_grado"
                        data-vv-as="Grado"
                        placeholder="Seleccione grado"
                        v-validate="'required'"
                        @change="listarComponentes(modal.seccion.id_grado)">
                            <option v-for="row in listarGrados" :key="row.id" :value="row.id" v-text="row.grado" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.grado")}}</span>
                    </div>
                    <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Sección</strong>
                        </p>
                        <select name="seccion"
                        class="form-control"
                        v-model="modal.seccion.id_seccion"
                        data-vv-as="Sección"
                        placeholder="Seleccione sección"
                        v-validate="'required'">
                            <option v-for="row in listarSeccions" :key="row.id" :value="row.id" v-text="row.seccion" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.seccion")}}</span>
                    </div>
                    <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Curso</strong>
                        </p>
                        <select name="curso"
                        class="form-control"
                        v-model="modal.seccion.id_curso"
                        data-vv-as="Sección"
                        placeholder="Seleccione el curso"
                        v-validate="'required'"
                        @change="listarCompetencia(modal.seccion.id_curso)">
                            <option v-for="row in listarCursos" :key="row.id" :value="row.id" v-text="row.curso.nombre" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
                    </div>
                     <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Competencia</strong>
                        </p>
                        <select name="curso"
                        class="form-control"
                        v-model="modal.seccion.id_competencia"
                        data-vv-as="Sección"
                        placeholder="Seleccione el curso"
                        v-validate="'required'"
                        @change="listarCriterio(modal.seccion.id_competencia)">
                            <option v-for="row in listarCompetencias" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
                    </div>
                     <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Criterio</strong>
                        </p>
                        <select name="curso"
                        class="form-control"
                        v-model="modal.seccion.id_criterio"
                        data-vv-as="Sección"
                        placeholder="Seleccione el curso"
                        v-validate="'required'">
                            <option v-for="row in listarCriterios" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
                    </div>
                    <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Generar registro de notas</strong>
                        </p>
                        <button class="btn btn-outline-success float-left"  type="button" @click="generarLista"> Generar  </button>
                    </div>
                    
                </div>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Listado</legend>
                    <div class="control-group">
                       <div class="table-responsive">
            <vue-good-table
            :columns="listaAlumnos.columns"
            :rows="listaAlumnos.data"
            :search-options="{
                enabled: true,
                placeholder: 'Buscar en la tabla',
            }"
            
            >
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'index'">
                {{props.index+1}}
                </span>
                <span v-if="props.column.field == 'nombre_completo'">
                {{props.row.matricula.estudiante.persona.apellido_pat}} {{props.row.matricula.estudiante.persona.apellido_mat}} {{props.row.matricula.estudiante.persona.nombres}}
                </span>
                <span v-if="props.column.field == 'nota'">
                   <input type="text" 
                        v-model="props.row.nota"
                        class="form-control"
                        data-vv-as="Documento"
                        placeholder="Documento"
                        name="num_docid"
                        @keyup.enter="modificarNota(props.row.id,props.row.nota,props.row.observacion)">
                </span>
                <span v-if="props.column.field == 'observacion'">
                    <input type="text" 
                        v-model="props.row.razon"
                        class="form-control"
                        data-vv-as="observacion"
                        placeholder="observacion"
                        name="num_docid"
                        @keyup.enter="modificarNota(props.row.id,props.row.nota,props.row.observacion)">
                </span>
            </template>
            </vue-good-table>
        </div>
                    </div>
                </fieldset>
            </div>
            <div class="tab-pane fade" id="paso2" role="tabpanel" aria-labelledby="paso2-tab">
          
            </div>
            <div class="tab-pane fade" id="paso3" role="tabpanel" aria-labelledby="paso3-tab">
          
            </div>
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
                        {label: 'N° Ord', field: 'index',},
                        {label: 'Apellidos y Nombres', field: 'nombre_completo' ,},
                        {label: 'Nota', field: 'nota',},
                        {label: 'Observación', field: 'observacion',},
                    ],
                    total: 0,
                    filtrosBusqueda:{
                        tipo:'',
                        orden: 'asc',
                        ordenPor: 'apellido_pat',
                    },
                    deshabilitarEdicion: false,
                },
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
                listarAnios: [], 
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    nivelID: null,
                    nivel:{
                        nombre: '',
                    }
                },
                modal:{
                    tipo: '',
                    titulo:  '',
                    nivelID: null,
                    seccion:{
                        seccion: '',
                        id_grado: '',
                        id_competencia: '',
                        id_criterio: '',
                    },
                    anio: new Date().getFullYear()
                },
                listarNiveles:[],
                listarGrados:[],
                listarSeccions:[],
                listarCursos:[],
                listarCompetencias:[],
                listarCriterios:[],

            }
        },
        created(){
            this.listarAños();
            this.listarNivel();
        },
        methods:{
            listarAños(){
                const anio = new Date().getFullYear();
                for (let index = anio+1; index >= 2023; index--) {
                    this.listarAnios.push(index);
                }
                console.log(this.listarAnios);
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
                    this.listarSeccions = '';
                    this.listarCursos = '';
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
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
                    this.listarSeccions = data;

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
                        this.listarCursos = data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toastr.e(error.response.data.message);
                    });
            },
           listarCompetencia(id_gracur) {
                axios.get("api/actividad/llenar_combo/" + id_gracur)
                    .then((response) => {
                        let data = response.data;
                        this.listarCompetencias= data;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toastr.e(error.response.data.message);
                    });
            },
            listarCriterio(id_competencia) {
                axios.get("api/criterio/llenar_combo/" + id_competencia)
                    .then((response) => {
                        let data = response.data;
                        this.listarCriterios = data;
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
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 
                        axios.post("api/nivel/crear", this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
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
                        axios.put("api/nivel/modificar/" + this.modal.nivelID, this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            modificarNota(id,nota,razon){
                const data={
                    nota,
                    razon,
                }
              axios.put("api/notas/modificar/"+id,data)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            this.generarLista();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    
            },
            eliminar(row, index){
                 this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios.put("api/nivel/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarNivel();
                });
                
            },
            activar(row, index){
                axios.put("api/nivel/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
            generarLista(){
                console.log(this.modal);
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {  
                        axios.post("api/notas/crear", this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            this.listaAlumnos.data=response.data.lista;
                            console.log(this.listaAlumnos);
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                });
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
fieldset.scheduler-border {
    border: 1px solid #dee2e6 !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1rem !important;
    font-weight: bold !important;
    text-align: left !important;
    border:none;
    width:120px;
}
</style>