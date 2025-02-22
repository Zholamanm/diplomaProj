import { requireAuth } from "../router-guards";

const userLogs = [
    {
        path: 'user-logs/',
        name: 'userLogs',
        component: () => import('../../views/AdminViews/UserLogs/Index'),
        beforeEnter: requireAuth,
    },
];

export default userLogs;
