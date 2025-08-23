<!-- src/components/Footer.vue -->
<template>
  <footer class="footer">
    <div class="footer__container">
      <!-- Copyright Section -->
      <div class="footer__copyright">
        <p class="footer__text">
          © {{ currentYear }} MenuAR. {{ $t('footer.rights') }}
        </p>
      </div>

      <!-- Social Icons Section -->
      <div class="footer__social">
        <a
          href="#"
          class="footer__social-link"
          aria-label="Facebook"
        >
          <i class="fab fa-facebook"></i>
        </a>
        <a
          href="#"
          class="footer__social-link"
          aria-label="Instagram"
        >
          <i class="fab fa-instagram"></i>
        </a>
        <a
          href="#"
          class="footer__social-link"
          aria-label="TikTok"
        >
          <i class="fab fa-tiktok"></i>
        </a>
      </div>
    </div>
  </footer>
</template>

<script setup>

    import { computed } from 'vue';

    const currentYear = computed(() => new Date().getFullYear());

</script>

<style scoped>

    .footer {
        background-color: rgba(236, 236, 236, 0.718);
        border-top: 0px solid var(--border);
        margin-top: auto;
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg,
            transparent,
            rgba(var(--primary-rgb), 0.3),
            transparent
        );
    }

    .footer__container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .footer__copyright {
        flex: 1;
    }

    .footer__text {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    }

    .footer__social {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    }

    .footer__social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background-color: black;
    border: 0px solid ;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    }

    .footer__social-link::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: linear-gradient(45deg, gray, darkgray);
    border-radius: 50%;
    transition: all 0.3s ease;
    transform: translate(-50%, -50%);
    z-index: 1;
    }

    .footer__social-link:hover::before {
    width: 100%;
    height: 100%;
    }

    .footer__social-link:hover {
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.25);
    }

    .footer__social-link i {
    font-size: 1rem;
    position: relative;
    z-index: 2;
    transition: color 0.3s ease;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
    .footer__container {
        flex-direction: column;
        text-align: center;
        padding: 1.25rem 0.75rem;
        gap: 1rem;
    }

    .footer__copyright {
        flex: none;
        order: 2;
    }

    .footer__social {
        order: 1;
        justify-content: center;
    }

    .footer__text {
        font-size: 0.8rem;
    }

    .footer__social-link {
        width: 2.25rem;
        height: 2.25rem;
    }

    .footer__social-link i {
        font-size: 0.9rem;
    }
    }

    @media (max-width: 480px) {
    .footer__container {
        padding: 1rem 0.5rem;
        gap: 0.75rem;
    }

    .footer__social {
        gap: 0.5rem;
    }

    .footer__social-link {
        width: 2rem;
        height: 2rem;
    }

    .footer__social-link i {
        font-size: 0.85rem;
    }
    }

    /* Dark mode enhancements */
    @media (prefers-color-scheme: dark) {
    .footer__social-link:hover {
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.4);
    }
    }

</style>
