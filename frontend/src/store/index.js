import {createStore} from 'vuex';
import auth from "./auth";
import user from "./user";
import common from "./common";


const store = createStore({
    state() {
    },
    mutations: {},
    modules: {
        auth,
        user,
        common
    }
});
export default store;
