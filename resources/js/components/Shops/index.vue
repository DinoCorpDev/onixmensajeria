<template>
  <div
    class="container-convoz"
    :class="
      changeActive === true
        ? 'container content-large'
        : 'container content-short'
    "
  >
    <h2>Tiendas</h2>
    <hr style="color: black;" />

    <div class="mt-4">
      <button
        v-if="id_rol == 1 || (id_rol == 2 && shops.length < 1)"
        type="button"
        class="btn btn-create"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
      >
        Crear Tienda
      </button>
    </div>

    <div class="row mt-4">
      <div class="col-md-12 mb-4" v-for="(getShops, key) in shops" :key="key">
        <div class="row">
          <p class="col-md-12 title-shop">{{ getShops.name }}</p>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="row">
              <figure class="col-md-12 mb-0">
                <img class="img-fluid" :src="getShops.image" />
              </figure>
            </div>
          </div>

          <div class="col-md-9 mt-3 mt-md-0">
            <div class="border-columm p-4">
              <div class="row d-flex justify-content-between">
                <div class="col-md-3">
                  <p class="text-black-50 title-table">Ubicación</p>
                  <p class="text-table">
                    {{ getShops.location }}
                  </p>
                </div>

                <!-- <div v-if="getShops.schedule">
                  <p class="text-black-50 title-table">Horario de atención</p>
                  <p v-if="getShops.schedule" class="text-table">
                    <template v-if="getShops.schedule.allDay === false">
                      De {{ getShops.schedule.initDay }} A
                      {{ getShops.schedule.endDay }} desde
                      {{ convertformat12h(getShops.schedule.initHour) }} a
                      {{ convertformat12h(getShops.schedule.endHour) }}
                    </template>
                    <template v-else>24 horas</template>
                  </p>
                </div> -->

                <div class="col-md-4">
                  <p class="text-black-50 title-table">Servicio</p>
                  <div v-for="(service, key) in getShops.services" :key="key">
                    <p>{{ service.name }}</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <p class="text-black-50 title-table">Categorias</p>
                  <div
                    v-for="(categories, key) in getShops.categories"
                    :key="key"
                  >
                    <p>{{ categories.name }}</p>
                  </div>
                </div>
                <div class="col-md-4 mt-5">
                  <button
                    class="btn btn-edit"
                    v-on:click="() => editShops(getShops)"
                  >
                    Editar
                  </button>
                  <button
                    class="btn btn-deleter"
                    v-on:click="() => deleteShop(getShops.id)"
                  >
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--============================
        MODAL
      ==============================-->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-bs-backdrop="static"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <b-form @submit.prevent="saveShops">
            <div class="modal-header">
              <h4 class="modal-title fw-bold" id="exampleModalLabel">
                <!-- prettier-ignore -->
                {{ id === null ? "Creacion de Tienda" : "Actualizacion de Tienda" }}
              </h4>
              <button
                v-on:click="cleanData"
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <!-- <div class="col-md-6">
                  <img
                    v-if="shop.image"
                    :src="shop.image"
                    class="img-thumbnail"
                    width="150"
                  />
                  <div class="form-group mb-3">
                    <label for="">
                      <span class="fw-bold">Banner</span>
                      - Tamaño (300x280)
                    </label>
                    <input
                      :required="!shop.image"
                      type="file"
                      class="form-control"
                      v-on:change="
                        (e) => imageToBase64('image', e.target.files)
                      "
                    />
                  </div>
                </div> -->
                <div class="col-md-6">
                  <img
                    v-if="shop.avatar"
                    :src="shop.avatar"
                    width="150"
                    class="img-thumbnail"
                  />
                  <div class="form-group mb-3">
                    <label for="">
                      <span class="fw-bold">Avatar</span>
                      - Tamaño (150x150)
                    </label>
                    <input
                      :required="!shop.avatar"
                      type="file"
                      class="form-control"
                      v-on:change="
                        (e) => imageToBase64('avatar', e.target.files)
                      "
                    />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label for="" class="fw-bold">Nombre</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="shop.name"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="phone" class="fw-bold">Teléfono</label>
                    <input
                      class="form-control"
                      id="phone"
                      type="tel"
                      v-model="shop.phone"
                      required
                    />
                  </div>
                </div>
              </div>

              <!-- <div class="row g-3">
                <div class="col-md-12">
                  <div class="form-group mb-3">
                    <label class="fw-bold" for="description">
                      Descripción
                    </label>
                    <input
                      class="form-control"
                      id="description"
                      type="text"
                      v-model="shop.description"
                      required
                    />
                  </div>
                </div>
              </div> -->

              <!-- <div class="row mt-3" v-if="shop.schedule">
                <p class="lead fw-bold">Horario de atencion</p>
                <hr />
                <div class="col-md-6">
                  <label for="" class="fw-bold">De</label>
                  <select
                    v-model="shop.schedule.initDay"
                    class="form-select"
                    required
                  >
                    <option
                      v-for="day in optionsWeek"
                      :value="day.value"
                      :key="day.value"
                    >
                      {{ day.text }}
                    </option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="" class="fw-bold">A</label>
                  <select
                    v-model="shop.schedule.endDay"
                    class="form-select"
                    required
                  >
                    <option
                      v-for="day in optionsWeek"
                      :value="day.value"
                      :key="day.value"
                    >
                      {{ day.text }}
                    </option>
                  </select>
                </div>

                <div class="col-md-6 mt-3">
                  <label for="" class="fw-bold">Desde las</label>
                  <b-form-timepicker
                    v-model="shop.schedule.initHour"
                    locale="en"
                    :disabled="shop.schedule.allDay"
                    :required="shop.schedule.allDay === false"
                  ></b-form-timepicker>
                </div>

                <div class="col-md-6 mt-3">
                  <label for="" class="fw-bold">Hasta</label>
                  <b-form-timepicker
                    dropright
                    v-model="shop.schedule.endHour"
                    locale="en"
                    :disabled="shop.schedule.allDay"
                    :required="shop.schedule.allDay === false"
                  ></b-form-timepicker>
                </div>
                <div class="col-12 d-flex justify-content-end mt-2">
                  <div class="form-check">
                    <input
                      name="allDay"
                      class="form-check-input"
                      type="checkbox"
                      :value="true"
                      v-model="shop.schedule.allDay"
                    />
                    <label class="form-check-label" for="allDay">
                      24 horas
                    </label>
                  </div>
                </div>
              </div> -->

              <div class="form-group">
                <label for="" class="fw-bold">Ubicación</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="shop.location"
                  required
                />
              </div>

              <b-form-group>
                <p class="lead fw-bold mt-3">Tipo de pago</p>
                <div class="border-columm p-3">
                  <b-form-checkbox-group
                    id="checkbox-group-2"
                    v-model="shop.payment_method"
                    name="flavour-2"
                    :required="shop.payment_method.length === 0"
                  >
                    <b-form-checkbox class="ps-1" value="Transferencia">
                      <span class="ps-2">Transferencia</span>
                    </b-form-checkbox>
                    <b-form-checkbox class="ps-1" value="Tarjeta">
                      <span class="ps-2">Tarjeta</span>
                    </b-form-checkbox>
                    <b-form-checkbox class="ps-1" value="Efectivo">
                      <span class="ps-2">Efectivo</span>
                    </b-form-checkbox>
                    <b-form-checkbox class="ps-1" value="Contraentrega">
                      <span class="ps-2">Contraentrega</span>
                    </b-form-checkbox>
                  </b-form-checkbox-group>
                </div>
              </b-form-group>

              <p class="lead fw-bold mt-3">Categorias</p>
              <div class="border-columm p-3">
                <div class="row">
                  <b-form-checkbox
                    v-for="category in categories"
                    :key="category.id_category"
                    inline
                    lab
                    class="ps-1 col-lg-6"
                    v-model="categoriesSelected"
                    :name="`category${category.name}`"
                    :value="category.id_category"
                    :required="categoriesSelected.length === 0"
                  >
                    <span class="ms-1 overflow-auto">{{ category.name }}</span>
                  </b-form-checkbox>
                </div>
              </div>
              <p class="lead fw-bold mt-3">Pedidos</p>
              <div class="border-columm p-3">
                <div class="row">
                  <b-form-checkbox
                    v-for="service in services"
                    :key="service.id_services"
                    inline
                    lab
                    class="ps-1 col-lg-6"
                    v-model="servicesSelected"
                    :name="`service${service.name}`"
                    :value="service.id_services"
                    :required="servicesSelected.length === 0"
                  >
                    <span class="ms-1 overflow-auto">{{ service.name }}</span>
                  </b-form-checkbox>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                v-on:click="cleanData"
              >
                Cerrar
              </button>
              <button type="submit" class="btn btn-primary">
                Guardar Cambios
              </button>
            </div>
          </b-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
// components: {Multiselect, 'b-form-checkbox-group': FormCheckboxPlugin, 'b-form-group': BFormGroup},
export default {
  components: { Multiselect },
  props: ['token', 'changeActive'],
  data() {
    return {
      shops: [],
      id: null,
      shop: {
        name: '',
        location: '',
        payment_method: [],
        phone: '',
      },
      services: [],
      categories: [],
      categoriesSelected: [],
      servicesSelected: [],
      user: {},
      canCreateStore: true,
      id_rol: '',
      options: [
        { text: 'Orange', value: 'orange' },
        { text: 'Apple', value: 'apple' },
        { text: 'Pineapple', value: 'pineapple' },
        { text: 'Grape', value: 'grape' },
      ],
    }
  },
  mounted() {
    this.getCategories()
    this.getUser().then((id_rol) => {
      this.id_rol = id_rol
      if (id_rol == 1) {
        this.getServices()
        this.getShops()
      } else if (id_rol == 2) {
        this.getMyServices()
        this.getMyShops()
      }
    })
  },
  methods: {
    convertformat12h(fecha) {
      if (fecha[0] == 0 && fecha[1] == 0) {
        return '12' + fecha.slice(2, 5) + ' am'
      } else if (fecha[0] + fecha[1] < 12) {
        return fecha.slice(0, 5) + ' am'
      } else if (fecha[0] + fecha[1] == 12) {
        return fecha.slice(0, 5) + ' pm'
      } else if (fecha[0] + fecha[1] > 12 && fecha[0] + fecha[1] < 22) {
        return '0' + (fecha[0] + fecha[1] - 12) + fecha.slice(2, 5) + ' pm'
      } else {
        return fecha[0] + fecha[1] - 12 + fecha.slice(2, 5) + ' pm'
      }
    },
    getShops() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/getAllStores', { headers }).then((response) => {
        this.shops = response.data
      })
    },
    getMyShops() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/getMyStores', { headers }).then((response) => {
        console.log(response.data)
        this.shops = response.data
      })
    },
    getServices() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/getServicesName', { headers }).then((response) => {
        this.services = response.data
      })
    },
    getMyServices() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/getMyServicesName', { headers }).then((response) => {
        this.services = response.data
      })
    },
    getCategories() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/getCategoriesName', { headers }).then((response) => {
        this.categories = response.data
      })
    },
    imageToBase64(type, data) {
      const file = data[0]
      const reader = new FileReader()
      let rawImg
      reader.onloadend = () => {
        rawImg = reader.result
        if (type === 'image') {
          this.shop.image = rawImg
        } else if (type === 'avatar') {
          this.shop.avatar = rawImg
        }
      }
      reader.readAsDataURL(file)
    },
    editShops(data) {
      // data.categories.forEach(element => {
      //   let data = {
      //     name: element.name,
      //     id_category: element.id
      //   }
      //   this.categoriesSelected.push(data);
      // });
      this.categoriesSelected = data.categories.map((item) => item.id)
      // data.services.forEach(element => {
      //   let data = {
      //     name: element.name,
      //     id_services: element.id
      //   }
      //   this.servicesSelected.push(data);
      // });
      this.servicesSelected = data.services.map((item) => item.id)
      this.shop = data
      this.id = data.id
      $('#exampleModal').modal('show')
    },
    hideModal() {
      $('#exampleModal').modal('hide')
    },
    saveShops() {
      this.shop.categories = this.categoriesSelected
      this.shop.services = this.servicesSelected
      let headers = { Authorization: `Bearer ${this.token}` }
      if (this.id === null) {
        axios
          .post('api/stores', this.shop, { headers })
          .then((response) => {
            toastr.success('Tienda creada con exito')
            if (this.id_rol == 1) {
              this.getShops()
            } else if (this.id_rol == 2) {
              this.getMyShops()
            }
            this.cleanData()
            this.hideModal()
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        axios
          .put(`api/stores/${this.id}`, this.shop, { headers })
          .then((response) => {
            toastr.success('Tienda actualizada con exito')
            if (this.id_rol == 1) {
              this.getShops()
            } else if (this.id_rol == 2) {
              this.getMyShops()
            }
            this.cleanData()
            this.hideModal()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    deleteShop(id) {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      if (window.confirm('¿Seguro que desea eliminar esta tienda?')) {
        axios
          .delete(`api/stores/${id}`, { headers })
          .then((response) => {
            toastr.success(response.data)
            if (this.id_rol == 1) {
              this.getServices()
              this.getShops()
            } else if (this.id_rol == 2) {
              this.getMyServices()
              this.getMyShops()
            }
            this.hideModal()
            this.cleanData()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    cleanData() {
      this.categoriesSelected = []
      this.servicesSelected = []
      this.id = null
      this.shop = {
        name: '',
        location: '',
        payment_method: [],
        phone: '',
      }
    },
    async getUser() {
      const response = await axios.get('api/getToken', {
        headers: { Authorization: `Bearer ${this.token}` },
      })
      this.user = response.data.user
      return Promise.resolve(response.data.user.id_rol)
    },
  },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
.title-shop {
  font-size: 20px;
}
.title-table {
  font-size: 15px;
}
.text-table {
  font-size: 14px;
}
/* .content-large {
    padding-left: 230px;
    transition: 0.5s;
  } */
.btn-edit {
  width: 60%;
  border-radius: 20px;
  padding: 1px 1px 1px 1px;
  background: #45f1be;
  border-color: #45f1be;
  margin-bottom: 7px;
  color: #fff;
}
.btn-edit:hover {
  border-color: #45f1be;
}
.btn-deleter {
  width: 60%;
  border-radius: 20px;
  padding: 1px 1px 1px 1px;
  background: #101a24;
  border-color: #101a24;
  margin-bottom: 7px;
  color: #fff;
}
.btn-deleter:hover {
  border-color: #101a24;
}
@media (max-width: 991px) {
  .btn-edit {
    width: 100%;
  }
  .btn-deleter {
    width: 100%;
  }
}
/* .content-short {
    padding-left: 100px;
    transition: 0.5s;
  } */
.container-convoz {
  margin-top: 10px;
  padding-left: 100px;
  transition: 0.5s;
}
@media (min-width: 768px) {
  .container-convoz {
    padding-left: 230px;
  }
}
.btn-create {
  background: #101a24;
  border-color: #101a24;
  border-radius: 20px;
  color: #fff;
}
.btn-create:hover {
  border-color: #101a24;
  color: #101a24;
  background: #fff;
}
.border-columm {
  border: 1px solid #101a24;
  border-radius: 5px;
}
.btn-save {
  border-radius: 20px;
  background: #45f1be;
  border-color: #45f1be;
  color: #fff;
}
.btn-closer {
  border-radius: 20px;
  background: #000;
  border-color: #000;
  color: #fff;
}
.modal-content {
  border: 2px solid #101a24;
  border-radius: 1.3rem;
}
.form-control {
  border: 1px solid #101a24;
}
.form-select {
  border: 1px solid #101a24;
}
.img-thumbnail {
  aspect-ratio: 1/1;
  object-fit: cover;
  margin-bottom: 1rem;
}
</style>
