import Catalog from "@/ClientViews/Catalog.vue";
import CategoryView from "@/ClientViews/CategoryView.vue";
import BorrowMap from "@/ClientViews/BorrowMap.vue";
import BorrowBook from "@/ClientViews/BorrowBook.vue";
import Main from "@/ClientViews/Main.vue";
import Login from "@/views/Login.vue";
import Register from "@/views/UserRegister.vue";
import Checkout from "@/ClientViews/Checkout.vue";
import Favourites from "@/ClientViews/Favourites.vue";
import About from "@/ClientViews/About.vue";
import Book from "@/ClientViews/Book.vue";
import Home from "@/ClientViews/Home.vue";

const clientRoutes = [
    {
        path: '',
        name: 'ClientMainView',
        component: Main,
        children: [
            {
                path: '',
                name: 'HomeView',
                component: Home,
            },
            {
                path: 'catalog',
                name: 'CatalogView',
                component: Catalog,
            },
            {
                path: 'category/:id',
                name: 'CategoryView',
                component: CategoryView,
            },
            {
                path: 'checkout',
                name: 'CheckoutView',
                component: Checkout,
            },
            {
                path: 'favourites',
                name: 'FavouriteView',
                component: Favourites,
            },
            {
                path: 'book/:id',
                name: 'BookView',
                component: Book,
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
            {
                path: 'about',
                name: 'AboutView',
                component: About,
            },
        ],
    },
    {
        path: 'login',
        name: 'login',
        component: Login
    },
    {
        path: 'register',
        name: 'UserRegister',
        component: Register
    },
];

export default clientRoutes;
