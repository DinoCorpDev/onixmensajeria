<template>
  <div
    :class="
      changeActive === true
        ? 'container content-large'
        : 'container content-short'
    "
  >
    <div class="card">
      <div class="card-header text-center">
        <h2>
          <strong>Convocatorias {{ fileBanner }}</strong>
        </h2>
      </div>
      <div class="col-md-">
        <button
          class="btn btn-outline-primary mb-2 mt-2"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal"
        >
          Crear Convocatoria
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
              <td>
                <img
                  style="height: 74px; width: 117px"
                  :src="postulation.banner"
                  alt=""
                />
              </td>
              <td>{{ postulation.name }}</td>
              <td>{{ postulation.address }}</td>
              <td>{{ postulation.city }}</td>
              <td>{{ postulation.location }}</td>
              <td>
                <button
                  class="btn btn-outline-primary"
                  v-on:click="getPostulations(postulation.id)"
                >
                  Detalle
                </button>
                <button
                  class="btn btn-outline-primary"
                  v-on:click="editPostulation(postulation)"
                >
                  Editar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!--============================
          CREACION DE MODAL
    ==============================-->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{
                id === null
                  ? "Creación de Convocatoria"
                  : "Actualización de Convocatoria"
              }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <loading
              :active.sync="isLoading"
              :is-full-page="fullPage"
            ></loading>
            <div class="row">
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Banner</label>
                  <input
                    type="file"
                    name="banner"
                    id="banner"
                    class="form-control"
                    v-on:change="(e) => bannerUpload(e.target.files)"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group mb-3">
                  <label for="label">ID Convocatoria</label>
                  <input
                    type="text"
                    v-model="postulation.idItalentt"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
                <!-- <input type="text" v-model="postulation.banner" required="required" name="label" class="form-control"/> -->
              </div>
              <div class="col-9">
                <div class="form-group mb-3">
                  <label for="value">Nombre</label>
                  <input
                    type="text"
                    v-model="postulation.name"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Tipo de Personal</label>
                  <select
                    v-model="postulation.aboutPersonal.type"
                    class="form-control"
                    required
                  >
                    <option
                      v-for="rol in roles"
                      :value="rol.value"
                      :key="rol.label"
                    >
                      {{ rol.label }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Cantidad</label>
                  <input
                    type="number"
                    v-model="postulation.aboutPersonal.quantity"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Genero</label>
                  <select
                    v-model="postulation.aboutPersonal.gender"
                    class="form-control"
                    required
                  >
                    <option
                      v-for="gender in genders"
                      :value="gender.value"
                      :key="gender.label"
                    >
                      {{ gender.label }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Fecha Inicial</label>
                  <input
                    type="date"
                    v-model="postulation.initialDate"
                    required="required"
                    name="label"
                    class="form-control"
                    :min="getInitialDate"
                  />
                </div>
              </div>

              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Fecha Final</label>
                  <input
                    type="date"
                    v-model="postulation.endDate"
                    required="required"
                    name="label"
                    class="form-control"
                    :min="postulation.initialDate"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <button
                  class="btn btn-success"
                  v-if="postulation.hourly.length < 7"
                  v-on:click="moreDays"
                >
                  +
                </button>
                <button class="btn btn-danger" v-on:click="lessDays">-</button>
              </div>
              <div class="col">
                <div
                  class="form-group mb-3"
                  v-for="(postHour, key) in postulation.hourly"
                  :key="key"
                >
                  <label for="value">Dia</label>
                  <input
                    type="text"
                    v-model="postulation.hourly[key].day"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
              </div>

              <div class="col">
                <div
                  class="form-group mb-3"
                  v-for="(postHour, key) in postulation.hourly"
                  :key="key"
                >
                  <label for="value">Hora</label>
                  <input
                    type="text"
                    v-model="postulation.hourly[key].hourly"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Ciudad</label>
                  <select
                    v-model="postulation.city"
                    required
                    class="form-control"
                  >
                    <option
                      :value="capital"
                      v-for="capital in capitals"
                      :key="capital"
                    >
                      {{ capital }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Dirección</label>
                  <input
                    type="text"
                    v-model="postulation.address"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col">
                <div class="form-group mb-3">
                  <label for="value">Ubicación</label>
                  <input
                    type="text"
                    v-model="postulation.location"
                    required="required"
                    name="label"
                    class="form-control"
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-3">
                  <label for="value">Presupuesto Diario</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">$</span>
                    <input
                      type="number"
                      v-model="postulation.dailyBudget"
                      required="required"
                      name="label"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="text-end" v-if="postulation.endDate">
                  <span class="d-block mb-3 h4">
                    Presupuesto Diario:
                    {{ formatBudget(postulation.dailyBudget) }}
                  </span>
                  <span class="d-block h4">
                    Presupuesto Total:
                    {{ formatBudget(getTotalBudget) }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cerrar
            </button>
            <button
              type="button"
              class="btn btn-primary"
              v-on:click="savePostulation"
            >
              Guardar Cambios
            </button>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="detailUserModal"
      tabindex="-1"
      aria-labelledby="detailUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailUserModalLabel">
              Detalle De Convocatoria
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div
            class="modal-body mb-5"
            v-for="(postulate, key) in postulateds"
            :key="key"
          >
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="id_postulate">Id Italentt</label>
                  <input
                    type="text"
                    id="id_postulate"
                    disabled
                    :value="postulate.idItalentt"
                    class="form-control"
                  />
                </div>
                <div class="form-group">
                  <label for="name_postulate">Nombre</label>
                  <input
                    type="text"
                    id="name_postulate"
                    disabled
                    :value="postulate.name"
                    class="form-control"
                  />
                </div>
              </div>
            </div>

            <div class="row mt-5 mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="type_postulate">Tipo de Personal</label>
                  <input
                    type="text"
                    id="type_postulate"
                    :value="postulate.typePersonal.type"
                    disabled
                    class="form-control"
                  />
                </div>

                <div class="form-group">
                  <label for="quantity_postulate">Cantidad</label>
                  <input
                    type="text"
                    id="quantity_postulate"
                    :value="postulate.typePersonal.quantity"
                    disabled
                    class="form-control"
                  />
                </div>
                <div class="form-group">
                  <label for="description_postulate">Descripción</label>
                  <input
                    type="text"
                    id="description_postulate"
                    :value="postulate.typePersonal.description"
                    disabled
                    class="form-control"
                  />
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col">
                <div class="form-group">
                  <label for="initialDate_postulate">Fecha Inicial</label>
                  <input
                    type="date"
                    id="initialDate_postulate"
                    :value="postulate.initialDate"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="endDate_postulate">Fecha Final</label>
                  <input
                    type="date"
                    id="endDate_postulate"
                    :value="postulate.endDate"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
            </div>

            <div class="row mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="day_postulate">Dia</label>
                  <input
                    type="text"
                    id="day_postulate"
                    :value="postulate.hourly[key].day"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="hourly_postulate">Hora</label>
                  <input
                    type="text"
                    id="hourly_postulate"
                    :value="postulate.hourly[key].hourly"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="city_postulate">Ciudad</label>
                  <input
                    type="text"
                    id="city_postulate"
                    :value="postulate.city"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>

                <div class="form-group">
                  <label for="location_postulate">Ubicación</label>
                  <input
                    type="text"
                    id="location_postulate"
                    :value="postulate.location"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="address_postulate">Dirección</label>
                  <input
                    type="text"
                    id="address_postulate"
                    :value="postulate.address"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
                <div class="form-group">
                  <label for="totalBudget_postulate">Presupuesto Total</label>
                  <input
                    type="number"
                    id="totalBudget_postulate"
                    :value="postulate.totalBudget"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>

                <div class="form-group">
                  <label for="dailyBudget_postulate">Presupuesto Diario</label>
                  <input
                    type="number"
                    id="dailyBudget_postulate"
                    :value="postulate.dailyBudget"
                    name="label"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import JsonCapitales from "../Postulations/capitales.json";
import { Modal } from "bootstrap";
import {
  getStorage,
  ref,
  uploadBytesResumable,
  getDownloadURL,
} from "firebase/storage";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  props: ["changeActive"],
  data() {
    return {
      center: { lat: 45.508, lng: -73.587 },
      fileStatus: false,
      postulations: [],
      postulateds: [],
      roles: [],
      genders: [],
      capitals: [],
      postulation: {
        aboutPersonal: {},
        initialDate: null,
        dailyBudget: 0,
        totalBudget: 0,
        hourly: [
          {
            day: "",
            hourly: "",
          },
        ],
        banner: null,
      },
      id: null,
      myModal: "",
      detailUserModal: "",
      fileBanner: null,
      isLoading: false,
      fullPage: false,
    };
  },
  computed: {
    getTotalBudget() {
      let day1 = new Date(this.postulation.initialDate);
      let day2 = new Date(this.postulation.endDate);

      let difference = day2 - day1;
      let days = difference / (1000 * 3600 * 24) + 1;
      let total = days * this.postulation.dailyBudget;

      return total;
    },
    getInitialDate() {
      const date = new Date();
      const month = (date.getMonth() + 1).toString().padStart(2, "0");
      return `${date.getFullYear()}-${month}-${date.getDate()}`;
    },
  },
  components: {
    Loading,
  },
  mounted() {
    this.getGenders();
    this.getConvocations();
    this.getRoles();
    this.modal = new Modal(document.getElementById("exampleModal"));
    this.detailUserModal = new Modal(
      document.getElementById("detailUserModal")
    );
    this.postulation.initialDate = this.getInitialDate;
    this.capitals = JsonCapitales;
  },
  methods: {
    formatBudget(value) {
      return new Intl.NumberFormat("es-CO", {
        style: "currency",
        currency: "COP",
        currencyDisplay: "narrowSymbol",
        maximumFractionDigits: 0,
      }).format(value);
    },
    geolocate() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
      });
    },
    getConvocations() {
      axios
        .get("api/getAllConvocations")
        .then((response) => {
          console.log(response.data);
          this.postulations = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getPostulations(id) {
      axios.post("api/getPostulations", { id_event: id }).then((response) => {
        this.postulateds = response.data;
        this.detailUserModal.show();
      });
    },
    moreDays() {
      this.postulation.hourly.push({
        day: "",
        hourly: "",
      });
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
        this.saveImageFire().then((response) => {
          this.postulation.banner = response;

          this.postulation.totalBudget = this.getTotalBudget;

          if (this.id === null) {
            axios
              .post("api/convocations", this.postulation)
              .then((response) => {
                this.cleanData();
                toastr.success("Convocatoria creada");
                console.log(response.data);
              })
              .catch((error) => {
                toastr.info("Intente de nuevo mas tarde");
                console.log(error);
              })
              .finally((response) => {
                this.isLoading = false;
              });
          } else {
            axios
              .put(`api/convocations/${this.id}}`, this.postulation)
              .then((response) => {
                this.cleanData();
                toastr.success("Convocatoria Actualizada");
              })
              .catch((error) => {
                toastr.info("Intente de nuevo mas tarde");
                console.log(error);
              })
              .finally((response) => {
                this.isLoading = false;
              });
          }
        });
      }
    },

    async saveImageFire() {
      if (this.fileBanner) {
        const storage = getStorage();
        const storageRef = ref(
          storage,
          `adminDashboard/postulations/${this.fileBanner.name}/`
        );
        const snapshot = await uploadBytesResumable(
          storageRef,
          this.fileBanner
        );
        const url = await getDownloadURL(snapshot.ref);
        alert("tenemos los datos");
        return Promise.resolve(url);
      }
    },

    cleanData() {
      this.postulation = {
        aboutPersonal: {},
        hourly: [
          {
            day: "",
            hourly: "",
          },
        ],
        banner: null,
      };
      this.id = null;
      this.fileBanner = null;
      this.getConvocations();
      this.modal.hide();
    },
    getRoles() {
      axios
        .get("api/getRoles")
        .then((response) => {
          console.log(response.data);
          this.roles = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getGenders() {
      axios
        .get("api/personalType")
        .then((response) => {
          console.log(response.data);
          this.genders = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
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
