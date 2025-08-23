<template>
  <Transition name="modal-fade">
    <div class="modal-overlay" @click="closeModal">
      <div class="modal-container" @click.stop>
        <header class="modal-header">
          <h2 class="modal-title">
            {{ isEditing ? $t('modal.editDish') : $t('modal.createDish') }}
          </h2>
          <button @click="closeModal" class="close-btn" type="button" :aria-label="$t('modal.close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
              <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
            </svg>
          </button>
        </header>

        <div class="modal-body">
          <form class="modal-form" @submit.prevent="handleSubmit">
            <div class="form-column">
              <section class="form-section">
                <h3 class="section-title">{{ $t('modal.dishInfo') }}</h3>

                <!-- Name fields in a single row -->
                <div class="form-group">
                  <label class="label">{{ $t('modal.name') }}</label>
                  <span v-if="errors.nameEn" class="error-text">{{ errors.nameEn }}</span>
                  <div class="language-row">
                    <div class="language-field">
                      <label class="language-label">English</label>
                      <input
                        v-model="localDish.name.en"
                        type="text"
                        class="input"
                        :class="{ 'input--error': errors.nameEn }"
                      />
                    </div>
                    <div class="language-field">
                      <label class="language-label">Français</label>
                      <input
                        v-model="localDish.name.fr"
                        type="text"
                        class="input"
                      />
                    </div>
                    <div class="language-field">
                      <label class="language-label">Español</label>
                      <input
                        v-model="localDish.name.es"
                        type="text"
                        class="input"
                      />
                    </div>
                  </div>
                </div>

                <!-- Description fields in a single row -->
                <div class="form-group">
                  <label class="label">{{ $t('modal.desc') }}</label>
                  <div class="language-row">
                    <div class="language-field">
                      <label class="language-label">English</label>
                      <textarea
                        v-model="localDish.description.en"
                        class="textarea"
                        rows="3"
                      ></textarea>
                    </div>
                    <div class="language-field">
                      <label class="language-label">Français</label>
                      <textarea
                        v-model="localDish.description.fr"
                        class="textarea"
                        rows="3"
                      ></textarea>
                    </div>
                    <div class="language-field">
                      <label class="language-label">Español</label>
                      <textarea
                        v-model="localDish.description.es"
                        class="textarea"
                        rows="3"
                      ></textarea>
                    </div>
                  </div>
                </div>
              </section>

              <div class="divider"></div>

              <section class="form-section">
                <div class="form-grid form-grid--3">
                  <div class="form-group">
                    <label class="label">{{ $t('modal.price') }} *</label>
                    <div class="input-group">
                      <span class="input-prefix">$</span>
                      <input
                        v-model="localDish.price"
                        type="number"
                        step="0.01"
                        min="0"
                        class="input input--with-prefix"
                        :class="{ 'input--error': errors.price }"
                        placeholder="0.00"
                        required
                      />
                    </div>
                    <span v-if="errors.price" class="error-text">{{ errors.price }}</span>
                  </div>

                  <div class="form-group">
                    <label class="label">{{ $t('modal.calories') }}</label>
                    <input
                      v-model="localDish.calories"
                      type="number"
                      min="0"
                      class="input"
                      :placeholder="$t('modal.caloriesPlaceholder')"
                    />
                  </div>

                  <div class="form-group">
                    <label class="label">{{ $t('modal.size') }}</label>
                    <select v-model="localDish.size" class="select">
                      <option value="" disabled >{{ $t('modal.selectSize') }}</option>
                      <option value="Small">{{ $t('modal.sizeSmall') }}</option>
                      <option value="Medium">{{ $t('modal.sizeMedium') }}</option>
                      <option value="Large">{{ $t('modal.sizeLarge') }}</option>
                    </select>
                  </div>
                </div>
              </section>

              <div class="divider"></div>

              <section class="form-section">
                <label class="label">{{ $t('modal.spicyLevel') }}</label>
                <div class="pill-group">
                  <label class="pill-item">
                    <input v-model="localDish.spicy" type="radio" value="Not Spicy" class="pill-input" />
                    <span class="pill-text">{{ $t('modal.notSpicy') }}</span>
                  </label>
                  <label class="pill-item">
                    <input v-model="localDish.spicy" type="radio" value="Medium" class="pill-input" />
                    <span class="pill-text">{{ $t('modal.mediumSpicy') }} 🌶️</span>
                  </label>
                  <label class="pill-item">
                    <input v-model="localDish.spicy" type="radio" value="Extra Hot" class="pill-input" />
                    <span class="pill-text">{{ $t('modal.extraHot') }} 🌶️🌶️</span>
                  </label>
                </div>
              </section>
            </div>

            <div class="form-column">
              <section class="form-section">
                <h3 class="section-title">{{ $t('modal.images') }}</h3>
                <div class="form-group">
                    <label class="label">{{ $t('modal.imageUrl') }}</label>
                    <input
                      v-model="localDish.image"
                      type="url"
                      class="input"
                      :placeholder="$t('modal.imageUrlPlaceholder')"
                    />
                </div>
                 <div class="form-group">
                    <label class="label">{{ $t('modal.arImageUrl') }}</label>
                    <input
                      v-model="localDish.imageAR"
                      type="url"
                      class="input"
                      :placeholder="$t('modal.arImageUrlPlaceholder')"
                    />
                </div>
                <div class="image-preview" v-if="localDish.image">
                    <img :src="localDish.image" alt="Dish Preview" />
                </div>
              </section>

              <div class="divider"></div>

              <section class="form-section">
                <h3 class="section-title">{{ $t('modal.categories') }}</h3>

                <div class="form-group">
                  <label class="label">{{ $t('modal.dietary') }}</label>
                  <div class="pill-group">
                    <label v-for="diet in dietaryOptions" :key="diet.id" class="pill-item">
                      <input
                        type="checkbox"
                        :checked="isOptionSelected(localDish.dietaries, diet.id)"
                        @change="handleOptionToggle('dietaries', diet)"
                        class="pill-input"
                      />
                      <span class="pill-text">{{ diet.name }}</span>
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="label">{{ $t('modal.allergens') }}</label>
                  <div class="pill-group">
                    <label v-for="allergen in allergenOptions" :key="allergen.id" class="pill-item">
                      <input
                        type="checkbox"
                        :checked="isOptionSelected(localDish.allergens, allergen.id)"
                        @change="handleOptionToggle('allergens', allergen)"
                        class="pill-input"
                      />
                      <span class="pill-text">{{ allergen.name }}</span>
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="label">{{ $t('modal.proteins') }}</label>
                  <div class="pill-group">
                    <label v-for="protein in proteinOptions" :key="protein.id" class="pill-item">
                      <input
                        type="checkbox"
                        :checked="isOptionSelected(localDish.proteins, protein.id)"
                        @change="handleOptionToggle('proteins', protein)"
                        class="pill-input"
                      />
                      <span class="pill-text">{{ protein.name }}</span>
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label class="label">{{ $t('modal.tasteProfiles') }}</label>
                  <div class="pill-group">
                    <label v-for="taste in tasteProfileOptions" :key="taste.id" class="pill-item">
                      <input
                        type="checkbox"
                        :checked="isOptionSelected(localDish.tasteProfiles, taste.id)"
                        @change="handleOptionToggle('tasteProfiles', taste)"
                        class="pill-input"
                      />
                      <span class="pill-text">{{ taste.name }}</span>
                    </label>
                  </div>
                </div>
              </section>
            </div>
          </form>
        </div>

        <footer class="modal-footer">
          <button v-if="isEditing" @click="handleDelete" type="button" class="btn btn--danger" :disabled="isLoading">
            {{ $t('modal.delete') }}
          </button>
          <div class="footer-actions">
            <button @click="closeModal" type="button" class="btn btn--secondary">
              {{ $t('modal.close') }}
            </button>
            <button @click="handleSubmit" type="submit" class="btn btn--primary" :disabled="isLoading">
              <span v-if="isLoading" class="spinner"></span>
              {{ isLoading ? $t('modal.saving') : (isEditing ? $t('modal.update') : $t('modal.create')) }}
            </button>
          </div>
        </footer>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { MenuResource } from '@/api/MenuResource'; // Import the menuResource
import Swal from 'sweetalert2'

// MOCK API for demonstration
const menuResource = new MenuResource();

const props = defineProps({
  dish: { type: Object, default: null },
  isVisible: { type: Boolean, default: false },
  dish_group_id: { type: Number, default: null }
});

const emit = defineEmits(['close', 'updated', 'created', 'deleted']);
const { t } = useI18n();

// --- STATE ---
const isLoading = ref(false);
const errors = ref({});

const isEditing = computed(() => props.dish && props.dish.id);

// --- FORM OPTIONS WITH IDs ---
const dietaryOptions = [
  { id: 1, name: 'Vegan' },
  { id: 2, name: 'Vegetarian' },
  { id: 3, name: 'Pescatarian' },
  { id: 4, name: 'Halal' },
  { id: 5, name: 'Kosher' },
  { id: 6, name: 'Gluten-Free' },
  { id: 7, name: 'Dairy-Free' }
];

const allergenOptions = [
  { id: 1, name: 'Nuts' },
  { id: 2, name: 'Dairy' },
  { id: 3, name: 'Gluten' },
  { id: 4, name: 'Shellfish' },
  { id: 5, name: 'Eggs' },
  { id: 6, name: 'Soy' }
];

const proteinOptions = [
  { id: 1, name: 'Chicken' },
  { id: 2, name: 'Beef' },
  { id: 3, name: 'Fish' },
  { id: 4, name: 'Seafood' },
  { id: 5, name: 'Tofu' },
  { id: 6, name: 'Vegetables' },
];

const tasteProfileOptions = [
  { id: 1, name: 'Sweet' },
  { id: 2, name: 'Savory' },
  { id: 3, name: 'Sour' },
  { id: 4, name: 'Bitter' },
  { id: 5, name: 'Umami' },
  { id: 6, name: 'Salty' }
];

// --- FORM DATA & INITIALIZATION ---
const initDishData = () => ({
  id: null,
  name: { en: '', fr: '', es: '' },
  description: { en: '', fr: '', es: '' },
  price: '',
  calories: '',
  spicy: 'Not Spicy',
  size: '',
  image: '',
  imageAR: '',
  dietaries: [],
  allergens: [],
  proteins: [],
  tasteProfiles: [],
});

const localDish = ref(initDishData());

// Helper function to find option by name from the options arrays
const findOptionByName = (optionsArray, name) => {
  return optionsArray.find(option => option.name === name) || { id: null, name };
};

// Helper function to convert incoming data to proper format
const mapIncomingDataToOptions = (incomingArray, optionsArray) => {
  if (!Array.isArray(incomingArray)) return [];

  return incomingArray.map(item => {
    if (typeof item === 'string') {
      // If it's just a string, find the matching option
      return findOptionByName(optionsArray, item);
    } else if (item && typeof item === 'object') {
      // If it's an object with id and name, use it directly
      return { id: item.id, name: item.name };
    }
    return { id: null, name: item };
  }).filter(option => option.name); // Filter out any invalid entries
};

watch(() => props.dish, (newDish) => {
  if (newDish) {
    localDish.value = {
      ...initDishData(),
      ...JSON.parse(JSON.stringify(newDish)),
      // Ensure nested objects exist
      name: { en: '', fr: '', es: '', ...newDish.name },
      description: { en: '', fr: '', es: '', ...newDish.description },
      // Map related models properly with IDs
      dietaries: mapIncomingDataToOptions(
        newDish.dietaries?.map(d => d.name || d) || [],
        dietaryOptions
      ),
      allergens: mapIncomingDataToOptions(
        newDish.allergens?.map(a => a.name || a) || [],
        allergenOptions
      ),
      proteins: mapIncomingDataToOptions(
        newDish.proteins?.map(p => p.name || p) || [],
        proteinOptions
      ),
      tasteProfiles: mapIncomingDataToOptions(
        newDish.taste_profiles?.map(t => t.name || t) || [],
        tasteProfileOptions
      ),
    };
  } else {
    localDish.value = initDishData();
  }
  errors.value = {};
}, { immediate: true, deep: true });

// --- METHODS ---
const isOptionSelected = (selectedOptions, optionId) => {
  return selectedOptions.some(option => option.id === optionId);
};

const handleOptionToggle = (fieldName, option) => {
  const currentOptions = [...localDish.value[fieldName]];
  const existingIndex = currentOptions.findIndex(item => item.id === option.id);

  if (existingIndex > -1) {
    // Remove if already exists
    currentOptions.splice(existingIndex, 1);
  } else {
    // Add if doesn't exist
    currentOptions.push({ id: option.id, name: option.name });
  }

  localDish.value[fieldName] = currentOptions;
};

const validateForm = () => {
  const newErrors = {};
  if (!localDish.value.name.en?.trim()) newErrors.nameEn = t('validation.required');
  if (!localDish.value.price || parseFloat(localDish.value.price) <= 0) newErrors.price = t('validation.priceRequired');
  errors.value = newErrors;
  return Object.keys(newErrors).length === 0;
};

const prepareDataForSubmission = () => {
  const submissionData = { ...localDish.value };

  // Ensure all option arrays contain objects with id and name
  submissionData.dietaries = localDish.value.dietaries.map(item => ({
    id: item.id,
    name: item.name
  }));

  submissionData.allergens = localDish.value.allergens.map(item => ({
    id: item.id,
    name: item.name
  }));

  submissionData.proteins = localDish.value.proteins.map(item => ({
    id: item.id,
    name: item.name
  }));

  submissionData.tasteProfiles = localDish.value.tasteProfiles.map(item => ({
    id: item.id,
    name: item.name
  }));

  submissionData.dish_group_id = props.dish_group_id;

  return submissionData;
};

const handleSubmit = async () => {
  if (!validateForm()) return;
  isLoading.value = true;

  try {
    const submissionData = prepareDataForSubmission();
    let response = null;
    if (isEditing.value) {
      response = await menuResource.updateDish(localDish.value.id, submissionData);
      emit('updated', submissionData);
    } else {
      response = await menuResource.createDish(submissionData);
      emit('created', response.data);
    }
    if(response.success){
        Swal.fire({
            title: t('Success!'),
            text: isEditing.value ? t('Dish updated successfully.') : t('Dish created successfully.'),
            icon: 'success',
            confirmButtonText: t('OK')
        });
    }else{
        Swal.fire({
            title: t('Error'),
            text: t('There was an error, re-load the page and try again.'),
            icon: 'error',
            confirmButtonText: t('OK')
        });
    }
    closeModal();
  } catch (error) {
    console.error('Error saving dish:', error);
  } finally {
    isLoading.value = false;
  }
};

const handleDelete = async () => {
   const result = await Swal.fire({
    title: t('Are you sure?'),
    text: t('This action will permanently delete the dish.'),
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: t('Yes, delete it!'),
    cancelButtonText: t('Cancel'),
  });

  if (!result.isConfirmed) return;  isLoading.value = true;
  try {
    await menuResource.deleteDish(localDish.value.id);
    emit('deleted', localDish.value.id);
    closeModal();
  } catch (error) {
    console.error('Error deleting dish:', error);
  } finally {
    isLoading.value = false;
  }
};

const closeModal = () => {
  emit('close');
};
</script>

<style>

:root {
  --primary: #667eea;
  --primary-hover: #5a67d8;
  --danger: #e53e3e;
  --danger-hover: #c53030;
  --text-primary: #1a202c;
  --text-secondary: #718096;
  --text-on-primary: #ffffff;
  --bg-primary: #ffffff;
  --bg-secondary: #f7fafc;
  --border-primary: #e2e8f0;
  --border-focus: #a3bffa;
  --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.1);

  --radius: 0.75rem;
  --spacing: 1.25rem;
}

/* @media (prefers-color-scheme: dark) {
  :root {
    --primary: #8b9dff;
    --primary-hover: #7c8ce8;
    --danger: #fc8181;
    --danger-hover: #f56565;
    --text-primary: #edf2f7;
    --text-secondary: #a0aec0;
    --bg-primary: #2d3748;
    --bg-secondary: #1a202c;
    --border-primary: #4a5568;
    --border-focus: #6377e4;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.1);

  --radius: 0.75rem;
  --spacing: 1.25rem;
  }
} */

</style>

<style scoped>
/* --- TRANSITIONS --- */
.modal-fade-enter-active {
  transition: opacity 0.3s ease-out;
}
.modal-fade-leave-active {
  transition: opacity 0.2s ease-in;
}
.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
.modal-fade-enter-active .modal-container {
  transition: transform 0.3s ease-out;
}
.modal-fade-leave-active .modal-container {
  transition: transform 0.2s ease-in;
}
.modal-fade-enter-from .modal-container,
.modal-fade-leave-to .modal-container {
  transform: scale(0.95) translateY(10px);
}

/* --- MODAL STRUCTURE --- */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  display: grid;
  place-items: center;
  padding: 1rem;
  z-index: 1000;
}

.modal-container {
  background: var(--bg-primary);
  border-radius: var(--radius);
  box-shadow: var(--shadow-lg);
  width: 100%;
  max-width: 64rem;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: var(--spacing);
  border-bottom: 1px solid var(--border-primary);
  background: var(--bg-secondary);
  position: sticky;
  top: 0;
  z-index: 10;
}

.modal-body {
  overflow-y: auto;
  padding: var(--spacing);
}

.modal-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: var(--spacing);
  border-top: 1px solid var(--border-primary);
  background: var(--bg-secondary);
  position: sticky;
  bottom: 0;
  z-index: 10;
  gap: 1rem;
}

.footer-actions {
  display: flex;
  gap: 0.75rem;
}

/* --- FORM LAYOUT & ELEMENTS --- */
.modal-form {
  display: grid;
  grid-template-columns: 1fr;
  gap: calc(var(--spacing) * 2);
}

@media (min-width: 1024px) {
  .modal-form {
    grid-template-columns: 2fr 1fr;
  }
}

.form-column {
  display: flex;
  flex-direction: column;
  gap: var(--spacing);
}

.form-section {
  display: flex;
  flex-direction: column;
  gap: var(--spacing);
}

.section-title {
  font-size: 1rem;
  font-weight: 600;
  color: var(--text-primary);
  margin: 0;
}

.form-grid {
  display: grid;
  gap: var(--spacing);
}
.form-grid--3 {
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.divider {
  border-bottom: 1px solid var(--border-primary);
  margin: 0.5rem 0;
}

/* Language fields layout - now in rows instead of columns */
.language-row {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: var(--spacing);
}

.language-field {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.language-label {
  font-size: 0.75rem;
  font-weight: 500;
  color: var(--text-secondary);
  text-transform: uppercase;
  letter-spacing: 0.025em;
}

@media (max-width: 768px) {
  .language-row {
    grid-template-columns: 1fr;
  }
}

/* --- STYLED ELEMENTS --- */
.label {
  font-weight: 500;
  color: var(--text-primary);
  font-size: 0.875rem;
}

.input, .textarea, .select {
  padding: 0.75rem;
  border: 1px solid var(--border-primary);
  border-radius: 0.5rem;
  background: var(--bg-primary);
  color: var(--text-primary);
  font-size: 1rem;
  transition: all 0.2s ease;
  width: 100%;
}
.input:focus, .textarea:focus, .select:focus {
  outline: none;
  border-color: var(--border-focus);
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.input-group {
  position: relative;
}
.input-prefix {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-secondary);
  pointer-events: none;
}
.input--with-prefix {
  padding-left: 2rem;
}

.textarea {
  resize: vertical;
  min-height: 60px;
}

/* Pill/Tag Selectors */
.pill-group {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
}
.pill-item {
  display: flex;
  cursor: pointer;
}
.pill-input {
  opacity: 0;
  width: 0;
  height: 0;
  position: absolute;
}
.pill-text {
  padding: 0.5rem 1rem;
  border: 1px solid var(--border-primary);
  border-radius: 9999px;
  background-color: var(--bg-secondary);
  color: var(--text-secondary);
  font-size: 0.875rem;
  font-weight: 500;
  transition: all 0.2s ease;
  white-space: nowrap;
}
.pill-item:hover .pill-text {
  border-color: var(--border-focus);
  color: var(--text-primary);
}
.pill-input:checked + .pill-text {
  background-color: var(--primary);
  border-color: var(--primary);
  color: var(--text-on-primary);
}
.pill-input:focus-visible + .pill-text {
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
}

/* Image Preview */
.image-preview {
  width: 100%;
  aspect-ratio: 16 / 9;
  border-radius: 0.5rem;
  overflow: hidden;
  margin-top: 0.5rem;
  background: var(--bg-secondary);
}
.image-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Error Text */
.error-text {
  color: var(--danger);
  font-size: 0.875rem;
}
.input--error {
  border-color: var(--danger);
}
.input--error:focus {
  border-color: var(--danger);
  box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.2);
}

/* Buttons */
.modal-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--text-primary);
}
.close-btn {
  background: none;
  border: none;
  color: var(--text-secondary);
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 99px;
}
.close-btn:hover {
  color: var(--text-primary);
  background-color: rgba(0,0,0,0.1);
}

.btn {
  padding: 0.6rem 1.25rem;
  border-radius: 0.5rem;
  font-weight: 500;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  border: 1px solid transparent;
}
.btn--primary {
  background: var(--primary);
  color: var(--text-on-primary);
}
.btn--primary:hover:not(:disabled) {
  background: var(--primary-hover);
}
.btn--secondary {
  background: var(--bg-primary);
  color: var(--text-primary);
  border-color: var(--border-primary);
}
.btn--secondary:hover {
  background: var(--bg-secondary);
}
.btn--danger {
  background: transparent;
  color: var(--danger);
}
.btn--danger:hover:not(:disabled) {
  background: rgba(229, 62, 62, 0.1);
  border-color: rgba(229, 62, 62, 0.1);
}
.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Spinner */
.spinner {
  width: 1rem;
  height: 1rem;
  border: 2px solid transparent;
  border-top-color: currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}
@keyframes spin {
  to { transform: rotate(360deg); }
}

/* --- RESPONSIVENESS --- */
@media (max-width: 768px) {
  .modal-container {
    max-height: 95vh;
  }
  .modal-footer {
    flex-direction: column;
    align-items: stretch;
  }
  .footer-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    width: 100%;
  }
  .language-fields {
    grid-template-columns: 1fr;
  }
  .language-row {
    grid-template-columns: 1fr;
  }
}

</style>
