<!-- src/components/UserModal.vue -->
<template>

    <div v-if="loading" class="loading-overlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>


    <div class="modal-overlay">
        <div class="modal">
            <form @submit.prevent="createUser">
                <div class="form-group">
                    <label for="name">{{ $t('Name') }}</label>
                    <input id="name" v-model="form.name" type="text" :placeholder="$t('Enter Name')" required />
                </div>
                <div class="form-group">
                    <label for="email">{{ $t('Email') }}</label>
                    <input id="email" v-model="form.email" type="email" :placeholder="$t('Enter Email')" required />
                </div>
                <div class="form-group">
                    <label for="contract_starts_at">{{ $t('Contract Starts At') }}</label>
                    <input id="contract_starts_at" v-model="form.contract_starts_at" type="date" :placeholder="$t('Contract Starts At')" />
                </div>
                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" v-model="form.can_access" /> {{ $t('Can Access') }}
                    </label>
                </div>
                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" v-model="form.admin" /> {{ $t('Admin') }}
                    </label>
                </div>
                <div class="form-group">
                    <label for="address">{{ $t('Address') }}</label>
                    <input id="address" v-model="form.address" type="text" :placeholder="$t('Enter Address')" />
                </div>
                <div class="form-group">
                    <label for="amount">{{ $t('Amount') }}</label>
                    <input id="amount" v-model="form.amount" type="number" step="0.01" :placeholder="$t('Enter Amount')" />
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-primary">{{ $t('Create') }}</button>
                    <button type="button" class="btn-secondary" @click="$emit('close')">{{ $t('Close') }}</button>
                </div>
                <div v-if="errors.length" class="errors">
                    <p v-for="error in errors" :key="error">{{ error }}</p>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { MenuResource } from '../api/MenuResource';
import Swal from 'sweetalert2'
import { useI18n } from 'vue-i18n';

const menuResource = new MenuResource();
const { t } = useI18n();

const form = ref({
    name: '',
    email: '',
    contract_starts_at: '',
    can_access: false,
    admin: false,
    address: '',
    amount: '',
});
const errors = ref([]);
const loading = ref(false);

const createUser = async () => {
    loading.value = true;
    try {
        const response  = await menuResource.createUser(form.value);
        if(response.success){
            Swal.fire({
                title: t('Success'),
                text: t('User created successfully.'),
                icon: 'success',
                confirmButtonText: t('OK')
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: t('Failed to create user.'),
            });
        }
        $emit('close');
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: t('Failed to create user.'),
        });
        errors.value = error.response?.data?.errors || [error.message];
    } finally {
        loading.value = false;
    }
};

defineEmits(['close']);
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Ensure overlay is above other content */
}

.modal {
    display: block;
    background: #f7f7fa;
    border-radius: 10px;
    padding: 24px;
    width: 100%;
    max-width: 500px;
    max-height: 80vh; /* Prevent modal from exceeding viewport height */
    overflow-y: hidden; /* Allow scrolling if content overflows */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    z-index: 1001; /* Ensure modal is above overlay */
    position: relative; /* Ensure modal is positioned correctly */

}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
}

input:focus {
    outline: none;
    border-color: #6b7280;
    box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
}

.checkbox-group {
    display: flex;
    align-items: center;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    font-size: 14px;
    color: #333;
    cursor: pointer;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 8px;
    accent-color: #6b7280;
}

.button-group {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.btn-primary {
    background: #6b7280;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #4b5563;
}

.btn-secondary {
    background: #e5e7eb;
    color: #333;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-secondary:hover {
    background: #d1d5db;
}

.errors {
    margin-top: 16px;
    color: #dc2626;
    font-size: 13px;
}

.errors p {
    margin: 4px 0;
}
</style>
