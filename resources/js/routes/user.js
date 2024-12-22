const Homepage = () => import('@/pages/Homepage.vue');
const ArticleLayout = () => import('@/pages/articles/ArticleLayout.vue');
const ArticleCatalog = () => import('@/pages/articles/ArticleCatalog.vue');
const ArticleDetail = () => import('@/pages/articles/ArticleDetail.vue');
const Profile = () => import('@/pages/user/Profile.vue');

import { authRoutes } from '@/routes/auth';

export const userRoutes = [
    {
        path: '',
        name: 'home',
        component: Homepage,
    },
    {
        path: 'articles',
        component: ArticleLayout,
        children: [
            {
                path: '',
                name: 'articles',
                component: ArticleCatalog,
            },
            {
                path: ':slug',
                name: 'articleDetail',
                component: ArticleDetail,
                props: true,
            },
        ],
    },
    {
        path: 'profile',
        name: 'profile',
        component: Profile,
    },
    ...authRoutes,
];
