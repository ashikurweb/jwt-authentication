<template>
  <div class="relative max-w-md w-full">
    <!-- Search Trigger Area -->
    <div 
      @click="openModal"
      class="group relative flex items-center w-full px-4 py-2.5 theme-bg-element border border-transparent hover:border-indigo-500/30 rounded-2xl cursor-pointer transition-all duration-300"
    >
      <svg class="w-5 h-5 theme-text-dim group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
      <span class="ml-3 text-sm theme-text-dim group-hover:theme-text-muted transition-colors">Search anything...</span>
      
      <div class="ml-auto flex items-center gap-1">
        <kbd class="px-1.5 py-0.5 text-[10px] font-bold theme-text-dim bg-white/50 dark:bg-slate-800/50 border theme-border rounded shadow-sm">{{ isMac ? '⌘' : 'Ctrl' }}</kbd>
        <kbd class="px-1.5 py-0.5 text-[10px] font-bold theme-text-dim bg-white/50 dark:bg-slate-800/50 border theme-border rounded shadow-sm">K</kbd>
      </div>
    </div>

    <!-- Search Modal -->
    <Teleport to="body">
      <Transition name="modal">
        <div v-if="isOpen" class="fixed inset-0 z-[100] flex items-start justify-center pt-[10vh] px-4 backdrop-blur-md bg-slate-900/20">
          <!-- Backdrop click to close -->
          <div class="absolute inset-0" @click="closeModal"></div>

          <!-- Modal Content -->
          <div class="relative w-full max-w-2xl theme-bg-card border theme-border rounded-[2rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200">
            <!-- Search Header -->
            <div class="p-6 border-b theme-border flex items-center gap-4">
              <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <input 
                ref="searchInput"
                type="text" 
                v-model="searchQuery"
                placeholder="Find courses, mentors, or files..."
                class="flex-1 bg-transparent border-none outline-none text-lg theme-text-main placeholder:theme-text-dim"
                @keydown.esc="closeModal"
              >
              <button @click="closeModal" class="p-2 theme-text-dim hover:theme-bg-element rounded-xl transition-colors">
                <kbd class="text-xs font-bold uppercase tracking-widest">Esc</kbd>
              </button>
            </div>

            <!-- Results Preview / Empty State -->
            <div class="max-h-[60vh] overflow-y-auto p-4 custom-scrollbar">
              <div v-if="!searchQuery" class="py-12 text-center space-y-4">
                <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold theme-text-main">Quick Actions</h3>
                    <p class="text-sm theme-text-dim">Search for anything or use shortcuts below.</p>
                </div>
                <div class="grid grid-cols-2 gap-3 max-w-sm mx-auto">
                    <button class="flex items-center gap-3 p-3 theme-bg-element hover:theme-bg-hover rounded-xl text-left transition-all">
                        <span class="text-lg">📚</span>
                        <span class="text-xs font-bold theme-text-main">My Courses</span>
                    </button>
                    <button class="flex items-center gap-3 p-3 theme-bg-element hover:theme-bg-hover rounded-xl text-left transition-all">
                        <span class="text-lg">👨‍🏫</span>
                        <span class="text-xs font-bold theme-text-main">Mentors</span>
                    </button>
                </div>
              </div>

              <!-- Dummy Results -->
              <div v-else class="space-y-2">
                 <div v-for="i in 3" :key="i" class="flex items-center gap-4 p-4 hover:theme-bg-element rounded-2xl cursor-pointer group transition-all">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold theme-text-main">Sample Result Item {{ i }}</h4>
                        <p class="text-[11px] theme-text-dim uppercase tracking-wider font-bold">Category • 2 hours ago</p>
                    </div>
                    <svg class="ml-auto w-5 h-5 theme-text-dim opacity-0 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                 </div>
              </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 theme-bg-element flex items-center justify-between border-t theme-border">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <kbd class="px-1.5 py-0.5 text-[10px] theme-text-dim bg-white dark:bg-slate-800 border theme-border rounded shadow-sm">↵</kbd>
                        <span class="text-[10px] theme-text-dim font-bold uppercase tracking-widest">Select</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <kbd class="px-1.5 py-0.5 text-[10px] theme-text-dim bg-white dark:bg-slate-800 border theme-border rounded shadow-sm">↑↓</kbd>
                        <span class="text-[10px] theme-text-dim font-bold uppercase tracking-widest">Navigate</span>
                    </div>
                </div>
                <div class="text-[10px] theme-text-dim font-bold uppercase">Search Powered by EduNexus</div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';

const isOpen = ref(false);
const searchQuery = ref('');
const isMac = ref(false);
const searchInput = ref(null);

const openModal = () => {
  isOpen.value = true;
  document.body.style.overflow = 'hidden';
  nextTick(() => {
    searchInput.value?.focus();
  });
};

const closeModal = () => {
  isOpen.value = false;
  searchQuery.value = '';
  document.body.style.overflow = 'auto';
};

onMounted(() => {
  isMac.value = /Mac|iPod|iPhone|iPad/.test(navigator.platform);
  window.addEventListener('keydown', handleGlobalKeydown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleGlobalKeydown);
});

const handleGlobalKeydown = (e) => {
  if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
    e.preventDefault();
    openModal();
  }
  if (e.key === 'Escape' && isOpen.value) {
    closeModal();
  }
};
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from, .modal-leave-to {
  opacity: 0;
}

/* Custom fade for the backdrop */
.bg-slate-900\/20 {
    transition: background-color 0.3s ease;
}
</style>
