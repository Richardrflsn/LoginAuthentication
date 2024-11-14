import { createApp } from 'vue'
import { createPinia } from 'pinia';
// import './style.css'

import App from './App.vue'

import router from './router';

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import { Notifications } from '@kyvg/vue3-notification';

import "../axios";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(Notifications)

app.mount('#app');
