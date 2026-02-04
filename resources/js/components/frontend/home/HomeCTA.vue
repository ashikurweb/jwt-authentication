<template>
  <section class="py-60 px-6 relative overflow-hidden">
    <!-- Center Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl aspect-square bg-indigo-600/20 blur-[180px] rounded-full"></div>

    <div class="max-w-[1200px] mx-auto text-center space-y-16 relative z-10">
        <h2 class="revealer-up-cta opacity-0 text-7xl md:text-9xl font-black theme-text-main tracking-tighter leading-[0.85] filter drop-shadow-2xl">
            Ready to <br /> Initialize?
        </h2>
        <p class="revealer-up-cta opacity-0 text-xl md:text-3xl theme-text-dim font-medium max-w-3xl mx-auto leading-relaxed">
          "Join over 52,000+ elite engineers redefining the scale of technical excellence on Nexus."
        </p>

        <div class="revealer-up-cta opacity-0 flex flex-col sm:flex-row items-center justify-center gap-10 pt-10">
            <button class="w-full sm:w-auto px-20 py-10 bg-indigo-600 hover:bg-indigo-500 text-white rounded-[4rem] font-black text-3xl shadow-[0_40px_100px_rgba(79,70,229,0.5)] transition-all active:scale-95">
                Join Now free
            </button>
            <div class="flex -space-x-6">
                <img v-for="i in 5" :key="i" :src="`https://i.pravatar.cc/150?u=${i+10}`" class="w-20 h-20 rounded-full border-4 theme-border bg-slate-800 shadow-2xl transition-transform hover:-translate-y-4">
            </div>
        </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

onMounted(() => {
  gsap.to(".revealer-up-cta", {
    scrollTrigger: {
      trigger: ".revealer-up-cta",
      start: "top 85%",
    },
    y: 0,
    opacity: 1,
    duration: 1.5,
    stagger: 0.25,
    ease: "power4.out"
  });
});
</script>

<style scoped>
.revealer-up-cta { transform: translateY(100px); }
</style>
