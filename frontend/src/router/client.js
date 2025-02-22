import Catalog from "@/ClientViews/Catalog.vue";
import Main from "@/ClientViews/Main.vue";

const clientRoutes = [
    {
        path: '/client',
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
];

export default clientRoutes;
