import VueAxios from "vue-axios";
import axios from "axios";
import services from "./services";
import { API_URL } from "./config";

export const api = services;

export default {
  install(Vue) {
    Vue.use(VueAxios, axios);
    Vue.axios.defaults.baseURL = API_URL;

    Vue.prototype.$api = api;
  },
};
