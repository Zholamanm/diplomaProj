import {requireAuth} from "../router-guards";

const categoryRoutes = [
    {
        path: 'categories/create',
        name: 'CategoryCreate',
        component: () => import('@/AdminViews/categories/create.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'categories',
        name: 'CategoryIndex',
        component: () => import('@/AdminViews/categories/index.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'category/:id/edit',
        name: 'CategoryEdit',
        component: () => import('@/AdminViews/categories/edit.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default categoryRoutes;
