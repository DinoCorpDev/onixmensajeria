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
                  <label for="id_postulate">Id Italentt</label>
                  <input type="text" id="id_postulate" disabled :value="postulate.idItalentt" class="form-control">
                </div>
                <div class="form-group">
                  <label for="name_postulate">Nombre</label>
                  <input type="text" id="name_postulate" disabled :value="postulate.name" class="form-control">
                </div>
              </div>
            </div>

            <div class="row mt-5 mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="type_postulate">Tipo de Personal</label>
                  <input type="text" id="type_postulate" :value="postulate.typePersonal.type" disabled class="form-control">
                </div>

                <div class="form-group">
                  <label for="quantity_postulate">Cantidad</label>
                  <input type="text" id="quantity_postulate" :value="postulate.typePersonal.quantity" disabled class="form-control">
                </div>
                <div class="form-group">
                  <label for="description_postulate">Descripción</label>
                  <input type="text" id="description_postulate" :value="postulate.typePersonal.description" disabled class="form-control">
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col">
                <div class="form-group">
                  <label for="initialDate_postulate">Fecha Inicial</label>
                  <input type="date" id="initialDate_postulate" :value="postulate.initialDate" name="label" class="form-control" disabled/>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="endDate_postulate">Fecha Final</label>
                  <input type="date" id="endDate_postulate" :value="postulate.endDate" name="label" class="form-control" disabled/>
                </div>
              </div>
            </div>

            <div class="row mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="day_postulate">Dia</label>
                  <input type="text" id="day_postulate" :value="postulate.hourly[key].day" name="label" class="form-control" disabled/>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="hourly_postulate">Hora</label>
                  <input type="text" id="hourly_postulate" :value="postulate.hourly[key].hourly" name="label" class="form-control" disabled/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="city_postulate">Ciudad</label>
                  <input type="text" id="city_postulate" :value="postulate.city" name="label" class="form-control" disabled/>
                </div>


                <div class="form-group">
                  <label for="location_postulate">Ubicación</label>
                  <input type="text" id="location_postulate" :value="postulate.location" name="label"
                         class="form-control" disabled/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="address_postulate">Dirección</label>
                  <input type="text" id="address_postulate" :value="postulate.address" name="label" class="form-control" disabled/>
                </div>
                <div class="form-group">
                  <label for="totalBudget_postulate">Presupuesto Total</label>
                  <input type="number" id="totalBudget_postulate" :value="postulate.totalBudget" name="label"
                         class="form-control" disabled/>
                </div>

                <div class="form-group">
                  <label for="dailyBudget_postulate">Presupuesto Diario</label>
                  <input type="number" id="dailyBudget_postulate" :value="postulate.dailyBudget" name="label" class="form-control" disabled/>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
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
