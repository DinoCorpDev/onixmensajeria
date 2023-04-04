import Vue from "vue";
import VueCurrencyInput from "vue-currency-input";

const pluginOptions = {
    globalOptions: { currency: "EUR", locale: "es", precision: 0 },
};
Vue.use(VueCurrencyInput, pluginOptions);
