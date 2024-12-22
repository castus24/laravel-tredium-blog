const Login = () => import('@/pages/auth/Login.vue');
const Register = () => import('@/pages/auth/Register.vue');
const PasswordForgot = () => import('@/pages/auth/password/PasswordForgot.vue');
const PasswordReset = () => import('@/pages/auth/password/PasswordReset.vue');
const PasswordLayout = () => import('@/pages/auth/password/PasswordLayout.vue');

export const authRoutes = [
    {
        path: 'login',
        name: 'login',
        component: Login,
    },
    {
        path: 'register',
        name: 'register',
        component: Register,
    },
    {
        path: 'password',
        component: PasswordLayout,
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
];
