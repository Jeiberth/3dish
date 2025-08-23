// src/stores/user.js
import { defineStore } from 'pinia';
import axios from 'axios';
import { MenuResource } from "@/api/MenuResource"

const menuResource = new MenuResource();

export const useUserStore = defineStore('user', {
    state: () => ({
        token: localStorage.getItem('token') || null,
        isAdmin: false,
    }),
    actions: {
        async login(credentials) {
            const response = await menuResource.login(credentials);
            this.token = response.token;
            this.isAdmin = response.user.admin;
            localStorage.setItem('token', this.token);
        },
        logout() {
            this.token = null;
            this.isAdmin = false;
            localStorage.removeItem('token');
        },
    },
});
