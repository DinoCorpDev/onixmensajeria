<template>
  <div
    class="container-convoz"
    :class="
      changeActive === true
        ? 'container content-large'
        : 'container content-short'
    "
  >
    <h2>Pedidos</h2>
    <hr style="color: black;" />

    <div class="mt-4">
      <button
        v-if="id_rol == 1 || (id_rol == 2 && services.length < 1)"
        type="button"
        class="btn btn-create"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
      >
        Crear Pedido
      </button>
    </div>

    <div class="row mt-4">
      <div
        class="col-md-6 mb-4"
        v-for="(getServices, key) in services"
        :key="key"
      >
        <div class="row">
          <p class="col-md-12 title-service">
            {{ getServices.name }}
          </p>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="row">
              <figure class="col-md-12 mb-0">
                <img class="img-fluid" :src="getServices.image" />
              </figure>
            </div>
          </div>
          <div class="col-md-9 mt-3 mt-md-0">
            <div class="border-columm p-4">
              <div class="row d-flex justify-content-between">
                <div class="col-md-5">
                  <p class="text-black-50 title-table">Descripción</p>
                  <p class="text-table">
                    {{ getServices.description }}
                  </p>
                </div>
                <div class="col-md-3">
                  <p class="text-black-50 title-table">Rango de Precios</p>
                  <p class="text-table">{{ getServices.price }} €</p>
                </div>
                <div class="col-md-4 mt-5">
                  <button
                    class="btn btn-edit"
                    v-on:click="() => editService(getServices)"
                  >
                    Editar
                  </button>
                  <button
                    class="btn btn-deleter"
                    v-on:click="() => deleteService(getServices.id)"
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

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-bs-backdrop="static"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <b-form @submit.prevent="saveService">
            <div class="modal-header">
              <h4 class="modal-title fw-bold" id="exampleModalLabel">
                <!-- prettier-ignore -->
                {{ id === null ? "Creación de Pedido" : "Actualización de Pedido" }}
              </h4>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                v-on:click="cleanData"
              ></button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="" class="fw-bold">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="service.name"
                  required
                />
              </div>

              <div class="form-group mt-3">
                <label for="" class="fw-bold">Rango de precio, desde</label>
                <currency-input
                  class="form-control"
                  v-model="service.price"
                  required
                />
              </div>

              <div class="form-group mt-3">
                <label for="" class="fw-bold">Descripción</label>
                <textarea
                  class="form-control"
                  v-model="service.description"
                  required
                />
              </div>

              <div class="mt-3">
                <img
                  v-if="service.image"
                  :src="service.image"
                  width="150"
                  class="img-thumbnail mb-3"
                />

                <div class="form-group">
                  <label for="">
                    <span class="fw-bold">Imagen</span>
                    - Tamaño (150x100)
                  </label>
                  <input
                    type="file"
                    class="form-control"
                    v-on:change="(e) => imageToBase64(e.target.files)"
                    :required="!service.image"
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-closer"
                data-bs-dismiss="modal"
                v-on:click="cleanData"
              >
                Cerrar
              </button>
              <button type="submit" class="btn btn-save">
                {{ id === null ? 'Crear servicio' : 'Guardar cambios' }}
              </button>
            </div>
          </b-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['token', 'changeActive'],
  data() {
    return {
      services: [],
      id: null,
      service: {},
      categories: [],
      user: {},
      id_rol: '',
    }
  },
  mounted() {
    this.getUser().then((id_rol) => {
      this.id_rol = id_rol
      if (id_rol == 1) {
        this.getServices()
      } else if (id_rol == 2) {
        this.getMyServices()
      }
    })
  },
  methods: {
    getServices() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/services', { headers }).then((response) => {
        console.log(response.data)
        this.services = response.data
      })
    },
    getMyServices() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/my-services', { headers }).then((response) => {
        this.services = response.data
      })
    },
    imageToBase64(data) {
      const file = data[0]
      const reader = new FileReader()

      let rawImg
      reader.onloadend = () => {
        rawImg = reader.result
        this.service.image = rawImg
      }
      reader.readAsDataURL(file)
    },
    editService(data) {
      this.service = data
      this.id = data.id

      $('#exampleModal').modal('show')
    },
    hideModal() {
      $('#exampleModal').modal('hide')
    },
    saveService() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }

      if (this.id === null) {
        axios
          .post('api/services', this.service, { headers })
          .then((response) => {
            toastr.success(response.data.message)
            this.cleanData()
            if (this.id_rol == 1) {
              this.getServices()
            } else if (this.id_rol == 2) {
              this.getMyServices()
            }
            this.hideModal()
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        axios
          .put(`api/services/${this.id}`, this.service, { headers })
          .then((response) => {
            toastr.success(response.data.message)
            this.cleanData()
            if (this.id_rol == 1) {
              this.getServices()
            } else if (this.id_rol == 2) {
              this.getMyServices()
            }
            this.hideModal()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    deleteService(id) {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }

      if (window.confirm('¿Seguro que desea eliminar este pedido?')) {
        axios
          .delete(`api/services/${id}`, { headers })
          .then((response) => {
            toastr.success(response.data.message)
            if (this.id_rol == 1) {
              this.getServices()
            } else if (this.id_rol == 2) {
              this.getMyServices()
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
      this.service = {}
      this.id = null
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
<style scoped>
.title-service {
  font-size: 20px;
}

.title-table {
  font-size: 15px;
}

.text-table {
  font-size: 14px;
  overflow-wrap: break-word;
}

/* .content-large {
  padding-left: 230px;
  transition: 0.5s;
}

.content-short {
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

.border-columm {
  border: 1px solid #101a24;
  border-radius: 15px;
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
.btn-save {
  border-radius: 20px;
  background: #101a24;
  border-color: #101a24;
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
.img-thumbnail {
  aspect-ratio: 1/1;
  object-fit: cover;
}
</style>
