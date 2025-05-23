import Echo from 'laravel-echo';
import store from "@/store";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '51e1497c66e3c8254621',
    cluster: 'ap2',
    forceTLS: true,
    encrypted: true,
    authEndpoint: 'http://localhost:8000/broadcasting/auth',
    auth: {
        headers: {
            Authorization: 'Bearer ' + store.state.auth.token,
            Accept: 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
    },
});
