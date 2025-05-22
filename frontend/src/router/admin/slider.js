import {requireAuth} from "../router-guards";

const sliderRoutes = [
    {
        path: 'sliders/create',
        name: 'SliderCreate',
        component: () => import('@/AdminViews/sliders/create.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'sliders',
        name: 'SliderIndex',
        component: () => import('@/AdminViews/sliders/index.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'slider/:id/edit',
        name: 'SliderEdit',
        component: () => import('@/AdminViews/sliders/edit.vue'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
];
export default sliderRoutes;
