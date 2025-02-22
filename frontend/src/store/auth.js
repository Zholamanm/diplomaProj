import {LS_TOKEN, LS_USERS} from '@/_types';

const auth = {
    state: () => ({
        authorized: !!localStorage.getItem(LS_USERS),
        token: localStorage.getItem(LS_TOKEN),
    }),
    mutations: {
        setAuth(state, token) {
            state.authorized = true;
            state.token = token;
        },
        removeAuth(state) {
            state.authorized = false;
            state.token = null;
        }

    },
    actions: {},
    getters: {}
};

export default auth;


