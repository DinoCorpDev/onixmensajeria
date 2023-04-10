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
        <hr style="color: black" />

        <div class="mt-4">
            <button
                v-if="id_rol == 1 || (id_rol == 2 && orders.length < 1)"
                type="button"
                class="btn btn-create"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
            >
                Crear Pedido
            </button>
        </div>

        <div class="row mt-4 justify-content-end">
            <div class="col-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span>Dinero recaudado:</span>
                        <span>{{ totalAmount }}</span>
                    </li>
                    <li class="list-group-item">
                        <span>Domicilios:</span>
                        <span>{{ deliveryAmount }}</span>
                    </li>
                    <li class="list-group-item">
                        <span>Dinero a enviar:</span>
                        <span>{{ totalAmount - deliveryAmount }} </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <b-table striped hover :items="orders" :fields="fields">
                <template #cell(actions)="row">
                    <div class="d-inline-flex gap-1">
                        <b-button
                            size="sm"
                            class="btn-edit"
                            @click="() => editOrder(row.item.id)"
                        >
                            <b-icon icon="pencil-fill"></b-icon>
                        </b-button>
                        <b-button
                            size="sm"
                            class="btn-deleter"
                            @click="() => deleteOrder(row.item.id)"
                        >
                            <b-icon icon="trash-fill"></b-icon>
                        </b-button>
                    </div>
                </template>
                <template #cell(status)="data">
                    <span
                        v-if="data.item.status == 'Entregado'"
                        class="badge bg-success"
                    >
                        {{ data.item.status }}
                    </span>
                    <span
                        v-if="data.item.status == 'No entregado'"
                        class="badge bg-danger"
                    >
                        {{ data.item.status }}
                    </span>
                    <span
                        v-if="
                            data.item.status == 'En bodega' ||
                            data.item.status == 'Recibido'
                        "
                        class="badge bg-secondary"
                    >
                        {{ data.item.status }}
                    </span>
                </template>
            </b-table>
        </div>

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
                    <b-form @submit.prevent="createOrder()">
                        <div class="modal-header">
                            <h4
                                class="modal-title fw-bold"
                                id="exampleModalLabel"
                            >
                                <!-- prettier-ignore -->
                                {{ orderId === null ? "Creación de Pedido" : "Actualización de Pedido" }}
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
                            <b-row>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3"
                                        label="Nombre:"
                                        label-for="name"
                                    >
                                        <b-form-input
                                            id="name"
                                            v-model="orderData.client.name"
                                            required
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3"
                                        label="Apellido:"
                                        label-for="lastname"
                                    >
                                        <b-form-input
                                            id="lastname"
                                            v-model="orderData.client.lastname"
                                            required
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col cols="12">
                                    <b-form-group
                                        class="mb-3"
                                        label="Dirección:"
                                        label-for="address"
                                    >
                                        <b-form-input
                                            id="address"
                                            v-model="orderData.address"
                                            required
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3"
                                        label="Barrio:"
                                        label-for="neighborhood"
                                    >
                                        <b-form-input
                                            id="neighborhood"
                                            v-model="orderData.neighborhood"
                                            required
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3"
                                        label="Zona:"
                                        label-for="zone"
                                    >
                                        <b-form-select
                                            class="form-select"
                                            v-model="orderData.zone"
                                            :options="['Norte', 'Sur']"
                                            required
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3"
                                        label="Teléfono:"
                                        label-for="phone"
                                    >
                                        <b-form-input
                                            id="phone"
                                            v-model="orderData.phone"
                                            required
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3"
                                        label="Recaudo:"
                                        label-for="amount"
                                    >
                                        <b-form-input
                                            id="amount"
                                            v-model.number="orderData.amount"
                                            required
                                            type="number"
                                            min="1"
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col cols="12">
                                    <b-form-group
                                        label="Comentarios:"
                                        label-for="comments"
                                    >
                                        <b-form-textarea
                                            id="comments"
                                            v-model="orderData.comments"
                                            rows="3"
                                            max-rows="6"
                                        ></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row v-if="orderId">
                                <b-col cols="12">
                                    <b-form-group
                                        class="mt-3"
                                        label="Estado:"
                                        label-for="status"
                                    >
                                        <b-form-select
                                            class="form-select"
                                            v-model="orderData.status"
                                            :options="[
                                                'En bodega',
                                                'Recibido',
                                                'Entregado',
                                                'No entregado',
                                            ]"
                                            required
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-closer"
                                data-bs-dismiss="modal"
                                @click="cleanData()"
                            >
                                Cerrar
                            </button>
                            <button type="submit" class="btn btn-save">
                                <!-- prettier-ignore -->
                                {{ orderId === null ? "Crear servicio" : "Guardar cambios" }}
                            </button>
                        </div>
                    </b-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    getDatabase,
    ref,
    onValue,
    set,
    push,
    remove,
} from "firebase/database";
import firebaseApp from "@firebaseConfig";

const db = getDatabase(firebaseApp);
const ordersRef = ref(db, "orders");

export default {
    props: ["token", "changeActive"],
    data() {
        return {
            orders: [],
            orderData: {
                client: {
                    name: "",
                    lastname: "",
                },
                phone: "",
                address: "",
                neighborhood: "",
                zone: "",
                amount: 0,
                status: "En bodega",
                created_at: "",
                comments: "",
            },
            orderId: null,
            user: {},
            id_rol: "",
            fields: [
                {
                    key: "id",
                    label: "# Pedido",
                    formatter: (value) => {
                        return value.toString().padStart(5, "0");
                    },
                    sortable: true,
                },
                {
                    key: "client.name",
                    label: "Nombre de Cliente",
                    sortable: true,
                },
                {
                    key: "client.lastname",
                    label: "Apellido de Cliente",
                    sortable: true,
                },
                { key: "zone", label: "Zona", sortable: true },
                { key: "status", label: "Estado", sortable: true },
                {
                    key: "created_at",
                    label: "Fecha de Creación",
                    sortable: true,
                },
                { key: "actions", label: "Acciones" },
            ],
        };
    },
    computed: {
        orderRef() {
            return ref(db, `orders/${this.orderId}`);
        },
        totalAmount() {
            return this.orders
                .filter((order) => order.status === "Entregado")
                .reduce((acc, order) => Number(acc) + Number(order.amount), 0);
        },
        deliveryAmount() {
            return this.orders.length * 8000;
        },
    },

    mounted() {
        this.getUser().then((id_rol) => {
            this.id_rol = id_rol;
            if (id_rol == 1) {
                this.getOrders();
            } else if (id_rol == 2) {
                // this.getMyServices();
            }
        });
    },
    methods: {
        async getOrders() {
            try {
                await onValue(ordersRef, (snapshot) => {
                    const data = [];
                    snapshot.forEach((childSnapshot) => {
                        data.push({
                            id: childSnapshot.key,
                            ...childSnapshot.val(),
                        });
                    });
                    this.orders = data.sort((a, b) => b.id - a.id);
                });
            } catch (error) {
                console.log(error);
            }
        },
        createOrder() {
            if (!this.orderId) {
                const newOrderRef = ref(db, `orders/${this.getOrderLastId()}`);
                this.orderData.created_at = new Date().toLocaleString();

                set(newOrderRef, this.orderData)
                    .then(() => {
                        toastr.success("Orden creada con éxito");
                        this.cleanData();
                        this.hideModal();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                set(this.orderRef, this.orderData)
                    .then(() => {
                        toastr.success("Orden actualizada con éxito");
                        this.cleanData();
                        this.hideModal();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        editOrder(orderId) {
            this.orderId = orderId;
            this.orderData = this.orders.find((order) => order.id === orderId);
            $("#exampleModal").modal("show");
        },
        deleteOrder(orderId) {
            this.orderId = orderId;

            if (confirm("¿Estás seguro de eliminar este pedido?")) {
                remove(this.orderRef)
                    .then(() => {
                        toastr.success("Orden eliminada con éxito");
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        getOrderLastId() {
            return this.orders.length > 0 ? Number(this.orders[0].id) + 1 : 1;
        },
        hideModal() {
            $("#exampleModal").modal("hide");
        },
        cleanData() {
            this.orderId = null;
            this.orderData = {
                client: {
                    name: "",
                    lastname: "",
                },
                phone: "",
                address: "",
                neighborhood: "",
                zone: "",
                amount: 0,
                status: "En Bodega",
                created_at: "",
                comments: "",
            };
        },
        async getUser() {
            const response = await axios.get("api/getToken", {
                headers: { Authorization: `Bearer ${this.token}` },
            });
            this.user = response.data.user;
            return Promise.resolve(response.data.user.id_rol);
        },
    },
};
</script>

<style lang="scss" scoped>
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

.btn-edit {
    background: #45f1be;
    border-color: #45f1be;
    color: #fff;
}

.btn-edit:hover {
    border-color: #45f1be;
}

.btn-deleter {
    background: #101a24;
    border-color: #101a24;
    color: #fff;
}

.btn-deleter:hover {
    border-color: #101a24;
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
