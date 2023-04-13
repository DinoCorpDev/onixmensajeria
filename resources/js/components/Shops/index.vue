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
        <hr style="color: black" />

        <div class="mt-4">
            <button
                v-if="
                    user.id_rol == 1 || (user.id_rol == 2 && shops.length < 1)
                "
                type="button"
                class="btn btn-create"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
            >
                Crear Tienda
            </button>
        </div>

        <div class="row mt-4">
            <div
                class="col-md-12 mb-4"
                v-for="(getShops, key) in shops"
                :key="key"
            >
                <div class="row">
                    <p class="col-md-12 title-shop">{{ getShops.name }}</p>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <figure class="col-md-12 mb-0">
                                <img class="img-fluid" :src="getShops.avatar" />
                            </figure>
                        </div>
                    </div>

                    <div class="col-md-9 mt-3 mt-md-0">
                        <div class="border-columm p-4">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md-3">
                                    <p class="text-black-50 title-table">
                                        Ubicación
                                    </p>
                                    <p class="text-table">
                                        {{ getShops.location }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p class="text-black-50 title-table">
                                        Categorias
                                    </p>
                                    <div
                                        v-for="(
                                            categories, key
                                        ) in getShops.categories"
                                        :key="key"
                                    >
                                        <p>{{ categories.name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-5">
                                    <button
                                        class="btn btn-edit"
                                        @click="editShops(getShops)"
                                    >
                                        Editar
                                    </button>
                                    <button
                                        class="btn btn-deleter"
                                        @click="deleteShop(getShops.id)"
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
                            <h4
                                class="modal-title fw-bold"
                                id="exampleModalLabel"
                            >
                                <!-- prettier-ignore -->
                                {{ id === null ? "Creación de Tienda" : "Actualización de Tienda" }}
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
                            <div class="row align-items-end">
                                <div v-if="shop.avatar" class="col-md-3">
                                    <img
                                        :src="shop.avatar"
                                        class="img-thumbnail"
                                    />
                                </div>
                                <div
                                    :class="[
                                        shop.avatar ? 'col-md-9' : 'col-md-12',
                                    ]"
                                >
                                    <div class="form-group mb-3">
                                        <label for="">
                                            <span class="fw-bold">
                                                Avatar
                                            </span>
                                            - Tamaño (150x150)
                                        </label>
                                        <!-- prettier-ignore   -->
                                        <input
                                            :required="!shop.avatar"
                                            type="file"
                                            class="form-control"
                                            @change="(e) => imageToBase64('avatar', e.target.files)"
                                        />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="fw-bold">
                                            Nombre
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="shop.name"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="fw-bold">
                                            Ubicación
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="shop.location"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="fw-bold">
                                            Teléfono
                                        </label>
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

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <b-form-group>
                                        <p class="fw-bold mb-1">Tipo de pago</p>
                                        <div class="border-columm p-3">
                                            <!-- prettier-ignore -->
                                            <b-form-checkbox-group
                                                :options="['Transferencia', 'Tarjeta', 'Efectivo', 'Contraentrega']"
                                                :required="shop.payment_method.length === 0"
                                                name="payment_methods"
                                                v-model="shop.payment_method"
                                            />
                                        </div>
                                    </b-form-group>
                                </div>
                                <div class="col-12 col-md-6">
                                    <b-form-group>
                                        <p class="fw-bold mb-1">Categorias</p>
                                        <div class="border-columm p-3">
                                            <!-- prettier-ignore -->
                                            <b-form-checkbox-group
                                                :options="categories"
                                                :required="categoriesSelected.length === 0"
                                                name="categories"
                                                text-field="name"
                                                v-model="categoriesSelected"
                                                value-field="id_category"
                                            />
                                        </div>
                                    </b-form-group>
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
import Multiselect from "vue-multiselect";

export default {
    components: { Multiselect },
    props: ["token", "changeActive", "user"],
    data() {
        return {
            shops: [],
            id: null,
            shop: {
                name: "",
                location: "",
                payment_method: [],
                phone: "",
            },
            categories: [],
            categoriesSelected: [],
            canCreateStore: true,
            options: [
                { text: "Orange", value: "orange" },
                { text: "Apple", value: "apple" },
                { text: "Pineapple", value: "pineapple" },
                { text: "Grape", value: "grape" },
            ],
        };
    },
    mounted() {
        this.getCategories();
        this.getShops();
    },
    methods: {
        convertformat12h(fecha) {
            if (fecha[0] == 0 && fecha[1] == 0) {
                return "12" + fecha.slice(2, 5) + " am";
            } else if (fecha[0] + fecha[1] < 12) {
                return fecha.slice(0, 5) + " am";
            } else if (fecha[0] + fecha[1] == 12) {
                return fecha.slice(0, 5) + " pm";
            } else if (fecha[0] + fecha[1] > 12 && fecha[0] + fecha[1] < 22) {
                return (
                    "0" + (fecha[0] + fecha[1] - 12) + fecha.slice(2, 5) + " pm"
                );
            } else {
                return fecha[0] + fecha[1] - 12 + fecha.slice(2, 5) + " pm";
            }
        },
        getShops() {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            axios.get("api/getAllStores", { headers }).then((response) => {
                this.shops = response.data;
            });
        },
        getCategories() {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            axios.get("api/getCategoriesName", { headers }).then((response) => {
                this.categories = response.data;
            });
        },
        imageToBase64(type, data) {
            const file = data[0];
            const reader = new FileReader();
            let rawImg;
            reader.onloadend = () => {
                rawImg = reader.result;
                this.shop.avatar = rawImg;
            };
            reader.readAsDataURL(file);
        },
        editShops(data) {
            this.categoriesSelected = data.categories.map((item) => item.id);
            this.shop = data;
            this.id = data.id;
            $("#exampleModal").modal("show");
        },
        hideModal() {
            $("#exampleModal").modal("hide");
        },
        saveShops() {
            this.shop.categories = this.categoriesSelected;
            let headers = { Authorization: `Bearer ${this.token}` };
            if (this.id === null) {
                axios
                    .post("api/stores", this.shop, { headers })
                    .then((response) => {
                        toastr.success("Tienda creada con exito");
                        this.getMyShops();
                        this.cleanData();
                        this.hideModal();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                axios
                    .put(`api/stores/${this.id}`, this.shop, { headers })
                    .then((response) => {
                        toastr.success("Tienda actualizada con exito");
                        this.getShops();
                        this.cleanData();
                        this.hideModal();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        deleteShop(id) {
            let headers = {
                Authorization: `Bearer ${this.token}`,
            };
            if (window.confirm("¿Seguro que desea eliminar esta tienda?")) {
                axios
                    .delete(`api/stores/${id}`, { headers })
                    .then((response) => {
                        toastr.success(response.data);
                        this.getShops();
                        this.hideModal();
                        this.cleanData();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        cleanData() {
            this.categoriesSelected = [];
            this.id = null;
            this.shop = {
                name: "",
                location: "",
                payment_method: [],
                phone: "",
            };
        },
    },
};
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
