import './bootstrap';

import { createApp } from 'vue';
import vuetify from "./vuetify";
import routes from './routes';
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

import App from './layouts/App.vue';

const app = createApp(App);

app.use(vuetify);
app.use(router);
app.mount('#app');

