<template>
    <div
        class="container-convoz"
        :class="
            changeActive === true
                ? 'container content-large'
                : 'container content-short'
        "
    >
        <h2>Roles</h2>
        <hr style="color: black" />

        <div class="mt-4">
            <button
                type="button"
                class="btn btn-create"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
            >
                Crear ROL
            </button>
        </div>
        <div class="row mt-4">
            <div class="col-md-6 mb-4" v-for="(rol, key) in roles" :key="key">
                <div class="row ROL-table">
                    <div class="col-md-12 p-4 border-columm">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-9">
                                <p class="text-black-50 title-table">Nombre</p>
                                <p class="text-table">{{ rol.name }}</p>
                            </div>
                            <div class="col-md-3 mt-2">
                                <button
                                    class="btn btn-edit"
                                    @click="() => editRol(rol)"
                                >
                                    Editar
                                </button>
                                <button
                                    class="btn btn-deleter"
                                    @click="() => deleteRol(rol.id)"
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
                    <b-form @submit.prevent="saveRol">
                        <div class="modal-header">
                            <h4
                                class="modal-title fw-bold"
                                id="exampleModalLabel"
                            >
                                <!-- prettier-ignore -->
                                {{ id === null ? "Creacion de Rol" : "Actualizacion de Rol" }}
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
                                    v-model="rol.name"
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
                                <!-- prettier-ignore -->
                                {{ id === null ? "Crear ROL" : "Guardar cambios" }}
                            </button>
                        </div>
                    </b-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    props: ["changeActive"],
    data() {
        return {
            roles: [],
            id: null,
            rol: {},
        };
    },
    computed: {
        ...mapGetters(["headers"]),
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        getRoles() {
            axios
                .get("api/roles", this.headers)
                .then((response) => {
                    this.roles = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        editRol(data) {
            this.rol = data;
            this.id = data.id;

            $("#exampleModal").modal("show");
        },
        hideModal() {
            $("#exampleModal").modal("hide");
        },
        saveRol() {
            if (this.id === null) {
                axios
                    .post("api/roles", this.rol, this.headers)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.cleanData();
                        this.getRoles();
                        this.hideModal();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                axios
                    .put(`api/roles/${this.id}`, this.rol, this.headers)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.cleanData();
                        this.getRoles();
                        this.hideModal();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        deleteRol(id) {
            if (window.confirm("¿Seguro que desea eliminar este rol?")) {
                axios
                    .delete(`api/roles/${id}`, this.headers)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.getRoles();
                        this.hideModal();
                        this.cleanData();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        cleanData() {
            this.rol = {};
            this.id = null;
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

.border-columm {
    border: 1px solid #101a24;
    border-radius: 5px;
}

.ROL-table {
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
</style>
