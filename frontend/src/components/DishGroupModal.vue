<template>
  <Transition name="modal-fade">
    <div class="modal-overlay" @click="closeModal">
      <div class="modal-container" @click.stop>
        <header class="modal-header">
          <h2 class="modal-title">
            {{ isEditing ? 'Update Dish Group' : 'Create Dish Group' }}
          </h2>
          <button @click="closeModal" class="close-btn" type="button" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
              <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
            </svg>
          </button>
        </header>

        <div class="modal-body">
          <form class="modal-form" @submit.prevent="handleSubmit">
            <div class="form-column">
              <section class="form-section">
                <h3 class="section-title">Dish Group Information</h3>

                <!-- Name fields in a single row -->
                <div class="form-group">
                  <label class="label">Name</label>
                  <span v-if="errors.nameEn" class="error-text">{{ errors.nameEn }}</span>
                  <div class="language-row">
                    <div class="language-field">
                      <label class="language-label">English</label>
                      <input
                        v-model="localDishGroup.name.en"
                        type="text"
                        class="input"
                        :class="{ 'input--error': errors.nameEn }"
                      />
                    </div>
                    <div class="language-field">
                      <label class="language-label">Français</label>
                      <input
                        v-model="localDishGroup.name.fr"
                        type="text"
                        class="input"
                      />
                    </div>
                    <div class="language-field">
                      <label class="language-label">Español</label>
                      <input
                        v-model="localDishGroup.name.es"
                        type="text"
                        class="input"
                      />
                    </div>
                  </div>
                </div>

                <!-- Order Number -->
                <div class="form-group">
                  <label class="label">Order Number</label>
                  <span v-if="errors.order_number" class="error-text">{{ errors.order_number }}</span>
                  <input
                    v-model.number="localDishGroup.order_number"
                    type="number"
                    min="0"
                    class="input"
                    :class="{ 'input--error': errors.order_number }"
                    placeholder="0"
                  />
                </div>
              </section>
            </div>
          </form>
        </div>

        <footer class="modal-footer">
          <button v-if="isEditing" @click="handleDelete" type="button" class="btn btn--danger" :disabled="isLoading">
            Delete
          </button>
          <div class="footer-actions">
            <button @click="closeModal" type="button" class="btn btn--secondary">
              Close
            </button>
            <button @click="handleSubmit" type="submit" class="btn btn--primary" :disabled="isLoading">
              <span v-if="isLoading" class="spinner"></span>
              {{ isLoading ? 'Saving...' : (isEditing ? 'Update' : 'Create') }}
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
import { MenuResource } from '@/api/MenuResource';
import Swal from 'sweetalert2';

const menuResource = new MenuResource();

const props = defineProps({
  dishGroup: { type: Object, default: null },
});

const emit = defineEmits(['close', 'updated', 'created', 'deleted']);
const { t } = useI18n();

const isLoading = ref(false);
const errors = ref({});

const isEditing = computed(() => props.dishGroup && props.dishGroup.id);

const initDishGroupData = () => ({
  id: null,
  name: { en: '', fr: '', es: '' },
  order_number: 0,
});

const localDishGroup = ref(initDishGroupData());

watch(() => props.dishGroup, (newDishGroup) => {
  if (newDishGroup) {
    localDishGroup.value = {
      ...initDishGroupData(),
      ...JSON.parse(JSON.stringify(newDishGroup)),
      name: { en: '', fr: '', es: '', ...newDishGroup.name },
      order_number: newDishGroup.order_number || 0,
    };
  } else {
    localDishGroup.value = initDishGroupData();
  }
  errors.value = {};
}, { immediate: true, deep: true });

const validateForm = () => {
  const newErrors = {};
  if (!localDishGroup.value.name.en?.trim()) newErrors.nameEn = t('validation.required');
  if (localDishGroup.value.order_number < 0) newErrors.order_number = t('validation.orderNumber');
  errors.value = newErrors;
  return Object.keys(newErrors).length === 0;
};

const prepareDataForSubmission = () => {
  return {
    ...localDishGroup.value,
  };
};

const handleSubmit = async () => {
  if (!validateForm()) return;
  isLoading.value = true;

  try {
    const submissionData = prepareDataForSubmission();
    let response = null;
    if (isEditing.value) {
      response = await menuResource.updateDishGroup(localDishGroup.value.id, submissionData);
    } else {
      response = await menuResource.createDishGroup(submissionData);
    }
    if (response.success) {
      Swal.fire({
        title: t('Success!'),
        text: isEditing.value ? t('Dish group updated successfully.') : t('Dish group created successfully.'),
        icon: 'success',
        confirmButtonText: t('OK'),
      });
      isEditing.value ? emit('updated', response.data) : emit('created', response.data);
    } else {
      Swal.fire({
        title: t('Error'),
        text: t('There was an error, please reload the page and try again.'),
        icon: 'error',
        confirmButtonText: t('OK'),
      });
    }
    closeModal();
  } catch (error) {
    console.error('Error saving dish group:', error);
    Swal.fire({
      title: t('Error'),
      text: t('There was an error, please reload the page and try again.'),
      icon: 'error',
      confirmButtonText: t('OK'),
    });
  } finally {
    isLoading.value = false;
  }
};

const handleDelete = async () => {
  const result = await Swal.fire({
    title: t('Are you sure?'),
    text: t('This action will permanently delete the dish group.'),
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: t('Yes, delete it!'),
    cancelButtonText: t('Cancel'),
  });

  if (!result.isConfirmed) return;
  isLoading.value = true;
  try {
    await menuResource.deleteDishGroup(localDishGroup.value.id);
    emit('deleted', localDishGroup.value.id);
    closeModal();
  } catch (error) {
    console.error('Error deleting dish group:', error);
    Swal.fire({
      title: t('Error'),
      text: t('There was an error, please reload the page and try again.'),
      icon: 'error',
      confirmButtonText: t('OK'),
    });
  } finally {
    isLoading.value = false;
  }
};

const closeModal = () => {
  emit('close');
};
</script>



<style scoped>
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
  max-width: 48rem;
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
  border-bottom: 0px solid var(--border-primary);
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
  border-top: 0px solid var(--border-primary);
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

.modal-form {
  display: flex;
  flex-direction: column;
  gap: var(--spacing);
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

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

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

.label {
  font-weight: 500;
  color: var(--text-primary);
  font-size: 0.875rem;
}

.input {
  padding: 0.75rem;
  border: 0px solid var(--border-primary);
  border-radius: 50px;
  background: #f1f1f1;
  color: var(--text-primary);
  font-size: 1rem;
  transition: all 0.2s ease;
  width: 100%;
}

.input:focus {
  outline: none;
  border-color: var(--border-focus);
  box-shadow: 0 0 0 3px rgba(102, 102, 102, 0.2);
}

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
  background-color: rgba(0, 0, 0, 0.1);
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
  background: rgba(0, 0, 0, 0.1);
  border-color: rgba(0, 0, 0, 0.1);
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

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

.error-text {
  color: var(--danger);
  font-size: 0.875rem;
}

.input--error {
  border-color: var(--danger);
}

.input--error:focus {
  border-color: var(--danger);
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
}

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
}
</style>
