import {requireAuth} from "../router-guards";

const dashboardRoutes = [
    {
        path: 'dashboard',
        name: 'DashboardView',
        component: () => import('@/AdminViews/Dashboard.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default dashboardRoutes;
