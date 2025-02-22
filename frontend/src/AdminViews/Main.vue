<template>
  <div class="wrapper">
    <header-view v-if="authorized"></header-view>
    <sidebar-view v-if="authorized"></sidebar-view>
    <RouterView
        v-if="((authorized&&$store.state.user.user) || $route.name=='login')"
        class=""/>
    <footer-view v-if="authorized"></footer-view>
  </div>
</template>

<script>
import {useHead} from "@vueuse/head";
import HeaderView from "./Elements/HeaderView.vue";
import FooterView from "./Elements/FooterView.vue";
import SidebarView from "./Elements/SidebarView.vue";
import $ from "jquery";
import "jquery-ui";

export default {
  name: "AdminMainView",
  components: {HeaderView, SidebarView, FooterView},
  setup() {
    useHead({
      title: "AdminPage",
      link: [
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback",
        },
        {
          rel: "stylesheet",
          href: "/plugins/fontawesome-free/css/all.min.css",
        },
        {
          rel: "stylesheet",
          href: "/plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
        },
        {
          rel: "stylesheet",
          href: "/dist/css/adminlte.min.css",
        },
      ],
    });
  },
  computed: {
    authorized() {
      return this.$store.state.auth.authorized;
    },
  },
  mounted() {
    document.body.classList.add('sidebar-mini');
    document.body.classList.add('layout-fixed');
    window.$ = window.jQuery = $;
    this.loadScript("/plugins/bootstrap/js/bootstrap.bundle.min.js");
    this.loadScript("/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js");
    this.loadScript("/dist/js/adminlte.js");
  },
  methods: {
    loadScript(src, callback) {
      let script = document.createElement("script");
      script.src = src;
      script.async = true;
      script.onload = () => {
        if (callback) callback();
      };
      document.body.appendChild(script);
    },
  },
};
</script>
<style>
body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
  transition: margin-left 0.3s ease-in-out;
  margin-left: 250px;
}
body.sidebar-mini.sidebar-collapse .content-wrapper,
body.sidebar-mini.sidebar-collapse .main-footer,
body.sidebar-mini.sidebar-collapse .main-header {
  margin-left: 0rem !important; /* Overrides weaker !important */
}
body.sidebar-mini.sidebar-collapse .main-sidebar,
body.sidebar-mini.sidebar-collapse .main-sidebar::before {
  margin-left: 0 !important;
  width: 0rem !important;
}

/* Default Sidebar Styles */
.main-sidebar {
  width: 250px;
  transition: width 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

/* Content Wrapper (Ensures Main Content Adjusts) */
.content-wrapper {
  transition: margin-left 0.3s ease-in-out;
  margin-left: 250px; /* Default with sidebar */
}

/* Hide Sidebar Smoothly */
.hidden-sidebar {
  width: 0 !important;
  opacity: 0;
  overflow: hidden;
}

/* Expand Content to Full Width */
.expanded-content {
  margin-left: 0 !important;
}

</style>
<style scoped>
</style>
