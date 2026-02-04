<template>
  <header 
    class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] w-[92%] max-w-[1600px] transition-all duration-700"
  >
    <div 
      class="flex justify-between items-center px-10 py-5 rounded-[2.5rem] theme-border border backdrop-blur-2xl transition-all duration-500"
      :class="[
        isScrolled 
          ? 'theme-bg-navbar shadow-2xl shadow-indigo-500/10 scale-95 md:scale-100' 
          : 'bg-white/10 border-white/10 scale-100'
      ]"
    >
      <!-- Brand -->
      <router-link to="/" class="flex items-center gap-3 group">
        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/20 group-hover:rotate-12 transition-all">
           <span class="text-white font-black text-xl">N</span>
        </div>
        <div class="flex flex-col -space-y-1">
          <span class="text-xl font-black theme-text-main tracking-tighter uppercase italic leading-none">Nexus<span class="text-indigo-600 not-italic">LMS</span></span>
          <span class="text-[8px] font-black theme-text-dim uppercase tracking-[0.3em] pl-1">Engineering</span>
        </div>
      </router-link>

      <!-- Minimal Center Nav -->
      <nav class="hidden md:flex items-center gap-10 px-10 border-x theme-border mx-6">
        <router-link 
          v-for="item in navItems" 
          :key="item.name" 
          :to="item.path"
          class="text-[10px] font-black theme-text-dim hover:theme-text-main uppercase tracking-widest transition-all relative group"
        >
          {{ item.name }}
          <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
        </router-link>
      </nav>

      <!-- Actions -->
      <div class="flex items-center gap-5">
        <button @click="toggleTheme" class="w-10 h-10 flex items-center justify-center rounded-xl hover:theme-bg-hover transition-all border theme-border theme-bg-element shadow-sm">
          <svg v-if="theme === 'dark'" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.95 16.95l.707.707M7.05 7.05l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
          </svg>
          <svg v-else class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
          </svg>
        </button>
        
        <router-link to="/login" class="text-[10px] font-black theme-text-main uppercase tracking-widest hover:text-indigo-600 transition-colors hidden sm:block">Login</router-link>
        
        <router-link 
          to="/pricing" 
          class="px-7 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-indigo-600/20 active:scale-95 transition-all flex items-center gap-2 group/sub"
        >
          <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
          Subscribe
        </router-link>
        
        <!-- Mobile Menu Trigger -->
        <button @click="$emit('toggle-mobile-menu')" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl theme-bg-element border theme-border">
          <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" /></svg>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useTheme } from '../../../composables/useTheme';

defineProps({
  isScrolled: Boolean,
  navItems: Array
});

defineEmits(['toggle-mobile-menu']);

const { theme, toggleTheme } = useTheme();
</script>
