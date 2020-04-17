import axios from "axios";

const instance = axios.create({
  baseURL: "http://massmailer.test/api",
  withCredentials: true,
});

instance.interceptors.request.use((config) => {
  const localStorageUser = localStorage.getItem("user");

  if (localStorageUser !== null && !config.headers["Authorization"]) {
    const user = JSON.parse(localStorageUser);
    // TODO: Check JWT token
    config.headers["Authorization"] = "Bearer " + user.token;
  }

  if (!config.headers["Content-Type"]) {
    config.headers["Content-Type"] = "application/json";
  }

  if (!config.headers["Accept"]) {
    config.headers["Accept"] = "application/json";
  }

  return config;
});

instance.interceptors.response.use((response) => {
  if (response.status === 401) {
    localStorage.removeItem("user");
    return Promise.reject({
      response,
      type: "Unauthenticated",
    });
  }

  if (response.status === 403) {
    return Promise.reject({
      response,
      type: "Unauthorized",
    });
  }

  if (response.status === 422) {
    return Promise.reject({
      response,
      errors: response.data.errors,
      type: "ValidationError",
    });
  }

  return response;
});

export default instance;
