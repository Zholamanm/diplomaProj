import client, {removeTokenFromClient, setTokenToClient} from "../api/index.js";
import {LS_TOKEN, LS_USERS} from "@/_types";
import store from "../store/index";
import { auth, provider, signInWithPopup } from '@/firebase';

const authApi = {
    async signInWithGoogle() {
        try {
            const result = await signInWithPopup(auth, provider);
            const user = result.user;
            const idToken = await user.getIdToken();

            // Use axios POST here, not fetch
            await this.sendIdTokenToBackend(idToken);
        } catch (error) {
            console.error("Google sign-in error", error);
            throw error; // Optional: propagate error
        }
    },

    async sendIdTokenToBackend(idToken) {
        try {
            const response = await client.post('/api/google-login', { idToken });
            const data = response.data;

            this.setAuthorization(data.user.email, '123456', data.token);
            store.commit('setUser', data.user);
        } catch (error) {
            console.error('Backend Google login failed:', error);
            throw new Error('Login failed');
        }
    },
    async login(data) {
        return await client.post('/api/login', data).then(res => {
            this.setAuthorization(data.email, data.password, res.data.token);
            store.commit('setUser', res.data.user);
        });
    },
    async setFcmToken(token) {
        const response = await client.post('/api/save-fcm-token', { fcm_token: token }, {
            headers: {
                'Authorization': `Bearer ${authApi.getToken()}`,
                'Content-Type': 'application/json',
            }
        });

        return response.data;
    },
    setAuthorization(email, password, token) {
        const authdata = window.btoa(email + ':' + encodeURIComponent(password));

        localStorage.setItem(LS_USERS, JSON.stringify(authdata));
        localStorage.setItem(LS_TOKEN, token);

        setTokenToClient(token);

        store.commit('setAuth', token);
    },
    getToken() {
        return localStorage.getItem(LS_TOKEN);
    },
    getMyUser() {
        return client.get('/api/user-info').then(res => {
            store.commit('setUser', res.data);
            return res.data;
        });
    },
    async logout() {
        removeTokenFromClient();
        localStorage.removeItem(LS_USERS);
        localStorage.removeItem(LS_TOKEN);
        store.commit('removeAuth');
        store.commit('deleteUser');
        // if (bool)
        window.location.reload();
        // return await client.post('/api/logout').then(() => {

        // });
    },

    register(data) {
        return client.post('/api/register', data).then(res => res.data);
    },

    getPersonalDataWithApplication() {
        return client.get('/api/personal-data').then(res => res.data);
    },
    updateProfile(data) {
        return client.post('/api/update-profile', data).then(res => res.data);
    },

    sendCode(data) {
        return client.post('/api/send-restore-code', data).then(res => res.data);
    },
    confirmSmsCode(data) {
        return client.post('/api/confirm-restore-code', data).then(res => res.data);
    },
    resetPassword(data) {
        return client.post('/api/restore-password', data).then(res => res.data);
    }
};

export default authApi;
