<template>
  <section class="py-40 px-6 overflow-hidden">
    <div class="max-w-[1600px] mx-auto rounded-[5rem] theme-bg-card border-2 theme-border relative overflow-hidden group shadow-2xl">
        <div class="absolute inset-0 bg-indigo-500/5 backdrop-blur-3xl"></div>
        <div class="relative z-10 px-10 md:px-24 py-24 grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            <div class="space-y-10 revealer-up-blog opacity-0">
                <div class="inline-flex items-center gap-4 text-indigo-600">
                  <div class="h-1 w-12 bg-indigo-600"></div>
                  <h4 class="text-xs font-black uppercase tracking-[0.5em]">Nexus Digital Journal</h4>
                </div>
                <h2 class="text-6xl md:text-6xl lg:text-8xl font-black theme-text-main tracking-tighter leading-[0.9]">Technical <br /> <span class="text-indigo-600">Blog</span> & Intelligence.</h2>
                <p class="theme-text-dim text-xl md:text-2xl font-medium leading-relaxed max-w-xl italic">
                  "Deep dives into cloud orchestration, distributed architectures, and elite security protocols. Pure technical excellence."
                </p>
                <router-link to="/blog" class="inline-flex items-center gap-6 px-12 py-6 bg-indigo-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-widest hover:bg-indigo-500 transition-all shadow-2xl active:scale-95 group/btn">
                    Read the Analytics
                    <svg class="w-6 h-6 group-hover/btn:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5-5 5"/></svg>
                </router-link>
            </div>
            <div class="grid grid-cols-1 gap-8 revealer-up-blog opacity-0">
                <div v-for="post in blogPosts" :key="post.title" class="p-10 rounded-[3rem] theme-bg-main border-2 theme-border hover:border-indigo-500/30 transition-all cursor-pointer group/card shadow-sm hover:shadow-2xl">
                    <div class="flex items-center gap-6 mb-6">
                        <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">{{ post.category }}</span>
                        <div class="h-px flex-1 bg-indigo-600/20"></div>
                        <span class="text-[9px] font-black theme-text-dim uppercase tracking-widest">{{ post.readTime }} Read</span>
                    </div>
                    <h3 class="text-2xl font-black theme-text-main group-hover/card:text-indigo-600 transition-colors tracking-tight leading-tight">{{ post.title }}</h3>
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

const blogPosts = [
    { title: "The Architecture of Global Scale Distributed Databases", category: "Engine", readTime: "12 min" },
    { title: "Zero Trust Security in Multi-Cloud Ecosystems", category: "Security", readTime: "8 min" },
    { title: "Event-Driven Logic: Beyond Microservices", category: "Logic", readTime: "15 min" },
];

onMounted(() => {
  gsap.to(".revealer-up-blog", {
    scrollTrigger: {
      trigger: ".revealer-up-blog",
      start: "top 85%",
    },
    y: 0,
    opacity: 1,
    duration: 1.2,
    stagger: 0.2,
    ease: "power3.out"
  });
});
</script>

<style scoped>
.revealer-up-blog { transform: translateY(80px); }
</style>
