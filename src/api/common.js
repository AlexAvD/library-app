import Vue from "vue";

export const queryString = (params) =>
  "?" +
  Object.entries(params)
    .map((param) => `${param[0]}=${param[1]}`)
    .join("&");

export const get = (resource, params) => {
  return Vue.axios.get(`${resource}${params ? queryString(params) : ""}`).catch((error) => {
    throw new Error(`[api] ${error}`);
  });
};

export const post = (resource, params) => {
  return Vue.axios.post(resource, params);
};

export const service = {
  get(resource, id = "") {
    return get(resource, id !== "" ? { id } : null);
  },
  delete(resource, payload) {
    return post(resource, { payload, type: "delete" });
  },
  update(resource, payload) {
    return post(resource, { payload, type: "update" });
  },
  add(resource, payload) {
    return post(resource, { payload, type: "add" });
  },
};

export const serviceFactory = (resource) => ({
  get(id = "") {
    return service.get(resource, id);
  },
  add(data) {
    return service.add(resource, data);
  },
  delete(id) {
    return service.delete(resource, { id });
  },
  update(id, data) {
    return service.update(resource, { id, ...data });
  },
});
