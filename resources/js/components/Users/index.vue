<template>
    <div
        class="container-convoz"
        :class="
            changeActive === true
                ? 'container content-large'
                : 'container content-short'
        "
    >
        <h2>Administración de Usuarios</h2>
        <hr style="color: black" />

        <div class="d-flex justify-content-between mt-4">
            <button
                type="button"
                class="btn btn-create mb-2"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
            >
                Crear Usuario
            </button>
            <div class="d-flex align-items-center">
                <button
                    class="btn-close me-3"
                    v-if="filterRol"
                    @click="filterRol = null"
                ></button>
                <b-form-select
                    class="form-select"
                    v-model="filterRol"
                    :options="roles"
                    text-field="name"
                    value-field="id"
                >
                    <template #first>
                        <option :value="null" hidden>Filtrar por Rol</option>
                    </template>
                </b-form-select>
            </div>
        </div>
        <div class="row mt-4">
            <div
                class="col-md-12 mb-4"
                v-for="(user, key) in filteredUsers"
                :key="key"
            >
                <div class="row users-table">
                    <div class="col-md-12 p-4 border-columm">
                        <div class="row d-flex justify-content-between">
                            <div class="col-lg-3">
                                <p class="text-black-50 title-table">Nombres</p>
                                <p class="text-table">{{ user.names }}</p>
                            </div>
                            <div class="col-lg-3" v-if="user.id_rol != 3">
                                <p class="text-black-50 title-table">Correo</p>
                                <p class="text-table overflow-auto">
                                    {{ user.email }}
                                </p>
                            </div>
                            <div class="col-lg-3" v-if="user.id_rol == 3">
                                <p class="text-black-50">Teléfono</p>
                                <p class="text-table">{{ user.phone }}</p>
                            </div>
                            <div class="col-lg-3">
                                <p class="text-black-50 title-table">ROL</p>
                                <p class="text-table">
                                    {{
                                        user.id_rol === 1 ||
                                        user.is_admin === "1"
                                            ? "Administrador"
                                            : user.id_rol === 2
                                            ? "Proveedor"
                                            : user.id_rol === 3
                                            ? "Cliente"
                                            : user.id_rol === 4
                                            ? "Conductor"
                                            : ""
                                    }}
                                </p>
                            </div>
                            <div class="col-md-3 mt-2">
                                <button
                                    class="btn btn-edit"
                                    v-on:click="() => editUser(user)"
                                >
                                    Editar
                                </button>
                                <button
                                    class="btn btn-deleter"
                                    v-on:click="() => deleteUser(user.id)"
                                >
                                    Eliminar
                                </button>
                                <template v-if="user.id_rol === 2">
                                    <a
                                        :href="user.dni"
                                        download
                                        class="btn btn-download mb-2"
                                    >
                                        Descargar DNI
                                    </a>
                                    <a
                                        :href="user.doc_responsable"
                                        download
                                        class="btn btn-download"
                                    >
                                        Descargar ID
                                    </a>
                                </template>
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
                    <b-form @submit.prevent="saveUsers">
                        <div class="modal-header">
                            <h4
                                class="modal-title fw-bold"
                                id="exampleModalLabel"
                            >
                                <!-- prettier-ignore -->
                                {{ id === null ? "Creacion de Usuario" : "Actualizacion de Usuario" }}
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
                            <div class="form-group mt-3">
                                <label for="" class="fw-bold">Rol</label>
                                <select
                                    class="form-control"
                                    v-model="user.id_rol"
                                    required
                                >
                                    <option
                                        v-for="(rol, key) in roles"
                                        :key="key"
                                        :value="rol.id"
                                    >
                                        {{ rol.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="" class="fw-bold">
                                            Nombre
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="user.names"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="user.id_rol === 3">
                                    <div class="form-group mt-3">
                                        <label for="" class="fw-bold">
                                            Telefono
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="user.phone"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="user.id_rol != 3">
                                    <div class="form-group mt-3">
                                        <label for="" class="fw-bold">
                                            Correo
                                        </label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            v-model="user.email"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3" v-if="id === null">
                                <label for="" class="fw-bold">Contraseña</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    v-model="user.password"
                                    required
                                />
                            </div>

                            <div class="mt-3" v-if="user.id_rol === 2">
                                <label class="login-text fw-bold" for="dni">
                                    DNI
                                </label>
                                <div class="input-group mb-3">
                                    <!-- <img src="img/nube.png" alt="" class="img-nube"> -->
                                    <input
                                        required
                                        v-on:change="
                                            (e) =>
                                                imageToBase64(
                                                    'dni',
                                                    e.target.files
                                                )
                                        "
                                        type="file"
                                        class="pt-3 pb-3 form-group form-control"
                                        id="dni"
                                        accept="image/png, image/jpeg, .pdf"
                                    />
                                    <label class="input-group-text" for="dni">
                                        Cargar
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3" v-if="user.id_rol === 2">
                                <label class="login-text fw-bold" for="docId">
                                    ID
                                </label>
                                <div class="input-group mb-3">
                                    <input
                                        required
                                        v-on:change="
                                            (e) =>
                                                imageToBase64(
                                                    'docId',
                                                    e.target.files
                                                )
                                        "
                                        type="file"
                                        class="pt-3 pb-3 form-group form-control"
                                        id="doc_responsable"
                                        accept="image/png, image/jpeg, .pdf"
                                    />
                                    <label
                                        class="input-group-text"
                                        for="doc_responsable"
                                    >
                                        Cargar
                                    </label>
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
                                <!-- prettier-ignore -->
                                {{ id === null ? "Crear usuario" : "Guardar cambios" }}
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
    props: ["token", "changeActive"],
    data() {
        return {
            users: [],
            roles: [],
            id: null,
            user: {
                is_admin: false,
                dni: null,
                doc_responsable: null,
            },
            filterRol: null,
        };
    },
    computed: {
        filteredUsers() {
            if (!this.filterRol) return this.users;
            return this.users.filter((user) => {
                return user.id_rol === this.filterRol;
            });
        },
    },
    mounted() {
        this.getUsers();
        this.getRoles();
    },
    methods: {
        getUsers() {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            axios.get("api/users", { headers }).then((response) => {
                console.log(response.data);
                this.users = response.data;
            });
        },
        getRoles() {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            axios.get("api/roles", { headers }).then((response) => {
                this.roles = response.data;
            });
        },
        editUser(data) {
            this.user = data;
            this.id = data.id;
            $("#exampleModal").modal("show");
        },
        hideModal() {
            $("#exampleModal").modal("hide");
        },
        saveUsers() {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            if (this.id === null) {
                axios
                    .post("api/userCreate", this.user, { headers })
                    .then((response) => {
                        toastr.success(response.data);
                        this.getUsers();
                        this.hideModal();
                        this.cleanData();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                axios
                    .put(`api/userUpdate/${this.id}`, this.user, { headers })
                    .then((response) => {
                        toastr.success(response.data);
                        this.getUsers();
                        this.hideModal();
                        this.cleanData();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        deleteUser(id) {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            if (window.confirm("¿Seguro que desea eliminar este usuario?")) {
                axios
                    .delete(`api/users/${id}`, { headers })
                    .then((response) => {
                        toastr.success(response.data);
                        this.getUsers();
                        this.hideModal();
                        this.cleanData();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        cleanData() {
            this.user = {
                is_admin: false,
                dni: null,
                doc_responsable: null,
            };
            this.id = null;
        },
        imageToBase64(type, data) {
            const file = data[0];
            const reader = new FileReader();
            let rawImg;
            reader.onloadend = () => {
                rawImg = reader.result;
                if (type === "dni") {
                    this.user.dni = rawImg;
                } else if (type === "docId") {
                    this.user.doc_responsable = rawImg;
                }
            };
            reader.readAsDataURL(file);
        },
    },
};
</script>

<style scoped>
.title-table {
    font-size: 15px;
}
.text-table {
    font-size: 14px;
    overflow-wrap: break-word;
}
/* .content-large {
    padding-left: 237px;
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
.users-table {
    padding-left: 15px;
}
.border-columm {
    border: 1px solid #101a24;
    border-radius: 5px;
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
.btn-download {
    width: 60%;
    border-radius: 20px;
    padding: 1px 1px 1px 1px;
    background: #101a24;
    border-color: #101a24;
    color: #fff;
}
.btn-download:hover {
    border-color: #101a24;
}
@media (max-width: 991px) {
    .btn-edit {
        width: 100%;
    }
    .btn-deleter {
        width: 100%;
    }
    .btn-download {
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
/* .img-nube {
      border-radius: 20px;
      padding: 0px 10px;
      border: 1px solid #101a24;
      color: #fff;
      z-index: 999;
  } */
</style>
