// src/stores/theme.js
import { defineStore } from 'pinia';

export const useThemeStore = defineStore('theme', {
    state: () => ({
        currentTheme: localStorage.getItem('theme') || 'light',
    }),
    actions: {
        toggleTheme() {
            this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', this.currentTheme);
        },
    },
});
