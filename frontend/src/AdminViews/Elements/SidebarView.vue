<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
<!--      <img src="http://localhost:8080/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
      <span class="brand-text font-weight-light">Diploma Project</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="http://localhost:8080/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $store.state.user.user.name }}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li v-for="route in routes.filter((i)=>i.access)" :key="route.name" class="mt-3 nav-item"
              style="height: auto">
            <router-link
                :class="{'dark:bg-green-600 dark:text-green-300 bg-green-100 text-green-800':route.child.includes($route.name)}"
                :to="{name:route.name,params:{locale: $route.params.locale}}"
                class="nav-link text-start flex flex-row items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-green-200 dark:hover:bg-green-700 group"
                style="cursor:pointer;height: auto">
              <span class="" v-html="route.svg"></span>
              <span class="ms-3">{{ route.label }}</span>
            </router-link>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>

export default {
  name: 'SidebarView',
  data() {
    return {
      routes: [
        {
          name: 'BookIndex',
          label: 'Books',
          child: ['BookIndex', 'BookCreate', 'BookEdit', 'BookView'],
          access: [1, 2].includes(this.$store.state.user.user.role_id),
          svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.5 2a7 7 0 0 0-.5 0 1 1 0 0 0-1 1v8c0 .6.4 1 1 1h8c.5 0 1-.4 1-1v-.5A8.5 8.5 0 0 0 13.5 2Z"/>
                    <path d="M11 6a1 1 0 0 0-1-1 8.5 8.5 0 1 0 9 9 1 1 0 0 0-1-1h-7V6Z"/>
                </svg>
                `
        },
        {
          name: 'CategoryIndex',
          label: 'Categories',
          child: ['CategoryIndex', 'CategoryCreate', 'CategoryEdit', 'CategoryView'],
          access: [1, 2].includes(this.$store.state.user.user.role_id),
          svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.5 2a7 7 0 0 0-.5 0 1 1 0 0 0-1 1v8c0 .6.4 1 1 1h8c.5 0 1-.4 1-1v-.5A8.5 8.5 0 0 0 13.5 2Z"/>
                    <path d="M11 6a1 1 0 0 0-1-1 8.5 8.5 0 1 0 9 9 1 1 0 0 0-1-1h-7V6Z"/>
                </svg>
                `
        },
        {
          name: 'TagIndex',
          label: 'Tags',
          child: ['TagIndex', 'TagCreate', 'TagEdit', 'TagView'],
          access: [1, 2].includes(this.$store.state.user.user.role_id),
          svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.5 2a7 7 0 0 0-.5 0 1 1 0 0 0-1 1v8c0 .6.4 1 1 1h8c.5 0 1-.4 1-1v-.5A8.5 8.5 0 0 0 13.5 2Z"/>
                    <path d="M11 6a1 1 0 0 0-1-1 8.5 8.5 0 1 0 9 9 1 1 0 0 0-1-1h-7V6Z"/>
                </svg>
                `
        },
        // {
        //   name: 'UserIndex',
        //   label: 'Users',
        //   child: ['UserIndex', 'UserCreate', 'UserEdit', 'UserView'],
        //   access: [1].includes(this.$store.state.user.user.role_id),
        //   svg: `<svg class="w-7 h-7 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        //             <path d="M13.5 2a7 7 0 0 0-.5 0 1 1 0 0 0-1 1v8c0 .6.4 1 1 1h8c.5 0 1-.4 1-1v-.5A8.5 8.5 0 0 0 13.5 2Z"/>
        //             <path d="M11 6a1 1 0 0 0-1-1 8.5 8.5 0 1 0 9 9 1 1 0 0 0-1-1h-7V6Z"/>
        //         </svg>
        //         `
        // },
      ],
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
<style scoped>
.main-sidebar{
  z-index: 0;
}
/* === Light Mode === */
.bg-green-100 {
  background-color: #D1FAE5 !important; /* Tailwind's bg-green-100 */
}

.text-green-800 {
  color: #065F46 !important; /* Tailwind's text-green-800 */
}

/* === Dark Mode === */
@media (prefers-color-scheme: dark) {
  .dark\:bg-green-600 {
    background-color: #047857 !important; /* Tailwind's dark:bg-green-600 */
  }

  .dark\:text-green-300 {
    color: #6EE7B7 !important; /* Tailwind's dark:text-green-300 */
  }
}
/* === Light Mode === */
.flex {
  display: flex !important;
}

.flex-row {
  flex-direction: row !important;
}

.items-center {
  align-items: center !important;
}

.p-2 {
  padding: 0.5rem !important; /* 8px */
}

.text-gray-900 {
  color: #111827 !important; /* Tailwind's text-gray-900 */
}

.rounded-lg {
  border-radius: 0.5rem !important; /* 8px */
}

.hover\:bg-green-200:hover {
  background-color: #BBF7D0 !important; /* Tailwind's hover:bg-green-200 */
}

/* === Dark Mode === */
@media (prefers-color-scheme: dark) {
  .dark\:text-white {
    color: #ffffff !important; /* Tailwind's dark:text-white */
  }

  .dark\:hover\:bg-green-700:hover {
    background-color: #047857 !important; /* Tailwind's dark:hover:bg-green-700 */
  }
}

/* === Group Hover Effect === */
.group:hover .group-hover\:bg-green-200 {
  background-color: #BBF7D0 !important; /* Tailwind's group-hover:bg-green-200 */
}

@media (prefers-color-scheme: dark) {
  .group:hover .dark\:group-hover\:bg-green-700 {
    background-color: #047857 !important; /* Tailwind's dark:group-hover:bg-green-700 */
  }
}

</style>