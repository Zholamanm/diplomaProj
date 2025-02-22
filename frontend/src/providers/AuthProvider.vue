<template>
    <div>
        <slot/>
    </div>
</template>

<script>
import {setTokenToClient} from "@/api";
import authApi from "../api/AuthApi";
import store from "../store";

export default {
    name: "AuthProvider",
    mounted() {
        if (this.$store.state.auth.authorized) {
            let token = authApi.getToken();
            setTokenToClient(token);
            store.commit('setAuth', token);
            this.$nextTick(() => {
                authApi.getMyUser().then(() => {
                }).catch(() => {
                    authApi.logout(false);
                });

            });

        }
    }
};
</script>

<style scoped>

</style>
