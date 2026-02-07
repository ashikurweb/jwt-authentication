import api from './api';

const API_URL = '/admin/payouts';

export const payoutService = {
    async index(params = {}) {
        const response = await api.get(API_URL, { params });
        return response.data;
    },

    async show(id) {
        const response = await api.get(`${API_URL}/${id}`);
        return response.data;
    },

    async update(id, data) {
        const response = await api.put(`${API_URL}/${id}`, data);
        return response.data;
    },

    async destroy(id) {
        const response = await api.delete(`${API_URL}/${id}`);
        return response.data;
    }
};
