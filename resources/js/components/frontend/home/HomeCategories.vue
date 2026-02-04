<template>
  <section class="py-40 px-6 theme-bg-card/30 border-y theme-border overflow-hidden">
    <div class="max-w-[1600px] mx-auto">
        <div class="revealer-up-cat opacity-0 text-center space-y-5 mb-24">
            <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.5em]">Specializations</h4>
            <h2 class="text-6xl md:text-8xl font-black theme-text-main tracking-tighter">System Domains</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div 
              v-for="cat in categories" 
              :key="cat.name" 
              class="revealer-up-cat opacity-0 p-12 rounded-[4rem] theme-bg-main border theme-border hover:border-indigo-500/30 hover:shadow-3xl transition-all duration-700 group cursor-pointer text-center space-y-8"
            >
                <div class="w-24 h-24 mx-auto rounded-[2.5rem] theme-bg-element flex items-center justify-center text-5xl transition-transform group-hover:scale-110 group-hover:rotate-12 shadow-inner">
                    {{ cat.emoji }}
                </div>
                <div class="space-y-3">
                    <h3 class="text-3xl font-black theme-text-main group-hover:text-indigo-600 transition-colors">{{ cat.name }}</h3>
                    <p class="text-[10px] font-black theme-text-dim uppercase tracking-[0.3em]">{{ cat.count }}+ Academy Units</p>
                </div>
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

const categories = [
  { name: 'Cloud Engineering', count: 142, emoji: '☁️' },
  { name: 'Security Logic', count: 85, emoji: '🔐' },
  { name: 'Machine Systems', count: 247, emoji: '🧬' },
  { name: 'Scale DevOps', count: 110, emoji: '🚀' },
];

onMounted(() => {
  gsap.to(".revealer-up-cat", {
    scrollTrigger: {
      trigger: ".revealer-up-cat",
      start: "top 85%",
    },
    y: 0,
    opacity: 1,
    duration: 1.2,
    stagger: 0.15,
    ease: "power3.out"
  });
});
</script>

<style scoped>
.revealer-up-cat { transform: translateY(60px); }
</style>
