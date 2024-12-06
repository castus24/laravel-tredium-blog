import './bootstrap';

import { createApp } from 'vue';
import vuetify from "./vuetify";
import routes from './routes';
import { createPinia } from 'pinia';

const pinia = createPinia();

import App from './App.vue';

const app = createApp(App);

app.use(vuetify);
app.use(routes);
app.use(pinia);
app.mount('#app');

