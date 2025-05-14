import {requireAuth} from "../router-guards";

const blackListRoutes = [
    {
        path: 'black-list',
        name: 'BlackListIndex',
        component: () => import('@/AdminViews/blackList/index.vue'),
        beforeEnter: requireAuth,
    },
];
export default blackListRoutes;
