import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from "./store";
import i18n from "./localization";
import InfiniteLoading from "v3-infinite-loading/lib/v3-infinite-loading.es.js";
import 'v3-infinite-loading/lib/style.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { createHead } from '@vueuse/head';

const app = createApp(App);
const head = createHead(); // Create an instance

app.config.devtools = true;
app.use(router);
app.use(store);
app.use(i18n);
app.use(head); // Register Head
app.component("InfiniteLoading", InfiniteLoading);
app.mount('#app');