import {checkIfAdmin, requireAuth} from "../router-guards";
import UsersItem from "../../views/AdminViews/Users/UsersItem";

const usersRoutes = [
    {
        path: 'users',
        name: 'userList',
        component: () => import('../../views/AdminViews/Users/UsersList'),
        // component: ListApplications,
        beforeEnter: requireAuth,
    },
    {
        path: 'users/create',
        name: 'userItemCreate',
        // component: () => import('./../views/Users/UsersItem'),
        component: UsersItem,
        beforeEnter: requireAuth,
    },
    {
        path: 'users/:id',
        name: 'userItem',
        // component: () => import('./../views/Users/UsersItem'),
        component: UsersItem,
        beforeEnter: requireAuth,
    },

];
export default usersRoutes;
