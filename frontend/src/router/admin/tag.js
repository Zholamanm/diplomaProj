import {requireAuth} from "../router-guards";

const tagRoutes = [
    {
        path: 'tags/create',
        name: 'TagCreate',
        component: () => import('@/AdminViews/tags/create.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'book/:id',
        name: 'TagView',
        component: () => import('@/AdminViews/tags/view.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'tags',
        name: 'TagIndex',
        component: () => import('@/AdminViews/tags/index.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'book/:id/edit    ',
        name: 'TagEdit',
        component: () => import('@/AdminViews/tags/edit.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default tagRoutes;
