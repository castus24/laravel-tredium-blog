import Homepage from '../pages/Homepage.vue'
import Catalog from '../pages/Catalog.vue';
import Article from '../pages/Article.vue';

export default [
    {
        path: '/',
        name: 'home',
        component: Homepage,
    },
    {
        path: '/articles',
        name: 'articles',
        component: Catalog,
    },
    {
        path: '/articles/:slug',
        name: 'articleDetail',
        component: Article,
        props: true,
    },
];
