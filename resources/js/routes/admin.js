const Dashboard = () => import('@/pages/admin/Dashboard.vue');
const Article = () => import('@/pages/admin/crud/Article.vue');
const Tag = () => import('@/pages/admin/crud/Tag.vue');
const Role = () => import('@/pages/admin/crud/Role.vue');
const Permission = () => import('@/pages/admin/crud/Permission.vue');
const User = () => import('@/pages/admin/crud/User.vue');

export const adminRoutes = [
    {
        path: '',
        name: 'dashboard',
        component: Dashboard,
    },
    {
        path: 'articles',
        name: 'articlesCrud',
        component: Article,
    },
    {
        path: 'tags',
        name: 'tagsCrud',
        component: Tag,
    },
    {
        path: 'roles',
        name: 'rolesCrud',
        component: Role,
    },
    {
        path: 'permissions',
        name: 'permissionsCrud',
        component: Permission,
    },
    {
        path: 'users',
        name: 'usersCrud',
        component: User,
    },
];
