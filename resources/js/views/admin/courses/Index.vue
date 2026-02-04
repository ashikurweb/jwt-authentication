<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black theme-text-main tracking-tight">Courses Management</h1>
        <p class="text-sm theme-text-muted mt-1 font-medium">Create, edit and manage your curriculum effortlessly.</p>
      </div>
      <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/20 active:scale-95 transition-all w-full md:w-auto">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Add New Course</span>
      </button>
    </div>

    <!-- Quick Filters -->
    <div class="flex flex-wrap items-center gap-3">
        <button v-for="cat in categories" :key="cat" 
                class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest border theme-border transition-all"
                :class="activeCat === cat ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'theme-bg-card theme-text-muted hover:theme-bg-hover'">
            {{ cat }}
        </button>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="course in courses" :key="course.id" 
           class="group theme-bg-card border theme-border rounded-[2rem] overflow-hidden hover:shadow-2xl hover:border-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1">
        <div class="h-48 relative overflow-hidden">
          <img :src="course.image" :alt="course.title" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
          <div class="absolute top-4 left-4">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-[10px] font-bold text-white rounded-lg border border-white/30 uppercase tracking-widest">{{ course.level }}</span>
          </div>
          <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white">
            <span class="text-xs font-bold">{{ course.lessons }} Lessons</span>
            <span class="text-xs font-bold bg-indigo-600 px-3 py-1 rounded-full shadow-lg shadow-indigo-600/20">${{ course.price }}</span>
          </div>
        </div>
        <div class="p-6 space-y-4">
          <h3 class="text-lg font-bold theme-text-main group-hover:text-indigo-600 transition-colors line-clamp-2 leading-tight">{{ course.title }}</h3>
          <div class="flex items-center gap-3 py-3 border-y theme-border">
            <img :src="course.instructor_avatar" class="w-8 h-8 rounded-full border theme-border" :alt="course.instructor">
            <span class="text-xs font-bold theme-text-muted">{{ course.instructor }}</span>
          </div>
          <div class="flex items-center justify-between pt-2">
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="text-xs font-black theme-text-main">{{ course.rating }}</span>
            </div>
            <button class="text-xs font-black text-indigo-600 uppercase tracking-[0.1em] hover:underline underline-offset-4 decoration-2">Manage Details</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const categories = ['All Courses', 'Development', 'Design', 'Marketing', 'Business'];
const activeCat = ref('All Courses');

const courses = [
  { id: 1, title: 'Mastering Advanced Vue 3 Design Patterns', level: 'Advanced', lessons: 24, price: 49, rating: 4.9, instructor: 'Sarah Drasner', instructor_avatar: 'https://i.pravatar.cc/100?u=sarah', image: 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&q=80&w=800' },
  { id: 2, title: 'Full-Stack Laravel & Vue 3 Masterclass', level: 'Pro', lessons: 42, price: 89, rating: 4.8, instructor: 'Taylor Otwell', instructor_avatar: 'https://i.pravatar.cc/100?u=taylor', image: 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?auto=format&fit=crop&q=80&w=800' },
  { id: 3, title: 'UI/UX Design Systems with Figma & Framer', level: 'Beginner', lessons: 18, price: 34, rating: 4.7, instructor: 'Zander White', instructor_avatar: 'https://i.pravatar.cc/100?u=zander', image: 'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=800' }
];
</script>
