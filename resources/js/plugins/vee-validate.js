import Vue from 'vue';
import * as rules from 'vee-validate/dist/rules'
import {extend, ValidationObserver, ValidationProvider} from 'vee-validate'
import {localize} from "vee-validate";
import es from 'vee-validate/dist/locale/es'

localize('es');
localize({es});
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule])
})
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider);
