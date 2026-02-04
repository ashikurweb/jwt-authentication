<template>
  <div class="px-8 py-20 text-center space-y-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="w-20 h-20 bg-indigo-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-indigo-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
    </div>
    <h2 class="text-2xl font-black theme-text-main">Module Under Development</h2>
    <p class="theme-text-muted max-w-sm mx-auto font-medium">We are currently building the <span class="text-indigo-500 font-bold">{{ moduleName }}</span> module to provide you with the best experience.</p>
    <router-link to="/admin/dashboard" class="inline-block mt-6 px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 active:scale-95 transition-all">Back to Dashboard</router-link>
  </div>
</template>

<script setup>
defineProps({
    moduleName: { type: String, default: 'Feature' }
});
</script>
