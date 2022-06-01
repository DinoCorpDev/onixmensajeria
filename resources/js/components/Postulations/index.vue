<template>
  <div :class="changeActive === true ? 'container content-large': 'container content-short'">


    <div class="card">
      <div class="card-header text-center">
        <h2><strong>Convocatorias {{ fileBanner }}</strong></h2>
      </div>
      <div class="col-md-">
        <button class="btn btn-outline-primary mb-2 mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear
          Postulación
        </button>
      </div>
      <div class="card-body">
        <table class="table table-sm">
          <thead>
          <tr>
            <th>Banner</th>
            <th>Nombre del Evento</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Ubicación</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(postulation, key) in postulations" :key="key">
            <td><img style="height: 74px; width: 117px;" :src="postulation.banner" alt=""></td>
            <td>{{ postulation.name }}</td>
            <td>{{ postulation.address }}</td>
            <td>{{ postulation.city }}</td>
            <td>{{ postulation.location }}</td>
            <td>
              <button class="btn btn-outline-primary" v-on:click="getPostulations(postulation.id)">Detalle</button>
              <button class="btn btn-outline-primary" v-on:click="editPostulation(postulation)">Editar</button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!--============================
          CREACION DE MODAL
    ==============================-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ id === null ? 'Creación de Postulación' : 'Actualización de Postulación' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <loading :active.sync="isLoading"
                     :is-full-page="fullPage"></loading>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="label">Id Italentt</label>
                  <input type="text" v-model="postulation.idItalentt" required="required" name="label"
                         class="form-control"/>
                </div>
                <div class="form-group">
                  <label for="value">banner</label>
                  <input type="file" name="banner" id="banner" class="form-control"
                         v-on:change="(e)=>bannerUpload(e.target.files)">
                  <!-- <input type="text" v-model="postulation.banner" required="required" name="label" class="form-control"/> -->
                </div>
                <div class="form-group">
                  <label for="value">Nombre</label>
                  <input type="text" v-model="postulation.name" required="required" name="label" class="form-control"/>
                </div>
              </div>
            </div>

            <div class="row mt-5 mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="value">Tipo de Personal</label>
                  <input type="text" v-model="postulation.aboutPersonal.type" required="required" name="label"
                         class="form-control"/>

                  <label for="value">Cantidad</label>
                  <input type="number" v-model="postulation.aboutPersonal.quantity" required="required" name="label"
                         class="form-control"/>

                  <label for="value">Descripción</label>
                  <textarea type="text" v-model="postulation.aboutPersonal.description" required="required" name="label"
                            class="form-control"/>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col">
                <div class="form-group">
                  <label for="value">Fecha Inicial</label>
                  <input type="date" v-model="postulation.initialDate" required="required" name="label"
                         class="form-control"/>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="value">Fecha Final</label>
                  <input type="date" v-model="postulation.endDate" required="required" name="label"
                         class="form-control"/>
                </div>
              </div>
            </div>

            <div class="row mb-5">
              <div class="col mt-3">
                <button class="btn btn-success" v-if="postulation.hourly.length < 7" v-on:click="moreDays">+</button>
                <button class="btn btn-danger" v-on:click="lessDays">-</button>
              </div>
              <div class="col">
                <div class="form-group" v-for="(postHour, key) in postulation.hourly" :key="key">
                  <label for="value">Dia</label>
                  <input type="text" v-model="postulation.hourly[key].day" required="required" name="label"
                         class="form-control"/>
                </div>
              </div>

              <div class="col">
                <div class="form-group" v-for="(postHour, key) in postulation.hourly" :key="key">
                  <label for="value">Hora</label>
                  <input type="text" v-model="postulation.hourly[key].hourly" required="required" name="label"
                         class="form-control"/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="value">Ciudad</label>
                  <input type="text" v-model="postulation.city" required="required" name="label" class="form-control"/>
                </div>


                <div class="form-group">
                  <label for="value">Ubicación</label>
                  <input type="text" v-model="postulation.location" required="required" name="label"
                         class="form-control"/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="value">Dirección</label>
                  <input type="text" v-model="postulation.address" required="required" name="label"
                         class="form-control"/>
                </div>
                <div class="form-group">
                  <label for="value">Presupuesto Total</label>
                  <input type="number" v-model="postulation.totalBudget" required="required" name="label"
                         class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="value">Presupuesto Diario</label>
                  <input type="number" v-model="postulation.dailyBudget" required="required" name="label"
                         class="form-control"/>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" v-on:click="savePostulation">Guardar Cambios</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailUserModalLabel">Detalle De Postulación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body mb-5" v-for="(postulate, key) in postulateds" :key="key">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="name_user">Nombre y Apellido Postulado</label>
                  <input type="text" id="name_user" disabled :value="postulate.name+' '+postulate.lastname"
                         class="form-control">
                </div>
                <div class="form-group">
                  <label for="identification_user">Documento Postulado</label>
                  <input type="text" id="identification_user" disabled :value="postulate.identification"
                         class="form-control">
                </div>
              </div>
            </div>

            <div class="row mt-5 mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="lastname_user">Nombre Artistico</label>
                  <input type="text" id="lastname_user" :value="postulate.nickname" disabled class="form-control">
                </div>

                <div class="form-group">
                  <label for="birthday_user">Fecha de Nacimiento</label>
                  <input type="text" id="birthday_user" :value="postulate.birthday" disabled class="form-control">
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col">
                <div class="form-group">
                  <label for="city_user">Ciudad Postulado</label>
                  <input type="text" id="city_user" disabled :value="postulate.city" class="form-control">
                </div>
              </div>

              <div class="col">
                <div class="form-group" v-if="postulate.gender">
                  <label for="gender_user">Genero Postulado</label>
                  <input type="text" id="city_user" disabled :value="postulate.gender.label" class="form-control">
                </div>
              </div>
            </div>

            <div class="row mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="gender_user">Foto Postulado</label>
                  <div v-for="(photo, key) in postulate.photos" :key="key">
                    <a :href="photo.uri" target="_blank">Link {{ key }}</a>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="video_user">Video Postulado</label>
                  <a :href="postulate.video" target="_blank">Video</a>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group" v-if="postulate.contact">
                  <label for="contact_user">Contacto Postulado</label>
                  <div v-if="postulate.contact">
                    <input type="text" class="form-control" :value="'Celular: '+postulate.contact.phone"/>
                    <input type="text" class="form-control" :value="'Facebook: '+postulate.contact.facebook"/>
                    <input type="text" class="form-control" :value="'Instagram: '+postulate.contact.instagram"/>
                    <input type="text" class="form-control" :value="'Snapchat: '+postulate.contact.snapchat"/>
                    <input type="text" class="form-control" :value="'Twitter: '+postulate.contact.twitter"/>
                    <input type="text" class="form-control" :value="'Spotify: '+postulate.contact.spotify"/>
                    <input type="text" class="form-control" :value="'Youtube: '+postulate.contact.youtube"/>
                  </div>
                </div>

                <div class="form-group" v-if="postulate.competences && postulate.competences.length > 0">
                  <label for="competences_user">Competencias Postulado</label>
                  <div v-for="(competence, key) in postulate.competences" :key="key">
                    <input type="text" class="form-control" :value="competence.label"/>
                  </div>
                </div>

                <div class="form-group" v-if="postulate.education && postulate.education.length > 0">
                  <label for="education_user">Educación Postulado</label>
                  <div v-for="(education, key) in postulate.education" :key="key">
                    <input type="text" class="form-control" :value="'Titulo: '+education.title"/>
                    <input type="text" class="form-control" :value="'Institución: '+education.institution"/>
                    <input type="text" class="form-control" :value="'Fecha Inicial: '+education.initialDate"/>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group" v-if="postulate.roles && postulate.roles.length > 0"></div>
                <label for="roles_user">Roles Postulado</label>
                <div v-for="(role, key) in postulate.roles" :key="key">
                  <input class="form-control" type="text" :value="role.name"/>
                </div>
              </div>
              <div class="form-group">
                <label for="pyshical_user">Atributos Fisicos Postulado</label>
                <div v-if="postulate.pyshical">
                  <input type="text" class="form-control" :value="'Ojos: '+postulate.pyshical.eyesColor"/>
                  <input type="text" class="form-control" :value="'Cabello: '+postulate.pyshical.hairColor"/>
                  <input type="text" class="form-control" :value="'Altura: '+postulate.pyshical.height"/>
                  <input type="text" class="form-control" v-if="postulate.pyshical.pantSize"
                         :value="'Pantalon: '+postulate.pyshical.pantSize.label"/>
                  <input type="text" class="form-control" v-if="postulate.pyshical.shirtSize"
                         :value="'Camisa: '+postulate.pyshical.shirtSize.label"/>
                  <input type="text" class="form-control" :value="'Zapatos: '+postulate.pyshical.shoes"/>
                  <input type="text" class="form-control" :value="'Peso: '+postulate.pyshical.weight"/>
                </div>
              </div>
              <GmapMap :center="center" :zoom='12' style='width:100%;  height: 400px;'/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" v-on:click="savePostulation">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {Modal} from 'bootstrap';
import {getStorage, ref, uploadBytesResumable, getDownloadURL} from "firebase/storage";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  props: ['changeActive'],
  data() {
    return {
      center: {lat: 45.508, lng: -73.587},
      fileStatus: false,
      postulations: [],
      postulateds: [],
      postulation: {
        aboutPersonal: {},
        hourly: [{
          day: "",
          hourly: ""
        }],
        banner: null,
      },
      id: null,
      myModal: '',
      detailUserModal: '',
      fileBanner: null,
      isLoading: false,
      fullPage: false
    }
  },
  components: {
    Loading
  },
  mounted() {
    this.getConvocations();
    this.modal = new Modal(document.getElementById('exampleModal'));
    this.detailUserModal = new Modal(document.getElementById('detailUserModal'));
  },
  methods: {
    geolocate() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
      });
    },
    getConvocations() {
      axios.get('api/getAllConvocations').then((response) => {
        console.log(response.data)
        this.postulations = response.data;
      }).catch((error) => {
        console.log(error);
      })
    },
    getPostulations(id) {
      axios.post('api/getPostulations', {id_event: id}).then((response) => {
        this.postulateds = response.data;
        this.detailUserModal.show();
      })
    },
    moreDays() {
      this.postulation.hourly.push({
        day: "",
        hourly: ""
      })
    },
    lessDays() {
      this.postulation.hourly = this.postulation.hourly.slice(0, -1);
    },
    bannerUpload(file) {
      this.fileBanner = file[0];
    },
    editPostulation(data) {
      this.postulation = data;
      this.id = data.id;
      this.modal.show();
    },
    savePostulation() {
      if (this.fileBanner) {
        this.isLoading = true;
        this.saveImageFire().then(response => {

          this.postulation.banner = response;

          if (this.id === null) {
            axios.post('api/convocations', this.postulation).then((response) => {
              this.cleanData();
              toastr.success('Postulación creada');
              console.log(response.data);
            }).catch((error) => {
              toastr.info('Intente de nuevo mas tarde');
              console.log(error);
            }).finally(response => {
              this.isLoading = false;
            })
          } else {
            axios.put(`api/convocations/${this.id}}`, this.postulation).then((response) => {
              this.cleanData();
              toastr.success('Postulación Actualizada');
            }).catch((error) => {
              toastr.info('Intente de nuevo mas tarde');
              console.log(error);
            }).finally(response => {
              this.isLoading = false;
            })
          }
        })
      }

    },

    async saveImageFire() {
      if (this.fileBanner) {
        const storage = getStorage();
        const storageRef = ref(storage, `adminDashboard/postulations/${this.fileBanner.name}/`);
        const snapshot = await uploadBytesResumable(storageRef, this.fileBanner);
        const url = await getDownloadURL(snapshot.ref);
        alert('tenemos los datos')
        return Promise.resolve(url)
      }
    },

    cleanData() {
      this.postulation = {
        aboutPersonal: {},
        hourly: [{
          day: "",
          hourly: ""
        }],
        banner: null
      };
      this.id = null;
      this.fileBanner = null
      this.getConvocations();
      this.modal.hide();
    }
  }
}
</script>
<style>
.content-large {
  margin-left: 118px;
  transition: 0.5s;
}

.content-short {
  margin-left: 19px;
  transition: 0.5s;
}
</style>
