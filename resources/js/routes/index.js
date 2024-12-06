import Homepage from '../pages/Homepage.vue'
import ArticleCatalog from '../pages/ArticleCatalog.vue';
import ArticleDetail from '../pages/ArticleDetail.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';

import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Homepage,
    },
    {
        path: '/articles',
        name: 'articles',
        component: ArticleCatalog,
    },
    {
        path: '/articles/:slug',
        name: 'articleDetail',
        component: ArticleDetail,
        props: true,
    },
    {
        path: "/login",
        name: "login",
        component: Login
    },
    {
        path: "/register",
        name: "register",
        component: Register
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: 'login' });
    } else {
        next();
    }
});

export default router;
