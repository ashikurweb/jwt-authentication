import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        redirect: '/admin/dashboard'
    },
    {
        path: '/admin',
        component: () => import('../layouts/DashboardLayout.vue'),
        children: [
            { path: 'dashboard', name: 'dashboard', component: () => import('../views/admin/dashboard/Index.vue') },
            // Learning
            { path: 'courses', name: 'courses', component: () => import('../views/admin/courses/Index.vue') },
            { path: 'categories', name: 'categories', component: () => import('../views/admin/categories/Index.vue') },
            { path: 'bundles', name: 'bundles', component: () => import('../views/admin/bundles/Index.vue') },
            { path: 'assignments', name: 'assignments', component: () => import('../views/admin/assignments/Index.vue') },
            { path: 'quizzes', name: 'quizzes', component: () => import('../views/admin/quizzes/Index.vue') },
            // Users
            { path: 'users', name: 'users', component: () => import('../views/admin/users/Index.vue') },
            { path: 'instructors', name: 'instructors', component: () => import('../views/admin/instructors/Index.vue') },
            { path: 'discussions', name: 'discussions', component: () => import('../views/admin/discussions/Index.vue') },
            { path: 'live-classes', name: 'live-classes', component: () => import('../views/admin/live-classes/Index.vue') },
            // Finance
            { path: 'orders', name: 'orders', component: () => import('../views/admin/orders/Index.vue') },
            { path: 'payouts', name: 'payouts', component: () => import('../views/admin/payouts/Index.vue') },
            { path: 'affiliates', name: 'affiliates', component: () => import('../views/admin/affiliates/Index.vue') },
            // Settings
            { path: 'settings', name: 'settings', component: () => import('../views/admin/settings/Index.vue') }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;