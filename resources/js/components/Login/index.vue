<template>
    <div>
        <HorizontalMenu v-if="!token">
            <template v-slot:buttons>
                <button @click="showFormLogin" class="btn btn-login px-4">Acceder</button>
                <!-- <button
                    @click="showFormRegister"
                    class="btn btn-link text-white text-decoration-none px-4"
                >
                    Registrarse
                </button> -->
            </template>
        </HorizontalMenu>
        <div class="container-fluid" v-if="!token">
            <!--============================
         FORMULARIO DE LOGIN
      ==============================-->
            <div class="row justify-content-center" v-if="loginView">
                <div class="col-12 col-md-10 col-lg-4 bg-light p-5 login-form">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="login-text"> Escribe tu correo </label>
                        <input
                            type="email"
                            v-model="email"
                            class="form-control"
                            id="exampleInputEmail1"
                            aria-describedby="emailHelp"
                            placeholder="Enter email"
                            required
                        />
                    </div>
                    <div class="form-group mt-4">
                        <label for="exampleInputPassword1" class="login-text"> Escribe tu contraseña </label>
                        <input
                            type="password"
                            v-model="password"
                            class="form-control"
                            id="exampleInputPassword1"
                            placeholder="Contraseña"
                            required
                        />
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button @click="validateLogin()" class="btn btn-create btn-block">Ingresar</button>
                    </div>

                    <div v-if="unauthorized" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Ha ocurrido un error</strong>
                        No tienes permisos para esta acción
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div v-if="errorLogged" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error</strong>
                        Datos Incorrectos
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <!--============================
          FORMULARIO DE REGISTRO
      ==============================-->
            <formRegister v-else @saved="showFormLogin" />
        </div>
        <div v-else>
            <dashboardAdminComponent />
        </div>
    </div>
</template>

<script>
import dashboardAdminComponent from "../Dashboard/index";
import formRegister from "../Register/Index";
import HorizontalMenu from "../HorizontalMenu.vue";

import { mapState, mapGetters, mapMutations } from "vuex";

export default {
    props: {
        type: {
            type: String,
            default: "login",
            required: true
        }
    },
    components: {
        dashboardAdminComponent,
        formRegister,
        HorizontalMenu
    },
    data() {
        return {
            email: "",
            password: "",
            errorLogged: false,
            unauthorized: false,
            loginView: this.type === "login" ? true : false
        };
    },
    computed: {
        ...mapState(["token", "user"]),
        ...mapGetters(["headers", "idRol"])
    },
    methods: {
        ...mapMutations(["setToken", "setUser"]),
        validateLogin() {
            const data = {
                email: this.email,
                password: this.password
            };

            axios
                .post("api/login", data)
                .then(response => {
                    this.setToken(response.data);
                    localStorage.setItem("token", this.token);

                    const url = new URL(window.location.href);
                    url.searchParams.set("section", "services");
                    window.history.pushState({}, "", url);

                    axios.get("api/getToken", this.headers).then(response => {
                        console.log(response.data);
                        if (this.idRol === 1) {
                            this.unauthorized = false;
                            this.errorLogged = false;
                        } else {
                            this.unauthorized = true;
                        }
                    });
                })
                .catch(error => {
                    console.log(error);
                    this.errorLogged = true;
                });
        },
        showFormRegister() {
            this.loginView = false;
        },
        showFormLogin() {
            this.loginView = true;
        }
    }
};
</script>
<style scoped>
.login-form {
    margin-top: 100px;
    min-width: 425px;
}

.login-text {
    color: #2d3748;
    font-size: 20px;
    font-weight: 500;
}

.sombra {
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
}
.btn-create {
    background: #101a24;
    border-color: #101a24;
    border-radius: 20px;
    color: #fff;
}
.btn-login {
    background: #fff;
    border-color: #101a24;
    border-radius: 20px;
    color: #101a24;
}
.btn-login:hover {
    background: #101a24;
    border-color: #fff;
    border-radius: 20px;
    color: #fff;
}
.btn-create:hover {
    border-color: #101a24;
    color: #101a24;
    background: #fff;
}
.form-control {
    border: 1px solid #101a24;
    border-radius: 10px;
}
</style>
