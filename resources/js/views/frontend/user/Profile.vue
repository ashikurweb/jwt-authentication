<template>
  <div class="min-h-screen pt-24 pb-12 px-4 sm:px-6 lg:px-8 theme-bg-main">
    <div class="max-w-4xl mx-auto space-y-8">
      
      <!-- Welcome Header -->
      <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 flex items-center justify-between">
         <div>
            <h1 class="text-3xl font-black theme-text-main tracking-tight">My Profile</h1>
            <p class="theme-text-dim mt-2 font-medium">Manage your account settings and preferences.</p>
         </div>
         <div class="hidden sm:block">
            <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/20">
               <span class="text-2xl font-bold text-white uppercase">{{ user?.name?.charAt(0) }}</span>
            </div>
         </div>
      </div>

      <!-- Content Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
         
         <!-- Left Sidebar Info -->
         <div class="space-y-6">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 space-y-4">
               <div>
                  <label class="text-[10px] uppercase tracking-widest theme-text-muted font-bold">Full Name</label>
                  <p class="theme-text-main font-bold text-lg">{{ user?.name }}</p>
               </div>
               <div>
                  <label class="text-[10px] uppercase tracking-widest theme-text-muted font-bold">Email Address</label>
                  <p class="theme-text-main font-bold text-lg">{{ user?.email }}</p>
               </div>
               <div>
                  <label class="text-[10px] uppercase tracking-widest theme-text-muted font-bold">Account Role</label>
                  <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-xs font-black uppercase tracking-wider">
                     {{ user?.roles?.[0]?.name || 'Student' }}
                  </div>
               </div>
            </div>

            <button @click="handleLogout" class="w-full py-4 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-500 hover:text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center gap-2 group">
               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
               Sign Out Securely
            </button>
         </div>

         <!-- Right Content Area (Placeholder for Tab/Content) -->
         <div class="md:col-span-2 space-y-6">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-8 min-h-[300px] flex flex-col items-center justify-center text-center space-y-4">
               <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center">
                  <svg class="w-8 h-8 theme-text-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
               </div>
               <div>
                  <h3 class="text-xl font-bold theme-text-main">Enrolled Courses</h3>
                  <p class="theme-text-dim max-w-sm mx-auto mt-2 text-sm">You haven't enrolled in any courses yet. Explore our catalog to start learning.</p>
               </div>
               <router-link :to="{name: 'frontend.courses'}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-sm transition-colors">
                  Browse Catalog
               </router-link>
            </div>
         </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuth } from '../../../composables/useAuth';
import { useRouter } from 'vue-router';

const { user, logout } = useAuth();
const router = useRouter();

const handleLogout = async () => {
   await logout();
   router.push({ name: 'login' });
};
</script>
