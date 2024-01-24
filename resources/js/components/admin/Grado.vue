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
      <h4 class="text-color-2 mb-3">Mantenimiento de Grados</h4>
    </div>
    <br />
    <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarGrados.filtrosBusqueda.tipo" @change="listarGrado" >
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
        :columns="listarGrados.columns"
        :rows="listarGrados.data"
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
              class="btn btn-outline-success btn-sm btn-icon"
              @click.prevent="agregarCurso(props.row, props.index)"
              data-toggle="tooltip"
              title="Agregar"
            >
              <i class="fas fa-plus"></i> Cursos
            </button>
            <button
              class="btn btn-outline-secondary btn-sm btn-icon"
              @click.prevent="ver(props.row, props.index)"
              data-toggle="tooltip"
              title="Ver"
            >
              <i class="fas fa-eye"></i>
            </button>
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
        id="modal-grado"
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
                    <strong>Nivel</strong>
                  </p>
                  <select
                    name="nivel"
                    class="form-control"
                    v-model="modal.grado.id_nivel"
                    data-vv-as="Nivel"
                    placeholder="Seleccione Nivel"
                    v-validate="'required'"
                  >
                    <option
                      v-for="row in listarNiveles"
                      :key="row.id"
                      :value="row.id"
                      v-text="row.nombre"
                    ></option>
                  </select>
                  <span class="text-danger">{{
                    errors.first("form_registro.nivel")
                  }}</span>
                </div>
                <div class="form-group">
                  <p class="m-0">
                    <strong>Grado</strong>
                  </p>
                  <input
                    type="text"
                    v-model="modal.grado.grado"
                    class="form-control"
                    data-vv-as="Grado"
                    placeholder="Grado"
                    name="grado"
                    v-validate="'required|max:30'"
                  />
                  <span class="text-danger">{{
                    errors.first("form_registro.grado")
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
              <form class="form" data-vv-scope="form_registro_grado_curso">
                <div class="row">
                  <div class="form-group col-6">
                    <p class="m-0">
                      <strong>Nivel</strong>
                    </p>
                    <select
                      name="id_nivel"
                      disabled
                      class="form-control"
                      v-model="modalAgregar.grado.id_nivel"
                      data-vv-as="id_nivel"
                      placeholder="Seleccione Nivel"
                      v-validate="'required'"
                    >
                      <option
                        v-for="row in listarNiveles"
                        :key="row.id"
                        :value="row.id"
                        v-text="row.nombre"
                      ></option>
                    </select>
                  </div>
                  <div class="form-group col-6">
                    <p class="m-0">
                      <strong>Grado</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modalAgregar.grado.grado"
                      disabled
                      class="form-control"
                      data-vv-as="Nombre"
                      placeholder="Nombre"
                      name="grado"
                      :id="modalAgregar.grado.id"
                      v-validate="'required'"
                    />
                  </div>
                  <div class="form-group col-10">
                    <p class="m-0">
                      <strong>Cursos</strong>
                    </p>
                    <select
                      name="Curso"
                      class="form-control"
                      v-model="modalAgregar.grado.id_curso"
                      data-vv-as="Curso"
                      placeholder="Seleccione Curso"
                      v-validate="'required'"
                    >
                      <option
                        v-for="row in listarCursos"
                        :key="row.id"
                        :value="row.id"
                        v-text="row.nombre"
                      ></option>
                    </select>
                    <span class="text-danger">{{
                      errors.first("form_registro_grado_curso.nivel")
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
                    :columns="listarGradoCursos.columns"
                    :rows="listarGradoCursos.data"
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
  name: "Ayudas",
  components: {},
  data() {
    return {
      listarGrados: {
        data: [],
        columns: [
          { label: "Grado", field: "grado" },
          { label: "Nivel", field: "nivel.nombre" },
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
      listarGradoCursos: {
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
      listarNiveles: [],
      listarCursos: [],
      deshabilitado: false,
      modal: {
        tipo: "",
        titulo: "",
        nivelID: null,
        grado: {
          grado: "",
          id_nivel: "",
        },
      },
      modalAgregar: {
        tipo: "",
        titulo: "",
        nivelID: null,
        grado: {
          grado: "",
          id_nivel: "",
          id_curso:"",
          cursos: [],
        },
      },
    };
  },
  created() {
    this.listarGrado();
    this.listarNivel();
  },
  methods: {
    listarGrado() {
      axios
        .get(
          "api/grado/listar" +
            Helper.getFilterURL(this.listarGrados.filtrosBusqueda)
        )
        .then((response) => {
          let data = response.data;
          this.listarGrados.data = data;
          console.log(this.listarGrados);
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
    listarCurso() {
      axios
        .get(
          "api/curso/listar" +
            Helper.getFilterURL(this.listarGrados.filtrosBusqueda)
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
    listarCursoPrimaria() {
      axios
        .get(
          "api/curso/listar_primaria" +
            Helper.getFilterURL(this.listarGrados.filtrosBusqueda)
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
            Helper.getFilterURL(this.listarGrados.filtrosBusqueda)
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
    listarGradoCurso(id_grado) {
      axios
        .get(
          "api/grado_curso/listar/" +id_grado
        )
        .then((response) => {
          let data = response.data;
          console.log("sadasd",data);
          this.listarGradoCursos.data = data;
        })
        .catch((error) => {
          console.log(error);
          this.$toastr.e(error.response.data.message);
        });
    },

    limpiarFormulario() {
      this.modal = {
        titulo: "",
        nivelID: null,
        grado: {
          grado: "",
        },
        deshabilitado: false,
      };
      this.$validator.reset();
    },
    nuevo() {
      $("#modal-grado").modal("show");
      this.limpiarFormulario();
      this.modal.titulo = "Nuevo grado";
      this.modal.tipo = "nuevo";
    },
    ver(row, index) {
      $("#modal-grado").modal("show");
      this.limpiarFormulario();
      this.modal = {
        titulo: "Ver grado",
        tipo: "ver",
        grado: {
          grado: row.grado,
          id_nivel: row.id_nivel,
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
        titulo: "Ver grado y cursos",
        tipo: "ver",
        grado: {
          grado: row.grado,
          id_grado:row.id,
          id_nivel: row.id_nivel,
          id_curso:'',
          cursos: [],
        },
        deshabilitado: true,
      };
      this.listarGradoCurso(row.id);

    },
    editar(row, index) {
      $("#modal-grado").modal("show");
      this.limpiarFormulario();
      this.modal = {
        titulo: "Editar grado",
        tipo: "editar",
        nivelID: row.id,
        grado: {
          grado: row.grado,
          id_nivel: row.id_nivel,
        },
        deshabilitado: false,
      };
    },
    guardar() {
      this.$validator.validateAll("form_registro").then((result) => {
        if (result) {
          axios
            .post("api/grado/crear", this.modal.grado)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-grado").modal("hide");
              this.listarGrado();
            })
            .catch((error) => {
              console.log(error);
              this.$toastr.e(error.response.data.message);
            });
        }
      });
    },
    guardarAgregarCurso() {
      this.$validator.validateAll("form_registro_grado_curso").then((result) => {
        if (result) {
          axios
            .post("api/grado_curso/crear", this.modalAgregar.grado)
            .then((response) => {
              this.$toastr.s(response.data.message);
              this.listarGradoCurso(this.modalAgregar.grado.id_grado);
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
            .put("api/grado/modificar/" + this.modal.nivelID, this.modal.grado)
            .then((response) => {
              this.$toastr.s(response.data.message);
              $("#modal-grado").modal("hide");
              this.listarGrado();
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
        .put("api/grado/eliminar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = false;
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
      this.listarGrado();
                });
     
    },
     eliminarGradoCurso(row, index) {
        this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios
        .put("api/grado_curso/eliminar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = false;
          this.listarGradoCurso(row.id_grado);
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
      this.listarGrado();
                });
      
    },
    activar(row, index) {
      axios
        .put("api/grado/activar/" + row.id)
        .then((response) => {
          this.$toastr.s(response.data.message);
          row.activo = true;
        })
        .catch((error) => {
          this.$toastr.e(error.response.data.message);
        });
    },
    listarContenidoPeligroso() {
      this.listarGrados.filtrosBusqueda.contenidoPeligroso = true;
      this.listarGrado();
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
        Helper.getFilterURL(this.listarGrados.filtrosBusqueda);
      window.open(url);
    },
  },
};
</script>
<style >
</style>
