import axios from "axios";
import store from "../store";
import router from "../router";

const client = axios.create({
    // baseURL: import.meta.env.BASE_URL || 'http://localhost',
    baseURL: process.env.MIX_BASE_URL || 'http://localhost:8000',
    headers: {
        'Content-Type': 'application/json',
    },
});

export const setTokenToClient = token => {
    client.defaults.headers.common.Authorization = 'Bearer ' + token;
};
export const removeTokenFromClient = () => {
    delete client.defaults.headers.common.Authorization;
};

client.interceptors.response.use(
    function (response) {
        return response;
    },
    function (error) {
        if (error.response.data.message == 'no role access') {
            console.log('no route access');
            const userRoleId = store.state.user.user.role_id;
            if (userRoleId == 5) {
                router.push({name: 'consultationsList'});
            } else if (userRoleId == 4)
                router.push({name: 'applicationsList'});
            else
                router.push({name: 'dashboardMain'});
        }

        return Promise.reject(error);
    }
);


export default client;
