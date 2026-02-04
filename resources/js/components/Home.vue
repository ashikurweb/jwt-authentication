<template>
  <div class="relative overflow-hidden">
    <!-- Mesh Gradient Backgrounds -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[1000px] pointer-events-none -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute top-[10%] right-[-5%] w-[35%] h-[35%] bg-blue-500/10 blur-[100px] rounded-full"></div>
        <div class="absolute top-[40%] left-[20%] w-[30%] h-[30%] bg-purple-500/5 blur-[100px] rounded-full"></div>
    </div>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-32">
      <div class="text-center space-y-8 animate-in fade-in slide-in-from-bottom-8 duration-1000">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full theme-bg-card border theme-border shadow-sm">
          <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
          <span class="text-[10px] font-black uppercase tracking-[0.2em] theme-text-main">Welcome to the future of learning</span>
        </div>
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black theme-text-main tracking-tight leading-[0.9]">
          Master Your Skills With <br>
          <span class="text-transparent bg-clip-text bg-linear-to-r from-indigo-600 via-violet-600 to-blue-600">Premium Mentors</span>
        </h1>
        <p class="max-w-2xl mx-auto text-lg md:text-xl theme-text-dim font-medium leading-relaxed">
          Unlock your potential with industry-standard courses, interactive quizzes, and personalized mentorship from world-class instructors.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
          <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-500 text-white px-10 py-5 rounded-[2rem] font-black text-lg shadow-2xl shadow-indigo-600/30 active:scale-95 transition-all">
            Get Started Now — It's Free
          </button>
          <button class="w-full sm:w-auto theme-bg-card border theme-border px-10 py-5 rounded-[2rem] font-black text-lg hover:theme-bg-hover theme-text-main active:scale-95 transition-all">
            Explore Courses
          </button>
        </div>

        <!-- Hero Mockup/Feature Grid -->
        <div class="pt-20 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 max-w-5xl mx-auto">
            <div v-for="stat in quickStats" :key="stat.label" class="p-8 theme-bg-card border theme-border rounded-[2.5rem] shadow-sm transform hover:-translate-y-2 transition-transform">
                <p class="text-3xl font-black theme-text-main">{{ stat.value }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest theme-text-dim mt-2">{{ stat.label }}</p>
            </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="theme-bg-card py-32 border-y theme-border relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-20">
            <div class="space-y-4">
                <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em]">Specializations</h4>
                <h2 class="text-4xl md:text-5xl font-black theme-text-main tracking-tight">Browse by Category</h2>
            </div>
            <button class="text-sm font-black theme-text-main group hover:text-indigo-600 transition-colors uppercase tracking-widest flex items-center gap-2">
                View All Categories 
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="cat in categories" :key="cat.name" class="p-8 theme-bg-main border theme-border rounded-[2.5rem] hover:border-indigo-500/30 hover:shadow-2xl transition-all group cursor-pointer">
                <div class="w-14 h-14 rounded-2xl theme-bg-element flex items-center justify-center text-3xl mb-6 transition-transform group-hover:scale-110 group-hover:rotate-12">
                    {{ cat.emoji }}
                </div>
                <h3 class="text-xl font-black theme-text-main">{{ cat.name }}</h3>
                <p class="text-xs font-bold theme-text-dim mt-2 uppercase tracking-widest">{{ cat.count }} Courses</p>
            </div>
        </div>
      </div>
    </section>

    <!-- Popular Courses -->
    <section class="py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-20">
                <h4 class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em]">Trending Now</h4>
                <h2 class="text-4xl md:text-5xl font-black theme-text-main tracking-tight">Most Popular Courses</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div v-for="course in trendingCourses" :key="course.id" class="group theme-bg-card border theme-border rounded-[2.5rem] overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="h-64 relative overflow-hidden">
                        <img :src="course.image" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between text-white">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-black uppercase tracking-widest border border-white/30">{{ course.level }}</span>
                            <span class="text-lg font-black">${{ course.price }}</span>
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <h3 class="text-xl font-black theme-text-main group-hover:text-indigo-600 transition-colors leading-tight">{{ course.title }}</h3>
                        <div class="flex items-center gap-3">
                            <img :src="course.instructor_avatar" class="w-8 h-8 rounded-full border theme-border">
                            <span class="text-xs font-bold theme-text-muted">{{ course.instructor }}</span>
                        </div>
                        <div class="pt-6 border-t theme-border flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-xs font-black theme-text-main">{{ course.students }} Students</span>
                            </div>
                            <button class="text-[10px] font-black text-indigo-600 uppercase tracking-widest py-2 px-4 theme-bg-element rounded-lg hover:theme-bg-hover transition-all">Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By Section -->
    <section class="pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-12 md:p-20 rounded-[3rem] bg-indigo-600 text-white relative overflow-hidden shadow-2xl shadow-indigo-600/20">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48"></div>
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h2 class="text-4xl md:text-5xl font-black leading-tight tracking-tight">Ready to start your <br> journey?</h2>
                        <p class="text-indigo-100 text-lg font-medium opacity-80 leading-relaxed">Join over 50,000+ students already learning and growing their careers on EduNexus.</p>
                        <button class="bg-white text-indigo-600 px-10 py-5 rounded-2xl font-black text-lg shadow-xl hover:scale-105 active:scale-95 transition-all">Create Account Now</button>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="i in 4" :key="i" class="h-32 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all cursor-pointer">
                            <span class="text-xl font-black text-white/40">BRAND {{ i }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>
</template>

<script setup>
const quickStats = [
  { label: 'Active Learners', value: '50k+' },
  { label: 'Premium Courses', value: '1.2k+' },
  { label: 'Expert Mentors', value: '450+' },
  { label: 'Success Rate', value: '98%' },
];

const categories = [
  { name: 'Development', count: 450, emoji: '💻' },
  { name: 'Business', count: 230, emoji: '📈' },
  { name: 'Design', count: 180, emoji: '🎨' },
  { name: 'Marketing', count: 120, emoji: '🚀' },
];

const trendingCourses = [
  { id: 1, title: 'Advanced Vue 3 & Composition API Masterclass', instructor: 'Sarah Drasner', instructor_avatar: 'https://i.pravatar.cc/100?u=sarah', students: '12.4k', price: 49, level: 'Advanced', image: 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800' },
  { id: 2, title: 'Laravel 11 Ecosystem & Microservices', instructor: 'Taylor Otwell', instructor_avatar: 'https://i.pravatar.cc/100?u=taylor', students: '8.2k', price: 89, level: 'Pro', image: 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?auto=format&fit=crop&q=80&w=800' },
  { id: 3, title: 'UI Design Systems with Figma & Tokens', instructor: 'Zander White', instructor_avatar: 'https://i.pravatar.cc/100?u=zander', students: '15.6k', price: 34, level: 'Beginner', image: 'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=800' }
];
</script>

<style scoped>
.mesh-gradient {
    background: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
}
</style>