import {requireAuth} from "../router-guards";

const genreRoutes = [
    {
        path: 'genres/create',
        name: 'GenreCreate',
        component: () => import('@/AdminViews/genres/create.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'genres',
        name: 'GenreIndex',
        component: () => import('@/AdminViews/genres/index.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'genre/:id/edit',
        name: 'GenreEdit',
        component: () => import('@/AdminViews/genres/edit.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default genreRoutes;
