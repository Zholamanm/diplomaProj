import Catalog from "@/ClientViews/Catalog.vue";
import BorrowMap from "@/ClientViews/BorrowMap.vue";
import BorrowBook from "@/ClientViews/BorrowBook.vue";
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
            {
                path: 'map/:id',
                name: 'BorrowMap',
                component: BorrowMap,
            },
            {
                path: 'map/:id/:locId',
                name: 'BorrowBook',
                component: BorrowBook,
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
