<template>
  <section class="revealer-up opacity-0 py-20 px-6 border-t theme-border">
    <div class="max-w-[1600px] mx-auto grid grid-cols-2 lg:grid-cols-4 gap-12 md:gap-20">
      <div v-for="stat in quickStats" :key="stat.label" class="space-y-4 group">
          <p class="text-5xl md:text-7xl font-black theme-text-main tracking-tighter group-hover:text-indigo-600 transition-colors duration-500">{{ stat.value }}</p>
          <div class="flex flex-col">
            <p class="text-[11px] font-black theme-text-dim uppercase tracking-[0.4em] leading-tight">{{ stat.label }}</p>
            <div class="h-1 w-0 bg-indigo-600 mt-2 transition-all duration-700 group-hover:w-full"></div>
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

const quickStats = [
  { label: 'Active Learners on Node', value: '52K+' },
  { label: 'Technical Modules Released', value: '1.2K+' },
  { label: 'Expert Mentor Architects', value: '450+' },
  { label: 'Fortune 500 Career rate', value: '98%' },
];

onMounted(() => {
  gsap.to(".revealer-up", {
    scrollTrigger: {
      trigger: ".revealer-up",
      start: "top 90%",
    },
    y: 0,
    opacity: 1,
    duration: 1.2,
    ease: "power3.out"
  });
});
</script>

<style scoped>
.revealer-up { transform: translateY(50px); }
</style>
