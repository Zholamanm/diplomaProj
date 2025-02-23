import Catalog from "@/ClientViews/Catalog.vue";
import Main from "@/ClientViews/Main.vue";
import Login from "@/views/Login.vue";

const clientRoutes = [
    {
        path: '',
        name: 'ClientMainView',
        component: Main,
        children: [
            {
                path: 'catalog',
                name: 'CatalogView',
                component: Catalog,
            },
        ],
    },
    {
        path: 'login',
        name: 'login',
        component: Login
    },
];

export default clientRoutes;
