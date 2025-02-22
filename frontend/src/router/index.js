import { createRouter, createWebHistory, RouterView } from 'vue-router';
import {checkLocale, requireAuth} from "./router-guards";
import RegisterPage from '@/views/UserRegister.vue'; 
import Login from '@/views/Login.vue';
import Home from '@/views/Home.vue';
import clientRoutes from "@/router/client";
import adminRoutes from "@/router/admin";

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    beforeEnter: checkLocale,
  },
  {
    path: '/register',
    name: 'RegisterPage', 
    component: RegisterPage,
    beforeEnter: checkLocale,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    beforeEnter: checkLocale,
  },
  {
    path: "/:locale?",
    component: RouterView,
    beforeEnter: checkLocale,
    children: [
      {
        path: 'admin',
        beforeEnter: requireAuth,
        component: () => import("@/AdminViews/Main.vue"),
        children: [
          ...adminRoutes
        ]
      },
      ...clientRoutes,
      {
        path: ':pathMatch(.*)*',
        redirect:'/',
      }
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      setTimeout(() => { //т.к. при первом переходе window.scrollY равен "0", и выходит криво, nextTick не помогает
        const element = document.querySelector(to.hash);
        if (element) {
          const offset = 82; // высота меню
          const elementPosition = element.getBoundingClientRect().top + window.scrollY;
          const offsetPosition = elementPosition - offset;

          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
          });
        }
      }, 500);
    } else if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  }
});

// router.beforeEach((to, from, next) => {
//   if (to.matched.some((record) => record.meta.requiresAuth)) {
//     if (!localStorage.getItem('token')) {
//       next('/login');
//     } else {
//       next();
//     }
//   } else {
//     next();
//   }
// });

router.beforeEach((to, from, next) => {
  next();
});

export default router;
