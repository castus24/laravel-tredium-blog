import {createRouter, createWebHistory} from 'vue-router'
import {useAuthStore} from '@/stores/auth'
import UserLayout from "@/components/layouts/UserLayout.vue"
import AdminLayout from "@/components/layouts/AdminLayout.vue"

import {userRoutes} from '@/routes/user'
import {adminRoutes} from '@/routes/admin'
import {errorRoutes} from '@/routes/error'

const routes = [
    {
        path: '/',
        component: UserLayout,
        children: userRoutes,
    },
    {
        path: '/admin',
        component: AdminLayout,
        children: adminRoutes,
        meta: {requiresAdmin: true},
    },
    ...errorRoutes,
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()

    if (!authStore.isAuthenticated && !authStore.isLoading) {
        await authStore.initializeAuth();
    }

    if (to.meta.requiresAdmin) {
        if (!authStore.isAuthenticated) {
            next({name: 'login'});
        } else if (!authStore.isAdmin) {
            next({name: 'home'});
        } else {
            next();
        }
    } else if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({name: 'login'});
    } else {
        next();
    }
});

export default router
