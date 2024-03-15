import axios from "axios";
import storeMessages from "../modules/messages/_store";
import store from "../store";

const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
});

api.interceptors.request.use(async (config) => {
  try {
    const token = null;

    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
  } catch (err) {
    return Promise.reject(err);
  }
});

api.interceptors.response.use(
  async (response) => {
    return response;
  },
  async (error) => {
    if (!error.response) {
      return;
    }
    registerModule();
    let response = error.response;
    let dataResponse = checkResponse(response);
    const code = dataResponse.status ? dataResponse.status : 0;

    switch (code) {
      case 406:
        await store.dispatch(
          "$_messages/setErrorsFormRequest",
          dataResponse?.data
        );
        break;
      case 500:
        await store.dispatch("$_messages/setMessages", {
          type: "error",
          message: "Erro Interno",
        });
        break;
      default:
        await store.dispatch("$_messages/setMessages", {
          type: "error",
          message: dataResponse?.data?.message,
        });
        break;
    }

    return Promise.reject(error.response.data);
  }
);

function checkResponse(response) {
  if (!response) {
    return {
      data: "",
      status: 500,
      statusText: "",
    };
  }
  return response;
}

function registerModule() {
  const STORE_KEY_MESSAGES = "$_messages";
  if (!(STORE_KEY_MESSAGES in store._modules.root._children)) {
    store.registerModule(STORE_KEY_MESSAGES, storeMessages);
  }
}

export default api;
