<template>
  <tr class="transition-all duration-500">
    <td :colspan="cols" class="px-8 py-40 text-center">
      <div class="flex flex-col items-center justify-center space-y-8">
        <!-- Ultra-Premium Glass Spinner -->
        <div class="relative w-24 h-24 flex items-center justify-center">
          <!-- Outer Glow -->
          <div class="absolute inset-0 bg-indigo-500/20 blur-[40px] rounded-full animate-pulse-slow"></div>
          
          <!-- Spinning Rings -->
          <svg class="w-full h-full animate-spin-slow" viewBox="0 0 100 100">
            <defs>
              <linearGradient id="spinner-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#a855f7;stop-opacity:0" />
              </linearGradient>
            </defs>
            <circle 
              cx="50" cy="50" r="45" 
              fill="none" 
              stroke="url(#spinner-grad)" 
              stroke-width="4" 
              stroke-linecap="round"
              stroke-dasharray="180 100"
            />
          </svg>

          <!-- Middle Counter-Rotating Ring -->
          <svg class="absolute w-16 h-16 animate-spin-reverse-medium" viewBox="0 0 100 100">
            <circle 
              cx="50" cy="50" r="45" 
              fill="none" 
              stroke="#10b981" 
              stroke-width="6" 
              stroke-linecap="round"
              stroke-dasharray="80 200"
              class="opacity-40"
            />
          </svg>

          <!-- Inner Core Pulse -->
          <div class="absolute w-4 h-4 bg-indigo-500 rounded-full shadow-[0_0_20px_rgba(99,102,241,0.8)] animate-ping"></div>
        </div>
        
        <div class="space-y-3">
          <div class="flex items-center justify-center gap-2">
            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce"></span>
            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
          </div>
          <h3 class="text-xl font-black theme-text-main tracking-[0.1em] uppercase">Loading Data</h3>
          <p class="text-[10px] theme-text-dim font-bold tracking-[0.3em] uppercase opacity-40">Compiling your workspace</p>
        </div>
      </div>
    </td>
  </tr>
</template>

<script setup>
defineProps({
  cols: {
    type: Number,
    default: 7
  }
});
</script>

<style scoped>
.animate-spin-slow {
  animation: spin 3s linear infinite;
}

.animate-spin-reverse-medium {
  animation: spin-reverse 1.5s linear infinite;
}

.animate-pulse-slow {
  animation: pulse-glow 4s ease-in-out infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

@keyframes spin-reverse {
  from { transform: rotate(360deg); }
  to { transform: rotate(0deg); }
}

@keyframes pulse-glow {
  0%, 100% { opacity: 0.2; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.2); }
}
</style>
