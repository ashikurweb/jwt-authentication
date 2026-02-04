<template>
  <div class="pt-32 pb-40 px-6">
    <div class="max-w-7xl mx-auto space-y-24">
        <!-- Header -->
        <div class="text-center space-y-6 max-w-3xl mx-auto">
            <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.4em] animate-in fade-in slide-in-from-bottom-4 duration-500">Technical Intelligence</h4>
            <h1 class="text-5xl md:text-7xl font-black theme-text-main tracking-tighter leading-none animate-in fade-in slide-in-from-bottom-8 duration-700">Nexus Insight <br /> Analytics</h1>
            <p class="theme-text-dim text-lg md:text-xl font-medium leading-relaxed animate-in fade-in slide-in-from-bottom-10 duration-1000">Deep dives into systems architecture, engineering philosophy, and the future of technical education.</p>
        </div>

        <!-- Featured Article -->
        <div class="group relative rounded-[4rem] overflow-hidden border theme-border theme-bg-card hover:shadow-3xl transition-all duration-700 cursor-pointer animate-in fade-in slide-in-from-bottom-12 duration-1000">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="w-full lg:w-3/5 h-[400px] lg:h-[600px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=1200" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[2s]">
                </div>
                <div class="w-full lg:w-2/5 p-12 md:p-20 space-y-8">
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 bg-indigo-500/10 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest">Featured Analysis</span>
                        <span class="theme-text-dim text-[10px] font-black uppercase tracking-widest">March 24, 2026</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black theme-text-main tracking-tighter leading-tight">The Zero-Trust Era: Reforming Enterprise Identity</h2>
                    <p class="theme-text-dim text-lg leading-relaxed font-medium">An exhaustive exploration of decentralized trust protocols and their implementation in hyperscale cloud environments.</p>
                    <div class="flex items-center gap-4 pt-4 border-t theme-border">
                        <img src="https://i.pravatar.cc/100?u=a" class="w-12 h-12 rounded-2xl border theme-border">
                        <div>
                            <p class="text-sm font-black theme-text-main uppercase tracking-widest">Alex Rivera</p>
                            <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest mt-1">Lead Systems Engineer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <div v-for="post in posts" :key="post.title" class="group space-y-8 cursor-pointer">
                <div class="aspect-video rounded-[2.5rem] overflow-hidden border theme-border shadow-sm group-hover:shadow-2xl transition-all duration-500">
                    <img :src="post.image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="space-y-4 px-2">
                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                        <span class="text-indigo-600">{{ post.category }}</span>
                        <span class="theme-text-dim">{{ post.readTime }}</span>
                    </div>
                    <h3 class="text-2xl font-black theme-text-main tracking-tight group-hover:text-indigo-600 transition-colors leading-tight">{{ post.title }}</h3>
                    <p class="theme-text-dim text-sm font-medium leading-relaxed line-clamp-3">{{ post.excerpt }}</p>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="rounded-[4rem] bg-indigo-600 p-12 md:p-24 text-center space-y-10 relative overflow-hidden shadow-3xl">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(255,255,255,0.1),transparent_70%)]"></div>
            <div class="relative z-10 space-y-6 max-w-2xl mx-auto text-white">
                <h2 class="text-4xl md:text-6xl font-black tracking-tighter leading-none">Subscribe to Intel.</h2>
                <p class="text-indigo-100 text-lg font-medium opacity-80">Join 15,000+ engineers receiving our weekly deep-dives on systems architecture.</p>
                <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                    <input type="email" placeholder="Enter your work email" class="w-full flex-1 px-8 py-5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder:text-white/40 focus:outline-none focus:bg-white/20 transition-all font-bold">
                    <button class="w-full sm:w-auto px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-lg hover:scale-105 active:scale-95 transition-all shadow-xl">Join Now</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script setup>
const posts = [
  { 
    title: "The Death of Traditional MVC: Moving to Event-Driven Systems", 
    category: "Architecture", 
    readTime: "8 min read", 
    excerpt: "Why modern technical stacks are moving away from synchronous request-response patterns toward resilient event streaming architectures.", 
    image: "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800" 
  },
  { 
    title: "Design Ethics in the Age of Autonomous Algorithms", 
    category: "Philosophy", 
    readTime: "12 min read", 
    excerpt: "A critical look at how human-centric design values intersect with black-box algorithmic decision making in modern product engineering.", 
    image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=800" 
  },
  { 
    title: "Scaling Distributed Databases: Lessons from the Edge", 
    category: "Data Systems", 
    readTime: "15 min read", 
    excerpt: "Practical insights on maintaining consistency and availability across geographically distributed data clusters.", 
    image: "https://images.unsplash.com/photo-1558494949-ef010cbdcc51?auto=format&fit=crop&q=80&w=800" 
  },
  { 
    title: "The UI of Infrastructure: How Developers Experience Cloud", 
    category: "Product", 
    readTime: "6 min read", 
    excerpt: "Analyzing why developer experience (DX) is becoming the most critical competitive advantage for cloud infrastructure companies.", 
    image: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800" 
  },
  { 
    title: "Compiler Optimizations in 2026: What's Next?", 
    category: "Languages", 
    readTime: "10 min read", 
    excerpt: "A technical review of recent breakthroughs in LLVM and JIT compilation strategies for high-performance systems.", 
    image: "https://images.unsplash.com/photo-1516116216624-53e697fedbea?auto=format&fit=crop&q=80&w=800" 
  },
  { 
    title: "Security by Design: Building Fortress-Grade APIs", 
    category: "Security", 
    readTime: "9 min read", 
    excerpt: "Implementing advanced authentication and authorization patterns at the gateway level for enterprise-grade security.", 
    image: "https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=800" 
  }
];
</script>

<style scoped>
.shadow-3xl {
    box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.4), 0 30px 60px -30px rgba(79, 70, 229, 0.2);
}
</style>
