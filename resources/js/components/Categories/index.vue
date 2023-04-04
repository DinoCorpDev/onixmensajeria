<template>
  <div
    class="container-convoz"
    :class="
      changeActive === true
        ? 'container content-large'
        : 'container content-short'
    "
  >
    <h2>Categorias</h2>
    <hr style="color: black;" />

    <div class="mt-4">
      <button
        type="button"
        class="btn btn-create"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
      >
        Crear Categoria
      </button>
    </div>

    <div class="row mt-4">
      <div
        class="col-md-12 mb-4"
        v-for="(getCategory, key) in categories"
        :key="key"
      >
        <div class="row categorias-table">
          <div class="col-md-12 p-4 border-columm">
            <div class="row d-flex justify-content-between">
              <div class="col-md-9">
                <p class="text-black-50 title-table">Categoria</p>
                <p class="text-table">{{ getCategory.name }}</p>
              </div>
              <div class="col-md-3 mt-2">
                <button
                  class="btn btn-edit"
                  v-on:click="() => editCategory(getCategory)"
                >
                  Editar
                </button>
                <button
                  class="btn btn-deleter"
                  v-on:click="() => deleteCategory(getCategory.id)"
                >
                  Eliminar
                </button>
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
          <b-form @submit.prevent="saveCategory">
            <div class="modal-header">
              <h4 class="modal-title fw-bold" id="exampleModalLabel">
                <!-- prettier-ignore -->
                {{ id === null ? "Creacion de Categoria" : "Actualizacion de Categoria" }}
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
                  v-model="category.name"
                  required
                />
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
                {{ id === null ? 'Crear categoria' : 'Guardar cambios' }}
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
      id: null,
      category: {},
      categories: [],
    }
  },
  mounted() {
    this.getCategory()
  },
  methods: {
    getCategory() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      axios.get('api/categories', { headers }).then((response) => {
        console.log(response.data)
        this.categories = response.data
      })
    },
    editCategory(data) {
      this.category = data
      this.id = data.id

      $('#exampleModal').modal('show')
    },
    hideModal() {
      $('#exampleModal').modal('hide')
    },
    saveCategory() {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }

      if (this.id === null) {
        axios
          .post('api/categories', this.category, { headers })
          .then((response) => {
            toastr.success(response.data)
            this.getCategory()
            this.hideModal()
            this.cleanData()
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        axios
          .put(`api/categories/${this.id}`, this.category, { headers })
          .then((response) => {
            toastr.success(response.data)
            this.getCategory()
            this.hideModal()
            this.cleanData()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    deleteCategory(id) {
      let headers = {
        Authorization: `Bearer ${this.token}`,
      }
      if (window.confirm('¿Seguro que desea eliminar esta categoria?')) {
        axios
          .delete(`api/categories/${id}`, { headers })
          .then((response) => {
            toastr.success(response.data)
            this.getCategory()
            this.hideModal()
            this.cleanData()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    cleanData() {
      this.category = {}
      this.id = null
    },
  },
}
</script>
<style scoped>
.title-table {
  font-size: 15px;
}

.text-table {
  font-size: 14px;
}

/* .content-large{
    padding-left:230px;
    transition: 0.5s;
}
.content-short{
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
  border-radius: 5px;
}

.categorias-table {
  padding-left: 15px;
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

@media (max-width: 1199px) {
  .btn-edit {
    width: 100%;
  }

  .btn-deleter {
    width: 100%;
  }
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
</style>
