import api from './api';

const API_URL = '/admin/settings';

export const settingsService = {
    /**
     * Get all settings
     */
    async getAll() {
        const response = await api.get(API_URL);
        return response.data;
    },

    /**
     * Get general settings
     */
    async getGeneral() {
        const response = await api.get(`${API_URL}/general`);
        return response.data;
    },

    /**
     * Get settings by group
     */
    async getByGroup(group) {
        const response = await api.get(`${API_URL}/group/${group}`);
        return response.data;
    },

    /**
     * Get all available timezones
     */
    async getTimezones() {
        const response = await api.get(`${API_URL}/timezones`);
        return response.data;
    },

    /**
     * Update multiple settings
     */
    async update(settings) {
        const response = await api.post(API_URL, { settings });
        return response.data;
    },

    /**
     * Update a single setting
     */
    async updateSingle(key, value, type = 'string', group = 'general') {
        const response = await api.post(`${API_URL}/single`, {
            key,
            value,
            type,
            group
        });
        return response.data;
    }
};
