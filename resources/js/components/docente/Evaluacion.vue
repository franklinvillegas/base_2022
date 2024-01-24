<template>
    <div class="p-3 pt-5">
      <div class="col-md-12" style="margin-left: -15px">
        <button
          class="btn btn-outline-secondary float-right"
          type="button"
          @click="nuevo"
        >
          Nuevo
        </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Evaluación</h4>
      </div>
      <br />
      <!--  <div class="row justify-content-md-center">
             <div class="col-md-5">
                  <div class="form-group">
                      <label for="">Tipo</label>
                      <select name="" class="form-control" v-model="listarEvaluaciones.filtrosBusqueda.tipo" @change="listarEvaluacion" >
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
          :columns="listarEvaluaciones.columns"
          :rows="listarEvaluaciones.data"
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
            <span v-if="props.column.field == 'notaP'">{{props.row.nota}} <b v-if="!props.row.pregunta[0]"><i title="Agregue preguntas a la evaluación" class="fa fa-exclamation-triangle text-warning ms-3"></i></b><b v-else-if="props.row.pregunta[0].total !== props.row.nota"><i title="El puntaje no coincide, revise las preguntas" class="fa fa-exclamation-triangle text-warning ms-3"></i></b></span>
            <span v-else-if="props.column.field == 'nombre_docente'">{{props.row.docente.persona.apellido_pat}} {{props.row.docente.persona.apellido_mat}} {{props.row.docente.persona.nombres}}</span>
            <span v-else-if="props.column.field == 'options'">
              <button
                class="btn btn-outline-success btn-sm btn-icon"
                @click.prevent="agregarCurso(props.row, props.index)"
                data-toggle="tooltip"
                title="Agregar"
              >
                <i class="fas fa-plus"></i> Asignar
              </button>
              <button
                class="btn btn-outline-secondary btn-sm btn-icon"
                @click.prevent="agregarPregunta(props.row, props.index)"
                data-toggle="tooltip"
                title="Agregar"
              >
                <i class="fas fa-plus"></i> Pregunta
              </button>
              <!-- <button
                class="btn btn-outline-secondary btn-sm btn-icon"
                @click.prevent="ver(props.row, props.index)"
                data-toggle="tooltip"
                title="Ver"
              >
                <i class="fas fa-eye"></i>
              </button> -->
              <button
                class="btn btn-outline-info btn-sm btn-icon"
                @click.prevent="editar(props.row, props.index)"
                data-toggle="tooltip"
                title="Editar"
              >
                <i class="fas fa-pencil-alt"></i>
              </button>
              <button
                class="btn btn-outline-danger btn-sm btn-icon"
                @click.prevent="eliminar(props.row, props.index)"
                data-toggle="tooltip"
                title="Eliminar"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </span>
          </template>
        </vue-good-table>
      </div>
      <!-- Modal -->
      <template>
        <div
          class="modal fade"
          id="modal-evaluacion"
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
                <form class="form" data-vv-scope="form_registro">
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Docente</strong>
                    </p>
                    <select
                      name="docente"
                      class="form-control"
                      v-model="modal.evaluacion.id_docente"
                      data-vv-as="Docente"
                      placeholder="Seleccione Docente"
                      v-validate="'required'"
                    >
                      <option
                        v-for="row in listarDocentes"
                        :key="row.id"
                        :value="row.id"
                        v-text="row.persona.apellido_pat+' '+row.persona.apellido_mat+' '+row.persona.nombres"
                      ></option>
                    </select>
                    <span class="text-danger">{{
                      errors.first("form_registro.docente")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Descripción</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modal.evaluacion.descripcion"
                      class="form-control"
                      data-vv-as="Descripción"
                      placeholder="Descripción"
                      name="descripcion"
                      v-validate="'required'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.descripcion")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Puntaje total</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modal.evaluacion.nota"
                      class="form-control"
                      data-vv-as="Nota total"
                      placeholder="Nota total"
                      name="nota"
                      v-validate="'required|decimal:2|max:5'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.nota")
                    }}</span>
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
                <form class="form" data-vv-scope="form_registro_evaluacion_curso">
                  <div class="row">
                    <div class="form-group col-md-6">
                        <p class="m-0">
                            <strong>Inicio</strong>
                        </p>
                        <input type="datetime-local"
                        v-model="modalAgregar.evaluacion_docente_curso.inicio"
                        class="form-control"
                        data-vv-as="Inicio"
                        placeholder="Inicio"
                        name="inicio">
                        <span class="text-danger">{{
                          errors.first("form_registro_evaluacion_curso.inicio")
                        }}</span>
                      </div>
                      <div class="form-group col-md-6">
                        <p class="m-0">
                            <strong>Fin</strong>
                        </p>
                        <input type="datetime-local"
                        v-model="modalAgregar.evaluacion_docente_curso.fin"
                        class="form-control"
                        data-vv-as="Fin"
                        placeholder="Fin"
                        name="fin">
                        <span class="text-danger">{{errors.first("form_registro_evaluacion_curso.fin")}}</span>
                      </div>
                      <div class="form-group col-md-4">
                        <p class="m-0">
                            <strong>Nivel</strong>
                        </p>
                        <select name="nivel"
                        v-model="modalAgregar.nivelID"
                        class="form-control"
                        data-vv-as="Nivel"
                        placeholder="Seleccione nivel"
                        v-validate="'required'"
                        @change="listarGrado(modalAgregar.nivelID, modalAgregar.id_docente)">
                            <option v-for="row in listarNiveles" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro_evaluacion_curso.nivel")}}</span>
                      </div>
                      <div class="form-group col-md-4">
                          <p class="m-0">
                              <strong>Grado</strong>
                          </p>
                          <select name="grado"
                          class="form-control"
                          v-model="modalAgregar.id_grado"
                          data-vv-as="Grado"
                          placeholder="Seleccione grado"
                          v-validate="'required'"
                          @change="listarSeccion(modalAgregar.id_grado, modalAgregar.id_docente)">
                              <option v-for="row in listarGrados" :key="row.id" :value="row.id" v-text="row.grado" ></option>
                          </select>
                          <span class="text-danger">{{errors.first("form_registro_evaluacion_curso.grado")}}</span>
                      </div>
                      <div class="form-group col-md-4">
                          <p class="m-0">
                              <strong>Sección</strong>
                          </p>
                          <select name="seccion"
                          class="form-control"
                          v-model="modalAgregar.id_seccion"
                          data-vv-as="Sección"
                          placeholder="Seleccione sección"
                          v-validate="'required'"
                          @change="listarCurso(modalAgregar.id_seccion, modalAgregar.id_docente)">
                              <option v-for="row in listarSeccions" :key="row.id" :value="row.id" v-text="row.seccion" ></option>
                          </select>
                          <span class="text-danger">{{errors.first("form_registro_evaluacion_curso.seccion")}}</span>
                      </div>
                      <div class="form-group col-md-10">
                        <p class="m-0">
                            <strong>Curso</strong>
                        </p>
                        <select name="id_grado_curso"
                        class="form-control"
                        v-model="modalAgregar.evaluacion_docente_curso.id_docen_curso"
                        data-vv-as="Curso"
                        placeholder="Seleccione curso"
                        >
                            <option v-for="row in listarCursos" :key="row.id" :value="row.id" v-text="row.curso.nombre" ></option>
                        </select>
                        <span class="text-danger">{{errors.first("form_registro_evaluacion_curso.id_grado_curso")}}</span>
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
                      :columns="listarEvaluacionCursos.columns"
                      :rows="listarEvaluacionCursos.data"
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
                            @click.prevent="eliminarEvaluacionCurso(props.row, props.index)"
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
       <!-- Modal agregar Pregunta y Alternativas -->
       <template>
        <div
          class="modal fade"
          id="modal-agregarPregunta"
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
                  v-text="modalAgregarPregunta.titulo"
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
                <form class="form" data-vv-scope="form_registro_pregunta">
                  <div class="row">
                    <div class="form-group col-md-10">
                        <p class="m-0">
                            <strong>Pregunta</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.pregunta.descripcion"
                        class="form-control"
                        data-vv-as="Descripción"
                        placeholder="Descripción"
                        name="descripcion">
                        <span class="text-danger">{{
                          errors.first("form_registro_pregunta.descripcion")
                        }}</span>
                      </div>
                      <div class="form-group col-md-2">
                        <p class="m-0">
                            <strong>Puntaje</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.pregunta.nota"
                        class="form-control"
                        data-vv-as="Puntaje"
                        placeholder="Puntaje"
                        name="nota">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.nota")}}</span>
                      </div>
                      <div class="form-group col-md-5">
                        <p class="m-0">
                            <strong>Imagen(Opcional)</strong>
                        </p>
                        <input type="file"
                        class="form-control"
                        data-vv-as="Imagen"
                        placeholder="Imagen"
                        accept="image/*"
                        name="imagen" id="imagenForm">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.imagen")}}</span>
                      </div>
                      <div class="form-group col-md-5">
                        <p class="m-0">
                            <strong>Alternativa correcta</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.alternativa_correcta"
                        class="form-control"
                        data-vv-as="Alternativa correcta"
                        placeholder="Alternativa correcta"
                        name="alternativa_correcta">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.alternativa_correcta")}}</span>
                      </div>
                      <div class="form-group col-md-5">
                        <p class="m-0">
                            <strong>Distractor1</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.distractor1"
                        class="form-control"
                        data-vv-as="Distractor1"
                        placeholder="Distractor1"
                        name="distractor1">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.distractor1")}}</span>
                      </div>
                      <div class="form-group col-md-5">
                        <p class="m-0">
                            <strong>Distractor2</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.distractor2"
                        class="form-control"
                        data-vv-as="Distractor2"
                        placeholder="Distractor2"
                        name="distractor2">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.distractor2")}}</span>
                      </div>
                      <div class="form-group col-md-5">
                        <p class="m-0">
                            <strong>Distractor3</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.distractor3"
                        class="form-control"
                        data-vv-as="Distractor3"
                        placeholder="Distractor3"
                        name="distractor3">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.distractor3")}}</span>
                      </div>
                      <div class="form-group col-md-5">
                        <p class="m-0">
                            <strong>Distractor4</strong>
                        </p>
                        <input type="text"
                        v-model="modalAgregarPregunta.distractor4"
                        class="form-control"
                        data-vv-as="Distractor4"
                        placeholder="Distractor4"
                        name="distractor4">
                        <span class="text-danger">{{errors.first("form_registro_pregunta.distractor4")}}</span>
                      </div>
                      
                    <div class="form-group col-2">
                      <p class="m-0 col-12">
                        <strong> &nbsp;</strong>
                      </p>
                      <button
                        type="button"
                        class="btn btn-success"
                        @click="guardarAgregarPregunta"
                      >
                        Agregar
                      </button>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <vue-good-table
                      :columns="listarEvaluacionPreguntas.columns"
                      :rows="listarEvaluacionPreguntas.data"
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
                              class="btn btn-outline-secondary btn-sm btn-icon"
                              @click.prevent="verEvaluacionPregunta(props.row, props.index)"
                              data-toggle="tooltip"
                              title="Ver"
                          >
                              <i class="fas fa-eye"></i>
                          </button>
                          <button
                            class="btn btn-outline-danger btn-sm btn-icon"
                            @click.prevent="eliminarEvaluacionPregunta(props.row, props.index)"
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

      <!-- Modal ver Evaluacion Pregunta -->
      <template>
        <div
          class="modal fade"
          id="modal-verPregunta"
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
                  v-text="modalVerPregunta.titulo"
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
                <div class="card shadow rounded my-3 mx-4">
                    <div class="card-header d-flex d-flex justify-content-between"><b>Pregunta {{modalVerPregunta.index+1}}</b> <span>(Puntaje: {{modalVerPregunta.pregunta.nota}})</span></div>
                    <div class="card-body text-dark d-flex flex-column flex-wrap align-content-center">
                      <h3 class="card-title">{{modalVerPregunta.pregunta.descripcion}}</h3>
                      <img v-if="modalVerPregunta.pregunta.imagen!=''" class="pb-3 object-fit-contain" style="height:150px; width: auto;" :src="$baseUrlVue(`images/preguntas/${modalVerPregunta.pregunta.imagen}`)" >
                      <div>
                        <div class="form-check" v-for="(alternativa, index) in modalVerPregunta.alternativas" :key="index" style="padding-left: 25px;margin-bottom: 4px;">
                            <input type="radio"
                            class="form-check-input"
                            :name="'pregunta_'+modalVerPregunta.id"
                            :id="'alternativa_'+modalVerPregunta.id+'_0' + index"
                            :value="index"
                            >
                            <label class="form-check-label" :for="'alternativa_'+modalVerPregunta.pregunta.id+'_0' + index" style="padding-left: 5px;">
                                <span v-html="alternativa.descripcion"></span>
                            </label>
                          </div> 
                      </div>
                    </div>
                  </div>
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
    name: "Ayudas",
    components: {},
    data() {
      return {
        listarEvaluaciones: {
          data: [],
          columns: [
            { label: "Evaluación", field: "descripcion" },
            { label: "Puntaje", field: "notaP" },
            { label: "Docente", field: "nombre_docente" },
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
        listarEvaluacionCursos: {
          data: [],
          columns: [
            { label: "Inicio", field: "inicio" },
            { label: "Fin", field: "fin" },
            { label: "Curso", field: "docente_curso.curso.nombre" },
            { label: "Sección", field: "docente_curso.seccion.seccion" },
            { label: "Nivel", field: "docente_curso.seccion.grado.nivel.nombre" },
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
        listarEvaluacionPreguntas: {
          data: [],
          columns: [
            { label: "Pregunta", field: "descripcion" },
            { label: "Puntaje", field: "nota" },
            { label: "Alternativa correcta", field: this.alternativa_correcta },
            { label: "Distractor1", field: this.distractor1 },
            { label: "Distractor2", field: this.distractor2 },
            { label: "Distractor3", field: this.distractor3 },
            { label: "Distractor4", field: this.distractor4 },
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
        listarDocentes: [],
        listarNiveles: [],
        listarGrados:[],
        listarSeccions:[],
        listarCursos: [],
        deshabilitado: false,
        modal: {
          tipo: "",
          titulo: "",
          id_evaluacion: null,
          evaluacion: {
            descripcion: "",
            nota: null,
            id_docente: "",
          },
        },
        modalAgregar: {
          tipo: "",
          titulo: "Asignar sección y curso",
          nivelID: "",
          id_grado: "",
          id_seccion: "",
          id_docente: "",
          evaluacion_docente_curso: {
            inicio: null,
            fin: null,
            id_docen_curso: null,
            id_evaluacion: null,
          },
        },
        modalAgregarPregunta: {
          tipo: "",
          titulo: "Agregar pregunta",
          pregunta: {
            descripcion: null,
            nota: null,
            imagen: null,
            id_evaluacion: null,
          },
          alternativa_correcta:'',
          distractor1:'',
          distractor2:'',
          distractor3:'',
          distractor4:'',
        },
        modalVerPregunta: {
          tipo: "",
          titulo: "Ver pregunta",
          pregunta: {
            descripcion: null,
            nota: null,
            imagen: null,
            id_evaluacion: null,
          },
          alternativa_correcta:'',
          distractor1:'',
          distractor2:'',
          distractor3:'',
          distractor4:'',
        },
      };
    },
    created() {
      this.listarEvaluacion();
      this.listarDocente();
      this.listarNivel();
    },
    methods: {
      listarEvaluacion() {
        axios
          .get(
            "api/evaluacion/listar" +
              Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda)
          )
          .then((response) => {
            let data = response.data;
            this.listarEvaluaciones.data = data;
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
              Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda)
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
      listarDocente() {
        axios
          .get(
            "api/docente/listar" +
              Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda)
          )
          .then((response) => {
            let data = response.data;
            this.listarDocentes = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },
      listarGrado(id_nivel, id_docente){
        axios.get("api/docente_curso/llenar_combo_grado/"+id_nivel+"/"+id_docente)
        .then((response) => {
            let data = response.data;
            this.listarGrados = data;
            this.modalAgregar.id_grado = '';
            this.modalAgregar.id_seccion = '';
            this.listarSeccions = '';
            this.listarCursos = '';
        })
        .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
        });
        },
        listarSeccion(id_grado, id_docente){
            axios.get("api/docente_curso/llenar_combo_seccion/"+id_grado+"/"+id_docente)
            .then((response) => {
                let data = response.data;
                this.listarSeccions = data;
                this.modalAgregar.id_seccion = '';
                this.listarCursos = '';
            })
            .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
            });
        },
      listarCurso(id_seccion, id_docente) {
        axios.get("api/docente_curso/llenar_combo_curso/"+id_seccion+"/"+id_docente)
          .then((response) => {
            let data = response.data;
            this.listarCursos = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },
      listarCursoPrimaria() {
        axios
          .get(
            "api/curso/listar_primaria" +
              Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda)
          )
          .then((response) => {
            let data = response.data;
            this.listarCursos = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },
      listarCursoSecundaria() {
        axios
          .get(
            "api/curso/listar_secundaria" +
              Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda)
          )
          .then((response) => {
            let data = response.data;
            this.listarCursos = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },
      listarEvaluacionCurso(id_evaluacion) {
        axios
          .get(
            "api/evaluacion_docente_curso/listarEvaluacion/"+id_evaluacion
          )
          .then((response) => {
            let data = response.data;
            this.listarEvaluacionCursos.data = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },
      listarEvaluacionPregunta(id_evaluacion) {
        axios
          .get(
            "api/evaluacion_pregunta/listarEvaluacion/"+id_evaluacion
          )
          .then((response) => {
            let data = response.data;
            this.listarEvaluacionPreguntas.data = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },
  
      limpiarFormulario() {
        this.modal = {
          titulo: "",
          id_evaluacion: null,
          evaluacion: {
            descripcion: "",
            nota: null,
            id_docente: "",
          },
          deshabilitado: false,
        };
        this.$validator.reset();
      },
      nuevo() {
        $("#modal-evaluacion").modal("show");
        this.limpiarFormulario();
        this.modal.titulo = "Nuevo evaluación";
        this.modal.tipo = "nuevo";
      },
      ver(row, index) {
        $("#modal-evaluacion").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Ver evaluación",
          tipo: "ver",
          evaluacion: {
            descripcion: row.descripcion,
            nota: row.nota,
            id_docente: row.id_docente,
          },
          deshabilitado: true,
        };
      },
      agregarCurso(row, index) {
        $("#modal-agregarCurso").modal("show");
        this.limpiarFormulario();
        this.modalAgregar = {
          titulo: "Ver evaluación y cursos",
          tipo: "ver",
          id_docente: row.id_docente,
          nivelID: this.modalAgregar.nivelID,
          id_grado: '',
          id_seccion: '',
          id_docente: row.id_docente,
          evaluacion_docente_curso: {
            inicio: null,
            fin: null,
            id_docen_curso: null,
            id_evaluacion: row.id,
          },
          deshabilitado: true,
        };
        this.listarEvaluacionCurso(row.id);
  
      },
      agregarPregunta(row, index) {
        $("#modal-agregarPregunta").modal("show");
        document.getElementById('imagenForm').value = null;
        this.limpiarFormulario();
        this.modalAgregarPregunta = {
          titulo: "Ver preguntas y alternativas",
          tipo: "ver",
          pregunta: {
            descripcion: null,
            nota: null,
            imagen: null,
            id_evaluacion: row.id,
          },
          alternativa_correcta:'',
          distractor1:'',
          distractor2:'',
          distractor3:'',
          distractor4:'',
          deshabilitado: true,
        };
        this.listarEvaluacionPregunta(row.id);
      },

      verEvaluacionPregunta(row, index) {
        $("#modal-verPregunta").modal("show");
        document.getElementById('imagenForm').value = null;
        this.limpiarFormulario();
        this.modalVerPregunta = {
          titulo: "Visualizador de pregunta",
          tipo: "ver",
          index: index,
          id_pregunta: row.id,
          pregunta: {
            descripcion: row.descripcion,
            nota: row.nota,
            imagen: row.imagen,
            id_evaluacion: row.id,
          },
          alternativas: row.alternativa,
          alternativa_correcta:row.alternativa[0].descripcion,
          distractor1:row.alternativa[1].descripcion,
          distractor2:row.alternativa[2].descripcion,
          distractor3:row.alternativa[3].descripcion,
          distractor4:row.alternativa[4].descripcion,
          deshabilitado: true,
        };
      },
      editar(row, index) {
        $("#modal-evaluacion").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Editar evaluación",
          tipo: "editar",
          id_evaluacion: row.id,
          evaluacion: {
            descripcion: row.descripcion,
            nota: row.nota,
            id_docente: row.id_docente,
          },
          deshabilitado: false,
        };
      },
      guardar() {
        this.$validator.validateAll("form_registro").then((result) => {
          if (result) {
            axios
              .post("api/evaluacion/crear", this.modal.evaluacion)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-evaluacion").modal("hide");
                this.listarEvaluacion();
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },
      guardarAgregarCurso() {
        this.$validator.validateAll("form_registro_evaluacion_curso").then((result) => {
          if (result) {
            axios
              .post("api/evaluacion_docente_curso/crear", this.modalAgregar.evaluacion_docente_curso)
              .then((response) => {
                this.$toastr.s(response.data.message);
                this.listarEvaluacionCurso(this.modalAgregar.evaluacion_docente_curso.id_evaluacion);
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },
      guardarAgregarPregunta() {
        this.$validator.validateAll("form_registro_evaluacion_pregunta").then((result) => {
          if (result) {
            let _this = this;
            let data = new FormData();
                data.append('imagen', document.getElementById('imagenForm').files[0]);
                data.append('nota', _this.modalAgregarPregunta.pregunta.nota);
                data.append('id_evaluacion', _this.modalAgregarPregunta.pregunta.id_evaluacion);
                data.append('descripcion', _this.modalAgregarPregunta.pregunta.descripcion);
                data.append('alternativa_correcta', _this.modalAgregarPregunta.alternativa_correcta);
                data.append('distractor1', _this.modalAgregarPregunta.distractor1);
                data.append('distractor2', _this.modalAgregarPregunta.distractor2);
                data.append('distractor3', _this.modalAgregarPregunta.distractor3);
                data.append('distractor4', _this.modalAgregarPregunta.distractor4);     
            axios
              .post("api/evaluacion_pregunta/crear", data)
              .then((response) => {
                this.$toastr.s(response.data.message);
                document.getElementById('imagenForm').value = null;
                this.listarEvaluacionPregunta(this.modalAgregarPregunta.pregunta.id_evaluacion);
                this.listarEvaluacion();
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },
      modificar() {
        this.$validator.validateAll("form_registro").then((result) => {
          if (result) {
            axios
              .put("api/evaluacion/modificar/" + this.modal.id_evaluacion, this.modal.evaluacion)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-evaluacion").modal("hide");
                this.listarEvaluacion();
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },
      eliminar(row, index) {
         this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios
          .put("api/evaluacion/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarEvaluacion();
                });
        
      },
       eliminarEvaluacionCurso(row, index) {
          this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios
          .put("api/evaluacion_docente_curso/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
            this.listarEvaluacionCurso(row.id_evaluacion);
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarEvaluacion();
                });
          
        
      },
      eliminarEvaluacionPregunta(row, index) {
         this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios
          .put("api/evaluacion_pregunta/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
            this.listarEvaluacionPregunta(row.id_evaluacion);
            this.listarEvaluacion();
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        });
         
        
      },
      activar(row, index) {
        axios
          .put("api/evaluacion/activar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = true;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
      },
      listarContenidoPeligroso() {
        this.listarEvaluaciones.filtrosBusqueda.contenidoPeligroso = true;
        this.listarEvaluacion();
      },
      obtenerTipo(row) {
        if (row.tipo == 1) return "Inicio";
        else if (row.tipo == 2) return "Pregunta";
        else if (row.tipo == 1) return "Publicación";
      },
      exportar() {
        let url =
          process.env.MIX_APP_URL +
          "/exportar/ocupaciones" +
          Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda);
        window.open(url);
      },

      alternativa_correcta(row){
        return row.alternativa[0].descripcion;
      },

      distractor1(row){
        return row.alternativa[1].descripcion;
      },

      distractor2(row){
        return row.alternativa[2].descripcion;
      },

      distractor3(row){
        return row.alternativa[3].descripcion;
      },

      distractor4(row){
        return row.alternativa[4].descripcion;
      },
    },
  };
  </script>
  <style >
  </style>
  