<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black theme-text-main tracking-tight">Assignments</h1>
        <p class="text-sm theme-text-muted mt-1 font-medium">Track and grade student submissions across all courses.</p>
      </div>
      <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/20 active:scale-95 transition-all w-full md:w-auto">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Add Assignment</span>
      </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Active Assignments Column -->
      <div class="lg:col-span-2 space-y-6">
        <div v-for="item in assignments" :key="item.id" 
             class="group p-6 theme-bg-card border theme-border rounded-[2rem] hover:border-indigo-500/30 transition-all shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl theme-bg-element flex items-center justify-center theme-text-muted">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black theme-text-main leading-tight">{{ item.title }}</h3>
                    <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest mt-0.5">{{ item.course }}</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-amber-500/10 text-amber-600 border border-amber-500/20 self-start sm:self-center">
                {{ item.status }}
            </span>
          </div>
          
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-4 border-y theme-border">
            <div>
                <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest">Submissions</p>
                <p class="text-lg font-black theme-text-main">{{ item.submissions }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest">Graded</p>
                <p class="text-lg font-black text-emerald-500">{{ item.graded }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest">Avg. Score</p>
                <p class="text-lg font-black text-indigo-500">{{ item.avgScore }}%</p>
            </div>
            <div>
                <p class="text-[10px] font-bold theme-text-dim uppercase tracking-widest">Deadline</p>
                <p class="text-sm font-bold theme-text-main mt-1">{{ item.deadline }}</p>
            </div>
          </div>

          <div class="flex items-center justify-between pt-4">
            <div class="flex -space-x-2">
                <img v-for="i in 3" :key="i" :src="`https://i.pravatar.cc/100?u=${item.id}${i}`" class="w-7 h-7 rounded-full border-2 theme-border theme-bg-card">
            </div>
            <button class="px-4 py-2 theme-bg-element hover:theme-bg-hover theme-text-main text-xs font-black uppercase tracking-widest rounded-xl transition-all">Review Submissions</button>
          </div>
        </div>
      </div>

      <!-- Right Column: Quick Stats -->
      <div class="space-y-8">
        <div class="p-8 rounded-[2rem] bg-linear-to-br from-indigo-600 to-violet-700 text-white shadow-xl shadow-indigo-600/20">
            <h3 class="text-xs font-black uppercase tracking-[0.2em] opacity-80 mb-6">Submission Trend</h3>
            <div class="flex items-end gap-2 h-24 mb-6">
                <div v-for="h in [40, 70, 50, 90, 60, 80]" :key="h" class="flex-1 bg-white/20 rounded-t-lg transition-all hover:bg-white/40" :style="{ height: h + '%' }"></div>
            </div>
            <div class="space-y-1">
                <p class="text-3xl font-black">2.4k</p>
                <p class="text-[10px] font-bold uppercase tracking-widest opacity-80">Total this month</p>
            </div>
        </div>

        <div class="p-8 theme-bg-card border theme-border rounded-[2rem] shadow-sm">
            <h3 class="text-sm font-black theme-text-main uppercase tracking-widest mb-6 border-b theme-border pb-4">Upcoming Deadlines</h3>
            <div class="space-y-6">
                <div v-for="i in 3" :key="i" class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold theme-text-main">Database Quiz #3</p>
                        <p class="text-[10px] theme-text-dim font-bold uppercase">In 2 days</p>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const assignments = [
  { id: 1, title: 'Final Project: Build a SaaS with Vue 3', course: 'Advanced Vue Mastery', submissions: 142, graded: 85, avgScore: 92, deadline: 'Feb 15, 2026', status: 'In Progress' },
  { id: 2, title: 'Module 4: Authentication Security', course: 'Full-Stack Laravel', submissions: 98, graded: 98, avgScore: 84, deadline: 'Passed', status: 'Graded' }
];
</script>
