import { createRouter, createWebHistory } from "vue-router";

import Home from "../pages/Home.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../pages/Login.vue')
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('../pages/Register.vue')
    },
    {
        path: '/forgot',
        name: 'Forgot',
        component: () => import('../pages/Forgot.vue')
    },
    {
        path: '/password-reset/:token',
        name: 'PasswordReset',
        component: () => import('../pages/ResetPassword.vue')
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active',
});

export default router;