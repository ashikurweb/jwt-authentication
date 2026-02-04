<template>
  <section class="min-h-screen relative flex items-center pt-20 overflow-hidden theme-bg-main selection:bg-indigo-500/30">
    <!-- Architectural Grid Background -->
    <div class="absolute inset-0 pointer-events-none -z-10 opacity-[0.03] dark:opacity-[0.07] bg-grid-pattern"></div>
    <div class="absolute top-0 right-0 w-[40%] h-full bg-linear-to-l from-indigo-600/10 to-transparent blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] left-[-5%] w-[30%] h-[50%] bg-violet-600/5 blur-[100px] -z-10"></div>

    <div class="max-w-[1600px] mx-auto px-8 md:px-16 lg:px-24 w-full grid grid-cols-1 lg:grid-cols-2 gap-20 items-center relative z-10">
      <!-- Left Content: Engineered Typography -->
      <div class="space-y-12">
        <div class="hero-stagger opacity-0 flex items-center gap-4">
          <div class="h-[2px] w-12 bg-indigo-600"></div>
          <span class="text-[11px] font-black uppercase tracking-[0.5em] theme-text-main leading-none">Nexus Protocol v4.0</span>
        </div>

        <h1 class="hero-stagger opacity-0 text-7xl md:text-8xl xl:text-[10rem] font-black theme-text-main tracking-tight-extreme leading-[0.82]">
          Build <br />
          <span class="text-indigo-600 italic">Beyond</span> <br />
          Limits.
        </h1>

        <p class="hero-stagger opacity-0 max-w-xl text-xl md:text-2xl theme-text-dim font-medium leading-relaxed">
          The industry's most rigorous technical ecosystem. Master complex systems, blockchain architecture, and enterprise-grade environments.
        </p>

        <div class="hero-stagger opacity-0 flex flex-col sm:flex-row items-center gap-6 pt-6">
          <button class="w-full sm:w-auto px-12 py-6 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-indigo-600/30 active:scale-95 transition-all group flex items-center justify-center gap-4">
            Initialize Access
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 8l5 5-5 5M6 8l5 5-5 5"/></svg>
          </button>
          <router-link to="/pricing" class="w-full sm:w-auto px-12 py-6 border-2 theme-border theme-text-main rounded-2xl font-black text-xs uppercase tracking-widest hover:theme-bg-hover active:scale-95 transition-all text-center">
            View Pricing
          </router-link>
        </div>

        <!-- Quick Integration Stats -->
        <div class="hero-stagger opacity-0 pt-16 grid grid-cols-3 gap-10 border-t theme-border max-w-lg">
            <div v-for="s in stats" :key="s.label" class="space-y-1">
                <p class="text-2xl font-black theme-text-main tracking-tighter">{{ s.val }}</p>
                <p class="text-[8px] font-black theme-text-dim uppercase tracking-[0.2em]">{{ s.label }}</p>
            </div>
        </div>
      </div>

      <!-- Right Visual: Abstract Blueprints -->
      <div class="relative hidden lg:block">
          <div class="absolute -inset-10 bg-indigo-600/5 blur-[100px] rounded-full animate-pulse-slow"></div>
          
          <div class="relative rounded-[4rem] border-2 theme-border theme-bg-card p-4 shadow-4xl transform rotate-3 hover:rotate-0 transition-all duration-[1.5s] overflow-hidden group">
              <div class="absolute inset-0 bg-linear-to-br from-indigo-500/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=1200" class="w-full aspect-[4/5] object-cover rounded-[3.5rem] grayscale-[0.8] group-hover:grayscale-0 transition-all duration-[2s]">
              
              <!-- Floating HUD Elements -->
              <div class="absolute top-12 right-12 w-32 h-32 bg-indigo-600/20 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] flex items-center justify-center animate-bounce-slow">
                  <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              </div>

              <div class="absolute bottom-12 left-12 right-12 p-8 rounded-[2.5rem] bg-black/60 backdrop-blur-2xl border border-white/10 text-white space-y-4 reveal-card opacity-0">
                  <div class="flex items-center gap-3">
                      <div class="flex -space-x-3">
                          <img v-for="i in 3" :key="i" :src="`https://i.pravatar.cc/100?u=${i}`" class="w-8 h-8 rounded-full border-2 border-indigo-600">
                      </div>
                      <span class="text-[9px] font-black uppercase tracking-widest text-indigo-400">Deployed Today</span>
                  </div>
                  <p class="text-lg font-bold leading-tight tracking-tight">"The depth of the Curriculum structure is lightyears ahead of conventional bootcamps."</p>
              </div>
          </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue';
import gsap from 'gsap';

const stats = [
    { val: '4.9/5', label: 'Avg Rating' },
    { val: '20ms', label: 'Latency' },
    { val: '99.9%', label: 'Success' },
];

onMounted(() => {
  gsap.to(".hero-stagger", {
    y: 0,
    opacity: 1,
    duration: 1.2,
    stagger: 0.15,
    ease: "power4.out",
    delay: 0.2
  });

  gsap.to(".reveal-card", {
    y: 0,
    opacity: 1,
    duration: 1.5,
    ease: "power3.out",
    delay: 1.2
  });
});
</script>

<style scoped>
.bg-grid-pattern {
    background-image: 
        linear-gradient(to right, rgba(79, 70, 229, 0.2) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(79, 70, 229, 0.2) 1px, transparent 1px);
    background-size: 80px 80px;
}
.tracking-tight-extreme { letter-spacing: -0.05em; }
.hero-stagger { transform: translateY(40px); }
.reveal-card { transform: translateY(20px); }

.shadow-4xl {
    box-shadow: 0 60px 100px -20px rgba(0, 0, 0, 0.5), 0 30px 60px -30px rgba(79, 70, 229, 0.2);
}

.animate-pulse-slow {
    animation: pulse-slow 8s infinite cubic-bezier(0.4, 0, 0.6, 1);
}

.animate-bounce-slow {
    animation: bounce-slow 4s infinite ease-in-out;
}

@keyframes pulse-slow {
    0%, 100% { opacity: 0.1; transform: scale(1); }
    50% { opacity: 0.2; transform: scale(1.1); }
}

@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
</style>
