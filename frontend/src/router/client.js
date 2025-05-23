import Catalog from "@/ClientViews/Catalog.vue";
import CategoryView from "@/ClientViews/CategoryView.vue";
import GenreView from "@/ClientViews/GenreView.vue";
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
import UserProfile from "@/ClientViews/UserProfile.vue";
import UserPage from "@/ClientViews/UserPage.vue";
import FriendList from "@/ClientViews/FriendList.vue";
import chat from "@/ClientViews/Elements/ChatWindow.vue";
import { requireAuth } from './router-guards'

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
                path: 'genre/:id',
                name: 'GenreView',
                component: GenreView,
            },
            {
                path: 'checkout',
                name: 'CheckoutView',
                component: Checkout,
                beforeEnter: requireAuth,
            },
            {
                path: 'favourites',
                name: 'FavouriteView',
                component: Favourites,
                beforeEnter: requireAuth,
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
                beforeEnter: requireAuth,
            },
            {
                path: 'map/:id/:locId',
                name: 'BorrowBook',
                component: BorrowBook,
                beforeEnter: requireAuth,
            },
            {
                path: 'about',
                name: 'AboutView',
                component: About,
            },
            {
                path: 'profile',
                name: 'UserProfile',
                component: UserProfile,
                beforeEnter: requireAuth,
            },
            {
                path: 'user/:id',
                name: 'UserPage',
                component: UserPage,
            },
            {
                path: 'friends',
                name: 'FriendList',
                component: FriendList,
                beforeEnter: requireAuth,
            },
            {
                path: 'chat/:userId',
                name: 'chat',
                component: chat,
                beforeEnter: requireAuth,
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
