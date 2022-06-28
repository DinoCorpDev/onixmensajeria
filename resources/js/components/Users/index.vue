<template>
  <div :class="changeActive === true ? 'container content-large': 'container content-short'">
    <div class="card">
      <div class="card-header text-center">
        <h2><strong>Usuarios</strong></h2>
      </div>
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Usuario
              </button>
              <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#importModal">Importar
                Usuarios
              </button>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Buscar por Nombre o Apellido o Correo"
                     v-model="search">
            </div>
          </div>
        </div>
        <table class="table table-striped table-bordered table-response">
          <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Status</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(user, key) in users" :key="key">
            <td>{{ user.name }}</td>
            <td>{{ user.lastname }}</td>
            <td>{{ user.email }}</td>
            <td>
              <select class="form-select selectStatus" v-on:change="saveUserStatus(user,$event)">
                <option value="1" :selected=" user.statusid  == 1 ? 'selected' : ''">Activo</option>
                <option value="2" :selected=" user.statusid  == 2 ? 'selected' : ''">Pendiente</option>
                <option value="3" :selected=" user.statusid  == 3 ? 'selected' : ''">Inactivo</option>
              </select>
            </td>
            <td>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                      v-on:click="editUser(user)">Editar
              </button>
            </td>
          </tr>
          </tbody>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li :class="page > 1 ? 'page-item' : 'page-item disabled'"><a class="page-link" v-on:click="lastPage">Anterior</a>
            </li>
            <li class="page-item"><a class="page-link">{{ page }}</a></li>
            <li class="page-item"><a class="page-link" v-on:click="nextPage">Siguiente</a></li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ id === null ? 'Creación de Usuario' : 'Actialización de usuario' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    v-on:click="cleanData"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Nombre</label>
              <input type="text" class="form-control" v-model="user.name" id="name">
            </div>

            <div class="form-group">
              <label for="lastname">Apellido</label>
              <input type="text" class="form-control" v-model="user.lastname" id="lastname">
            </div>

            <div class="form-group" v-if="id !== null">
              <label for="nickname">Nombre Artistico</label>
              <input type="text" class="form-control" v-model="user.nickname" id="nickname">
            </div>

            <div class="form-group">
              <label for="phone">Numero de Telefono</label>
              <input type="number" class="form-control" v-model="user.contact.phone" id="phone">
            </div>

            <div class="form-group" v-if="id === null">
              <label for="email">Correo</label>
              <input type="email" class="form-control" v-model="user.email" id="email">
            </div>

            <div class="form-group" v-if="id === null">
              <label for="password">Contraseña</label>
              <input type="password" class="form-control" v-model="user.password" id="password">
            </div>

            <div class="form-group" v-if="id !== null">
              <label for="address">Dirección</label>
              <input type="text" class="form-control" v-model="user.address" id="address">
            </div>

            <div class="form-group" v-if="id !== null">
              <label for="city">Ciudad</label>
              <input type="text" class="form-control" v-model="user.city" id="city">
            </div>
            <div class="form-group" v-if="id !== null">
              <label for="city">País</label>
              <input type="text" class="form-control" v-model="user.country" id="country">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-on:click="cleanData">Cerrar
            </button>
            <button type="button" class="btn btn-primary" v-on:click="saveUser">Guardar Cambios</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Importación de Usuarios</h2>
          </div>
          <div class="modal-body">
            <div class="spinner-border text-secondary" role="status" v-if="loader === true">
              <span class="visually-hidden">Loading...</span>
            </div>
            <div class="form-group">
              <label for="">Importar</label>
              <input type="file" class="form-control" v-on:change="(e)=>importFile(e.target.files)"/>
            </div>
          </div>
          <div class="modal-footer" v-if="loader === false">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" v-on:click="saveFile">Importar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {Modal} from 'bootstrap'

export default {
  props: ['changeActive'],
  data() {
    return {
      users: [],
      user: {
        contact: {},
        autorization: true,
        terms_conditions: true,
      },
      id: null,
      file: null,
      loader: false,
      page: 1,
      search: '',
    }
  },
  watch: {
    search: function (newVal, oldVal) {
      if (newVal !== '' && newVal !== oldVal) {
        axios.get(`api/getAllUsers/${newVal}`).then(response => {
          this.users = response.data.data
        })
      } else {
        this.getUsers();
      }
    }
  },

  mounted() {
    this.getUsers();
    this.modal = new Modal(document.getElementById('exampleModal'));
  },

  methods: {
    nextPage() {

      this.page = this.page + 1;
      this.getUsers();

    },
    lastPage() {
      if (this.page > 1) {
        this.page = this.page - 1;
        this.getUsers();
      }
    },
    getUsers() {
      axios.get(`api/getAllUsers?page=${this.page}`).then(response => {
        this.users = response.data.data
      })
    },
    editUser(data) {
      this.user = data;
      this.id = data.id;
    },
    saveUser() {
      if (this.id === null) {
        console.log(this.user);
        axios.post('api/adminRegisterUser', this.user).then((response) => {
          console.log(response.data);
          toastr.success('Usuario Creado');
          this.cleanData();
          this.getUsers();
        }).catch((error) => {
          toastr.error('Intenta de nuevo mas Tarde');
          console.log(error);
        })
      } else {
        console.log(this.user);
        axios.patch(`api/updateUserInAdmin/${this.id}`, this.user).then((response) => {
          console.log(response.data);
          toastr.success('Usuario Actualizado');
          this.cleanData();
          this.getUsers();
        }).catch((error) => {
          toastr.error('Intenta de nuevo mas Tarde');
          console.log(error);
        })
      }
    },
    cleanData() {
      this.modal.hide();
      this.user = {
        contact: {},
        autorization: true,
        terms_conditions: true,
      };
      this.id = null,
          this.file = null
    },
    importFile(data) {
      this.file = data[0];
    },

    saveUserStatus(data,event) {
      this.loader = true;
      this.user = data;
      this.id = data.id;
      this.status=event.target.value;

      axios.patch(`api/updateStatusUser/${this.id}`, {'status': this.status}).then((response) => {
        console.log(response.data);
        toastr.success('Status Actualizado');
        this.cleanData();
        this.getUsers();
      }).catch((error) => {
        toastr.error('Intenta de nuevo mas Tarde');
        console.log(error);
      })
    },

    saveFile() {
      this.loader = true;
      var data = new FormData();
      data.append('file', this.file);
      data.append('_method', 'POST');
      axios.post('api/importUsersCSV', data).then(response => {
        this.loader = false
        toastr.success('Usuarios Importados');
        this.cleanData();
        this.getUsers();
      }).catch((error) => {
        this.loader = false
        toastr.error('Revisa que los campos estén completos e intenta de nuevo mas tarde');
        this.cleanData();
        this.getUsers();
        console.log(error);
      })
    }
  }
}
</script>
