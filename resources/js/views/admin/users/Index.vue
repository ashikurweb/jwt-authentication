<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black theme-text-main tracking-tight">Student Directory</h1>
        <p class="text-sm theme-text-muted mt-1 font-medium">Manage and monitor student engagement and progress.</p>
      </div>
      <div class="flex items-center gap-3">
        <button class="flex items-center justify-center p-3 theme-bg-card border theme-border rounded-xl theme-text-muted hover:theme-text-main transition-all active:scale-95 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        </button>
        <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/20 active:scale-95 transition-all">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          <span class="hidden sm:inline">Add Student</span>
        </button>
      </div>
    </div>

    <!-- Table Container -->
    <div class="theme-bg-card border theme-border rounded-[2.5rem] overflow-hidden shadow-sm">
      <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b theme-border theme-bg-element">
              <th class="px-8 py-5 text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">Student</th>
              <th class="px-8 py-5 text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">Status</th>
              <th class="px-8 py-5 text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">Courses</th>
              <th class="px-8 py-5 text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">Enrolled</th>
              <th class="px-8 py-5 text-[10px] font-black theme-text-dim uppercase tracking-[0.2em] text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y theme-border">
            <tr v-for="user in students" :key="user.id" class="group hover:theme-bg-element/50 transition-colors">
              <td class="px-8 py-6">
                <div class="flex items-center gap-4">
                  <div class="w-11 h-11 rounded-xl overflow-hidden border theme-border">
                    <img :src="user.avatar" class="w-full h-full object-cover">
                  </div>
                  <div>
                    <p class="text-sm font-black theme-text-main">{{ user.name }}</p>
                    <p class="text-xs theme-text-dim leading-tight">{{ user.email }}</p>
                  </div>
                </div>
              </td>
              <td class="px-8 py-6">
                <span :class="[
                  'px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border',
                  user.active ? 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20' : 'bg-rose-500/10 text-rose-600 border-rose-500/20'
                ]">
                  {{ user.active ? 'Active' : 'Suspended' }}
                </span>
              </td>
              <td class="px-8 py-6">
                <p class="text-sm font-bold theme-text-main">{{ user.courses }} Joined</p>
              </td>
              <td class="px-8 py-6">
                <p class="text-xs font-bold theme-text-dim">{{ user.date }}</p>
              </td>
              <td class="px-8 py-6 text-right">
                <div class="flex items-center justify-end gap-2">
                    <button class="p-2 theme-text-muted hover:theme-text-main transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button class="p-2 theme-text-muted hover:text-rose-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Pagination Placeholder -->
      <div class="px-8 py-5 border-t theme-border theme-bg-element/30 flex items-center justify-between">
        <p class="text-xs font-bold theme-text-dim tracking-tight">Showing 1-10 of 2,450 students</p>
        <div class="flex items-center gap-2">
            <button class="px-4 py-1.5 theme-bg-card border theme-border rounded-lg text-xs font-bold theme-text-muted hover:theme-text-main transition-all">Prev</button>
            <button class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-bold shadow-md shadow-indigo-600/20">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const students = [
  { id: 1, name: 'Ashikur Rahman', email: 'ashikur@nexus.com', avatar: 'https://i.pravatar.cc/100?u=ashikur', active: true, courses: 14, date: 'Oct 12, 2025' },
  { id: 2, name: 'Sarah Connor', email: 'sarah@matrix.com', avatar: 'https://i.pravatar.cc/100?u=sarahc', active: true, courses: 8, date: 'Nov 04, 2025' },
  { id: 3, name: 'John Doe', email: 'john@edu.com', avatar: 'https://i.pravatar.cc/100?u=john', active: false, courses: 3, date: 'Jan 15, 2026' }
];
</script>
