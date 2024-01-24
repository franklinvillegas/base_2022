<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;">
        <h4 class="text-color-2 mb-3">Matricula de alumnos</h4></div>
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

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="paso1-tab" data-toggle="tab" data-target="#paso1" type="button" role="tab" aria-controls="paso1" aria-selected="true">Paso 1</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="paso2-tab" :disabled="paso01" data-toggle="tab" data-target="#paso2" type="button" role="tab" aria-controls="paso2" aria-selected="false">Paso 2</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="paso3-tab" :disabled="paso02" data-toggle="tab" data-target="#paso3" type="button" role="tab" aria-controls="paso3" aria-selected="false">Paso 3</button>
              </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="paso1" role="tabpanel" aria-labelledby="paso1-tab">
                <form data-vv-scope="form_registro">
                <div class="row">
                    <div class="form-group col-3">
                        <p class="m-0">
                            <strong>Año</strong>
                        </p>
                        <select name="anio"
                        v-model="datos.anio"
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
                        v-model="datos.nivelID"
                        class="form-control"
                        data-vv-as="Nivel"
                        placeholder="Seleccione nivel"
                        v-validate="'required'"
                        @change="listarGrado(datos.nivelID)">
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
                        v-model="datos.seccion.id_grado"
                        data-vv-as="Grado"
                        placeholder="Seleccione grado"
                        v-validate="'required'"
                        @change="listarSeccion(datos.seccion.id_grado)">
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
                        v-model="datos.seccion.id_seccion"
                        data-vv-as="Sección"
                        placeholder="Seleccione sección"
                        v-validate="'required'">
                            <option v-for="row in listarSeccions" :key="row.id" :value="row.id" v-text="row.seccion" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro.seccion")}}</span>
                    </div>
                </div>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Datos generales</legend>
                    <div class="control-group">
                        <div class="form d-flex flex-wrap" >
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Tipo de Documento</strong>
                                </p>
                                <select name="tipo_documento" 
                                v-model="datos.persona.id_docid" 
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
                                v-model="datos.persona.num_docid"
                                class="form-control"
                                data-vv-as="Documento"
                                placeholder="Documento"
                                name="num_docid"
                                v-validate="'required|digits:8'"
                                >
                                <span class="text-danger">{{errors.first("form_registro.num_docid")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div >
                                <p class="m-0">
                                    <strong>Buscar persona</strong>
                                </p>
                                <button type="button"  class="btn btn-secondary" :disabled="datos.persona.num_docid==''" @click="buscar(datos.persona.num_docid)"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Apellido Paterno</strong>
                                </p>
                                <input type="text"
                                v-model="datos.persona.apellido_pat"
                                class="form-control"
                                data-vv-as="Apellido Paterno"
                                placeholder="Apellido Paterno"
                                name="apellido_pat"
                                :disabled="datos.existe"
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
                                v-model="datos.persona.apellido_mat"
                                class="form-control"
                                data-vv-as="Apellido_mat"
                                :disabled="datos.existe"
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
                                v-model="datos.persona.nombres"
                                class="form-control"
                                data-vv-as="Nombres"
                                placeholder="Nombres"
                                name="datos_nombres"
                                :disabled="datos.existe"
                                v-validate="'required|alpha_spaces|max:200'">
                                <span class="text-danger">{{errors.first("form_registro.datos_nombres")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Sexo</strong>
                                </p>
                                <select
                                v-model="datos.persona.sexo"
                                class="form-control"
                                data-vv-as="Sexo"
                                placeholder="Sexo"
                                name="sexo"
                                :disabled="datos.existe"
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
                                v-model="datos.persona.telefono1"
                                class="form-control"
                                data-vv-as="Telefono1"
                                placeholder="Telefono 1"
                                name="telefono1"
                                v-validate="'digits:9'"
                                :disabled="datos.existe">
                                <span class="text-danger">{{errors.first("form_registro.telefono1")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Telefono 2</strong>
                                </p>
                                <input type="text"
                                v-model="datos.persona.telefono2"
                                class="form-control"
                                data-vv-as="Telefono2"
                                placeholder="Telefono 2"
                                name="telefono2"
                                v-validate="'digits:9'"
                                :disabled="datos.existe">
                                <span class="text-danger">{{errors.first("form_registro.telefono2")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div>
                                <p class="m-0">
                                    <strong>Dirección</strong>
                                </p>
                                <input type="text"
                                v-model="datos.persona.direccion"
                                class="form-control"
                                data-vv-as="direccion"
                                placeholder="direccion"
                                name="fecha_nac"
                                :disabled="datos.existe">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Fecha de Nacimiento</strong>
                                </p>
                                <input type="date"
                                v-model="datos.persona.fecha_nac"
                                class="form-control"
                                data-vv-as="Fecha_nac"
                                placeholder="Fecha_nac"
                                name="fecha_nac"
                                v-validate="'required'"
                                :disabled="datos.existe">
                                <span class="text-danger">{{errors.first("form_registro.fecha_nac")}}</span>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-left: -15px;">
                                <button class="btn btn-outline-secondary float-right"  type="button" @click="siguiente"> Siguiente </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
                </form>
            </div>
            <div class="tab-pane fade" id="paso2" role="tabpanel" aria-labelledby="paso2-tab">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border salud">Salud del estudiante</legend>
                    <div class="control-group">
                        <form class="form d-flex flex-wrap" data-vv-scope="form_registro_alumno">
                            <div class="form-group col-md-4">
                                <p class="m-0">
                                    <strong>Talla (m)</strong>
                                </p>
                                <input type="text"
                                v-model="datos.alumno.talla"
                                class="form-control"
                                data-vv-as="Talla"
                                placeholder="Talla"
                                name="talla"
                                v-validate="'required|decimal:2|max:5'">
                                <span class="text-danger">{{errors.first("form_registro_alumno.talla")}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <p class="m-0">
                                    <strong>Peso (Kg)</strong>
                                </p>
                                <input type="text"
                                v-model="datos.alumno.peso"
                                class="form-control"
                                data-vv-as="Peso"
                                placeholder="Peso"
                                name="peso"
                                v-validate="'required|decimal:2|max:5'">
                                <span class="text-danger">{{errors.first("form_registro_alumno.peso")}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <p class="m-0">
                                </p>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox mb-05">
                                    <input type="checkbox" class="custom-control-input"  name="alergias" id="alergias" v-model="datos.alumno.alergias">
                                    <label class="custom-control-label" for="alergias">Alergias</label>
                                </div>
                                <div v-if="datos.alumno.alergias==true">
                                    <textarea type="text"
                                    v-model="datos.alumno.detalle_alergia"
                                    class="form-control"
                                    data-vv-as="Detalle de Alergias"
                                    placeholder="Detalle de alergias"
                                    name="detalle_alergia"
                                    v-validate="'required'"></textarea>
                                    <span class="text-danger">{{errors.first("form_registro_alumno.detalle_alergia")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox mb-05">
                                    <input type="checkbox" class="custom-control-input" name="discapacidad" id="discapacidad" v-model="datos.alumno.discapacidad">
                                    <label class="custom-control-label" for="discapacidad">Discapacidad</label>
                                </div>
                                <div v-if="datos.alumno.discapacidad==true">
                                    <textarea type="text"
                                    v-model="datos.alumno.detalle_discapacidad"
                                    class="form-control"
                                    data-vv-as="Detalle de Discapacidad"
                                    placeholder="Detalle de discapacidad"
                                    name="detalle_discapacidad"
                                    v-validate="'required'"></textarea>
                                    <span class="text-danger">{{errors.first("form_registro_alumno.detalle_discapacidad")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-checkbox mb-05">
                                    <input type="checkbox" class="custom-control-input" name="enfermedad" id="enfermedad" v-model="datos.alumno.enfermedad">
                                    <label class="custom-control-label" for="enfermedad">Enfermedad</label>
                                </div>
                                <div v-if="datos.alumno.enfermedad==true">
                                    <textarea type="text"
                                    v-model="datos.alumno.detalle_enfermedad"
                                    class="form-control"
                                    data-vv-as="Nombre"
                                    placeholder="Detalle de enfermedad"
                                    name="detalle_enfermedad"
                                    v-validate="'required'"></textarea>
                                    <span class="text-danger">{{errors.first("form_registro_alumno.detalle_enfermedad")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <p class="m-0">
                                    <strong>Otros (detalle aquí)</strong>
                                </p>
                                <div>
                                    <textarea type="text"
                                    v-model="datos.alumno.otros"
                                    class="form-control"
                                    data-vv-as="Otros"
                                    placeholder="Detalle de otros"
                                    name="otros"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-left: -15px;">
                                <button class="btn btn-outline-secondary float-right"  type="button" @click="guardar"> Siguiente </button>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
            <div class="tab-pane fade" id="paso3" role="tabpanel" aria-labelledby="paso3-tab">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Apoderados</legend>
                    <div class="control-group">
                        <form class="form d-flex flex-wrap" data-vv-scope="form_registro_apoderados">
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Tipo de Documento</strong>
                                </p>
                                <select name="tipo_documento" 
                                v-model="persona.id_docid" 
                                class="form-control" 
                                data-vv-as="Tipo de documento"
                                v-validate="'required'"> 
                                    <option v-for="row in listarTipoDocs" :key="row.id" :value="row.id" v-text="row.tipo" ></option>
                                </select>
                                <span class="text-danger">{{errors.first("form_registro_apoderados.tipo_documento")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Documento</strong>
                                </p>
                                <input type="text"
                                v-model="persona.num_docid"
                                class="form-control"
                                data-vv-as="Documento"
                                placeholder="Documento"
                                name="num_docid"
                                v-validate="'required|digits:8'">
                                <span class="text-danger">{{errors.first("form_registro_apoderados.num_docid")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Buscar persona</strong>
                                </p>
                                <button type="button"  class="btn btn-secondary" :disabled="persona.num_docid==''" @click="buscarApoderado(persona.num_docid)"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <!--- -->
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Apellido Paterno</strong>
                                </p>
                                <input type="text"
                                v-model="apoderado.persona.apellido_pat"
                                class="form-control"
                                data-vv-as="Apellido Paterno"
                                placeholder="Apellido Paterno"
                                name="apellido_pat"
                                :disabled="modal.existe"
                                v-validate="'required|alpha_spaces|max:50'">
                                <span class="text-danger">{{errors.first("form_registro_apoderados.apellido_pat")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Apellido Materno</strong>
                                </p>
                                <input type="text"
                                v-model="apoderado.persona.apellido_mat"
                                class="form-control"
                                data-vv-as="Apellido_mat"
                                :disabled="modal.existe"
                                placeholder="Apellido Materno"
                                name="apellido_mat"
                                v-validate="'required|alpha_spaces|max:50'">
                                <span class="text-danger">{{errors.first("form_registro_apoderados.apellido_mat")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Nombres</strong>
                                </p>
                                <input type="text"
                                v-model="apoderado.persona.nombres"
                                class="form-control"
                                data-vv-as="Nombres"
                                placeholder="Nombres"
                                name="nombres"
                                :disabled="modal.existe"
                                v-validate="'required|alpha_spaces|max:200'">
                                <span class="text-danger">{{errors.first("form_registro_apoderados.nombres")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>Vinculo</strong>
                                </p>
                                <input type="text"
                                v-model="apoderado.vinculo"
                                class="form-control"
                                data-vv-as="Vinculo"
                                placeholder="Vinculo"
                                name="vinculo"
                                :disabled="modal.existe"
                                v-validate="'required|alpha_spaces|max:50'">
                                <span class="text-danger">{{errors.first("form_registro_apoderados.vinculo")}}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div>
                                <p class="m-0">
                                    <strong>&nbsp;</strong>
                                </p>
                                <button type="button"  class="btn btn-secondary" :disabled="apoderado.persona.num_docid==''" @click="agregarApoderado()"><i class="fa fa-plus"></i>Agregar</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <vue-good-table
                                :columns="listarApoderados.columns"
                                :rows="listarApoderados.data"
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
                                    <button class="btn btn-outline-danger btn-sm btn-icon" @click.prevent="eliminar(props.row, props.index)" data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                    </span>
                                </template>
                                </vue-good-table>
                            </div>
                        </form>
                        <template>
                            <div class="modal fade" id="modal-apoderado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle" v-text="modal.titulo"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form d-flex flex-wrap" data-vv-scope="form_registro_apoderado">
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.tipo_documento")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.num_docid")}}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div v-if="modal.tipo == 'nuevo'">
                                                    <p class="m-0">
                                                        <strong>Buscar persona</strong>
                                                    </p>
                                                    <button type="button"  class="btn btn-secondary" :disabled="modal.persona.num_docid==''" @click="buscarPersonaApoderado(modal.persona.num_docid)"><i class="fa fa-search"></i></button>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.apellido_pat")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.apellido_mat")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.nombres")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.sexo")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.telefono1")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.telefono2")}}</span>
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
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.fecha_nac")}}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <p class="m-0">
                                                        <strong>Ocupación</strong>
                                                    </p>
                                                    <input type="text"
                                                    v-model="modal.apoderado.ocupacion"
                                                    class="form-control"
                                                    data-vv-as="Ocupacion"
                                                    placeholder="Ocupacion"
                                                    name="ocupacion"
                                                    v-validate="'required'">
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.ocupacion")}}</span>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <p class="m-0">
                                                        <strong>Vinculo</strong>
                                                    </p>
                                                    <input type="text"
                                                    v-model="modal.apoderadoEstudiante.vinculo"
                                                    class="form-control"
                                                    data-vv-as="Vinculo"
                                                    placeholder="Vinculo"
                                                    name="vinculo"
                                                    v-validate="'required'">
                                                    <span class="text-danger">{{errors.first("form_registro_apoderado.vinculo")}}</span>
                                                </div>
                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                            <button type="button" v-if="modal.tipo == 'nuevo'" class="btn btn-primary" @click="guardarApoderado">Guardar</button>
                                            <button type="button" v-else-if="modal.tipo == 'editar'" class="btn btn-primary" @click="modificar">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </fieldset>
            </div>
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
                listarApoderados:{
                    data: [],
                    columns:[
                        {label: 'Apellido Paterno', field: 'apoderado.persona.apellido_pat',},
                        {label: 'Apellido Materno', field: 'apoderado.persona.apellido_mat',},
                        {label: 'Nombres', field: 'apoderado.persona.nombres',},
                        {label: 'Vinculo', field: 'vinculo',},
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
                datos:{
                    tipo: '',
                    existe:null,
                    titulo:  '',
                    nivelID: null,
                    nivel:{
                        nombre: '',
                    },
                    seccion:{
                        id_seccion:'',
                        seccion: '',
                        id_grado: '',
                        anio: new Date().getFullYear(),
                    },
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
                        estado:1,
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
                    anio: new Date().getFullYear()
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
                apoderado:{
                    estado:'',
                    id:'',
                    id_per:'',
                    id_est:'',
                    id_apo:'',
                    ocupacion:'',
                    vinculo:'',
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
                modal:{
                    tipo: '',
                    titulo:  '',
                    nivelID: null,
                    nivel:{
                        nombre: '',
                    },
                    seccion:{
                        seccion: '',
                        id_grado: '',
                    },
                    apoderado:{
                        estado:'1',
                        ocupacion:'',
                        id_per:'',
                    },
                    apoderadoEstudiante:{
                        vinculo:'',
                        id_est:'',
                        id_apo:'',
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
                        id_dist:'1', 
                    },
                    anio: new Date().getFullYear()
                },
                listarTipoDocs:[],
                listarNiveles:[],
                listarGrados:[],
                listarSeccions:[],
                id_est:'',
                paso01 : true,
                paso02 : true,
            }
        },
        created(){
            this.listarAños();
            this.listarNivel();
            this.listarTipoDoc();
        },
        methods:{
            listarEstudanteApoderado(id_est){
                axios.get("api/apoderado/listarEstudianteApoderado/"+id_est)
                .then((response) => {
                    let data = response.data;
                    this.listarApoderados.data = data;
                    console.log(this.listarApoderados);
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
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
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
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

            guardar(){
                console.log('paso 1');
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 
                        console.log('paso 2');
                        axios.post("api/matricula/crear", this.datos)
                        .then((response) => {
                            if (response.data.idMatricula) this.$toastr.w(response.data.message);
                            else this.$toastr.s(response.data.message);
                            this.id_est=response.data.idAlumno;
                            if(response.data.idPersona) this.datos.existe=response.data.idPersona;
                            this.listarEstudanteApoderado(this.id_est);
                            this.siguiente();
                            console.log('paso 3');
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            guardarApoderado(){
                this.modal.apoderadoEstudiante.id_est = this.id_est;
                                console.log("estos es",this.modal);

                this.$validator.validateAll('form_registro_apoderado').then(result => {
                    if (result) { 
                        axios.post("api/matricula/guardarApoderado", this.modal)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-apoderado").modal('hide');
                            this.listarEstudanteApoderado(this.id_est);
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
            listarContenidoPeligroso(){
                this.listarSecciones.filtrosBusqueda.contenidoPeligroso = true;
                this.listarNivel();
            },
            obtenerTipo(row){
                if (row.tipo == 1) return 'Inicio';
                else if (row.tipo == 2) return 'Pregunta';
                else if (row.tipo == 1) return 'Publicación';

            },
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarSecciones.filtrosBusqueda);
                window.open(url);
            },
             buscar(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra, continue con el registro');
                            this.limpiarFormularioBuscar();
                            }
                            else{
                            this.limpiarFormularioBuscar();
                            this.datos.persona=response.data;  
                            this.datos.alumno.id_per=response.data.id;
                            this.datos.existe=response.data.id;
                        
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                   
            },
            buscarPersonaApoderado(dni){
                console.log('dni',dni);
                        axios.get("api/persona/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra, continue con el registro');
                            this.modal.existe='';
                            this.limpiarFormularioBuscarApoderado()
                            }
                            else{
                            this.limpiarFormularioBuscarApoderado()
                            this.modal.persona=response.data;  
                            // this.modal.alumno.id_per=response.data.id;
                            this.modal.existe=response.data.id;
                        
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                   
            },
            buscarApoderado(dni){
                        axios.get("api/apoderado/buscar/" + dni)
                        .then((response) => {
                            if (!response.data || response.data==''){
                            this.$toastr.w('La persona no se encuentra, continue con el registro');
                            $("#modal-apoderado").modal('show');
                            this.modal.tipo = 'nuevo';
                            }
                            else{
                            this.apoderado=response.data; 
                            this.apoderado.id_apo=response.data.id;
                            // this.modal.existe=response.data.id;
                        
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                   
            },
            agregarApoderado(){
                console.log('paso 1',this.apoderado);
                const apoderadoEnviar={
                    id_apo: this.apoderado.id_apo,
                    id_est: this.id_est,
                    vinculo: this.apoderado.vinculo,
                };
                this.$validator.validateAll('form_registro_apoderado').then(result => {
                    if (result) { 
                        console.log('paso 2');
                        axios.post("api/apoderado/estudianteApoderado", apoderadoEnviar)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            this.listarEstudanteApoderado(this.id_est);
                            console.log('paso 3');
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            limpiarFormularioBuscarApoderado(){
                console.log('entro limpiar buscar');
                this.modal={
                    tipo: 'nuevo',
                    existe:null,
                    nivelID:this.datos.nivelID,
                    seccion:{
                        id_grado:this.datos.seccion.id_grado,
                        id_seccion:this.datos.seccion.id_seccion,
                    },
                    apoderado:{
                        estado:'1',
                        ocupacion:'',
                        id_per:'',
                    },
                    apoderadoEstudiante:{
                        vinculo:'',
                        id_est:'',
                        id_apo:'',
                    },
                    persona:{
                        id_docid:this.modal.persona.id_docid,
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
                    anio:this.datos.anio,
                
                    deshabilitado: false,   
                },
                this.$validator.reset();
            },
            limpiarFormularioBuscar(){
                console.log('entro limpiar buscar');
                this.datos={
                    tipo: '',
                    existe:null,
                    nivelID:this.datos.nivelID,
                    seccion:{
                        id_grado:this.datos.seccion.id_grado,
                        id_seccion:this.datos.seccion.id_seccion,
                    },
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
                        id_docid:this.datos.persona.id_docid,
                        nombres:'',
                        apellido_pat:'',
                        apellido_mat:'',
                        sexo:'FEMENINO',
                        telefono1:'',
                        telefono2:'',
                        fecha_nac:'',
                        num_docid:this.datos.persona.num_docid,
                        direccion:'',
                        id_dist:'1', 
                    },
                    anio:this.datos.anio,
                
                    deshabilitado: false,   
                },
                this.$validator.reset();
            },
            siguiente(){
                        this.paso01=false;


                 this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 
                        this.paso01=false;
                        if(this.paso01==false)document.getElementById('paso2-tab').click();
                    }
                });
                if(this.id_est){
                    this.paso02=false;
                    if(this.paso02==false)document.getElementById('paso3-tab').click();
                } 
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
legend.scheduler-border.salud {
    width:160px;
}
</style>