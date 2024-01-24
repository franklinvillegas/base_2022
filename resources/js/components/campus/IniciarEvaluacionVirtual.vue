<template>
  <div class="p-3 pt-5">
    <div class="row">
      <div class="col-md-12 col-8">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex justify-content-between">
              <span>CURSO: {{evaluacion.docente_curso.curso.nombre}}</span>
              <span>SECCIÓN: {{evaluacion.docente_curso.seccion.seccion}}</span>
            </div>
            <h4 class="card-title text-center">{{evaluacion.evaluacion.descripcion}}</h4>
            <div class="alert alert-success" role="alert" v-if="cRegresiva.expira > 0">
              <div v-if="cuentaRegresivaSegundos!=0">
                Faltan <span v-if="cuentaRegresivaDias!=0">
                  <strong v-text="cuentaRegresivaDias"></strong> días con
                </span>
                <span v-if="cuentaRegresivaSegundos">
                  <strong v-text="cRegresiva.tiempo"></strong> horas
                </span>
                para dar inicio con la evaluación.
              </div>
            </div>
            <div class="alert alert-success" role="alert" v-else-if="cuentaTerminarSegundos > 0">
              La evaluación ha empezado por favor presione el botón <strong>"Iniciar evaluación" </strong>
            </div>
            <div class="alert alert-success" role="alert" v-else>
              La evaluación ha concluido.
            </div>
            <br>
            <p v-if="cRegresiva.expira > 0 || cuentaTerminarSegundos <= 0">La evaluación empezó el día <span v-text="examen.inicio_fecha"></span>, a las <span v-text="examen.inicio_hora"></span>
              horas.</p>
            <p v-else>La evaluación empezará el día <span v-text="examen.inicio_fecha"></span>, a las <span v-text="examen.inicio_hora"></span>
              horas; cuando llegue la hora presione el botón iniciar para poder empezar con la prueba.</p>
            <p v-if="cRegresiva.expira > 0 || cuentaTerminarSegundos <= 0">La evaluación concluyó el día <span v-text="examen.fin_fecha"></span>, a las <span v-text="examen.fin_hora"></span>.</p>
            <p v-else>La evaluación concluiráel día <span v-text="examen.fin_fecha"></span>, a las <span v-text="examen.fin_hora"></span>.</p>
            <div class="row justify-content-md-center">
              <button type="button" class="btn btn-success p-3" @click="iniciarPrueba()" :disabled="cRegresiva.expira > 0 || cuentaTerminarSegundos <= 0" data-toggle="tooltip" v-if="cRegresiva.expira > 0 || cuentaTerminarSegundos > 0"
                title="Iniciar"><!-- <i class="fa fa-search"></i> --> Iniciar evaluación </button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 col-8" v-if="cRegresiva.expira <= 0 && cuentaTerminarSegundos <= 0 && listarEvaluacionRespuestas.length > 0">
        <div class="card">
          <div class="col-md-12">
              <div class="card-body">
                  <h5>Resultado de la evaluación</h5>
                  <table class="table table-striped">
                      <thead>
                          <tr>
                          <th>Total de preguntas</th>
                          <th>Preguntas Respondidas</th>
                          <th>Respuestas Correctas</th>
                          <th>Respuestas incorrectas</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td v-text="evaluacion.evaluacion.pregunta_count.length"></td>
                              <td v-text="resp_correcta + resp_incorrecta"></td>
                              <td v-text="resp_correcta"></td>
                              <td v-text="resp_incorrecta"></td>
                          </tr>
                      </tbody>    
                  </table>
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
        id_matricula: null,
        cuentaRegresivaSegundos: 0,
        cuentaTerminarSegundos: 0,
        cuentaRegresivaDias: 0,
        id_evaluacion: '',
        fecha_inicio: '',
        fecha_fin: '',
        listarEvaluacionRespuestas: [],
        resp_correcta: null,
        resp_incorrecta: null,
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
      console.log('evaluacion', this.evaluacion);
      this.listarEvaluacionRespuesta(this.evaluacion.id)
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
            this.cuentaRegresiva(this.cuentaRegresivaSegundos);
          })
          .catch(function (error) {
            console.log(error);
            this.$toastr.e(error);
          });
      },

      cuentaRegresiva(segundos) {
        let _this = this;
        this.cRegresiva.tiempo = moment.utc(segundos).format('HH:mm:ss');
        this.cRegresiva.expira = segundos;
        this.intervalo = setInterval(() => {
          if (this.cRegresiva.expira <= 0) {
            clearInterval(this.intervalo);
          } else {
            this.cRegresiva.expira -= 1;
            this.cRegresiva.tiempo = moment.utc(this.cRegresiva.expira * 1000).subtract(1, 'seconds').format('HH:mm:ss');
          }
        }, 1000);
      },

      iniciarPrueba(){
          if(this.cRegresiva.expira <= 0){
              this.$router.push({
                name:'EvaluacionPregunta',
                params: {
                  evaluacion: this.evaluacion,
                  id_matricula: this.id_matricula,
              }});
          }
          else{
             toastr['error']('Todavía no ha empezado el examen');  
          }               
      },

      listarEvaluacionRespuesta(id_evaluacion) {
        axios
          .get(
            "api/evaluacion_respuesta_matricula/listarRespuestas/"+id_evaluacion+"/"+this.id_matricula
          )
          .then((response) => {
            this.listarEvaluacionRespuestas = response.data;
            const correcta = this.listarEvaluacionRespuestas.find(element => element.correcta);
            const incorrecta = this.listarEvaluacionRespuestas.find(element => !element.correcta);
            this.resp_correcta = correcta ? correcta.count : 0;
            this.resp_incorrecta =  incorrecta ? incorrecta.count : 0;
            console.log(this.listarEvaluacionRespuestas);
            
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
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