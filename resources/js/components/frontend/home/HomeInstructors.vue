<template>
  <section class="py-40 px-6 theme-bg-card/20">
    <div class="max-w-[1600px] mx-auto">
        <div class="revealer-up-inst opacity-0 flex flex-col md:flex-row md:items-end justify-between gap-10 mb-24">
            <div class="space-y-4">
                <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.5em]">The Council</h4>
                <h2 class="text-6xl md:text-8xl font-black theme-text-main tracking-tighter leading-none">Master Architects</h2>
            </div>
            <router-link to="/instructors" class="text-[10px] font-black theme-text-main uppercase tracking-[0.4em] flex items-center gap-5 group py-4 px-8 border theme-border rounded-full hover:bg-indigo-600 hover:text-white transition-all">
                Meet All Mentors
                <div class="w-10 h-10 rounded-full bg-indigo-600 group-hover:bg-white text-white group-hover:text-indigo-600 flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </router-link>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div v-for="inst in instructors" :key="inst.name" class="revealer-up-inst opacity-0 group theme-bg-main border-2 theme-border rounded-[4rem] p-10 text-center hover:border-indigo-500/30 transition-all duration-700 shadow-sm hover:shadow-4xl">
                <div class="relative w-48 h-48 mx-auto mb-10 group">
                    <div class="absolute inset-0 bg-indigo-600 rounded-[3rem] rotate-6 group-hover:rotate-12 transition-transform duration-500 opacity-20"></div>
                    <img :src="inst.image" class="relative w-full h-full object-cover rounded-[3rem] border-4 theme-border grayscale group-hover:grayscale-0 transition-all duration-700 shadow-2xl">
                </div>
                <div class="space-y-3">
                    <h3 class="text-3xl font-black theme-text-main group-hover:text-indigo-600 transition-colors tracking-tight">{{ inst.name }}</h3>
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">{{ inst.role }}</p>
                    <div class="pt-6 flex justify-center gap-4 opacity-40 group-hover:opacity-100 transition-opacity">
                         <div v-for="i in 3" :key="i" class="w-8 h-8 rounded-xl theme-bg-element border theme-border flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all text-xs">
                             <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.45-1.13-1.09-1.43-1.09-1.43-.9-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.89 1.52 2.34 1.08 2.91.83.09-.64.35-1.08.63-1.33-2.22-.25-4.55-1.11-4.55-4.94 0-1.1.39-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.64.71 1.03 1.61 1.03 2.71 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85v2.74c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12c0-5.523-4.477-10-10-10z"/></svg>
                         </div>
                    </div>
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

const instructors = [
  { name: 'Dr. Helena Ray', role: 'Dist. Architect', image: 'https://i.pravatar.cc/300?u=helena' },
  { name: 'Xavier Vance', role: 'Quantum Systems', image: 'https://i.pravatar.cc/300?u=xavier' },
  { name: 'Sarah Drasner', role: 'Vue Principal', image: 'https://i.pravatar.cc/300?u=sarah' },
  { name: 'Marcus Jin', role: 'Cloud Lead', image: 'https://i.pravatar.cc/300?u=marcus' },
];

onMounted(() => {
  gsap.to(".revealer-up-inst", {
    scrollTrigger: {
      trigger: ".revealer-up-inst",
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
.revealer-up-inst { transform: translateY(60px); }
.shadow-4xl {
    box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.4), 0 30px 60px -30px rgba(79, 70, 229, 0.2);
}
</style>
