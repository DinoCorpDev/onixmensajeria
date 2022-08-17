<template>
  <div class="container">
    <div class="row justify-content-center">
      <div v-if="user === null">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Inicio de sesión</div>

            <div class="card-body">
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  v-model="email"
                  name="email"
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <label for="password">Contraseña</label>
                <input
                  type="password"
                  v-model="password"
                  name="password"
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <button class="btn btn-primary mt-2" v-on:click="login">
                  Iniciar Sesión
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <dashboardComponent :user="user" :logout="logout" />
      </div>
    </div>
  </div>
</template>

<script>
import dashboardComponent from "../adminDashboard/index.vue";
export default {
  components: {
    dashboardComponent,
  },
  data() {
    return {
      email: "administrador@gmail.com",
      password: "Talentos@2020!Bogota",
      user: null,
    };
  },
  mounted() {
    axios
      .get("api/getMyUser")
      .then((response) => {
        this.user = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    login() {
      let data = {
        email: this.email,
        password: this.password,
      };
      axios
        .post("api/login", data)
        .then((response) => {
          this.user = response.data.data;
        })
        .catch((error) => {
          toastr.error("Usuario y / o Contraseña Incorrectos");
          console.log(error);
        });
    },
    logout() {
      axios.post("api/logout").then((response) => {
        this.cleanData();
        console.log(response.data);
      });
    },
    cleanData() {
      this.email = "";
      this.password = "";
      this.user = null;
    },
  },
};
</script>
