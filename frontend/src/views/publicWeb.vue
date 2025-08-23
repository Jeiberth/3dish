<template>
    <div id="app">

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>{{ $t('The Menu Your Food Deserves.') }}</h1>
                <p>{{ $t('Transform your restaurant\'s menu with stunning professional photography and interactive 3D models. Engage customers, increase sales, and elevate your brand with an unforgettable digital experience.') }}</p>
                <a href="#pricing" class="cta-btn hoverAnimation">{{ $t('View Pricing') }}</a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <h2 class="section-title">{{ $t('Features That Make a Difference') }}</h2>
                <div class="features-grid">
                    <div class="feature-card hoverAnimation">
                        <h3>{{ $t('Professional Photography') }}</h3>
                        <p>{{ $t('We capture the essence of your dishes with high-quality, professional images that make your food look as delicious as it tastes.') }}</p>
                    </div>
                    <div class="feature-card hoverAnimation">
                        <h3>{{ $t('Interactive 3D Models') }}</h3>
                        <p>{{ $t('Allow customers to view your dishes from every angle with immersive 3D models, providing a unique and engaging experience.') }}</p>
                    </div>
                    <div class="feature-card hoverAnimation">
                        <h3>{{ $t('Easy Menu Creation') }}</h3>
                        <p>{{ $t('Our intuitive dashboard makes it simple to create, update, and manage your digital menu anytime, anywhere.') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="how-it-works">
            <div class="container">
                <h2 class="section-title">{{ $t('Simple Process, Powerful Results') }}</h2>
                <div class="steps">
                    <div class="step hoverAnimation">
                        <h3>{{ $t('1. We Shoot') }}</h3>
                        <p>{{ $t('Our team visits your restaurant for a professional, non-disruptive photoshoot to capture your dishes.') }}</p>
                    </div>
                    <div class="step hoverAnimation">
                        <h3>{{ $t('2. We Build') }}</h3>
                        <p>{{ $t('We create your beautiful, interactive digital menu, complete with 3D models and advanced filtering.') }}</p>
                    </div>
                    <div class="step hoverAnimation">
                        <h3>{{ $t('3. You Sell More') }}</h3>
                        <p>{{ $t('Launch your new menu and watch as customer engagement and order values increase.') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="pricing">
            <div class="container">
                <h2 class="section-title">{{ $t('Choose Your Plan') }}</h2>

                <div class="pricing-toggle">
                    <div class="toggle-switch">
                        <button
                            @click="isAnnual = false"
                            :class="['toggle-btn', { active: !isAnnual }]"
                        >
                            {{ $t('Monthly') }}
                        </button>
                        <button
                            @click="isAnnual = true"
                            :class="['toggle-btn', { active: isAnnual }]"
                        >
                            {{ $t('Annual (20% off)') }}
                        </button>
                    </div>
                </div>

                <div class="pricing-grid">
                    <!-- Starter Plan -->
                    <div class="pricing-card hoverAnimation">
                        <h3>Starter</h3>
                        <div class="price">${{ isAnnual ? '60' : '75' }}</div>
                        <div class="setup-fee">{{ $t('Setup Fee') }}: $0</div>
                        <ul class="features-list">
                            <li>✅ {{ $t('Custom menu.domain.com URL') }}</li>
                            <li>✅ {{ $t('Mobile-Optimized Design') }}</li>
                            <li>✅ {{ $t('Advanced Filtering System') }}</li>
                            <li>✅ {{ $t('QR Code Generation') }}</li>
                            <li>✅ {{ $t('Easy Menu Creation (dashboard)') }}</li>
                            <li>✅ {{ $t('Professional Photography') }}: {{ $t('Up to 30 dishes') }}</li>
                            <li>❌ {{ $t('Interactive 3D Models') }}</li>
                            <li>❌ {{ $t('Priority Support') }}</li>
                        </ul>
                        <button class="pricing-btn hoverAnimation">{{ $t('Get Started') }}</button>
                    </div>

                    <!-- Pro Plan -->
                    <div class="pricing-card hoverAnimation">
                        <h3>Pro</h3>
                        <div class="price">${{ isAnnual ? '96' : '120' }}</div>
                        <div class="setup-fee">{{ $t('Setup Fee') }}: $200</div>
                        <ul class="features-list">
                            <li>✅ {{ $t('Custom menu.domain.com URL') }}</li>
                            <li>✅ {{ $t('Mobile-Optimized Design') }}</li>
                            <li>✅ {{ $t('Advanced Filtering System') }}</li>
                            <li>✅ {{ $t('QR Code Generation') }}</li>
                            <li>✅ {{ $t('Easy Menu Creation (dashboard)') }}</li>
                            <li>✅ {{ $t('Professional Photography') }}: {{ $t('Up to 50 dishes') }}</li>
                            <li>✅ {{ $t('Interactive 3D Models') }}: {{ $t('Up to 30 dishes') }}</li>
                            <li>❌ {{ $t('Priority Support') }}</li>
                        </ul>
                        <button class="pricing-btn hoverAnimation">{{ $t('Choose Pro') }}</button>
                    </div>

                    <!-- Ultimate 3D Plan -->
                    <div class="pricing-card hoverAnimation">
                        <h3>Ultimate 3D</h3>
                        <div class="price">${{ isAnnual ? '120' : '150' }}</div>
                        <div class="setup-fee">{{ $t('Setup Fee') }}: $500</div>
                        <ul class="features-list">
                            <li>✅ {{ $t('Custom menu.domain.com URL') }}</li>
                            <li>✅ {{ $t('Mobile-Optimized Design') }}</li>
                            <li>✅ {{ $t('Advanced Filtering System') }}</li>
                            <li>✅ {{ $t('QR Code Generation') }}</li>
                            <li>✅ {{ $t('Easy Menu Creation (dashboard)') }}</li>
                            <li>✅ {{ $t('Professional Photography') }}: {{ $t('Up to 100 dishes') }}</li>
                            <li>✅ {{ $t('Interactive 3D Models') }}: {{ $t('Up to 50 dishes') }}</li>
                            <li>✅ {{ $t('Priority Support') }}</li>
                        </ul>
                        <button class="pricing-btn hoverAnimation">{{ $t('Go Ultimate') }}</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact">
            <div class="container">
                <h2 class="section-title">{{ $t('Ready to Elevate Your Menu?') }}</h2>
                <div class="contact-content">
                    <div class="contact-form">
                        <form @submit.prevent="submitForm">
                            <div class="form-group">
                                <label>{{ $t('Full Name') }}</label>
                                <input type="text"  required>
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Restaurant Name') }}</label>
                                <input type="text" required>
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Email Address') }}</label>
                                <input type="email" required>
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Inquiry Type') }}</label>
                                <select  required>
                                    <option value="">{{ $t('Select an option') }}</option>
                                    <option value="demo">{{ $t('Request a Free Demo') }}</option>
                                    <option value="quote">{{ $t('Get a Quote') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Message') }}</label>
                                <textarea  required></textarea>
                            </div>
                            <button type="submit" class="submit-btn hoverAnimation">{{ $t('Submit Request') }}</button>
                        </form>
                    </div>
                    <div class="contact-info">
                        <h3>{{ $t('Or contact us directly:') }}</h3>
                        <div class="contact-details">
                            <p><strong>{{ $t('Email') }}:</strong> contact@menu-ar.com</p>
                            <p><strong>{{ $t('Phone') }}:</strong> +1 (450) 555-0123</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
 </template>

<script>

    import { ref, reactive, onMounted } from 'vue';

    const languages = [
        { code: 'en', name: 'EN' },
        { code: 'es', name: 'ES' },
        { code: 'fr', name: 'FR' }
    ];

    const currentLanguage = ref('en');
    const isAnnual = ref(false);

    // Form data
    const form = ref({
        fullName: '',
        restaurantName: '',
        email: '',
        inquiryType: '',
        message: ''
    });


    const setLanguage = (lang) => {
        currentLanguage.value = lang;
        localStorage.setItem('preferred-language', lang);
        document.documentElement.lang = lang;
    };

    // Form submission
    const submitForm = () => {
        // In a real application, you would send this data to a server
        alert('Thank you for your message! We will get back to you soon.');

        // Reset form
        Object.keys(form).forEach(key => {
            form[key] = '';
        });
    };

</script>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #ffffff;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Hover Animation */
    .hoverAnimation {
        transition: all 0.2s ease;
    }
    .hoverAnimation:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(146, 146, 146, 0.726);
    }

    /* Header */
    .header {
        background: #ffffff;
        padding: 1rem 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .language-selector {
        display: flex;
        gap: 0.5rem;
    }

    .language-btn {
        padding: 0.5rem 1rem;
        border: none;
        background: #f1f1f1;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 500;
    }

    .language-btn.active {
        background: #333;
        color: white;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, #f1f1f1 0%, #ffffff 100%);
        padding: 8rem 0 4rem;
        text-align: center;
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .hero p {
        font-size: 1.2rem;
        color: #666;
        max-width: 800px;
        margin: 0 auto 2.5rem;
        line-height: 1.7;
    }

    .cta-btn {
        display: inline-block;
        padding: 1rem 2rem;
        background: #333;
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
    }

    /* Features Section */
    .features {
        padding: 4rem 0;
        background: #ffffff;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-card {
        background: #f1f1f1;
        padding: 2.5rem;
        border-radius: 50px;
        text-align: center;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .feature-card p {
        color: #666;
        line-height: 1.7;
    }

    /* How It Works Section */
    .how-it-works {
        padding: 4rem 0;
        background: #f1f1f1;
    }

    .section-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 3rem;
        color: #333;
    }

    .steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .step {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 50px;
        text-align: center;
    }

    .step h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .step p {
        color: #666;
        line-height: 1.7;
    }

    /* Pricing Section */
    .pricing {
        padding: 4rem 0;
        background: #ffffff;
    }

    .pricing-toggle {
        text-align: center;
        margin-bottom: 3rem;
    }

    .toggle-switch {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        background: #f1f1f1;
        padding: 0.5rem;
        border-radius: 50px;
    }

    .toggle-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        background: transparent;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 500;
    }

    .toggle-btn.active {
        background: #333;
        color: white;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .pricing-card {
        background: #f1f1f1;
        padding: 2.5rem;
        border-radius: 50px;
        text-align: center;
        position: relative;
    }

    .pricing-card h3 {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .price {
        font-size: 3rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .setup-fee {
        font-size: 1rem;
        color: #666;
        margin-bottom: 2rem;
    }

    .features-list {
        text-align: left;
        margin: 2rem 0;
    }

    .features-list li {
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pricing-btn {
        width: 100%;
        padding: 1rem 2rem;
        background: #333;
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 2rem;
    }

    /* Contact Section */
    .contact {
        padding: 4rem 0;
        background: #f1f1f1;
    }

    .contact-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        margin-top: 3rem;
    }

    .contact-form {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 50px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #333;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem 2rem;
        background: #333;
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1.1rem;
    }

    .contact-info {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 50px;
    }

    .contact-info h3 {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        color: #333;
    }

    .contact-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .contact-details p {
        color: #666;
        font-size: 1.1rem;
    }

    /* Footer */
    .footer {
        background: #333;
        color: white;
        padding: 2rem 0;
        text-align: center;
    }

    .footer-content {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .footer-links {
        display: flex;
        gap: 1rem;
    }

    .footer-links a {
        color: white;
        text-decoration: none;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .contact-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .features-grid,
        .steps,
        .pricing-grid {
            grid-template-columns: 1fr;
        }

        .footer-content {
            flex-direction: column;
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .hero {
            padding: 6rem 0 3rem;
        }

        .hero h1 {
            font-size: 2rem;
        }

        .container {
            padding: 0 15px;
        }

        .language-selector {
            flex-wrap: wrap;
        }
    }
</style>
