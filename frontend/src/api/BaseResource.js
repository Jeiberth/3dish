// src/api/BaseResource.js
import axios from 'axios';
import { useUserStore } from '../stores/user';

export default class BaseResource {
    constructor() {
        this.axios = axios.create({ baseURL: 'http://localhost:8000/api' });
    }

    async makeRequest({ url, method, data = null, headers = {} }) {
        const userStore = useUserStore();
        const token = userStore.token;
        try {
            const response = await this.axios({
                url,
                method,
                data,
                headers: { ...headers, Authorization: `Bearer ${token}` },
            });
            return response.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    }
}
