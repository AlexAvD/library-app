import Vue from "vue";
import App from "./App.vue";

import router from "./router";
import store from "./store";
import api from "./api";

import { ValidationProvider, extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import { messages } from "vee-validate/dist/locale/en.json";

import VueInputMask from "vue-inputmask";
import VSelect from "vue-select";

Object.keys(rules).forEach((rule) => {
  extend(rule, {
    ...rules[rule], // copies rule configuration
    message: messages[rule], // assign message
  });
});

import date from "./validators/date";

extend("date", date);

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("VSelect", VSelect);

Vue.config.productionTip = false;

Vue.use(api);
Vue.use(VueInputMask.default);

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
