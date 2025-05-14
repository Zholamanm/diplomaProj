import dashboardRoutes from "@/router/admin/dashboard";
import bookRoutes from "@/router/admin/book";
import borrowRoutes from "@/router/admin/borrow";
import blackListRoutes from "@/router/admin/blackList";
import Login from "@/views/Login.vue";
import categoryRoutes from "@/router/admin/category";
import tagRoutes from "@/router/admin/tag";

const adminRoutes = [
    ...dashboardRoutes,
    ...bookRoutes,
    ...borrowRoutes,
    ...blackListRoutes,
    ...categoryRoutes,
    ...tagRoutes,
    {
        path: 'login',
        name: 'login',
        component: Login
    },
];

export default adminRoutes;
