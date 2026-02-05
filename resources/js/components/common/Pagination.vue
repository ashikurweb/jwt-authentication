<template>
  <div v-if="pagination.total > pagination.per_page" class="px-8 py-5 border-t theme-border theme-bg-element/30 flex flex-col sm:flex-row items-center justify-between gap-4">
    <!-- Meta Info -->
    <p class="text-xs font-bold theme-text-dim tracking-tight order-2 sm:order-1">
      Showing 
      <span class="theme-text-main">{{ pagination.from }}</span> 
      to 
      <span class="theme-text-main">{{ pagination.to }}</span> 
      of 
      <span class="theme-text-main">{{ pagination.total }}</span> 
      results
    </p>

    <!-- Navigation -->
    <div class="flex items-center gap-1 order-1 sm:order-2">
      <!-- Prev Button -->
      <button 
        @click="changePage(pagination.current_page - 1)"
        :disabled="pagination.current_page === 1"
        class="w-10 h-10 flex items-center justify-center rounded-xl theme-bg-card border theme-border theme-text-muted hover:theme-text-main hover:border-indigo-500/50 transition-all disabled:opacity-30 disabled:pointer-events-none active:scale-90"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </button>

      <!-- Page Numbers -->
      <div class="flex items-center gap-1 mx-1">
        <template v-for="page in displayedPages" :key="page">
          <button 
             v-if="page !== '...'"
             @click="changePage(page)"
             class="w-10 h-10 flex items-center justify-center rounded-xl font-black text-xs transition-all active:scale-90"
             :class="pagination.current_page === page 
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' 
                : 'theme-bg-card border theme-border theme-text-dim hover:theme-text-main hover:border-indigo-500/50'"
          >
            {{ page }}
          </button>
          <span v-else class="w-8 text-center theme-text-dim font-bold">...</span>
        </template>
      </div>

      <!-- Next Button -->
      <button 
        @click="changePage(pagination.current_page + 1)"
        :disabled="pagination.current_page === pagination.last_page"
        class="w-10 h-10 flex items-center justify-center rounded-xl theme-bg-card border theme-border theme-text-muted hover:theme-text-main hover:border-indigo-500/50 transition-all disabled:opacity-30 disabled:pointer-events-none active:scale-90"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  pagination: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['change']);

const changePage = (page) => {
  if (page >= 1 && page <= props.pagination.last_page && page !== props.pagination.current_page) {
    emit('change', page);
  }
};

const displayedPages = computed(() => {
  const current = props.pagination.current_page;
  const last = props.pagination.last_page;
  const delta = 2;
  const left = current - delta;
  const right = current + delta + 1;
  const range = [];
  const rangeWithDots = [];
  let l;

  for (let i = 1; i <= last; i++) {
    if (i === 1 || i === last || (i >= left && i < right)) {
      range.push(i);
    }
  }

  for (let i of range) {
    if (l) {
      if (i - l === 2) {
        rangeWithDots.push(l + 1);
      } else if (i - l !== 1) {
        rangeWithDots.push('...');
      }
    }
    rangeWithDots.push(i);
    l = i;
  }

  return rangeWithDots;
});
</script>
