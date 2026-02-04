<template>
  <div class="min-h-screen">
    <!-- Blog Hero Header -->
    <section class="relative pt-40 pb-20 overflow-hidden">
      <div class="absolute inset-0 pointer-events-none -z-10 bg-dot-pattern opacity-30"></div>
      <div class="absolute top-0 right-0 w-[40%] h-full bg-linear-to-l from-indigo-600/10 to-transparent blur-[100px] -z-10"></div>
      
      <div class="max-w-[1600px] mx-auto px-8 md:px-16">
        <div class="max-w-4xl space-y-8">
          <div class="flex items-center gap-4">
            <div class="h-[2px] w-12 bg-indigo-600"></div>
            <span class="text-[11px] font-black uppercase tracking-[0.5em] theme-text-main">Digital Journal</span>
          </div>
          <h1 class="text-7xl md:text-9xl font-black theme-text-main tracking-tighter leading-[0.85]">
            Technical <span class="text-indigo-600">Blog</span>
          </h1>
          <p class="text-xl md:text-2xl theme-text-dim font-medium leading-relaxed max-w-2xl">
            Deep dives into cloud orchestration, distributed architectures, and elite security protocols. Pure technical excellence.
          </p>
        </div>
      </div>
    </section>

    <!-- Featured Post -->
    <section class="px-8 md:px-16 pb-20">
      <div class="max-w-[1600px] mx-auto">
        <div class="group relative rounded-[4rem] overflow-hidden theme-bg-card border-2 theme-border hover:border-indigo-500/30 transition-all duration-700 shadow-xl hover:shadow-4xl">
          <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="relative h-80 lg:h-auto overflow-hidden">
              <img :src="featuredPost.image" class="w-full h-full object-cover grayscale-[0.5] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-[2s]">
              <div class="absolute inset-0 bg-linear-to-r from-black/60 to-transparent lg:hidden"></div>
            </div>
            <div class="p-12 lg:p-16 flex flex-col justify-center space-y-8">
              <div class="flex items-center gap-4">
                <span class="px-4 py-1.5 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg">Featured</span>
                <span class="text-[10px] font-black theme-text-dim uppercase tracking-widest">{{ featuredPost.category }}</span>
              </div>
              <h2 class="text-4xl lg:text-5xl font-black theme-text-main tracking-tighter leading-[1.1] group-hover:text-indigo-600 transition-colors">
                {{ featuredPost.title }}
              </h2>
              <p class="theme-text-dim text-lg font-medium leading-relaxed">{{ featuredPost.excerpt }}</p>
              <div class="flex items-center justify-between pt-6 border-t theme-border">
                <div class="flex items-center gap-4">
                  <img :src="featuredPost.author.avatar" class="w-12 h-12 rounded-2xl border-2 theme-border object-cover">
                  <div>
                    <p class="text-sm font-black theme-text-main">{{ featuredPost.author.name }}</p>
                    <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest">{{ featuredPost.date }} · {{ featuredPost.readTime }}</p>
                  </div>
                </div>
                <router-link :to="`/blog/${featuredPost.slug}`" class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-500 transition-all shadow-xl hover:scale-110 active:scale-90">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Category Filter -->
    <section class="px-8 md:px-16 pb-16">
      <div class="max-w-[1600px] mx-auto">
        <div class="flex flex-wrap items-center gap-4">
          <button 
            v-for="cat in categories" 
            :key="cat.slug"
            @click="activeCategory = cat.slug"
            class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all border-2"
            :class="activeCategory === cat.slug 
              ? 'bg-indigo-600 text-white border-indigo-600 shadow-xl shadow-indigo-600/20' 
              : 'theme-bg-card theme-border theme-text-main hover:border-indigo-500/30'"
          >
            {{ cat.name }}
          </button>
        </div>
      </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="px-8 md:px-16 pb-40">
      <div class="max-w-[1600px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
          <router-link 
            v-for="post in posts" 
            :key="post.id"
            :to="`/blog/${post.slug}`"
            class="group theme-bg-card border-2 theme-border rounded-[3rem] overflow-hidden hover:border-indigo-500/30 hover:shadow-4xl transition-all duration-700 hover:-translate-y-4"
          >
            <!-- Post Image -->
            <div class="h-64 relative overflow-hidden">
              <img :src="post.image" class="w-full h-full object-cover grayscale-[0.5] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-[1.5s]">
              <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>
              <div class="absolute top-6 left-6">
                <span class="px-4 py-1.5 bg-white/10 backdrop-blur-xl text-white text-[9px] font-black uppercase tracking-widest rounded-lg border border-white/20">{{ post.category }}</span>
              </div>
              <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between text-white">
                <span class="text-[10px] font-bold opacity-70">{{ post.readTime }}</span>
                <div class="flex items-center gap-2 text-[10px] font-bold opacity-70">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  {{ post.views }}
                </div>
              </div>
            </div>

            <!-- Post Content -->
            <div class="p-10 space-y-6">
              <h3 class="text-2xl font-black theme-text-main group-hover:text-indigo-600 transition-colors tracking-tight leading-[1.2]">{{ post.title }}</h3>
              <p class="theme-text-dim text-sm font-medium leading-relaxed line-clamp-3">{{ post.excerpt }}</p>
              
              <div class="pt-6 border-t theme-border flex items-center gap-4">
                <img :src="post.author.avatar" class="w-10 h-10 rounded-xl border-2 theme-border object-cover">
                <div class="flex-1">
                  <p class="text-xs font-black theme-text-main">{{ post.author.name }}</p>
                  <p class="text-[9px] font-bold theme-text-dim uppercase tracking-widest mt-1">{{ post.date }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl theme-bg-element border-2 theme-border flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Load More -->
        <div class="text-center pt-20">
          <button class="px-12 py-6 border-2 theme-border theme-text-main rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm">
            Load More Articles
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const activeCategory = ref('all');

const categories = [
  { name: 'All Posts', slug: 'all' },
  { name: 'Engineering', slug: 'engineering' },
  { name: 'Cloud', slug: 'cloud' },
  { name: 'Security', slug: 'security' },
  { name: 'DevOps', slug: 'devops' },
];

const featuredPost = {
  id: 1,
  title: 'The Architecture of Global Scale Distributed Databases',
  slug: 'architecture-global-scale-distributed-databases',
  excerpt: 'Exploring the fundamental principles behind building databases that can handle millions of requests per second across multiple continents while maintaining consistency and availability.',
  category: 'Engineering',
  image: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc51?auto=format&fit=crop&q=80&w=1600',
  date: 'Feb 4, 2026',
  readTime: '12 min read',
  author: {
    name: 'Dr. Helena Ray',
    avatar: 'https://i.pravatar.cc/100?u=helena'
  }
};

const posts = [
  {
    id: 2,
    title: 'Zero Trust Security in Multi-Cloud Ecosystems',
    slug: 'zero-trust-security-multi-cloud',
    excerpt: 'How to implement a comprehensive zero-trust security model across AWS, GCP, and Azure environments.',
    category: 'Security',
    image: 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?auto=format&fit=crop&q=80&w=800',
    date: 'Feb 3, 2026',
    readTime: '8 min',
    views: '2.4K',
    author: { name: 'Xavier Vance', avatar: 'https://i.pravatar.cc/100?u=xavier' }
  },
  {
    id: 3,
    title: 'Event-Driven Architecture: Beyond Microservices',
    slug: 'event-driven-architecture-beyond-microservices',
    excerpt: 'Why event-driven patterns are becoming the backbone of modern distributed systems.',
    category: 'Engineering',
    image: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=800',
    date: 'Feb 2, 2026',
    readTime: '15 min',
    views: '5.1K',
    author: { name: 'Marcus Jin', avatar: 'https://i.pravatar.cc/100?u=marcus' }
  },
  {
    id: 4,
    title: 'Kubernetes at Scale: Lessons from Production',
    slug: 'kubernetes-at-scale-lessons-production',
    excerpt: 'Real-world insights from managing 500+ Kubernetes clusters in enterprise environments.',
    category: 'DevOps',
    image: 'https://images.unsplash.com/photo-1667372393119-3d4c48d07fc9?auto=format&fit=crop&q=80&w=800',
    date: 'Feb 1, 2026',
    readTime: '10 min',
    views: '3.8K',
    author: { name: 'Sarah Chen', avatar: 'https://i.pravatar.cc/100?u=sarah' }
  },
  {
    id: 5,
    title: 'The Future of Serverless Computing',
    slug: 'future-serverless-computing',
    excerpt: 'Analyzing the trajectory of serverless platforms and what it means for cloud architecture.',
    category: 'Cloud',
    image: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=800',
    date: 'Jan 30, 2026',
    readTime: '7 min',
    views: '1.9K',
    author: { name: 'Dr. Helena Ray', avatar: 'https://i.pravatar.cc/100?u=helena' }
  },
  {
    id: 6,
    title: 'GraphQL vs REST: A Technical Deep Dive',
    slug: 'graphql-vs-rest-technical-deep-dive',
    excerpt: 'Comparing performance, flexibility, and use cases for both API paradigms.',
    category: 'Engineering',
    image: 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=800',
    date: 'Jan 28, 2026',
    readTime: '11 min',
    views: '4.2K',
    author: { name: 'Xavier Vance', avatar: 'https://i.pravatar.cc/100?u=xavier' }
  },
];
</script>

<style scoped>
.bg-dot-pattern {
  background-image: radial-gradient(rgba(79, 70, 229, 0.15) 1.5px, transparent 1.5px);
  background-size: 60px 60px;
}
.shadow-4xl {
  box-shadow: 0 60px 100px -20px rgba(0, 0, 0, 0.4), 0 30px 60px -30px rgba(79, 70, 229, 0.2);
}
</style>
