import api from './api';

const API_URL = '/admin/instructors';

export const instructorService = {
    async index(params = {}) {
        const response = await api.get(API_URL, { params });
        return response.data;
    },

    async show(id) {
        const response = await api.get(`${API_URL}/${id}`);
        return response.data;
    },

    async store(data) {
        const response = await api.post(API_URL, data);
        return response.data;
    },

    async update(id, data) {
        const response = await api.put(`${API_URL}/${id}`, data);
        return response.data;
    },

    async destroy(id) {
        const response = await api.delete(`${API_URL}/${id}`);
        return response.data;
    },

    async toggleFeatured(id) {
        const response = await api.patch(`${API_URL}/${id}/toggle-featured`);
        return response.data;
    },

    async toggleStatus(id) {
        const response = await api.patch(`${API_URL}/${id}/toggle-status`);
        return response.data;
    }
};
