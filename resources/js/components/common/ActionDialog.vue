<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-100 flex items-center justify-center p-4 overflow-hidden">
        <!-- Backdrop with faster blur -->
        <div 
          class="absolute inset-0 bg-slate-950/40 backdrop-blur-sm shadow-inner transition-all duration-300"
          @click="$emit('cancel')"
        ></div>

        <!-- Dialog Card -->
        <Transition
          enter-active-class="transition duration-300 cubic-bezier(0.34, 1.56, 0.64, 1)"
          enter-from-class="opacity-0 scale-90 translate-y-8"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-90 translate-y-8"
        >
          <div v-if="show" class="relative w-full max-w-md theme-bg-card rounded-[2.5rem] border theme-border shadow-[0_32px_64px_-16px_rgba(0,0,0,0.5)] overflow-hidden p-8 text-center glass-card">
            <!-- Premium Icon Header -->
            <div class="mb-6 relative">
              <div class="w-20 h-20 rounded-3xl bg-rose-500/10 flex items-center justify-center mx-auto relative z-10 box-glow">
                <div class="absolute inset-0 bg-rose-500/20 rounded-3xl animate-ping opacity-20"></div>
                <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </div>
              <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-rose-500/5 blur-3xl rounded-full"></div>
            </div>

            <!-- Content -->
            <div class="space-y-2 mb-8">
              <h3 class="text-2xl font-black theme-text-main tracking-tight">{{ title }}</h3>
              <p class="text-sm theme-text-dim font-medium leading-relaxed px-4">{{ message }}</p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-3">
              <button
                @click="$emit('confirm')"
                :disabled="loading"
                class="w-full bg-rose-500 hover:bg-rose-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-rose-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-3 group/btn"
              >
                <svg v-if="loading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="group-hover/btn:tracking-wide transition-all">{{ confirmText }}</span>
              </button>
              <button
                @click="$emit('cancel')"
                :disabled="loading"
                class="w-full theme-bg-element hover:bg-slate-500/10 theme-border border py-4 rounded-2xl font-bold theme-text-main active:scale-[0.98] transition-all border-transparent hover:theme-border"
              >
                {{ cancelText }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  show: Boolean,
  title: {
    type: String,
    default: 'Are you sure?'
  },
  message: {
    type: String,
    default: 'This action cannot be undone.'
  },
  confirmText: {
    type: String,
    default: 'Yes, Delete'
  },
  cancelText: {
    type: String,
    default: 'Cancel'
  },
  loading: {
    type: Boolean,
    default: false
  }
});

defineEmits(['confirm', 'cancel']);
</script>

<style scoped>
.box-glow {
  box-shadow: 0 0 20px rgba(244, 63, 94, 0.1);
}
.glass-card {
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
}
</style>
