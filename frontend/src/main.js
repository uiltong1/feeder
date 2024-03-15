import { createApp } from "vue";
import Antd from "ant-design-vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "ant-design-vue/dist/antd.css";

const app = createApp(App);

/** Componentes global personalizados */
import Form from "./templates/UI/Form.vue";
import Table from "./templates/UI/Table.vue";
app.component("Form", Form);
app.component("Table", Table);

app.use(Antd);
app.use(store);
app.use(router);
app.mount("#app");
