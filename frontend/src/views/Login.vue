<template>

    <div v-if="loading" class="loading-overlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>


    <div class="row" style="height: 100vh; width: 100%; align-items: center; justify-content: center; align-content: center; margin: auto;">
        <div style="background-color: #f1f1f1; border-radius: 50px; padding: 20px; width: 400px; height: 350px;  box-shadow: 0 2px 8px rgba(146, 146, 146, 0.726);">
            <div class="row">
                <div class="col-12" style="display: flex; justify-content: center;">
                    <img src="@/assets/icons/icon_transparent.png" alt="Logo" style="height: 100px; "/>
                </div>
                <div class="col-12" style="display: flex; justify-content: center; margin-top: 10px;">
                    <h2>{{ $t("Welcome to Menu-AR") }}</h2>
                </div>
                <!-- <div class="col-12" style="display: flex; justify-content: center;">
                    <h4>Sign in to your Account</h4>
                </div> -->
                <div class="col-12" style="display: flex; justify-content: center; margin: 10px 0;">
                    <input
                        v-model="email"
                        type="email"
                        :placeholder="$t('login.email')"
                        required
                        style="background-color: white; border: 0px; border-radius: 50px; color: black; padding-left: 10px; width: 350px; height: 36px;"
                        autocomplete="email"
                    />
                </div>
                <div class="col-12" style="display: flex; justify-content: center; margin: 10px 0;">
                    <input
                        v-model="password"
                        type="password"
                        :placeholder="$t('login.password')"
                        required
                        style="background-color: white; border: 0px; border-radius: 50px; color: black; padding-left: 10px; width: 350px; height: 36px;"
                        autocomplete="current-password"
                    />
                </div>
                <div class="col-12" style="display: flex; justify-content: center; margin: 10px 0;">
                    <button @click="login" type="submit" class="hoverAnimation" style="background-color: white; border: 0px; border-radius: 50px; color: black; width: 70px; height: 36px; font-weight: 700;">
                        {{ $t('login.loginButton') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/user';
import Swal from 'sweetalert2'

const email = ref('');
const password = ref('');
const router = useRouter();
const userStore = useUserStore();

const loading = ref(false);

const login = async () => {
  try {
    loading.value = true;
    await userStore.login({
      email: email.value,
      password: password.value
    });
    router.push('/');
  } catch (error) {
    console.log(error);
    Swal.fire({
        title: 'Error!',
        text: 'The credentials are not correct.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* Page Layout */
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  padding: 1rem;
  position: relative;
  overflow: hidden;
}

/* Background Decoration */
.bg-decoration {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  pointer-events: none;
  z-index: 1;
}

.bg-circle {
  position: absolute;
  border-radius: 50%;
  background: rgba(var(--background-rgb), 0.1);
  backdrop-filter: blur(10px);
  animation: float 6s ease-in-out infinite;
}

.bg-circle-1 {
  width: 200px;
  height: 200px;
  top: 10%;
  left: 10%;
  animation-delay: 0s;
}

.bg-circle-2 {
  width: 150px;
  height: 150px;
  top: 60%;
  right: 15%;
  animation-delay: 2s;
}

.bg-circle-3 {
  width: 100px;
  height: 100px;
  bottom: 20%;
  left: 20%;
  animation-delay: 4s;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(180deg);
  }
}

/* Container */
.login-container {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
}

/* Card */
.login-card {
  background: rgba(var(--background-rgb), 0.95);
  backdrop-filter: blur(20px);
  border-radius: 20px;
  padding: 2.5rem;
  box-shadow:
    0 20px 25px -5px rgba(0, 0, 0, 0.1),
    0 10px 10px -5px rgba(0, 0, 0, 0.04);
  border: 1px solid rgba(var(--background-rgb), 0.2);
  transition: all 0.3s ease;
}

.login-card:hover {
  transform: translateY(-5px);
  box-shadow:
    0 25px 50px -12px rgba(0, 0, 0, 0.15),
    0 10px 20px -5px rgba(0, 0, 0, 0.1);
}

/* Logo Section */
.logo-section {
  text-align: center;
  margin-bottom: 2.5rem;
}

.logo-wrapper {
  display: inline-flex;
  padding: 1rem;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border-radius: 20px;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.3);
  transition: all 0.3s ease;
}

.logo-wrapper:hover {
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(var(--primary-rgb), 0.4);
}

.logo {
  width: 60px;
  height: 60px;
  object-fit: contain;
  filter: brightness(0) invert(1);
}

.brand-title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.5rem 0;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.brand-subtitle {
  font-size: 1rem;
  color: var(--text-secondary);
  margin: 0;
  font-weight: 400;
}

/* Form */
.login-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

/* Input Groups */
.input-group {
  position: relative;
}

.input-wrapper {
  position: relative;
}

.input-field {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 2px solid var(--border);
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 500;
  color: var(--text-primary);
  background: var(--background);
  transition: all 0.3s ease;
  outline: none;
  box-sizing: border-box;
}

.input-field:focus {
  border-color: var(--primary);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(var(--primary-rgb), 0.15);
}

.input-field::placeholder {
  color: var(--text-secondary);
  font-weight: 400;
}

.input-border {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border-radius: 0 0 12px 12px;
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.input-field:focus + .input-border {
  transform: scaleX(1);
}

/* Button */
.login-button {
  position: relative;
  width: 100%;
  padding: 1rem 1.5rem;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border: none;
  border-radius: 12px;
  color: white;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(var(--primary-rgb), 0.4);
}

.login-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(var(--primary-rgb), 0.5);
}

.login-button:active {
  transform: translateY(0);
}

.button-text {
  position: relative;
  z-index: 2;
}

.button-ripple {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, var(--secondary), var(--primary));
  transform: translateX(-100%);
  transition: transform 0.3s ease;
  z-index: 1;
}

.login-button:hover .button-ripple {
  transform: translateX(0);
}

/* Footer */
.login-footer {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid var(--border);
}

.footer-text {
  font-size: 0.9rem;
  color: var(--text-secondary);
  margin: 0;
}

.footer-link {
  color: var(--primary);
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: var(--secondary);
  text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 480px) {
  .login-page {
    padding: 1rem 0.5rem;
  }

  .login-card {
    padding: 2rem 1.5rem;
    border-radius: 16px;
  }

  .brand-title {
    font-size: 1.75rem;
  }

  .logo {
    width: 50px;
    height: 50px;
  }

  .logo-wrapper {
    padding: 0.75rem;
  }

  .input-field {
    padding: 0.875rem 1rem;
    font-size: 0.95rem;
  }

  .login-button {
    padding: 0.875rem 1.25rem;
    font-size: 0.95rem;
  }

  .bg-circle-1 {
    width: 120px;
    height: 120px;
  }

  .bg-circle-2 {
    width: 90px;
    height: 90px;
  }

  .bg-circle-3 {
    width: 60px;
    height: 60px;
  }
}

@media (max-width: 320px) {
  .login-card {
    padding: 1.5rem 1rem;
  }

  .brand-title {
    font-size: 1.5rem;
  }
}

/* Loading state animation */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

.login-button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  animation: pulse 1.5s infinite;
}
</style>
