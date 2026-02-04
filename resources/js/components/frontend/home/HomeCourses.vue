<template>
  <section class="py-40 px-6">
    <div class="max-w-[1600px] mx-auto">
        <div class="revealer-up-course opacity-0 flex flex-col md:flex-row md:items-end justify-between gap-10 mb-24">
            <div class="space-y-4">
                <h4 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.5em]">Curriculum Database</h4>
                <h2 class="text-6xl md:text-8xl font-black theme-text-main tracking-tighter leading-none">Engineering Tracks</h2>
            </div>
            <router-link to="/courses" class="text-[10px] font-black theme-text-main uppercase tracking-[0.4em] flex items-center gap-5 group py-4 px-10 border-2 theme-border rounded-full hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                Access All Modules
                <div class="w-10 h-10 rounded-full bg-indigo-600 group-hover:bg-white text-white group-hover:text-indigo-600 flex items-center justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </router-link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <div v-for="course in courses" :key="course.id" class="revealer-up-course opacity-0 group theme-bg-card border-2 theme-border rounded-[4rem] overflow-hidden hover:shadow-4xl transition-all duration-700 hover:-translate-y-4">
                <!-- Course Media Layer -->
                <div class="h-80 relative overflow-hidden">
                    <img :src="course.thumbnail" class="w-full h-full object-cover grayscale-[0.5] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-[1.5s] ease-out">
                    <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/20 to-transparent"></div>
                    
                    <!-- Metadata Badges -->
                    <div class="absolute top-8 left-8 flex flex-col gap-2">
                        <span v-if="course.is_bestseller" class="px-4 py-1.5 bg-amber-500 text-black text-[9px] font-black uppercase tracking-widest rounded-lg shadow-xl">Bestseller</span>
                        <span v-if="course.is_new" class="px-4 py-1.5 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-xl">New Protocol</span>
                    </div>

                    <div class="absolute bottom-8 left-8 right-8 flex items-center justify-between text-white">
                        <div class="flex items-center gap-3">
                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-xl rounded-xl text-[9px] font-black uppercase tracking-widest border border-white/20">{{ course.level }}</span>
                            <span class="text-white/60 text-[10px] font-bold">{{ course.duration }}m</span>
                        </div>
                        <div class="flex flex-col items-end">
                            <span v-if="course.compare_price" class="text-xs text-white/40 line-through font-bold">${{ course.compare_price }}</span>
                            <span class="text-3xl font-black tracking-tighter">${{ course.price }}</span>
                        </div>
                    </div>
                </div>

                <!-- Course Content Layer -->
                <div class="p-12 space-y-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center text-amber-500">
                                <svg v-for="i in 5" :key="i" class="w-3 h-3" :class="i <= Math.floor(course.rating) ? 'fill-current' : 'opacity-30'" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <span class="text-[10px] font-black theme-text-dim">({{ course.total_reviews }} reviews)</span>
                        </div>
                        <h3 class="text-3xl font-black theme-text-main group-hover:text-indigo-600 transition-colors leading-[1.1] tracking-tighter">{{ course.title }}</h3>
                        <p class="theme-text-dim text-sm font-medium leading-relaxed line-clamp-2 italic">"{{ course.short_description }}"</p>
                    </div>
                    
                    <!-- Instructor & Meta Footer -->
                    <div class="pt-10 border-t theme-border flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-linear-to-tr from-indigo-500 to-violet-500 border-2 border-white/10 p-0.5">
                                <img :src="`https://ui-avatars.com/api/?name=${course.instructor}&background=0b1120&color=fff`" class="w-full h-full rounded-[0.9rem] object-cover">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black theme-text-main uppercase tracking-widest leading-none">{{ course.instructor }}</span>
                                <span class="text-[9px] font-bold theme-text-dim uppercase tracking-[0.3em] mt-2">Lead Architect</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                             <button class="w-14 h-14 rounded-[1.5rem] theme-bg-element border-2 theme-border flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-xl hover:scale-110 active:scale-90">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            </button>
                             <button class="w-14 h-14 rounded-[1.5rem] bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-500 transition-all shadow-xl hover:scale-110 active:scale-90">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </button>
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

const courses = [
  { 
    id: 1, 
    title: 'Distributed Systems Mastery', 
    short_description: 'Building resilient, fault-tolerant ecosystems at global scale using modern protocols.',
    level: 'Advanced', 
    price: 199, 
    compare_price: 299,
    instructor: 'Dr. Helena Ray', 
    thumbnail: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc51?auto=format&fit=crop&q=80&w=800',
    rating: 4.8,
    total_reviews: 1240,
    duration: 1420,
    is_bestseller: true,
    is_new: false
  },
  { 
    id: 2, 
    title: 'Quantum Computing Fundamentals', 
    short_description: 'Deep dive into quantum algorithms and their implementation in current systems.',
    level: 'Expert', 
    price: 149, 
    compare_price: null,
    instructor: 'Xavier Vance', 
    thumbnail: 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&q=80&w=800',
    rating: 4.9,
    total_reviews: 856,
    duration: 840,
    is_bestseller: false,
    is_new: true
  },
  { 
    id: 3, 
    title: 'Cloud Infrastructure Governance', 
    short_description: 'Establishing zero-trust security and policy-driven governance across cloud providers.',
    level: 'Pro', 
    price: 99, 
    compare_price: 159,
    instructor: 'Marcus Jin', 
    thumbnail: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=800',
    rating: 4.7,
    total_reviews: 2100,
    duration: 1120,
    is_bestseller: true,
    is_new: false
  },
];

onMounted(() => {
  gsap.to(".revealer-up-course", {
    scrollTrigger: {
      trigger: ".revealer-up-course",
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
.revealer-up-course { transform: translateY(70px); }
.shadow-4xl {
    box-shadow: 0 60px 100px -20px rgba(0, 0, 0, 0.4), 0 30px 60px -30px rgba(79, 70, 229, 0.2);
}
</style>
