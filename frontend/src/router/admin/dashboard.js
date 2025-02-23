import {requireAuth} from "../router-guards";

const dashboardRoutes = [
    {
        path: 'dashboard',
        name: 'DashboardView',
        component: () => import('@/AdminViews/Dashboard.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'map',
        name: 'MapComponent',
        component: () => import('@/AdminViews/MapComponent.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'map/:id',
        name: 'LocationMap',
        component: () => import('@/AdminViews/LocationMap.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default dashboardRoutes;
