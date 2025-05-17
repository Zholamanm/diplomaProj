import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from "./store";
import i18n from "./localization";
import $ from 'jquery';
import InfiniteLoading from "v3-infinite-loading/lib/v3-infinite-loading.es.js";
import 'v3-infinite-loading/lib/style.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { createHead } from '@vueuse/head';
import { messaging, onMessage } from '@/firebase';
import './assets/styles.css';

const app = createApp(App);
const head = createHead(); // Create an instance

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(registration => {
            console.log('Service Worker registered:', registration.scope);
        })
        .catch(err => {
            console.error('Service Worker registration failed:', err);
        });
}

onMessage(messaging, payload => {
    console.log('Foreground message received:', payload);

    if (Notification.permission === 'granted') {
        const { title, body } = payload.notification;

        new Notification(title, {
            body,
            icon: '/path/to/icon.png' // optional
        });
    }
});

app.config.devtools = true;
app.use(router);
app.use(store);
app.use(i18n);
app.use($);
app.use(head); // Register Head
app.component("InfiniteLoading", InfiniteLoading);
app.mount('#app');