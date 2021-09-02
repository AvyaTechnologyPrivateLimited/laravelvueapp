import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Books from '../components/Products';
import AddBook from '../components/AddProduct';
import EditBook from '../components/EditProduct';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'products',
        path: '/products',
        component: Books
    },
    {
        name: 'addproduct',
        path: '/products/add',
        component: AddBook
    },
    {
        name: 'editproduct',
        path: '/products/edit/:id',
        component: EditBook
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
