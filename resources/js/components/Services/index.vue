<template>
    <div
        class="container-convoz"
        :class="changeActive === true ? 'content-large' : 'content-short'"
    >
        <h2>Pedidos</h2>
        <hr style="color: black" />

        <div class="mt-4 btn-block">
            <button
                v-if="idRol === 1 || idRol === 2"
                type="button"
                class="btn btn-create"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                :disabled="!checkCurrentDate()"
            >
                Crear Pedido
            </button>
        </div>

        <!--Botones desktop-->
        <b-row class="row align-items-end container-desk">
            <b-col cols="12" sm="6">
                <label for="selected-date">Filtrar por Fecha</label>
                <b-form-datepicker
                    id="selected-date"
                    v-model="selectedDate"
                    @input="getOrders()"
                    locale="es-CO"
                />
            </b-col>
            <b-col cols="12" sm="6">
                <div
                    v-if="idRol === 1 || idRol === 3"
                    class="d-flex justify-content-end"
                >
                    <b-dropdown
                        v-if="idRol === 1"
                        :disabled="!selectedStore ? true : false"
                        dropleft
                        text="Asignar a Condutor"
                        variant="primary"
                    >
                        <b-dropdown-item
                            v-for="driver in driversByStore"
                            :key="driver.name"
                            @click="assignDriver(driver.id)"
                        >
                            {{ driver.names }}
                        </b-dropdown-item>
                    </b-dropdown>

                    <b-dropdown
                        v-if="idRol === 3"
                        :disabled="!orderId ? true : false"
                        dropleft
                        text="Cambiar Estado"
                        variant="primary"
                    >
                        <b-dropdown-item
                            v-for="status in status"
                            :key="status"
                            @click="assignStatus(status)"
                        >
                            {{ status }}
                        </b-dropdown-item>
                    </b-dropdown>
                </div>
            </b-col>
        </b-row>

        <!--Botones responsive-->
        <b-row class="row align-items-end container-res">
            <b-col cols="12" sm="6" class="my-4">
                <div
                    v-if="idRol === 1 || idRol === 3"
                    class="d-flex justify-content-end"
                >
                    <b-dropdown
                        v-if="idRol === 1"
                        :disabled="!selectedStore ? true : false"
                        dropleft
                        text="Asignar a Condutor"
                        variant="primary"
                    >
                        <b-dropdown-item
                            v-for="driver in driversByStore"
                            :key="driver.name"
                            @click="assignDriver(driver.id)"
                        >
                            {{ driver.names }}
                        </b-dropdown-item>
                    </b-dropdown>

                    <b-dropdown
                        v-if="idRol === 3"
                        :disabled="!orderId ? true : false"
                        dropleft
                        text="Cambiar Estado"
                        variant="primary"
                    >
                        <b-dropdown-item
                            v-for="status in status"
                            :key="status"
                            @click="assignStatus(status)"
                        >
                            {{ status }}
                        </b-dropdown-item>
                    </b-dropdown>
                </div>
            </b-col>
            <b-col cols="12" sm="6">
                <label for="selected-date">Filtrar por Fecha</label>
                <b-form-datepicker
                    id="selected-date"
                    v-model="selectedDate"
                    @input="getOrders()"
                    locale="es-CO"
                />
            </b-col>
        </b-row>

        <!--Tabla desktop-->
        <div v-if="ordersByShop" class="row mt-4 container-desk">
            <div class="col-12">
                <div
                    v-for="shop in ordersByShop"
                    :key="`store-table-${shop.store_id}`"
                >
                    <div class="d-flex aligns-items-center">
                        <template v-if="idRol === 1">
                            <b-form-checkbox
                                :id="`checkbox-${shop.store_id}`"
                                v-model="selectedStore"
                                :name="`checkbox-${shop.store_id}`"
                                :value="shop.store_id"
                                :unchecked-value="null"
                            >
                                <h5 class="fw-bold">
                                    {{ shop.name }}
                                </h5>
                            </b-form-checkbox>
                        </template>
                        <template v-else-if="idRol === 3">
                            <h5 class="fw-bold">
                                {{ shop.name }}
                            </h5>
                        </template>
                    </div>
                    <b-table
                        responsive
                        hover
                        :items="shop.orders"
                        :selectable="idRol === 3 ? true : false"
                        select-mode="single"
                        :fields="fields"
                        ref="selectableTable"
                        @row-selected="onRowSelected"
                    >
                        <template v-if="idRol !== 3" #cell(actions)="row">
                            <div class="d-inline-flex gap-1">
                                <b-button
                                    size="sm"
                                    class="btn-view"
                                    @click="viewOrder(row.item.id)"
                                >
                                    <b-icon
                                        icon="eye"
                                        title="Ver Pedido"
                                    ></b-icon>
                                </b-button>
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
        </div>

        <!--Tabla responsive-->
        <div v-if="ordersByShop" class="row mt-4 container-res">
            <div class="col-12">
                <div
                    v-for="shop in ordersByShop"
                    :key="`store-table-${shop.store_id}`"
                >
                    <div class="d-flex aligns-items-center">
                        <template v-if="idRol === 1">
                            <b-form-checkbox
                                :id="`checkbox-${shop.store_id}`"
                                v-model="selectedStore"
                                :name="`checkbox-${shop.store_id}`"
                                :value="shop.store_id"
                                :unchecked-value="null"
                            >
                                <h5 class="fw-bold">
                                    {{ shop.name }}
                                </h5>
                            </b-form-checkbox>
                        </template>
                        <template v-else-if="idRol === 3">
                            <h5 class="fw-bold">
                                {{ shop.name }}
                            </h5>
                        </template>
                    </div>
                    <b-table
                        responsive
                        striped
                        hover
                        :items="shop.orders"
                        :selectable="idRol === 3 ? true : false"
                        select-mode="single"
                        :fields="fields2"
                        ref="selectableTable"
                        @row-selected="onRowSelected"
                    >
                        <template v-if="idRol !== 3" #cell(actions)="row">
                            <div class="d-inline-flex gap-1">
                                <b-button
                                    size="sm"
                                    class="btn-view"
                                    @click="viewOrder(row.item.id)"
                                >
                                    <b-icon
                                        icon="eye"
                                        title="Ver Pedido"
                                    ></b-icon>
                                </b-button>
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
        </div>

        <!--Cajon dinero reaudado-->
        <b-row v-if="idRol !== 3" class="row mt-2 mb-4 justify-content-end">
            <b-col cols="12" sm="4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span>Dinero recaudado:</span>
                        <span>{{ formatterAmount(totalAmount) }}</span>
                    </li>
                    <li class="list-group-item">
                        <span>Domicilios:</span>
                        <span>{{ formatterAmount(deliveryAmount) }}</span>
                    </li>
                    <li class="list-group-item envio-box">
                        <span>Dinero a enviar:</span>
                        <span>
                            {{ formatterAmount(totalAmount - deliveryAmount) }}
                        </span>
                    </li>
                </ul>
            </b-col>
        </b-row>

        <!--Modal editar-->
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
                                {{ orderId === null ? "Crear de Pedido" : "Editar de Pedido" }}
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
                                <b-col v-if="orderId" cols="6">
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

        <!--Modal ver-->
        <div
            class="modal fade"
            id="viewModal"
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
                                Pedido
                            </h4>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                                @click="cleanData"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <b-row>
                                <b-col v-if="orderId" cols="6">
                                    <b-form-group
                                        label=""
                                        label-for="status"
                                        class="mb-3"
                                    >
                                        <b-form-select
                                            class="badge bg-success"
                                            v-model="orderData.status"
                                            :options="[
                                                'En bodega',
                                                'Recibido',
                                                'Entregado',
                                                'No entregado',
                                            ]"
                                            required
                                            disabled
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="6">
                                    <b-form-group
                                        class="mb-3 zone-btn"
                                        label=""
                                        label-for="zone"
                                    >
                                        <b-form-select
                                            class="badge bg-secondary"
                                            v-model="orderData.zone"
                                            :options="['Norte', 'Sur']"
                                            required
                                            disabled
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
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
                                            disabled
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
                                            disabled
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
                                            disabled
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
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
                                            disabled
                                        ></b-form-input>
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
                                            disabled
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
                                            disabled
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
                                            disabled
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
                        </div>
                    </b-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

import {
    getDatabase,
    ref,
    onValue,
    set,
    remove,
    update,
    query,
    orderByChild,
    orderByKey,
    limitToLast,
    startAt,
    endAt,
} from "firebase/database";
import firebaseApp from "@firebaseConfig";

const db = getDatabase(firebaseApp);
const ordersRef = ref(db, "orders");

export default {
    props: ["changeActive"],
    data() {
        return {
            orders: [],
            ordersByShop: null,
            drivers: [],
            driversByStore: [],
            stores: null,
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
                date: "",
                comments: "",
            },
            status: ["En bodega", "Recibido", "Entregado", "No entregado"],
            selectedDate: this.formatCurrentDate(),
            selectedStore: null,
            orderId: null,
            ordersLastId: 0,
            fields: [
                {
                    key: "id",
                    label: "#",
                    formatter: (value) => {
                        return value.toString().padStart(2, "0");
                    },
                    sortable: true,
                },
                {
                    key: "client.name",
                    label: "Nombre",
                    sortable: true,
                },
                {
                    key: "client.lastname",
                    label: "Apellido",
                    sortable: true,
                },
                { key: "zone", label: "Zona", sortable: true },
                {
                    key: "amount",
                    label: "Recaudo",
                    formatter: (value) => this.formatterAmount(value),
                    sortable: true,
                },
                {
                    key: "driver_id",
                    label: "Conductor",
                    formatter: (value) => this.getDriverName(value),
                    sortable: true,
                },
                { key: "status", label: "Estado", sortable: true },
                {
                    key: "date",
                    label: "Fecha",
                    formatter: (value) => this.formatterDate(value),
                    sortable: true,
                },
                {
                    key: "actions",
                    label: "",
                    class: this.idRol === 3 ? "d-none" : "",
                },
            ],
            fields2: [
                {
                    key: "id",
                    label: "#",
                    formatter: (value) => {
                        return value.toString().padStart(2, "0");
                    },
                    sortable: true,
                },
                {
                    key: "client.name",
                    label: "Cliente",
                    sortable: true,
                },
                {
                    key: "amount",
                    label: "Recaudo",
                    formatter: (value) => this.formatterAmount(value),
                    sortable: true,
                },
                { key: "status", label: "Estado", sortable: true },
                {
                    key: "actions",
                    label: "",
                    class: this.idRol === 3 ? "d-none" : "",
                },
            ],
        };
    },
    computed: {
        ...mapState(["user"]),
        ...mapGetters(["headers", "idRol"]),
        orderRef() {
            return ref(db, `orders/${this.orderId}`);
        },
        totalAmount() {
            return this.orders
                .filter((order) => order.status === "Entregado")
                .reduce((acc, order) => Number(acc) + Number(order.amount), 0);
        },
        deliveryAmount() {
            return this.orders.length * 9500;
        },
    },
    async mounted() {
        await this.getDrivers();
        this.getStores().then(() => {
            this.getOrders();
            this.getOrderLastId();
        });
    },
    watch: {
        selectedStore: function () {
            if (this.selectedStore) {
                this.getDriversByStore();
            }
        },
        selectedDate: function () {
            if (!this.user.store_id) {
                this.selectedStore = null;
            }
        },
    },
    methods: {
        onRowSelected(items) {
            this.orderId = items.length > 0 ? items[0].id : null;
        },
        async getOrders() {
            try {
                const dateISO = new Date(this.selectedDate)
                    .toISOString()
                    .split("T")[0];

                const q = query(
                    ordersRef,
                    orderByChild("date"),
                    startAt(dateISO),
                    endAt(`${dateISO}\uf8ff`)
                );

                await onValue(q, (snapshot) => {
                    const data = [];
                    snapshot.forEach((childSnapshot) => {
                        data.push({
                            id: childSnapshot.key,
                            ...childSnapshot.val(),
                        });
                    });

                    // Order by id
                    this.orders = data.sort((a, b) => b.id - a.id);

                    // Single shop
                    if (this.idRol === 2) {
                        if (this.user.store_id) {
                            this.orders = this.orders.filter(
                                (order) => order.store_id === this.user.store_id
                            );
                        } else {
                            this.orders = [];
                        }
                    }

                    // Filter by driver
                    if (this.idRol === 3) {
                        this.orders = this.orders.filter((order) =>
                            this.stores.some(
                                (store) => store.id === order.store_id
                            )
                        );
                    }

                    // multiple shops
                    this.ordersByShop = this.orders.reduce((acc, order) => {
                        if (!acc[order.store_id]) {
                            acc[order.store_id] = {
                                store_id: null,
                                name: "",
                                orders: [],
                            };
                        }

                        acc[order.store_id].store_id = order.store_id;
                        // prettier-ignore
                        acc[order.store_id].name = this.getStoreName(order.store_id);
                        acc[order.store_id].orders.push(order);

                        return acc;
                    }, {});
                });
            } catch (error) {
                console.log(error);
            }
        },
        createOrder() {
            if (!this.orderId) {
                // prettier-ignore
                const newOrderRef = ref(db, `orders/${this.ordersLastId + 1}`);

                this.orderData.store_id = this.user.store_id;
                this.orderData.date = this.dateUTCtoISO(new Date());

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
        viewOrder(orderId) {
            this.orderId = orderId;
            // prettier-ignore
            this.orderData = JSON.parse(JSON.stringify(this.orders.find(order => order.id === orderId)));
            $("#viewModal").modal("show");
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
                date: "",
                comments: "",
            };
        },
        getStores() {
            return new Promise((resolve, reject) => {
                axios
                    .get("api/getAllStores", this.headers)
                    .then((response) => {
                        this.stores = response.data;
                        resolve();
                    })
                    .catch((error) => {
                        console.log(error);
                        reject();
                    });
            });
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
            try {
                this.orders.forEach((order) => {
                    if (!order.driver_id) {
                        update(ref(db, `orders/${order.id}`), {
                            driver_id: driverId,
                        }).catch((error) => {
                            console.log(error);
                        });
                    }
                });

                toastr.success("Conductor asignado con éxito");
                this.selectedStore = null;
                this.cleanData();
            } catch (error) {
                console.log(error);
            }
        },
        assignStatus(status) {
            update(this.orderRef, { status: status })
                .then(() => {
                    toastr.success("Cambio de estado con éxito");
                    this.cleanData();
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
        formatterDate(value) {
            const date = new Date(value);
            date.setHours(date.getHours() + 5);

            return new Intl.DateTimeFormat("es-CO", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
                hour: "numeric",
                minute: "numeric",
            }).format(date);
        },
        formatCurrentDate() {
            const date = new Date();
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const day = date.getDate();
            return `${year}-${month.toString().padStart(2, "0")}-${day
                .toString()
                .padStart(2, "0")}`;
        },
        dateUTCtoISO(date) {
            const utcDate = new Date(date.toUTCString());
            utcDate.setHours(utcDate.getHours() - 5);
            return utcDate.toISOString();
        },
        getStoreName(storeId) {
            const store = this.stores.find((store) => store.id == storeId);
            return store ? store.name : "Sin asignar";
        },
        getDriverName(driverId) {
            const driver = this.drivers.find((driver) => driver.id == driverId);
            return driver ? driver.names : "--";
        },
        getDriversByStore() {
            const driverId = this.stores.find(
                (store) => store.id == this.selectedStore
            ).driver_id;

            this.driversByStore = this.drivers.filter(
                (driver) => driver.id == driverId
            );
        },
        checkCurrentDate() {
            return this.selectedDate === this.formatCurrentDate();
        },
        getOrderLastId() {
            const orderRef = ref(db, "orders");
            const q = query(orderRef, orderByKey(), limitToLast(1));

            onValue(q, (snapshot) => {
                snapshot.forEach((childSnapshot) => {
                    this.ordersLastId = Number(childSnapshot.key);
                });
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.container-desk {
    display: flex;
}

@media (max-width: 550px) {
    .container-desk {
        display: none;
    }
}

.container-res {
    display: none;
}

@media (max-width: 550px) {
    .container-res {
        display: block;
    }
}

.container-convoz {
    margin-top: 10px;
    padding-left: 65px;
    margin-left: 15px;
    transition: 0.5s;
    margin-right: 0;
}

@media (min-width: 1024px) {
    .container-convoz {
        padding-left: 20% !important;
        margin-right: 15px;
    }
}

@media (min-width: 1390px) {
    .container-convoz {
        padding-left: 20% !important;
        margin-right: 15px;
    }
}

@media (min-width: 768px) {
    .container-convoz {
        padding-left: 80px;
        padding-right: 0;
        margin-right: 10px;
    }
}

.envio-box {
    background: #101a24;
    color: #fff;
}

.list-group {
    --bs-list-group-border-color: #101a24;
    --bs-list-group-border-width: 1px;
    font-weight: 600;
}

@media (max-width: 550px) {
    .list-group {
        font-size: 13px;
    }
}

@media (min-width: 768px) {
    .list-group {
        font-size: 12px;
    }
}

.zone-btn {
    text-align: end;
}

.btn-block {
    display: flex;
    justify-content: flex-end;
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

.btn-view {
    background: #fff;
    border-color: #101a24;
    color: #101a24;
}

.btn-edit:hover {
    background: #fff;
    border-color: #45f1be;
    color: #45f1be;
}

.btn-view:hover {
    background: #101a24;
    border-color: #101a24;
    color: #fff;
}

.btn-deleter {
    background: #101a24;
    border-color: #101a24;
    color: #fff;
}

.btn-deleter:hover {
    background: #fff;
    border-color: #101a24;
    color: #101a24;
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
