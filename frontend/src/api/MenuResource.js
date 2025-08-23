// src/api/MenuResource.js
import BaseResource from './BaseResource';

export class MenuResource extends BaseResource {
    getDishGroups() {
        return this.makeRequest({ url: '/dish-groups', method: 'get' });
    }

    createDishGroup(data) {
        return this.makeRequest({ url: '/dish-groups', method: 'post', data });
    }

    updateDishGroup(id, data) {
        return this.makeRequest({ url: `/dish-groups/${id}`, method: 'put', data });
    }

    deleteDishGroup(id) {
        return this.makeRequest({ url: `/dish-groups/${id}`, method: 'delete' });
    }

    createDish(data) {
        return this.makeRequest({ url: '/dishes', method: 'post', data });
    }

    updateDish(id, data) {
        return this.makeRequest({ url: `/dishes/${id}`, method: 'put', data });
    }

    deleteDish(id) {
        return this.makeRequest({ url: `/dishes/${id}`, method: 'delete' });
    }

    login(data) {
        return this.makeRequest({ url: '/login', method: 'post', data });
    }

    createUser(data) {
        return this.makeRequest({ url: '/users', method: 'post', data });
    }
}
