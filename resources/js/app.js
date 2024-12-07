import './bootstrap';

import { createApp } from 'vue';
import vuetify from "./plugins/vuetify.js";
import routes from './routes';
import { createPinia } from 'pinia';

import toast, { POSITION } from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const pinia = createPinia();

const toastOptions = {
    position: POSITION.TOP_RIGHT,
    timeout: 3000,
    hideProgressBar: true,
};

import App from './App.vue';

const app = createApp(App);

app.use(vuetify);
app.use(toast, toastOptions);
app.use(routes);
app.use(pinia);
app.mount('#app');

