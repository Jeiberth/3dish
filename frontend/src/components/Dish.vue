<!-- src/components/Dish.vue -->
<template>
    <div
        class="dish-card hoverAnimation"
        @click="$emit('click')"
        :class="{ 'dish-card--expanded': isExpanded }"
    >
        <div class="dish-card__image-container">
            <img
                :src="dish.image "
                :alt="dishName"
                class="dish-card__image"
                @error="onImageError"
            />

            <!-- ? dish.image : require('/dishPlaceholder.webp') -->

        </div>

        <div class="dish-card__content">
            <div class="dish-card__header">
                <div class="dish-card__title-container">
                    <h1 class="dish-card__title">{{ dishName }}</h1>
                    <span v-if="spicyLevel" class="dish-card__spicy-indicator">{{ spicyIcon }}</span>
                </div>
                <div class="dish-card__price">
                    <span class="dish-card__currency">$</span>
                    <span class="dish-card__amount">{{ formattedPrice }}</span>
                </div>
            </div>

            <div v-if="dishDescription" class="dish-card__description-container">
                <div class="dish-card__description-wrapper">
                    <p
                        class="dish-card__description"
                        :class="{
                            'dish-card__description--truncated': !isExpanded && shouldTruncate,
                            'dish-card__description--expanded': isExpanded
                        }"
                        ref="descriptionRef"
                    >
                        {{ dishDescription }}
                    </p>
                    <div
                        v-if="!isExpanded && shouldTruncate"
                        class="dish-card__fade-overlay"
                    ></div>
                </div>
                <button
                    v-if="shouldTruncate"
                    @click.stop="toggleExpanded"
                    class="dish-card__expand-btn"
                >
                    {{ isExpanded ? 'Read Less' : 'Read More' }}
                </button>
            </div>

            <div class="dish-card__info-grid">
                <div v-if="dish.calories" class="dish-card__info-item">
                    <i class="fa-solid fa-utensils dish-card__info-icon"></i>
                    <span>{{ dish.calories }} cal</span>
                </div>

                <div v-if="dish.size" class="dish-card__info-item">
                    <i class="fa-solid fa-scale-balanced dish-card__info-icon"></i>
                    <span>Size {{ dish.size }}</span>
                </div>
            </div>

            <div class="dish-card__tags">
                <!-- Dietary Tags -->
                <div v-if="dietaryTags.length" class="dish-card__tag-group">
                    <span
                        v-for="dietary in dietaryTags"
                        :key="`dietary-${dietary}`"
                        class="dish-card__tag dish-card__tag--dietary"
                    >
                        <svg class="dish-card__tag-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                        </svg>
                        {{ dietary }}
                    </span>
                </div>

                <!-- Allergen Tags -->
                <div v-if="allergenTags.length" class="dish-card__tag-group">
                    <span
                        v-for="allergen in allergenTags"
                        :key="`allergen-${allergen}`"
                        class="dish-card__tag dish-card__tag--allergen"
                    >
                        <svg class="dish-card__tag-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z" />
                        </svg>
                        {{ allergen }}
                    </span>
                </div>

                <!-- Protein Tags -->
                <div v-if="proteinTags.length" class="dish-card__tag-group">
                    <span
                        v-for="protein in proteinTags"
                        :key="`protein-${protein}`"
                        class="dish-card__tag dish-card__tag--protein"
                    >
                        {{ protein }}
                    </span>
                </div>

                <!-- Taste Profile Tags -->
                <div v-if="tasteTags.length" class="dish-card__tag-group">
                    <span
                        v-for="taste in tasteTags"
                        :key="`taste-${taste}`"
                        class="dish-card__tag dish-card__tag--taste"
                    >
                        {{ taste }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <ModelViewer :modelSrc="dish.imageAR" />

</template>

<script setup>
import { defineProps, defineEmits, computed, ref, onMounted, nextTick } from 'vue';
import { useI18n } from 'vue-i18n';
import ModelViewer from './ModelViewer.vue'

const props = defineProps({
  dish: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['click']);
const { locale, t } = useI18n();

// Reactive refs
const isExpanded = ref(false);
const shouldTruncate = ref(false);
const descriptionRef = ref(null);

// Computed properties for display data
const dishName = computed(() => {
  return props.dish.name?.[locale.value] ||
         props.dish.name?.en ||
         'dish.untitled';
});

const dishDescription = computed(() => {
  return props.dish.description?.[locale.value] ||
         props.dish.description?.en ||
         '';
});

const formattedPrice = computed(() => {
  if (!props.dish.price) return '0.00';
  return parseFloat(props.dish.price).toFixed(2);
});

const spicyLevel = computed(() => {
    if(props.dish.spicy == "Not Spicy"){
        return false
    }else{
        return props.dish.spicy;
    }
});

const spicyIcon = computed(() => {
  switch (props.dish.spicy) {
    case 'Extra Hot':
      return '🌶️🌶️🌶️';
    case 'Medium':
      return '🌶️🌶️';
    default:
      return '';
  }
});

// Tag arrays
const dietaryTags = computed(() => {
  return props.dish.dietaries?.map(d => d.name).filter(Boolean) || [];
});

const allergenTags = computed(() => {
  return props.dish.allergens?.map(a => a.name).filter(Boolean) || [];
});

const proteinTags = computed(() => {
  const proteins = props.dish.proteins?.map(p => p.name).filter(Boolean) || [];
  return [...new Set(proteins)];
});

const tasteTags = computed(() => {
  const tastes = props.dish.taste_profiles?.map(t => t.name).filter(Boolean) || [];
  return [...new Set(tastes)];
});

// Methods
const onImageError = (event) => {
  event.target.src = '/dishPlaceholder.webp';
};

const checkTruncation = async () => {
  if (!descriptionRef.value || !dishDescription.value) return;

  await nextTick();

  // Temporarily remove truncation to measure full height
  isExpanded.value = true;
  await nextTick();

  const element = descriptionRef.value;
  const fullHeight = element.scrollHeight;

  // Reset to truncated state to measure truncated height
  isExpanded.value = false;
  await nextTick();

  const truncatedHeight = element.scrollHeight;

  // If full height is greater than truncated height, we need truncation
  shouldTruncate.value = fullHeight > truncatedHeight;

  // If we don't need truncation, keep expanded
  if (!shouldTruncate.value) {
    isExpanded.value = true;
  }
};

const toggleExpanded = () => {
  isExpanded.value = !isExpanded.value;
};

// Lifecycle
onMounted(() => {
  checkTruncation();
});
</script>

<style scoped>
:root {
  --primary: #667eea;
  --primary-rgb: 102, 126, 234;
  --secondary: #764ba2;
  --text-primary: #1a202c;
  --text-secondary: #718096;
  --background: #ffffff;
  --background-rgb: 255, 255, 255;
  --border: #e2e8f0;
}

@media (prefers-color-scheme: dark) {
  :root {
    --primary: #667eea;
    --primary-rgb: 102, 126, 234;
    --secondary: #764ba2;
    --text-primary: #f7fafc;
    --text-secondary: #cbd5e0;
    --background: #1a202c;
    --background-rgb: 26, 32, 44;
    --border: #4a5568;
  }
}

/* Base card styles */
.dish-card {
  background: rgba(236, 236, 236, 0.718);
  border-radius: 50px;
  overflow: hidden;
  cursor: pointer;
  /* transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); */
  /* box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); */
  margin: 1rem;
  width: calc(100% - 2rem);
  display: flex;
  flex-direction: column;

  /* Mobile first approach */
  min-height: auto;
}

/* Desktop styles */
@media (min-width: 560px) {
  .dish-card {
    height: 300px;
    flex-direction: row;
    max-height: 300px;
  }

  .dish-card--expanded {
    height: auto;
    max-height: none;
  }

}
/*
.dish-card:hover {
  box-shadow: 0 10px 25px rgba(var(--primary-rgb), 0.15);
} */

/* Image Section */
.dish-card__image-container {
  position: relative;
  width: 100%;
  height: calc(100vw - 2rem - 30px);
  max-height: calc(100vw - 2rem - 30px);
  overflow: hidden;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 15px;
}

@media (min-width: 560px) {
  .dish-card__image-container {
    width: 300px;
    height: 300px;
    max-height: 300px;
    padding: 15px;
  }
}

.dish-card__image {
  width: calc(100% - 30px);
  height: calc(100% - 30px);
  border-radius: 50px;
  object-fit: cover;
}

@media (min-width: 560px) {
  .dish-card__image {
    width: 270px;
    height: 270px;
  }
}

/* Content Section */
.dish-card__content {
  padding: 30px;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex: 1;
  overflow: hidden;
  color: black;
}

@media (min-width: 768px) {
  .dish-card__content {
    padding: 1.25rem;
    gap: 1rem;
  }
}



/* Header */
.dish-card__header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  flex-shrink: 0;
}

.dish-card__title-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex: 1;
}

.dish-card__title {
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--text-primary);
  margin: 0;
  line-height: 1.3;
  color: black;
}

@media (min-width: 768px) {
  .dish-card__title {
    font-size: 1.25rem;
  }
}

@media (min-width: 560px) {
  .dish-card__title {
    font-size: 1.375rem;
  }
}

@media (max-width: 560px) {
  .dish-card__content {
    padding-top: 0px ;
  }
}

.dish-card__spicy-indicator {
  font-size: 1.125rem;
  line-height: 1;
}

@media (min-width: 768px) {
  .dish-card__spicy-indicator {
    font-size: 1.25rem;
  }
}

.dish-card__price {
  display: flex;
  align-items: baseline;
  color: var(--primary);
  font-weight: 700;
  flex-shrink: 0;
  color: black;
   margin-right: 0px;
}

@media (min-width: 768px) {
  .dish-card__price {
        margin-right: 8px;
  }
}

.dish-card__currency {
  font-size: 0.875rem;
  margin-right: 0.125rem;
}

@media (min-width: 768px) {
  .dish-card__currency {
    font-size: 1rem;
  }
}

.dish-card__amount {
  font-size: 1.125rem;
}

@media (min-width: 768px) {
  .dish-card__amount {
    font-size: 1.25rem;
  }
}

@media (min-width: 560px) {
  .dish-card__amount {
    font-size: 1.375rem;
  }
}

/* Description */
.dish-card__description-container {
  position: relative;
  flex-shrink: 0;
}

.dish-card__description-wrapper {
  position: relative;
  overflow: hidden;
}

.dish-card__description {
  color: var(--text-secondary);
  font-size: 0.875rem;
  line-height: 1.4;
  margin: 0;
  color: black;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (min-width: 768px) {
  .dish-card__description {
    font-size: 1rem;
    line-height: 1.5;
  }
}

@media (min-width: 560px) {
  .dish-card__description {
    font-size: 1.125rem;
  }
}

.dish-card__description--truncated {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  max-height: calc(1.4em * 2); /* 2 lines at mobile */
}

@media (min-width: 768px) {
  .dish-card__description--truncated {
    max-height: calc(1.5em * 2); /* 2 lines at tablet */
  }
}

@media (min-width: 560px) {
  .dish-card__description--truncated {
    -webkit-line-clamp: 1;
    max-height: calc(1.4em * 1); /* 1 line at desktop to save space */
  }
}

.dish-card__description--expanded {
  display: block;
  max-height: none;
  -webkit-line-clamp: unset;
  -webkit-box-orient: unset;
  overflow: visible;
}

.dish-card__fade-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 1.5em;
  background: linear-gradient(transparent, rgba(236, 236, 236, 0.718));
  pointer-events: none;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.dish-card__expand-btn {
  background: none;
  border: none;
  color: var(--primary);
  cursor: pointer;
  font-size: 0.75rem;
  font-weight: 600;
  margin-top: 0.5rem;
  padding: 0.25rem 0;
  text-decoration: none;
  transition: all 0.2s ease;
  color: #667eea;
  display: inline-block;
  position: relative;
}

.dish-card__expand-btn::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 1px;
  background-color: #667eea;
  transition: width 0.2s ease;
}

.dish-card__expand-btn:hover::after {
  width: 100%;
}

@media (min-width: 768px) {
  .dish-card__expand-btn {
    font-size: 0.875rem;
  }
}

/* Info Grid */
.dish-card__info-grid {
  display: flex;
  gap: 1rem;
  flex-shrink: 0;
}

.dish-card__info-item {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  color: var(--text-secondary);
  font-size: 0.75rem;
  font-weight: 500;
  color: black;
}

@media (min-width: 768px) {
  .dish-card__info-item {
    font-size: 0.875rem;
  }
}

@media (min-width: 560px) {
  .dish-card__info-item {
    font-size: 1rem;
  }
}

.dish-card__info-icon {
  width: 0.875rem;
  height: 0.875rem;
  opacity: 0.7;
}

@media (min-width: 768px) {
  .dish-card__info-icon {
    width: 1rem;
    height: 1rem;
  }
}

/* Tags */
.dish-card__tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.375rem;
  flex: 1;
  overflow: hidden;
  align-content: flex-start;
}

@media (min-width: 768px) {
  .dish-card__tags {
    gap: 0.5rem;
  }
}

.dish-card__tag-group {
  display: contents;
}

.dish-card__tag {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.375rem 0.5rem;
  border-radius: 25px;
  font-size: 0.75rem;
  font-weight: 500;
  line-height: 1;
  transition: all 0.2s ease;
  background-color: white !important;
  flex-shrink: 0;
}

@media (min-width: 768px) {
  .dish-card__tag {
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
  }
}

@media (min-width: 560px) {
  .dish-card__tag {
    font-size: 1rem;
  }
}

.dish-card__tag-icon {
  width: 0.75rem;
  height: 0.75rem;
}

@media (min-width: 768px) {
  .dish-card__tag-icon {
    width: 0.875rem;
    height: 0.875rem;
  }
}

.dish-card__tag--dietary {
  background-color: rgba(34, 197, 94, 0.1);
  color: rgb(34, 197, 94);
}

.dish-card__tag--allergen {
  background-color: rgba(239, 68, 68, 0.1);
  color: rgb(239, 68, 68);
}

.dish-card__tag--protein {
  background-color: rgba(168, 85, 247, 0.1);
  color: rgb(168, 85, 247);
}

.dish-card__tag--taste {
  background-color: rgba(245, 158, 11, 0.1);
  color: rgb(245, 158, 11);
}

.dish-card__tag--more {
  background-color: rgba(107, 114, 128, 0.1);
  color: rgb(107, 114, 128);
  font-weight: 600;
}

.dish-card__tag--allergen-more {
  background-color: rgba(239, 68, 68, 0.1);
  color: rgb(239, 68, 68);
}

/* Mobile specific adjustments */
@media (max-width: 767px) {
  .dish-card {
    margin: 0.75rem;
    width: calc(100% - 1.5rem);
  }

  .dish-card__header {
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  .dish-card__title-container {
    order: 1;
    width: 100%;
  }

  .dish-card__price {
    order: 2;
    align-self: flex-end;
  }

  .dish-card__info-grid {
    flex-wrap: wrap;
    gap: 0.75rem;
  }
}

/* Loading state */
.dish-card__image[src="/dishPlaceholder.webp"] {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
}

.dish-card__image[src="/dishPlaceholder.webp"]::after {
  content: '🍽️';
  font-size: 2rem;
  opacity: 0.5;
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
  .dish-card__title,
  .dish-card__price,
  .dish-card__description,
  .dish-card__info-item {
    color: var(--text-primary);
  }

  .dish-card__expand-btn {
    color: var(--primary);
  }
}</style>
