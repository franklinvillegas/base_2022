<template>
  <div class="p-3 pt-5">
    <div class="row">
      <div class="col-md-12 col-8">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex justify-content-center">
              Tiempo Restante: <span v-text="cRegresiva.tiempo"></span>
            </div>
            <div class="card-title d-flex justify-content-between">
              <span>CURSO: {{evaluacion.docente_curso.curso.nombre}}</span>
              <span>SECCIÓN: {{evaluacion.docente_curso.seccion.seccion}}</span>
            </div>
            <h4 class="card-title text-center">{{evaluacion.evaluacion.descripcion}}</h4>

            <div class="card shadow rounded my-3 mx-4" v-for="(pregunta, index) in listarEvaluacionPreguntas" :key="index" v-show="index == posicion">
              <div class="card-header d-flex d-flex justify-content-between"><b>Pregunta
                  {{posicion+1}}</b> <span>(Puntaje: {{pregunta.nota}})</span></div>
              <div class="card-body text-dark d-flex flex-column flex-wrap align-content-center">
                <h3 class="card-title">{{pregunta.descripcion}}</h3>
                <img v-if="pregunta.imagen!=''" class="pb-3 object-fit-contain" style="height:150px; width: auto;"
                  :src="$baseUrlVue(`images/preguntas/${pregunta.imagen}`)">
                <div>
                  <div class="form-check" v-for="(alternativa, index) in pregunta.alternativa" :key="index"
                    style="padding-left: 25px;margin-bottom: 4px;">
                    <input type="radio" class="form-check-input" :name="'pregunta_'+pregunta.id"
                      :id="'alternativa_'+pregunta.id+'_0' + index" :value="index" :checked="verificarCheck(alternativa)" @change="radioSeleccionado(alternativa)">
                    <label class="form-check-label" :for="'alternativa_'+pregunta.id+'_0' + index"
                      style="padding-left: 5px;">
                      <span v-html="alternativa.descripcion"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <br>
            <div class="d-flex justify-content-between" v-if="listarEvaluacionPreguntas.length > 0">
              <button type="button" class="btn btn-success p-3" @click="anteriorPregunta()" :disabled="1 > posicion" data-toggle="tooltip"
                title="Anterior">Anterior</button>
              <button type="button" class="btn btn-primary p-3" @click="terminarEvaluacion()" v-if="posicion + 1 >= listarEvaluacionPreguntas.length" data-toggle="tooltip"
                title="Anterior">Terminar evaluación</button>
              <button type="button" class="btn btn-success p-3" @click="siguientePregunta()" :disabled="posicion + 1 >= listarEvaluacionPreguntas.length" data-toggle="tooltip"
                title="Siguiente">Siguiente</button>
            </div>
          </div>
        </div>
      </div>
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
        modalVerPregunta: {
          tipo: "",
          titulo: "Ver pregunta",
          pregunta: {
            descripcion: null,
            nota: null,
            imagen: null,
            id_evaluacion: null,
          },
          alternativa_correcta: '',
          distractor1: '',
          distractor2: '',
          distractor3: '',
          distractor4: '',
        },
        actual: {
          fecha: '',
          hora: '',
        },
        examen: {
          inicio_fecha: '',
          inicio_hora: '',
          fin_fecha: '',
          fin_hora: '',
        },
        cRegresiva: {
          tiempo: null,
          expira: null,
        },
        evaluacion: {
          id:'',
          evaluacion:{
            descripcion:'',
          },
          docente_curso: {
            seccion:'',
            curso:''
          },
        },
        listarEvaluacionPreguntas: [],
        listarEvaluacionRespuestas: [],
        posicion: 0,
        cuentaRegresivaSegundos: 0,
        cuentaTerminarSegundos: 0,
        cuentaRegresivaDias: 0,
        id_evaluacion: '',
        id_matricula: '',
        fecha_inicio: '',
        fecha_fin: '',
      };
    },
    created() {
      if (!this.$route.params.evaluacion) {
        this.$router.push({ name: "EvaluacionVirtual" });
        return;
      }
      this.evaluacion = this.$route.params.evaluacion;
      this.id_matricula = this.$route.params.id_matricula;
      this.id_evaluacion = this.evaluacion.id_evaluacion;
      this.fecha_inicio = this.evaluacion.inicio;
      this.fecha_fin = this.evaluacion.fin;
      this.getDateTime();
      this.listarEvaluacionPregunta(this.id_evaluacion);
      this.listarEvaluacionRespuesta(this.evaluacion.id, this.id_matricula)
      
    },
    beforeDestroy () {
      clearInterval(this.intervalo);
    },
    methods: {
      getDateTime() {
        axios.get('api/evaluacion/getDateTimeActual')
          .then((response) => {
            this.actual.fecha = response.data.fechaActual;
            this.actual.hora = response.data.horaActual;
            this.examen.inicio_fecha = moment(this.fecha_inicio).format("DD/MM/YYYY");
            this.examen.inicio_hora = moment(this.fecha_inicio).format('HH:mm');
            this.examen.fin_fecha = moment(this.fecha_fin).format("DD/MM/YYYY");
            this.examen.fin_hora = moment(this.fecha_fin).format('HH:mm');
            var fecha_actual = moment(this.actual.fecha + ' ' + this.actual.hora);
            var fecha_examen = moment(this.fecha_inicio);
            var fecha_fin_examen = moment(this.fecha_fin);
            this.cuentaRegresivaSegundos = Number(fecha_examen.diff(fecha_actual, 'seconds'));
            this.cuentaRegresivaDias = Number(fecha_examen.diff(fecha_actual, 'days'));
            this.cuentaTerminarSegundos = Number(fecha_fin_examen.diff(fecha_actual, 'seconds'));
            this.cuentaRegresiva(this.cuentaTerminarSegundos);
          })
          .catch(function (error) {
            console.log(error);
            this.$toastr.e(error);
          });
      },

      cuentaRegresiva(segundos) {
        this.cRegresiva.tiempo = moment.utc(segundos).format('HH:mm:ss');
        this.cRegresiva.expira = segundos;
        this.intervalo = setInterval(() => {
          if (this.cRegresiva.expira <= 0) {
            this.terminarEvaluacion();
            clearInterval(this.intervalo);
          } else {
            this.cRegresiva.expira -= 1;
            this.cRegresiva.tiempo = moment.utc(this.cRegresiva.expira * 1000).subtract(1, 'seconds').format('HH:mm:ss');
          }
        }, 1000);
      },

      listarEvaluacionPregunta(id_evaluacion) {
        axios
          .get(
            "api/evaluacion_pregunta/listarEvaluacionMatricula/"+id_evaluacion+"/"+this.id_matricula+"/"+this.evaluacion.id
          )
          .then((response) => {
            this.listarEvaluacionPreguntas = response.data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },

      listarEvaluacionRespuesta(id_evaluacion) {
        axios
          .get(
            "api/evaluacion_respuesta_matricula/listarRespuestas/"+id_evaluacion+"/"+this.id_matricula
          )
          .then((response) => {
            this.listarEvaluacionRespuestas = response.data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },

      anteriorPregunta(){
        if(this.posicion > 0){
          this.posicion -= 1;   
        }  
      },  

      siguientePregunta(){
        if(this.listarEvaluacionPreguntas.length > this.posicion + 1){
          this.posicion += 1;
        }    
      }, 
      
      radioSeleccionado(alternativa){               
        let actualizo = false;
        for(var i = 0 ;i< this.listarEvaluacionRespuestas.length; i++ ){
          if(this.listarEvaluacionRespuestas[i].evaluacion_alternativa.id_evaluacion_pregunta == alternativa.id_evaluacion_pregunta){
            this.actualizarRespuesta(alternativa.id, this.listarEvaluacionRespuestas[i].id);
            // this.listarEvaluacionRespuestas[i].idAlternativa = alternativa.idAlternativa;
            actualizo = true;
            break;
          }
        }
        if(actualizo==false){
          this.guardarRespuesta(alternativa.id);
        }
      },

      guardarRespuesta(id_alternativa){
        if (id_alternativa) {
          const date = moment().format("DD/MM/YYYY");
          const data = {
            id_evaluacion_alter: id_alternativa,
            id_matricula: this.id_matricula,
            id_evaluacion_docen_curso: this.evaluacion.id
          }
            axios.post("api/evaluacion_respuesta_matricula/crear", data)
            .then((response) => {
              this.listarEvaluacionRespuesta(this.evaluacion.id, this.id_matricula)
            })
            .catch((error) => {
                console.log(error);
                //this.$toastr.e(error.response.data.message);
            });
        }
      },

      actualizarRespuesta(id_alternativa, id_alternativa_respuesta){
        if (id_alternativa) {
          const date = moment().format("DD/MM/YYYY");
          const data = {
            id_evaluacion_alter: id_alternativa,
          }
            axios.put("api/evaluacion_respuesta_matricula/modificar/"+id_alternativa_respuesta, data)
            .then((response) => {
              this.listarEvaluacionRespuesta(this.evaluacion.id, this.id_matricula)
            })
            .catch((error) => {
                console.log(error);
                //this.$toastr.e(error.response.data.message);
            });
        }
      },

      terminarEvaluacion(){
        this.$router.push({name: 'EvaluacionVirtual'})
      },

      verificarCheck(alternativa){
        if(alternativa.respuesta_matricula.length > 0)
          return true;
        return false; 
      },

      alternativa_correcta(row) {
        return row.alternativa[0].descripcion;
      },

      distractor1(row) {
        return row.alternativa[1].descripcion;
      },

      distractor2(row) {
        return row.alternativa[2].descripcion;
      },

      distractor3(row) {
        return row.alternativa[3].descripcion;
      },

      distractor4(row) {
        return row.alternativa[4].descripcion;
      },
    },
  };
</script>
<style>
</style>