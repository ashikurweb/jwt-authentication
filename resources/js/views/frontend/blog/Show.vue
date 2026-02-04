<template>
  <div class="min-h-screen">
    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1 z-[150] pointer-events-none">
      <div 
        class="h-full bg-indigo-600 transition-all duration-150 ease-out"
        :style="{ width: `${scrollProgress}%` }"
      ></div>
    </div>

    <!-- Article Header -->
    <header class="relative pt-40 pb-20 overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute inset-0 pointer-events-none -z-10 bg-dot-pattern opacity-30"></div>
      <div class="absolute top-0 right-0 w-[40%] h-full bg-linear-to-l from-indigo-600/10 to-transparent blur-[100px] -z-10"></div>
      
      <div class="max-w-5xl mx-auto px-8 md:px-16 text-center space-y-8">
        <div class="flex items-center justify-center gap-4">
          <router-link to="/blog" class="text-[10px] font-black theme-text-dim hover:theme-text-main uppercase tracking-[0.4em] transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Back to Journal
          </router-link>
          <span class="theme-text-muted">/</span>
          <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">{{ post.category }}</span>
        </div>

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black theme-text-main tracking-tighter leading-[0.95]">
          {{ post.title }}
        </h1>

        <div class="flex flex-col md:flex-row items-center justify-center gap-6 pt-6">
          <div class="flex items-center gap-4">
            <img :src="post.author.avatar" class="w-12 h-12 rounded-2xl border-2 theme-border object-cover">
            <div class="text-left">
              <p class="text-sm font-black theme-text-main">By {{ post.author.name }}</p>
              <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest">{{ post.author.role }}</p>
            </div>
          </div>
          <div class="hidden md:block w-px h-8 theme-border border-l"></div>
          <div class="flex items-center gap-8 text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">
            <span class="flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
              {{ post.date }}
            </span>
            <span class="flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              {{ post.readTime }} read
            </span>
          </div>
        </div>
      </div>
    </header>

    <!-- Featured Image -->
    <section class="max-w-[1400px] mx-auto px-8 md:px-16 pb-20">
      <div class="relative rounded-[4rem] overflow-hidden border-4 theme-border shadow-4xl aspect-video lg:aspect-21/9">
        <img :src="post.image" class="w-full h-full object-cover grayscale-[0.3] hover:grayscale-0 transition-all duration-[2s]">
        <div class="absolute inset-0 bg-linear-to-t from-black/20 via-transparent to-transparent"></div>
      </div>
    </section>

    <!-- Post Content & Sidebar -->
    <section class="max-w-7xl mx-auto px-8 md:px-16 pb-40">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-20">
        <!-- Main Content -->
        <article class="lg:col-span-8 space-y-12">
          <div class="prose prose-xl dark:prose-invert prose-indigo max-w-none">
            <p class="text-2xl font-medium leading-relaxed theme-text-main italic border-l-4 border-indigo-600 pl-8 mb-12">
              {{ post.excerpt }}
            </p>
            
            <div class="theme-text-main leading-relaxed space-y-8 text-lg md:text-xl font-medium" v-html="post.content"></div>
          </div>

          <!-- Tags & Share -->
          <div class="pt-12 border-t theme-border flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex flex-wrap gap-3">
              <span 
                v-for="tag in post.tags" 
                :key="tag"
                class="px-4 py-2 rounded-xl theme-bg-card border theme-border theme-text-dim text-[10px] font-black uppercase tracking-widest hover:border-indigo-500/50 hover:theme-text-main transition-all cursor-pointer"
              >
                #{{ tag }}
              </span>
            </div>
            
            <div class="flex items-center gap-4">
              <span class="text-[10px] font-black theme-text-dim uppercase tracking-widest">Share Protocol:</span>
              <div class="flex gap-2">
                <button v-for="i in 3" :key="i" class="w-10 h-10 rounded-xl theme-bg-element border theme-border flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Author Box -->
          <div class="mt-20 p-10 md:p-16 rounded-[3rem] theme-bg-card border-2 theme-border relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 blur-[50px] -z-10 group-hover:bg-indigo-600/10 transition-all"></div>
            <div class="flex flex-col md:flex-row items-center gap-10">
              <div class="relative">
                <div class="absolute inset-0 bg-indigo-600 rounded-3xl rotate-6 opacity-20 group-hover:rotate-12 transition-transform"></div>
                <img :src="post.author.avatar" class="relative w-32 h-32 rounded-3xl border-4 theme-border object-cover shadow-2xl">
              </div>
              <div class="flex-1 space-y-4 text-center md:text-left">
                <div class="space-y-1">
                  <h4 class="text-2xl font-black theme-text-main tracking-tight">Written by {{ post.author.name }}</h4>
                  <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">{{ post.author.role }}</p>
                </div>
                <p class="theme-text-dim text-lg leading-relaxed italic">"Helena is a Distinguished Architect with 15+ years of experience in designing high-availability distributed systems for global financial networks."</p>
                <div class="flex items-center justify-center md:justify-start gap-4 pt-2">
                  <button v-for="i in 3" :key="i" class="text-xs font-black theme-text-main uppercase tracking-widest hover:text-indigo-600 transition-colors">Twitter</button>
                </div>
              </div>
            </div>
          </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-16">
          <!-- Table of Contents (Simulated) -->
          <div class="p-10 rounded-[2.5rem] theme-bg-card border-2 theme-border space-y-8 sticky top-32">
            <h5 class="text-xs font-black theme-text-main uppercase tracking-[0.4em] border-b theme-border pb-4">On this page</h5>
            <nav class="space-y-4">
              <a v-for="i in 4" :key="i" href="#" class="block text-sm font-bold theme-text-dim hover:theme-text-main hover:translate-x-2 transition-all">
                0{{ i }}. {{ ['Foundation Core', 'Scaling Logic', 'Consistency Nodes', 'Production Benchmarks'][i-1] }}
              </a>
            </nav>

            <div class="pt-8 border-t theme-border space-y-6">
              <h5 class="text-xs font-black theme-text-main uppercase tracking-[0.4em]">Get more Intel</h5>
              <div class="relative">
                <input type="email" placeholder="Email for Protocol Updates" class="w-full px-6 py-4 rounded-xl theme-bg-element border theme-border theme-text-main text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                <button class="absolute right-2 top-2 bottom-2 px-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-all">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5-5 5"/></svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Related Posts -->
          <div class="space-y-8">
            <h5 class="text-xs font-black theme-text-main uppercase tracking-[0.4em] px-4">Related Intel</h5>
            <div class="space-y-6">
              <router-link 
                v-for="i in 3" 
                :key="i"
                to="/blog/next-post"
                class="group flex gap-6 p-4 rounded-3xl hover:theme-bg-hover transition-all"
              >
                <div class="w-24 h-24 shrink-0 rounded-2xl overflow-hidden border theme-border">
                  <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc51?auto=format&fit=crop&q=80&w=200" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                </div>
                <div class="space-y-2">
                  <h6 class="text-sm font-black theme-text-main leading-tight group-hover:text-indigo-600 transition-colors">Quantum Logic in Micro-Services</h6>
                  <p class="text-[9px] font-bold theme-text-dim uppercase tracking-widest">Digital Architect · 5 min</p>
                </div>
              </router-link>
            </div>
          </div>
        </aside>
      </div>
    </section>

    <!-- Bottom Newsletter CTA -->
    <section class="max-w-[1600px] mx-auto px-8 md:px-16 pb-40">
      <div class="relative p-16 md:p-24 rounded-[4rem] bg-indigo-600 text-white overflow-hidden text-center space-y-10 shadow-4xl shadow-indigo-600/30">
        <div class="absolute inset-0 bg-dot-pattern opacity-10"></div>
        <h2 class="text-5xl md:text-7xl font-black tracking-tighter leading-[0.9]">Never Miss a <br /> Technical Breakthrough.</h2>
        <p class="text-indigo-100/70 text-xl font-medium max-w-2xl mx-auto">Join 50,000+ engineers receiving weekly deep-dives into the latest architecture patterns.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-6">
          <input type="email" placeholder="Enter your engineering email" class="w-full sm:w-96 px-10 py-6 rounded-2xl bg-white/10 border-2 border-white/20 text-white placeholder:text-white/40 focus:bg-white/20 outline-none transition-all text-xl font-bold">
          <button class="w-full sm:w-auto px-12 py-6 bg-white text-indigo-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 active:scale-95 transition-all">Enable Broadcast</button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const scrollProgress = ref(0);

const post = {
  title: 'The Architecture of Global Scale Distributed Databases',
  slug: 'architecture-global-scale-distributed-databases',
  excerpt: 'Exploring the fundamental principles behind building databases that can handle millions of requests per second across multiple continents while maintaining consistency and availability.',
  category: 'Engineering',
  image: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc51?auto=format&fit=crop&q=80&w=1600',
  date: 'Feb 4, 2026',
  readTime: '12 min',
  tags: ['Architecture', 'Database', 'Scaling', 'Distributed'],
  author: {
    name: 'Dr. Helena Ray',
    role: 'Distinguished Architect',
    avatar: 'https://i.pravatar.cc/100?u=helena'
  },
  content: `
    <h2>The Foundation of Scale</h2>
    <p>Building at global scale requires a fundamental shift in how we perceive data consistency and network partitioning. When your users are spread across 24 time zones, the laws of physics—specifically light speed—become your greatest bottleneck.</p>
    
    <h3>1. CAP Theorem Re-imagined</h3>
    <p>In a global environment, we often choose between Consistency and Availability. Modern systems like Spanner or CockroachDB attempt to bridge this gap using Atomic Clocks or Hybrid Logical Clocks. The ability to coordinate transactions across thousands of nodes without centralized locks is the "holy grail" of distributed logic.</p>

    <div class="my-12 p-8 bg-linear-to-tr from-indigo-500/10 to-transparent rounded-3xl border theme-border">
      <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-4">Pro Insight</p>
      <p class="theme-text-main italic text-lg">"The most expensive part of a global system isn't the compute; it's the coordination of state across high-latency links."</p>
    </div>

    <h3>2. Sharding and Re-distribution</h3>
    <p>Sharding is no longer just about splitting a table. It's about data locality. We must ensure that a user in Tokyo doesn't have to wait for their requests to travel to Virginia and back. Data should be "attracted" to its users while maintaining the ability to be queried globally.</p>

    <p>We use consistent hashing rings to ensure that adding or removing nodes doesn't trigger a catastrophic data migration. This allows our infrastructure to breathe—expanding during peak loads and contracting when idle, all without manual intervention.</p>
  `
};

const updateScrollProgress = () => {
  const scrollTop = window.scrollY;
  const docHeight = document.documentElement.scrollHeight;
  const winHeight = window.innerHeight;
  const scrollPercent = (scrollTop / (docHeight - winHeight)) * 100;
  scrollProgress.value = scrollPercent;
};

onMounted(() => {
  window.addEventListener('scroll', updateScrollProgress);
  window.scrollTo(0, 0);
});

onUnmounted(() => {
  window.removeEventListener('scroll', updateScrollProgress);
});
</script>

<style scoped>
.bg-dot-pattern {
  background-image: radial-gradient(rgba(79, 70, 229, 0.15) 1.5px, transparent 1.5px);
  background-size: 60px 60px;
}
.shadow-4xl {
  box-shadow: 0 60px 100px -20px rgba(0, 0, 0, 0.4), 0 30px 60px -30px rgba(79, 70, 229, 0.2);
}
.aspect-21\/9 {
  aspect-ratio: 21 / 9;
}

/* Custom Prose overrides for premium look */
:deep(.prose) h2 {
  font-weight: 900;
  letter-spacing: -0.05em;
  font-size: 3rem;
  margin-top: 4rem;
  margin-bottom: 2rem;
}
:deep(.prose) h3 {
  font-weight: 800;
  letter-spacing: -0.02em;
  font-size: 2rem;
  margin-top: 3rem;
}
:deep(.prose) p {
  line-height: 1.8;
  margin-bottom: 2rem;
  opacity: 0.9;
}
</style>
