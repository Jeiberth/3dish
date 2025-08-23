<template>
  <div :data-theme="themeStore.currentTheme" class="layout">
    <TopBar v-if="isAuthenticated" />
    <main class="content">
      <router-view />
    </main>
    <Footer v-if="isAuthenticated" />
  </div>
</template>


<script setup>
import TopBar from './components/TopBar.vue';
import Footer from './components/Footer.vue';
import { useThemeStore } from './stores/theme';
import { useUserStore } from './stores/user'; // adjust path if different
import { computed } from 'vue';

const themeStore = useThemeStore();
const userStore = useUserStore();

// Computed property to check if token is defined
const isAuthenticated = computed(() => !!userStore.token);

</script>

<style src="@/assets/main.css"></style>
