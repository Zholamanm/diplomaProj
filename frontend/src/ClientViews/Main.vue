<template>
  <div id="main-container" class="main-container nav-effect-1">
    <header-view></header-view>
    <router-view></router-view>
  </div>
</template>
<script>
import HeaderView from './Elements/HeaderView.vue';

export default {
  name: 'ClientMainView',
  components: {HeaderView},
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      errors: {},
      globalError: null,
    };
  },
  methods: {
  },
  mounted() {
  }
};
</script>
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,300,700,900);
@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
@import url("https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css");
</style>
<style scoped>
html,
body,
.main,
.main-container {
  height: 100%;
}

body {
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #313131;
  background: #ecf0f1;
}

.row {
  max-width: 1024px;
}

/*
 *  Typography
*/
body,
p,
a,
li {
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 15px;
}

a {
  color: #219e9a;
}

h2,
h3 {
  margin-top: 6px;
  margin-bottom: 6px;
  font-size: 28px;
  font-weight: bold;
  letter-spacing: -1px;
  color: #313131;
}

h2 {
  font-size: 28px;
}

h3 {
  font-size: 24px;
}

h4 {
  margin-bottom: 12px;
  font-size: 22px;
  line-height: 40px;
  color: rgba(49, 49, 49, 0.7);
}

p:not(.author) {
  font-size: 15px;
  font-weight: 300;
  line-height: 1.4;
}

p.author {
  margin-bottom: 10px;
  letter-spacing: -1px;
  font-weight: 400;
  color: rgba(49, 49, 49, 0.5);
}

/*
 *  Button
*/
a.button {
  margin-bottom: 0;
  padding: 8px 14px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 3px;
  background-color: rgba(49, 49, 49, 0.5);
}
a.button:hover, a.button:focus {
  background-color: #219e9a;
}

/*
 *  Header
*/
.page-header {
  position: relative;
  margin-bottom: 55px;
  width: 100%;
  border-bottom: 1px solid #d2d6d5;
  background-color: #fff;
}

.main-logo {
  display: inline-block;
  padding: 1em;
  width: auto;
}
.main-logo a.logo {
  display: block;
  width: 150px;
  height: 40px;
  text-indent: -9999px;
  background: url("http://interactivejoe.com/book-viewer/assets/images/logo.svg");
  background-color: #fff;
  transition: background-color 250ms ease-out;
}
.main-logo a.logo:hover, .main-logo a.logo:focus {
  background-color: #ecf0f1;
}

.menu-search {
  float: right;
  width: calc(100% - 200px);
}

/*
 *  Search Input
*/
.catalog-search {
  position: relative;
  margin: 0 20px;
  max-width: 275px;
  width: calc(100% - 2em);
  vertical-align: top;
  overflow: hidden;
  float: right;
}

.input_field {
  position: relative;
  display: block;
  float: right;
  margin-top: 10px;
  padding: 14px 7px 0;
  width: 100%;
  border: none;
  border-radius: 0;
  color: #313131;
  font-weight: normal;
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  background: none;
  box-shadow: none;
  -webkit-appearance: none;
  /* for box shadows to show on iOS */
}
.input_field:focus {
  outline: none;
  border: none;
  background: none;
  box-shadow: none;
  -webkit-appearance: none;
}
.input_field:focus .input_label-content {
  bottom: 20px;
}

.input_label {
  position: absolute;
  display: inline-block;
  bottom: 0;
  left: 0;
  padding: 0 0.25em;
  width: 100%;
  height: calc(100% - 1em);
  color: #d2d6d5;
  font-weight: light;
  font-size: 15px;
  text-align: left;
  pointer-events: none;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.input_label:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: calc(100% - 10px);
  border-bottom: 1px solid rgba(49, 49, 49, 0.45);
}
.input_label:after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 2px;
  width: 100%;
  height: calc(100% - 10px);
  border-bottom: 3px solid #219e9a;
  transform: translate3d(-100%, 0, 0);
  transition: transform 0.3s;
}

.input_label-content {
  position: absolute;
  width: 100%;
  bottom: 14px;
}

.input_label-search {
  position: relative;
  display: block;
  color: rgba(49, 49, 49, 0.45);
}
.input_label-search:after {
  content: "";
  position: absolute;
  top: 7px;
  right: 5px;
  font-family: "fontawesome";
}

.input_field:focus + .input_label::after,
.input--filled .input_label::after {
  transform: translate3d(0, 0, 0);
}
/*
 *  Menu
*/
.main-navigation-nav {
  position: relative;
  float: right;
  margin: 16px 0;
  padding: 0 20px;
  height: 40px;
  border-left: 1px solid #d2d6d5;
}
.main-navigation-nav a {
  display: inline-block;
  line-height: 40px;
  vertical-align: middle;
  font-size: 14px;
  font-weight: bold;
  text-transform: uppercase;
  color: #313131;
}
.main-navigation-nav a:before {
  content: "";
  position: relative;
  display: inline-block;
  padding-right: 10px;
  font-family: "fontawesome";
  font-size: 18px;
  font-weight: 400;
  color: rgba(49, 49, 49, 0.45);
  vertical-align: middle;
}

/*
 *  Off Canvas Menu
*/
.main-container {
  position: relative;
  overflow-x: hidden;
}
.main-container.prevent-scroll, .main-container.nav-menu-open {
  overflow: hidden;
}

.nav-menu {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 100;
  visibility: visible;
  width: 300px;
  height: 100%;
  background: #219e9a;
  transition: all 0.5s;
  transform: translate3d(100%, 0, 0);
}
.nav-menu:after {
  position: absolute;
  top: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.2);
  content: "";
  opacity: 1;
  transition: opacity 0.5s;
  display: none;
}
.nav-menu h2 {
  margin: 0;
  padding: 1em;
  color: rgba(0, 0, 0, 0.4);
  text-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
  font-weight: 300;
  font-size: 2em;
}
.nav-menu ul {
  margin: 0;
  padding: 0;
  list-style-type: none;
}
.nav-menu li a {
  display: block;
  padding: 1em 1em 1em 1.2em;
  outline: none;
  box-shadow: inset 0 -1px rgba(0, 0, 0, 0.2);
  color: #f3efe0;
  text-transform: uppercase;
  text-shadow: 0 0 1px rgba(255, 255, 255, 0.1);
  letter-spacing: 1px;
  font-weight: 400;
  transition: background 0.3s, box-shadow 0.3s;
}
.nav-menu li:first-child a {
  box-shadow: inset 0 -1px rgba(0, 0, 0, 0.2), inset 0 1px rgba(0, 0, 0, 0.2);
}
.nav-menu li:hover {
  background: rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 -1px rgba(0, 0, 0, 0);
  color: #fff;
}

.nav-menu-open .nav-menu {
  visibility: visible;
  transform: translate3d(0, 0, 0);
}
.nav-menu-open .nav-menu:after {
  width: 0;
  height: 0;
  opacity: 0;
  transition: opacity 0.5s, width 0.1s 0.5s, height 0.1s 0.5s;
}

.main-overlay-nav {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none;
  background-color: rgba(49, 49, 49, 0.65);
}
.main-overlay-nav .overlay-full {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
#footer {
  margin-top: 60px;
  padding: 15px 0 20px;
  border-top: 1px solid #fff;
  background-color: rgba(49, 49, 49, 0.5);
}
#footer div,
#footer a,
#footer p {
  color: #fff;
  font-size: 12px;
  text-align: center;
}
</style>