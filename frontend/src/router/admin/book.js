import {requireAuth} from "../router-guards";

const bookRoutes = [
    {
        path: 'books/create',
        name: 'BookCreate',
        component: () => import('@/AdminViews/books/create.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'book/:id',
        name: 'BookView',
        component: () => import('@/AdminViews/books/view.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'books',
        name: 'BookIndex',
        component: () => import('@/AdminViews/books/index.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'book/:id/edit    ',
        name: 'BookEdit',
        component: () => import('@/AdminViews/books/edit.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default bookRoutes;
