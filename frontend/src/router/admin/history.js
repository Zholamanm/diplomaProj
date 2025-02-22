import {requireAuth} from "../router-guards";

const historyRoutes = [
    {
        path: 'history',
        name: 'historyList',
        component: () => import('../../views/AdminViews/History/HistoryList'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'history/:id',
        name: 'historyItem',
        component: () => import('../../views/AdminViews/History/HistoryItem'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'history/create',
        name: 'historyItemCreate',
        component: () => import('../../views/AdminViews/History/HistoryItem'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },


];
export default historyRoutes;
