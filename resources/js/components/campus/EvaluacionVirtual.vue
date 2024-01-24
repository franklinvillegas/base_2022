<template>
    <div class="p-3 pt-5">
      <div class="col-md-12" style="margin-left: -15px">
        <h4 class="text-color-2 mb-3">Evaluación Virtual</h4>
      </div>
      <br />
      
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
            <span v-if="props.column.field == 'options'">
              <button
              class="btn btn-outline-secondary btn-sm btn-icon"
              @click.prevent="iniciarEvaluacionVirtual(props.row, props.index)"
              data-toggle="tooltip"
              title="Acceder a la evaluación"
            >
              <i class="fas fa-sign-in-alt"></i>
            </button>
            </span>
          </template>
        </vue-good-table>
      </div>

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
            { label: "Evaluación", field: "evaluacion.descripcion" },
            { label: "Inicio", field: "inicio" },
            { label: "Fin", field: "fin" },
            { label: "Curso", field: "docente_curso.curso.nombre" },
            { label: "Sección", field: "docente_curso.seccion.seccion" },
            { label: "Nivel", field: "docente_curso.seccion.grado.nivel.nombre" },
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
        tipo: this.$store.getters.getAuthUser('rol')
      };
    },
    created() {
      this.listarEvaluacionDocenteCurso();
    },
    methods: {
      listarEvaluacionDocenteCurso() {
        console.log('tipo',this.tipo)
        axios
          .get(
            "api/evaluacion_docente_curso/listar/"+this.tipo +
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

      iniciarEvaluacionVirtual(row, index){
        this.$router.push({
              name: "IniciarEvaluacionVirtual",
              params: {
                  evaluacion: row,
                  id_matricula: '1',
              }
          });
      },
  
      exportar() {
        let url =
          process.env.MIX_APP_URL +
          "/exportar/ocupaciones" +
          Helper.getFilterURL(this.listarEvaluaciones.filtrosBusqueda);
        window.open(url);
      },

    },
  };
  </script>
  <style >
  </style>
  