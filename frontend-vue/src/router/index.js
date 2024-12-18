import { createRouter, createWebHistory } from "vue-router";

import Home from "../pages/Home.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/books',
        name: 'Books',
        component: () => import('../pages/Books.vue'),
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
    {
        path: '/create-user/',
        name: 'CreateUser',
        component: () => import('../pages/user/FormUser.vue')
    },
    {
        path: '/edit-user/:id',
        name: 'EditUser',
        component: () => import('../pages/user/FormEditUser.vue')
    },
    {
        path: '/create-book',
        name: 'CreateBook',
        component: () => import('../pages/book/FormCreateBook.vue')
    },
    {
        path: '/edit-book/:id',
        name: 'EditBook',
        component: () => import('../pages/book/FormEditBook.vue')
    },
    {
        path: '/book-details/:id',
        name: 'BookDetails',
        component: () => import('../components/BookDetails.vue')
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active',
});

export default router;