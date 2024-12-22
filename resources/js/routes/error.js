import NotFound404 from "@/pages/PageNotFound.vue";

export const errorRoutes = [
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: NotFound404,
    },
];
