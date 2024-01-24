<template>
  <div class="p-3 pt-5">
    <div class="col-md-12" style="margin-left: -15px">
      <h4 class="text-color-2 mb-3">Reunión Virtual</h4>
    </div>
    <br />
    <div class="table-responsive">
      <vue-good-table
        :columns="listarSalaReuniones.columns"
        :rows="listarSalaReuniones.data"
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
              @click.prevent="unirseSala(props.row, props.index)"
              data-toggle="tooltip"
              title="Acceder a la reunión"
            >
              <i class="fas fa-sign-in-alt"></i>
            </button>
          </span>
        </template>
      </vue-good-table>
    </div>
    <!-- Modal -->
    <template>
      <div
        class="modal fade"
        id="modal-sala_reunion"
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
              <form class="form d-flex flex-wrap" data-vv-scope="form_registro">
                <div class="form-group col-md-12">
                  <p class="m-0">
                    <strong>Descripción</strong>
                  </p>
                  <input
                    type="text"
                    v-model="modal.sala_reunion.descripcion"
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
                <div class="form-group col-md-12">
                  <p class="m-0">
                    <strong>URL sala</strong>
                  </p>
                  <input
                    type="text"
                    v-model="modal.sala_reunion.url_sala"
                    class="form-control"
                    data-vv-as="URL"
                    placeholder="URL"
                    name="url_sala"
                    v-validate="'required'"
                  />
                  <span class="text-danger">{{
                    errors.first("form_registro.url_sala")
                  }}</span>
                </div>
                <div class="form-group col-md-6">
                  <p class="m-0">
                      <strong>Inicio</strong>
                  </p>
                  <input type="datetime-local"
                  v-model="modal.sala_reunion.inicio"
                  class="form-control"
                  data-vv-as="Inicio"
                  placeholder="Inicio"
                  name="inicio">
                  <span class="text-danger">{{
                    errors.first("form_registro.inicio")
                  }}</span>
                </div>
                <div class="form-group col-md-6">
                  <p class="m-0">
                      <strong>Fin</strong>
                  </p>
                  <input type="datetime-local"
                  v-model="modal.sala_reunion.fin"
                  class="form-control"
                  data-vv-as="Fin"
                  placeholder="Fin"
                  name="fin">
                  <span class="text-danger">{{errors.first("form_registro.fin")}}</span>
                </div>
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
                    <select name="grado"
                    class="form-control"
                    v-model="modal.id_grado"
                    data-vv-as="Grado"
                    placeholder="Seleccione grado"
                    v-validate="'required'"
                    @change="listarComponentes(modal.id_grado)">
                        <option v-for="row in listarGrados" :key="row.id" :value="row.id" v-text="row.grado" ></option>
                    </select>
                    <span class="text-danger">{{errors.first("form_registro.grado")}}</span>
                </div>
                <div class="form-group col-md-4">
                    <p class="m-0">
                        <strong>Sección</strong>
                    </p>
                    <select name="seccion"
                    class="form-control"
                    v-model="modal.id_seccion"
                    data-vv-as="Sección"
                    placeholder="Seleccione sección"
                    v-validate="'required'">
                        <option v-for="row in listarSeccions" :key="row.id" :value="row.id" v-text="row.seccion" ></option>
                    </select>
                    <span class="text-danger">{{errors.first("form_registro.seccion")}}</span>
                </div>
                <div class="form-group col-md-12">
                  <p class="m-0">
                      <strong>Curso</strong>
                  </p>
                  <select name="id_grado_curso"
                  class="form-control"
                  v-model="modal.id_curso "
                  data-vv-as="id_grado_curso"
                  placeholder="Seleccione curso"
                  >
                      <option v-for="row in listarCursos" :key="row.id_curso" :value="row.id_curso" v-text="row.curso.nombre" ></option>
                  </select>
                  <span class="text-danger">{{errors.first("form_registro.curso")}}</span>
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
  name: "Ayudas",
  components: {},
  data() {
    return {
      listarSalaReuniones: {
        data: [],
        columns: [
          { label: "Descripcion", field: "descripcion" },
          { label: "Inicio", field: "inicio" },
          { label: "Fin", field: "fin" },
          { label: "Docente", field: "docente_curso.docente.persona.nombres" },
          { label: "Nivel", field: "docente_curso.seccion.grado.nivel.nombre" },
          { label: "Seccion", field: "docente_curso.seccion.seccion" },
          { label: "Curso", field: "docente_curso.curso.nombre" },
          { label: "Acceder", field: "options" },
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
      listarSalaReunionCursos: {
        data: [],
        columns: [
          { label: "Curso", field: "curso.nombre" },
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
      listarNiveles:[],
      listarGrados:[],
      listarSeccions:[],
      listarCursos: [],
      listarAnios: [], 
      id_curso: null,
      deshabilitado: false,
      modal: {
        tipo: "",
        titulo: "",
        nivelID: null,
        id_seccion: '',
        id_grado: '',
        id_curso: '',
        sala_reunion: {
          descripcion: '',
          url_sala: '',
          inicio: '',
          fin: '',
          id_docen_curso: '',
          id_sala: 1,
        },
      },
      modalAgregar: {
        tipo: "",
        titulo: "",
        nivelID: null,
        sala_reunion: {
          sala_reunion: "",
          id_nivel: "",
          id_curso:"",
          cursos: [],
        },
      },
      tipo: this.$store.getters.getAuthUser('rol')
    };
  },
  created() {
    this.listarSalaReunion();
    this.listarAños();
    this.listarNivel();
  },
  methods: {
    listarSalaReunion() {
      console.log('tipo',this.tipo);
      axios
        .get(
          "api/sala_reunion/listar/"+this.tipo+
            Helper.getFilterURL(this.listarSalaReuniones.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarSalaReuniones.data = data;
          console.log(this.listarSalaReuniones);
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
        axios.get("api/nivel/listar"+Helper.getFilterURL(this.listarSalaReuniones.filtrosBusqueda))
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
    listarSalaReunionCurso(id_sala_reunion) {
      axios
        .get(
          "api/sala_reunion_curso/listar/" +id_sala_reunion
        )
        .then((response) => {
          let data = response.data;
          console.log("sadasd",data);
          this.listarSalaReunionCursos.data = data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },

    unirseSala(row, index) {
      const left = (screen.width - 800) / 2;
      const top = (screen.height - 600) / 4;
      window.open(row.url_sala,"Descripción: " + row.descripcion, "width=800, height=600"+ ', top=' + top + ', left=' + left)
    },

    limpiarFormulario() {
      this.modal = {
        tipo: "",
        titulo: "",
        nivelID: null,
        id_seccion: '',
        id_grado: '',
        id_curso: '',
        sala_reunion: {
          descripcion: '',
          url_sala: '',
          inicio: '',
          fin: '',
          id_docen_curso: '',
          id_sala: 1,
        },
        deshabilitado: false,
      };
      this.$validator.reset();
    },
    nuevo() {
      $("#modal-sala_reunion").modal("show");
      this.limpiarFormulario();
      this.modal.titulo = "Nuevo sala reunión";
      this.modal.tipo = "nuevo";
    },
    ver(row, index) {
      $("#modal-sala_reunion").modal("show");
      this.limpiarFormulario();
      this.listarGrado(row.docente_curso.seccion.grado.id_nivel);
      this.listarComponentes(row.docente_curso.seccion.id_grado);
      this.modal = {
        titulo: "Ver sala reunión",
        tipo: "ver",
        nivelID: row.docente_curso.seccion.grado.id_nivel,
        id_seccion: row.docente_curso.id_seccion,
        id_grado: row.docente_curso.seccion.id_grado,
        id_curso: row.docente_curso.id_curso,
        sala_reunion: {
          descripcion: row.descripcion,
          url_sala: row.url_sala,
          inicio: row.inicio,
          fin: row.fin,
          id_docen_curso: row.id_docen_curso,
          id_sala: row.id_sala,
        },
        deshabilitado: true,
      };
    },
    agregarCurso(row, index) {
      $("#modal-agregarCurso").modal("show");
      this.limpiarFormulario();
      if (row.id_nivel == 1) this.listarCursoPrimaria();
      else this.listarCursoSecundaria();
      this.modalAgregar = {
        titulo: "Ver sala_reunion y cursos",
        tipo: "ver",
        sala_reunion: {
          sala_reunion: row.sala_reunion,
          id_sala_reunion:row.id,
          id_nivel: row.id_nivel,
          id_curso:'',
          cursos: [],
        },
        deshabilitado: true,
      };
      this.listarSalaReunionCurso(row.id);

    },
    editar(row, index) {
      $("#modal-sala_reunion").modal("show");
      this.limpiarFormulario();
      this.listarGrado(row.docente_curso.seccion.grado.id_nivel);
      this.listarComponentes(row.docente_curso.seccion.id_grado);
      this.modal = {
        tipo: "editar",
        titulo: "Ver sala reunión",
        nivelID: row.docente_curso.seccion.grado.id_nivel,
        id_seccion: row.docente_curso.id_seccion,
        id_grado: row.docente_curso.seccion.id_grado,
        id_curso: row.docente_curso.id_curso,
        sala_reunion: {
          descripcion: row.descripcion,
          url_sala: row.url_sala,
          inicio: row.inicio,
          fin: row.fin,
          id_docen_curso: row.id_docen_curso,
          id_sala: row.id_sala,
        },
        deshabilitado: false,
      };
    },
    guardar() {
      this.$validator.validateAll("form_registro").then((result) => {
        if (result) {
          axios
            .post("api/sala_reunion/crear", this.modal)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-sala_reunion").modal("hide");
              this.listarSalaReunion();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    guardarAgregarCurso() {
      this.$validator.validateAll("form_registro_sala_reunion").then((result) => {
        if (result) {
          axios
            .post("api/sala_reunion_curso/crear", this.modalAgregar.sala_reunion)
            .then((response) => {
              this.$toastr.s(response.data.message);
              this.listarSalaReunionCurso(this.modalAgregar.sala_reunion.id_sala_reunion);
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
            .put("api/sala_reunion/modificar/" + this.modal.nivelID, this.modal.sala_reunion)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-sala_reunion").modal("hide");
              this.listarSalaReunion();
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
        .put("api/sala_reunion/eliminar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = false;
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
      this.listarSalaReunion();
                });
      
    },
     eliminarSalaReunionCurso(row, index) {
        this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios
        .put("api/sala_reunion_curso/eliminar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = false;
          this.listarSalaReunionCurso(row.id_sala_reunion);
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
      this.listarSalaReunion();
                });
      
    },
    activar(row, index) {
      axios
        .put("api/sala_reunion/activar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = true;
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
    },
    listarContenidoPeligroso() {
      this.listarSalaReuniones.filtrosBusqueda.contenidoPeligroso = true;
      this.listarSalaReunion();
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
        Helper.getFilterURL(this.listarSalaReuniones.filtrosBusqueda);
      window.open(url);
    },
  },
};
</script>
<style >
</style>
