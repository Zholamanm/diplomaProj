<template>
    <div v-if="currLocale">
        <router-view/>
    </div>
</template>

<script>
import {checkLocale} from "../../router/router-guards";

export default {
    name: "Localization",
    computed: {
        currLocale() {
            return this.$route.params.locale;
        }
    },
    beforeRouteUpdate: checkLocale
};
</script>

<style scoped>

</style>
