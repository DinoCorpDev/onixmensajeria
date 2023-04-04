import Vue from "vue";
import "./plugins/index";

window.Vue = require("vue").default;
require("./bootstrap");

window.toastr = require("toastr");
Vue.use(toastr);

Vue.component("home-component", require("./Components/Home/index.vue").default);
Vue.component(
    "login-component",
    require("./Components/Login/index.vue").default
);

const app = new Vue({
    el: "#app",
});
