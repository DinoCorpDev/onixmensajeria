import Vue from "vue";
import "./plugins/index";

window.Vue = require("vue").default;
require("./bootstrap");

import Vuex from "vuex";
Vue.use(Vuex);

window.toastr = require("toastr");
Vue.use(toastr);

Vue.component("home-component", require("./Components/Home/index.vue").default);
Vue.component("login-component", require("./Components/Login/index.vue").default);

const store = new Vuex.Store({
    state: {
        token: localStorage.getItem("token") || null,
        user: null
    },
    getters: {
        headers(state) {
            return { headers: { Authorization: `Bearer ${state.token}` } };
        },
        idRol(state) {
            return state.user ? state.user.id_rol : null;
        }
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        setUser(state, user) {
            state.user = user;
        }
    },
    actions: {
        getUser({ commit, getters, dispatch, state }) {
            axios
                .get("api/getToken", getters.headers)
                .then(response => {
                    commit("setUser", response.data.user);

                    if (!state.user) {
                        dispatch("logoutUser");
                    }
                })
                .catch(error => {
                    console.log(error);
                    commit("setUser", null);
                });
        },
        logoutUser({ commit, getters }) {
            axios
                .get("api/logout", getters.headers)
                .then(response => {
                    localStorage.removeItem("token");
                    commit("setToken", null);
                    commit("setUser", null);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
});

const app = new Vue({
    el: "#app",
    store: store
});
