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
                v-if="user.id_rol == 1 || user.id_rol == 2"
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
                        <span>{{ formatterAmount(totalAmount) }}</span>
                    </li>
                    <li class="list-group-item">
                        <span>Domicilios:</span>
                        <span>{{ formatterAmount(deliveryAmount) }}</span>
                    </li>
                    <li class="list-group-item">
                        <span>Dinero a enviar:</span>
                        <span>
                            {{ formatterAmount(totalAmount - deliveryAmount) }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div
                    v-if="user.id_rol === 1"
                    class="d-flex justify-content-end"
                >
                    <b-dropdown
                        :disabled="!orderId ? true : false"
                        class="mb-3"
                        dropleft
                        text="Asignar a Condutor"
                        variant="primary"
                    >
                        <div class="px-3 pb-2">
                            <input
                                class="form-control"
                                id="search-driver"
                                placeholder="Buscar..."
                                size="sm"
                                type="search"
                            />
                        </div>
                        <b-dropdown-item
                            v-for="driver in drivers"
                            :key="driver.name"
                            @click="assignDriver(driver.id)"
                        >
                            {{ driver.names }}
                        </b-dropdown-item>
                    </b-dropdown>
                </div>

                <b-table
                    hover
                    :items="orders"
                    :selectable="user.id_rol === 1 ? true : false"
                    select-mode="single"
                    :fields="fields"
                    ref="selectableTable"
                    @row-selected="onRowSelected"
                >
                    <template #cell(actions)="row">
                        <div class="d-inline-flex gap-1">
                            <b-button
                                size="sm"
                                class="btn-edit"
                                @click="editOrder(row.item.id)"
                            >
                                <b-icon
                                    icon="pencil-fill"
                                    title="Editar Pedido"
                                ></b-icon>
                            </b-button>
                            <b-button
                                size="sm"
                                class="btn-deleter"
                                @click="deleteOrder(row.item.id)"
                            >
                                <b-icon
                                    icon="trash-fill"
                                    title="Eliminar"
                                ></b-icon>
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
        </div>

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
                                <b-col cols="6">
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
                                <b-col cols="4">
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
                                <b-col cols="2">
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
                                <b-col :cols="orderId ? 3 : 6">
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
                                <b-col cols="3" v-if="orderId">
                                    <b-form-group
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
    remove,
    update,
    equalTo,
    query,
    orderByChild,
} from "firebase/database";
import firebaseApp from "@firebaseConfig";

const db = getDatabase(firebaseApp);
const ordersRef = ref(db, "orders");

export default {
    props: ["token", "changeActive", "user"],
    data() {
        return {
            orders: [],
            drivers: [],
            orderData: {
                store_id: "",
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
                {
                    key: "amount",
                    label: "Recaudo",
                    formatter: (value) => this.formatterAmount(value),
                    sortable: true,
                },
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
        headers() {
            return { headers: { Authorization: `Bearer ${this.token}` } };
        },
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
        this.getOrders();
        this.getDrivers();
    },
    methods: {
        onRowSelected(items) {
            this.orderId = items.length > 0 ? items[0].id : null;
        },
        async getOrders() {
            try {
                if (!this.user.store_id) {
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
                } else {
                    const q = query(
                        ordersRef,
                        orderByChild("store_id"),
                        equalTo(this.user.store_id)
                    );

                    await onValue(q, (snapshot) => {
                        const data = [];
                        snapshot.forEach((childSnapshot) => {
                            data.push({
                                id: childSnapshot.key,
                                ...childSnapshot.val(),
                            });
                        });

                        this.orders = data.sort((a, b) => b.id - a.id);
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        createOrder() {
            if (!this.orderId) {
                const newOrderRef = ref(db, `orders/${this.getOrderLastId()}`);
                this.orderData.store_id = this.user.store_id;
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
            // prettier-ignore
            this.orderData = JSON.parse(JSON.stringify(this.orders.find(order => order.id === orderId)));
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
                status: "En bodega",
                created_at: "",
                comments: "",
            };
        },
        getDrivers() {
            axios
                .get("api/drivers", this.headers)
                .then((response) => {
                    this.drivers = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        assignDriver(driverId) {
            update(this.orderRef, { driver_id: driverId })
                .then(() => {
                    toastr.success("Conductor asignado con éxito");
                    this.cleanData();
                    this.hideModal();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        formatterAmount(value) {
            return new Intl.NumberFormat("es-CO", {
                style: "currency",
                currency: "COP",
                minimumFractionDigits: 0,
            }).format(value);
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
