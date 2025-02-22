import dashboardRoutes from "@/router/admin/dashboard";
import bookRoutes from "@/router/admin/book";
import Login from "@/views/Login.vue";
import categoryRoutes from "@/router/admin/category";
import tagRoutes from "@/router/admin/tag";

const adminRoutes = [
    ...dashboardRoutes,
    ...bookRoutes,
    ...categoryRoutes,
    ...tagRoutes,
    {
        path: 'login',
        name: 'login',
        component: Login
    },
];

export default adminRoutes;
