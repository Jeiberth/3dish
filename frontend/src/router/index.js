// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Main from '../views/Main.vue';
import publicWeb from '../views/publicWeb.vue';
import demo from '../views/demo.vue';
import { useUserStore } from '../stores/user';

const routes = [
    { path: '/', component: publicWeb },
    { path: '/demo', component: demo },
    { path: '/login', component: Login },
    { path: '/dashboard', component: Main, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const userStore = useUserStore();
    if (to.meta.requiresAuth && !userStore.token) next('/login');
    else next();
});

export default router;
