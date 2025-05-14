import {requireAuth} from "../router-guards";

const borrowRoutes = [
    {
        path: 'borrows',
        name: 'BorrowIndex',
        component: () => import('@/AdminViews/borrows/index.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default borrowRoutes;
