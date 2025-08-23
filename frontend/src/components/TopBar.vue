<template>

    <div style="background-color: #f1f1f1;">
        <div class="row" style="background-color: #f1f1f1; height: 100px;  align-items: center; max-width: 1280px; margin-inline: auto; padding: 16px 24px;">
            <div class="col-4">
                <button
                    @click="openUserModal"
                    class="hoverAnimation"
                    style="background-color: white; border-radius: 50px; color: black; border: 0px; padding: 12px; font-weight: 700;"
                >
                    +<i class="fa-solid fa-user"></i>
                </button>
                <!-- <button
                    @click="openUserDish"
                    class="hoverAnimation ms-3"
                    style="background-color: white; border-radius: 50px; color: black; border: 0px; padding: 12px; font-weight: 700;"
                >
                    +<i class="fa-solid fa-sitemap"></i>
                </button> -->
            </div>
            <div class="col-4" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <img src="@/assets/icons/icon_transparent.png" alt="Logo" style="height: 70px; width: auto; border-radius: 0px; padding: 0px;" class="logo-mobile"/>
                <img src="@/assets/icons/logo_transparent.png" alt="Logo" style="height: 70px; width: auto; border-radius: 0px; padding: 0px;" class="logo-desktop"/>
            </div>
            <div class="col-4" style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                <div class="top-bar__select-wrapper">
                    <select v-model="$i18n.locale" class="top-bar__select">
                        <option value="en">EN</option>
                        <option value="fr">FR</option>
                        <option value="es">ES</option>
                    </select>
                </div>
                <button
                    @click="logout"
                    class="hoverAnimation"
                    style="background-color: white; border-radius: 50px; color: black; border: 0px; padding: 12px; font-weight: 700;"
                >
                    <!-- {{ $t('topBar.logout') }} -->
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>
        </div>
    </div>

  <UserModal v-if="showUserModal" @close="showUserModal = false" />

</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useUserStore } from '../stores/user';
import { useThemeStore } from '../stores/theme';
import { useRouter } from 'vue-router';
import UserModal from './UserModal.vue';

const userStore = useUserStore();
const themeStore = useThemeStore();
const router = useRouter();

const logout = () => {
  userStore.logout();
  router.push('/login');
};

const showUserModal = ref(false);
const openUserModal = () => {
  showUserModal.value = true;
};

const openUserDish = () => {
//   showUserDish.value = true;
};

</script>

<style scoped>
.top-bar {
  background-color: var(--background);
  border-bottom: 1px solid var(--border);
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(10px);
  background-color: rgba(var(--background-rgb), 0.95);
}

.top-bar__container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 4rem;
}

.top-bar__brand {
  display: flex;
  align-items: center;
}

.top-bar__logo {
  height: 2rem;
  width: auto;
  object-fit: contain;
}

.top-bar__actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.top-bar__button {
  padding: 0.5rem 1rem;
  border: 1px solid var(--border);
  border-radius: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  background-color: var(--background);
  color: var(--text-primary);
  min-height: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.top-bar__button:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(var(--primary-rgb), 0.15);
}

.top-bar__button--primary {
  background-color: var(--primary);
  color: white;
  border-color: var(--primary);
}

.top-bar__button--primary:hover {
  background-color: var(--secondary);
  border-color: var(--secondary);
}

.top-bar__button--secondary {
  color: var(--text-secondary);
}

.top-bar__button--secondary:hover {
  color: var(--text-primary);
  border-color: var(--primary);
}

.top-bar__button--icon {
  padding: 0.5rem;
  min-width: 2.5rem;
}

.top-bar__theme-icon {
  font-size: 1.125rem;
}

.top-bar__select-wrapper {
  position: relative;
}

.top-bar__select {
  appearance: none;
  background-color: white;
  border: 0px solid var(--border);
  border-radius: 50px;
  height: 100%;
  width: 60px;
  padding: 12px;
  color: black;
  cursor: pointer;
   font-weight: 700;
  transition: all 0.2s ease;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1rem;
}

.top-bar__select:hover {
  border-color: var(--primary);
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(var(--primary-rgb), 0.15);
}


.top-bar__select:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .top-bar__container {
    padding: 0 0.75rem;
    height: 3.5rem;
  }

  .top-bar__actions {
    gap: 0.5rem;
  }

  .top-bar__button {
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
    min-height: 2.25rem;
  }

  .top-bar__button--icon {
    padding: 0.375rem;
    min-width: 2.25rem;
  }

  .top-bar__select {
    height: 2.25rem;
    font-size: 0.8rem;
    min-width: 3.5rem;
    padding: 0.375rem 1.75rem 0.375rem 0.5rem;
  }

  .top-bar__logo {
    height: 1.75rem;
  }
}

@media (max-width: 480px) {
  .top-bar__container {
    flex-wrap: wrap;
    height: auto;
    min-height: 3.5rem;
    padding: 0.5rem;
  }

  .top-bar__actions {
    width: 100%;
    justify-content: center;
    margin-top: 0.5rem;
  }

  .top-bar__button {
    flex: 1;
    max-width: none;
  }

  .top-bar__button--icon {
    flex: 0 0 auto;
    min-width: 2.25rem;
  }
}

.logo-desktop {
  display: block;
}

.logo-mobile {
  display: none;
}

@media (max-width: 655px) {
  .logo-desktop {
    display: none;
  }

  .logo-mobile {
    display: block;
  }
}

</style>
