<template>
  <div v-if="loading" class="flex items-center justify-center py-40">
    <div class="flex flex-col items-center gap-4">
      <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
      <p class="text-xs font-black theme-text-dim uppercase tracking-widest">Loading Profile...</p>
    </div>
  </div>

  <div v-else-if="student" class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Profile Header / Cover Section -->
    <div class="relative h-64 rounded-[3rem] overflow-hidden group shadow-2xl">
      <div class="absolute inset-0 bg-linear-to-br from-indigo-600 via-violet-600 to-fuchsia-600"></div>
      <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
      
      <!-- Back Button -->
      <router-link 
        :to="{ name: 'users.index' }"
        class="absolute top-8 left-8 p-3 bg-white/10 backdrop-blur-md rounded-2xl text-white hover:bg-white/20 transition-all active:scale-90 flex items-center gap-2 group/back"
      >
        <svg class="w-5 h-5 transition-transform group-hover/back:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        <span class="text-sm font-bold pr-2">Back to List</span>
      </router-link>

      <!-- Action Buttons -->
      <div class="absolute top-8 right-8 flex gap-3">
        <button 
          @click="toggleStatus"
          class="p-4 rounded-2xl backdrop-blur-md transition-all active:scale-90 flex items-center gap-2 shadow-lg"
          :class="student.is_active ? 'bg-rose-500/20 text-rose-100 hover:bg-rose-500/30' : 'bg-emerald-500/20 text-emerald-100 hover:bg-emerald-500/30'"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path v-if="student.is_active" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-xs font-black uppercase tracking-widest">{{ student.is_active ? 'Suspend' : 'Activate' }}</span>
        </button>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-12 gap-8 -mt-32 relative px-8">
      <!-- Left Sidebar: Profile Identity -->
      <div class="col-span-12 lg:col-span-4 space-y-6">
        <div class="theme-bg-card border theme-border rounded-[2.5rem] p-8 shadow-xl backdrop-blur-sm relative overflow-hidden group">
          <div class="absolute -top-24 -left-24 w-48 h-48 bg-indigo-500/10 blur-[80px] rounded-full"></div>
          
          <div class="relative flex flex-col items-center text-center space-y-4">
            <div class="relative">
              <div class="w-32 h-32 rounded-[2.5rem] p-1 bg-linear-to-tr from-indigo-500 to-fuchsia-500 shadow-2xl overflow-hidden group-hover:rotate-3 transition-transform duration-500">
                <img :src="student.avatar" class="w-full h-full object-cover rounded-[2.3rem] theme-bg-element" alt="Student">
              </div>
              <div 
                class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl border-4 theme-border flex items-center justify-center shadow-lg transform rotate-12"
                :class="student.is_active ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'"
              >
                <svg v-if="student.is_active" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
              </div>
            </div>

            <div class="space-y-1">
              <h2 class="text-2xl font-black theme-text-main tracking-tight">{{ student.name }}</h2>
              <p class="text-sm theme-text-dim font-bold tracking-tight opacity-70">@{{ student.username }}</p>
            </div>

            <div class="pt-4 flex flex-wrap justify-center gap-2">
              <span class="px-4 py-2 bg-indigo-500/10 text-indigo-500 text-[10px] font-black uppercase tracking-widest rounded-xl border border-indigo-500/20">Official Student</span>
              <span class="px-4 py-2 bg-slate-500/10 theme-text-muted text-[10px] font-black uppercase tracking-widest rounded-xl border theme-border">LMS Member</span>
            </div>

            <div class="w-full h-px bg-linear-to-r from-transparent via-slate-700/20 to-transparent my-6"></div>

            <div class="w-full space-y-4 text-left">
              <div class="flex items-center gap-4 p-4 theme-bg-element rounded-2xl border theme-border hover:border-indigo-500/30 transition-all">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                  <p class="text-[9px] theme-text-dim font-bold uppercase tracking-widest opacity-60">Primary Email</p>
                  <p class="text-xs font-black theme-text-main leading-none mt-0.5">{{ student.email }}</p>
                </div>
              </div>

              <div class="flex items-center gap-4 p-4 theme-bg-element rounded-2xl border theme-border hover:border-indigo-500/30 transition-all">
                <div class="w-10 h-10 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-500">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <div>
                  <p class="text-[9px] theme-text-dim font-bold uppercase tracking-widest opacity-60">Phone Support</p>
                  <p class="text-xs font-black theme-text-main leading-none mt-0.5">{{ student.phone || 'Not Connected' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Side: Details & Stats -->
      <div class="col-span-12 lg:col-span-8 space-y-8">
        <!-- Stats Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="theme-bg-card border theme-border rounded-[2rem] p-6 shadow-sm overflow-hidden relative group">
            <div class="absolute inset-0 bg-linear-to-br from-indigo-500/5 via-transparent to-transparent"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-[10px] theme-text-dim font-bold uppercase tracking-widest opacity-60 mb-1">Courses Joined</p>
                <h4 class="text-4xl font-black theme-text-main leading-none">{{ student.courses_count }}</h4>
              </div>
              <div class="w-14 h-14 rounded-2xl theme-bg-element border theme-border flex items-center justify-center text-indigo-500 shadow-inner group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
              </div>
            </div>
          </div>

          <div class="theme-bg-card border theme-border rounded-[2rem] p-6 shadow-sm overflow-hidden relative group">
            <div class="absolute inset-0 bg-linear-to-br from-emerald-500/5 via-transparent to-transparent"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-[10px] theme-text-dim font-bold uppercase tracking-widest opacity-60 mb-1">Completed Items</p>
                <h4 class="text-4xl font-black theme-text-main leading-none">0</h4>
              </div>
              <div class="w-14 h-14 rounded-2xl theme-bg-element border theme-border flex items-center justify-center text-emerald-500 shadow-inner group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
            </div>
          </div>

          <div class="theme-bg-card border theme-border rounded-[2rem] p-6 shadow-sm overflow-hidden relative group">
            <div class="absolute inset-0 bg-linear-to-br from-amber-500/5 via-transparent to-transparent"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-[10px] theme-text-dim font-bold uppercase tracking-widest opacity-60 mb-1">Account Active</p>
                <h4 class="text-xl font-black theme-text-main leading-none mt-2">{{ student.created_at }}</h4>
              </div>
              <div class="w-14 h-14 rounded-2xl theme-bg-element border theme-border flex items-center justify-center text-amber-500 shadow-inner group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
              </div>
            </div>
          </div>
        </div>

        <!-- System Logs / Info -->
        <div class="theme-bg-card border theme-border rounded-[2.5rem] p-8 shadow-sm">
          <div class="flex items-center justify-between mb-8">
            <div>
              <h3 class="text-xl font-black theme-text-main tracking-tight">System Account Information</h3>
              <p class="text-xs theme-text-dim font-medium">Metadata and audit details for this student</p>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
              <div class="flex items-start gap-4">
                <div class="w-2 h-2 rounded-full bg-indigo-500 mt-2 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                <div>
                  <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest">Internal UUID</p>
                  <p class="text-xs font-mono theme-text-main font-bold break-all opacity-80 mt-1">{{ student.uuid }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-2 h-2 rounded-full bg-indigo-500 mt-2"></div>
                <div>
                  <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest">Current Status</p>
                  <p class="text-xs theme-text-main font-bold mt-1 inline-flex items-center gap-2">
                    <span :class="student.is_active ? 'text-emerald-500' : 'text-rose-500'">{{ student.status.toUpperCase() }}</span>
                    <span class="w-1 h-1 bg-slate-500 rounded-full"></span>
                    <span class="opacity-70">Verified Member</span>
                  </p>
                </div>
              </div>
            </div>

            <div class="space-y-6">
               <div class="flex items-start gap-4">
                <div class="w-2 h-2 rounded-full bg-indigo-500 mt-2"></div>
                <div>
                  <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest">Enrollment Activity</p>
                  <div class="mt-2 h-2 w-full bg-slate-700/20 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 rounded-full" :style="{ width: student.courses_count > 0 ? '65%' : '0%' }"></div>
                  </div>
                  <p class="text-[10px] theme-text-muted mt-2 font-bold">{{ student.courses_count > 0 ? 'High potential student' : 'No engagement yet' }}</p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-2 h-2 rounded-full bg-indigo-500 mt-2"></div>
                <div>
                  <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest">Platform Language</p>
                  <p class="text-xs theme-text-main font-bold mt-1">Global Standard (English - US)</p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-2 h-2 rounded-full bg-indigo-500 mt-2 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                <div>
                  <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest">Last Active Session</p>
                  <p class="text-xs theme-text-main font-bold mt-1 inline-flex items-center gap-2">
                    <span class="text-violet-500">{{ student.last_login_at }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { userService } from '../../../services/userService';
import { useToast } from '../../../composables/useToast';

const route = useRoute();
const toast = useToast();
const loading = ref(true);
const toggling = ref(false);
const student = ref(null);

const fetchStudent = async () => {
  loading.value = true;
  try {
    const data = await userService.show(route.params.uuid);
    student.value = data.data;
  } catch (error) {
    toast.error('Failed to load student profile');
  } finally {
    loading.value = false;
  }
};

const toggleStatus = async () => {
  if (toggling.value) return;
  toggling.value = true;
  try {
    await userService.toggleStatus(student.value.uuid);
    student.value.is_active = !student.value.is_active;
    student.value.status = student.value.is_active ? 'active' : 'suspended';
    toast.success(`Account ${student.value.is_active ? 'activated' : 'suspended'} successfully`);
  } catch (error) {
    toast.error('Failed to update status');
  } finally {
    toggling.value = false;
  }
};

onMounted(() => {
  fetchStudent();
});
</script>
