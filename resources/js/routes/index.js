import Homepage from '../pages/Homepage.vue'
import ArticleCatalog from '../pages/articles/ArticleCatalog.vue';
import ArticleDetail from '../pages/articles/ArticleDetail.vue';
import Login from '../pages/auth/Login.vue';
import Register from '../pages/auth/Register.vue';
import PasswordForgot from "../pages/auth/password/PasswordForgot.vue";
import PasswordReset from "../pages/auth/password/PasswordReset.vue";
import NotFound404 from "../pages/NotFound404.vue";
import PasswordWrapper from "../pages/auth/password/PasswordWrapper.vue";
import Profile from "../pages/user/Profile.vue";

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
    {
        path: '/password',
        component: PasswordWrapper,
        children: [
            {
                path: 'email',
                name: 'resetLink',
                component: PasswordForgot,
            },
            {
                path: 'reset',
                name: 'passwordReset',
                component: PasswordReset,
            },
        ],
    },
    {
        path: "/user/profile",
        name: "profile",
        component: Profile
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: NotFound404,
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
