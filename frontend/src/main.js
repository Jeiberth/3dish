// src/main.js
import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import en from './locales/en';
import fr from './locales/fr';
import es from './locales/es';
import '@fortawesome/fontawesome-free/css/all.css'
import 'bootstrap/dist/css/bootstrap.min.css'

const i18n = createI18n({
    locale: 'en',
      legacy: false,
    messages: { en, fr, es },
});

const app = createApp(App);
app.use(router).use(i18n).use(createPinia()).mount('#app');
