import api from './api';

export const publicBlogService = {
    async getPosts(params = {}) {
        const response = await api.get('/blog/posts', { params });
        return response.data;
    },

    async getFeaturedPosts() {
        const response = await api.get('/blog/posts/featured');
        return response.data;
    },

    async getPost(slug) {
        const response = await api.get(`/blog/posts/${slug}`);
        return response.data;
    },

    async getCategories() {
        const response = await api.get('/blog/categories');
        return response.data;
    },

    async sharePost(slug) {
        const response = await api.post(`/blog/posts/${slug}/share`);
        return response.data;
    },

    async likePost(slug) {
        const response = await api.post(`/blog/posts/${slug}/like`);
        return response.data;
    },

    async commentOnPost(slug, data) {
        const response = await api.post(`/blog/posts/${slug}/comment`, data);
        return response.data;
    }
};
