<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Premium Dashboard Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 relative px-2">
      <div class="absolute -top-12 -left-12 w-64 h-64 bg-indigo-500/5 blur-[100px] rounded-full"></div>
      
      <div class="relative space-y-2">
        <h1 class="text-4xl font-black theme-text-main tracking-tighter leading-none flex items-center gap-3">
           <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
           </div>
           Instructors
        </h1>
        <p class="text-sm theme-text-muted font-bold tracking-tight ml-1">Orchestrating <span class="theme-text-main">{{ pagination.total }}</span> professional educators across your platform.</p>
      </div>

      <div class="flex items-center gap-4 relative z-10">
        <div class="relative group">
          <input 
            v-model="search"
            type="text" 
            placeholder="Search mentors..." 
            class="pl-12 pr-6 py-4 theme-bg-card border-2 theme-border rounded-[1.5rem] text-sm font-bold theme-text-main outline-none focus:border-indigo-500 focus:ring-8 focus:ring-indigo-500/5 transition-all w-72 shadow-xl"
            @input="debounceSearch"
          >
          <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 theme-text-dim group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <router-link 
          :to="{ name: 'instructors.create' }"
          class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/20 active:scale-95 transition-all whitespace-nowrap"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          <span class="hidden sm:inline">Add Creator</span>
        </router-link>
      </div>
    </div>

    <!-- Main List Container -->
    <div class="relative min-h-[500px]">
      <!-- Column Headers - Modern Glass Style -->
      <div class="grid grid-cols-12 gap-4 px-8 py-4 mb-4 theme-table-header rounded-2xl overflow-hidden relative group/header">
        <div class="absolute inset-x-0 bottom-0 h-px bg-linear-to-r from-transparent via-indigo-500/30 to-transparent"></div>
        <div class="col-span-1 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em]">SL</div>
        <div class="col-span-3 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em]">Instructor Identity</div>
        <div class="col-span-2 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em]">Subject Matter</div>
        <div class="col-span-1 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em] text-center">Impact</div>
        <div class="col-span-1 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em] text-center">Revenue</div>
        <div class="col-span-1 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em] text-center">Featured</div>
        <div class="col-span-1 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em] text-center">Status</div>
        <div class="col-span-2 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em] text-right">Actions</div>
      </div>

      <!-- Loading State (Category Style) -->
      <div v-if="loading" class="flex items-center justify-center py-32 theme-bg-card border theme-border rounded-[2.5rem] shadow-sm">
         <SkeletonLoader :cols="8" />
      </div>

      <template v-else>
        <!-- Empty State Component -->
        <EmptyState 
          v-if="instructors.length === 0"
          title="No mentors found"
          message="Your faculty is currently empty or no results match your query."
        />

        <!-- Floating List Items -->
        <div class="space-y-3">
          <div 
            v-for="(instructor, index) in instructors" 
            :key="instructor.id" 
            class="grid grid-cols-12 gap-4 items-center px-8 py-4 theme-bg-card border theme-border rounded-[1.5rem] shadow-sm transition-all duration-500 group"
          >
            <!-- SL Column - Premium Badge Style -->
            <div class="col-span-1">
              <div class="w-10 h-10 rounded-xl theme-bg-element border theme-border flex items-center justify-center transition-all duration-500 group-hover:border-indigo-500/30 group-hover:bg-indigo-500/5">
                <span class="text-[10px] font-black theme-text-dim group-hover:theme-text-main tabular-nums tracking-tighter">
                  {{ (pagination.current_page - 1) * pagination.per_page + index + 1 < 10 ? '0' : '' }}{{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}
                </span>
              </div>
            </div>

            <!-- Identity Column -->
            <div class="col-span-3">
              <div class="flex items-center gap-5">
                <div class="relative group/avatar">
                  <div class="absolute inset-0 bg-indigo-500/20 rounded-2xl blur-lg opacity-0 group-hover/avatar:opacity-100 transition-opacity"></div>
                  <img 
                    v-if="instructor.avatar_url" 
                    :src="instructor.avatar_url" 
                    class="relative w-14 h-14 rounded-2xl object-cover border-2 theme-border shadow-inner transition-transform duration-700 group-hover/avatar:scale-110"
                  >
                  <div 
                    v-else
                    class="relative w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-black bg-indigo-600/10 text-indigo-600 border-2 theme-border transition-transform duration-700 group-hover/avatar:scale-110"
                  >
                    {{ instructor.name.charAt(0) }}
                  </div>
                </div>
                <div class="flex flex-col space-y-1">
                  <router-link :to="{ name: 'instructors.show', params: { id: instructor.id } }" class="text-base font-black theme-text-main tracking-tight group-hover:text-indigo-500 transition-colors">{{ instructor.name }}</router-link>
                  <div class="flex items-center gap-2">
                     <span class="text-[9px] theme-text-dim font-black uppercase tracking-widest">{{ instructor.email }}</span>
                     <span v-if="instructor.is_featured" class="w-3 h-3 text-amber-500"><svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Subject Column -->
            <div class="col-span-2">
              <div class="flex flex-col gap-1">
                <span class="text-[11px] font-black theme-text-main truncate italic">{{ instructor.headline || 'Professional Mentor' }}</span>
                <div class="flex flex-wrap gap-1">
                   <span v-for="tag in (instructor.expertise?.split(',') || ['Academic'])" :key="tag" class="px-2 py-0.5 rounded-md bg-slate-800/10 dark:bg-slate-200/5 theme-text-dim text-[8px] font-black uppercase tracking-tighter">
                      {{ tag.trim() }}
                   </span>
                </div>
              </div>
            </div>

            <!-- Courses & Students -->
            <div class="col-span-1 text-center">
              <div class="inline-flex flex-col items-center">
                <span class="text-xl font-black theme-text-main tabular-nums leading-none">{{ instructor.total_courses }}</span>
                <span class="text-[8px] font-black theme-text-dim uppercase tracking-widest">Courses</span>
              </div>
            </div>

            <!-- Revenue -->
            <div class="col-span-1 text-center">
              <div class="inline-flex flex-col items-center">
                <span class="text-sm font-black theme-text-main tabular-nums">${{ instructor.total_earnings?.toLocaleString() }}</span>
                <span class="text-[8px] font-black theme-text-dim uppercase tracking-widest">Revenue</span>
              </div>
            </div>

            <!-- Featured Toggle - Fixed Centering -->
            <div class="col-span-1 flex justify-center">
              <button 
                @click="toggleFeatured(instructor)"
                class="relative w-11 h-6 rounded-full transition-all duration-500 shadow-inner overflow-hidden border theme-border flex items-center px-1"
                :class="instructor.is_featured ? 'bg-amber-500 shadow-amber-900/20 border-amber-500/50' : 'theme-bg-element'"
              >
                <div 
                  class="w-4 h-4 bg-white rounded-full transition-all duration-500 shadow-lg flex items-center justify-center"
                  :class="instructor.is_featured ? 'translate-x-5 rotate-180' : 'translate-x-0'"
                >
                  <svg class="w-2.5 h-2.5" :class="instructor.is_featured ? 'text-amber-500' : 'text-slate-300'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
              </button>
            </div>

            <!-- Status Indicator -->
            <div class="col-span-1 flex justify-center">
              <button 
                @click="toggleStatus(instructor)"
                class="flex flex-col items-center gap-1 group/status"
              >
                <div 
                  class="px-3 py-1.5 rounded-xl border-2 transition-all duration-500 text-[9px] font-black uppercase tracking-widest shadow-sm"
                  :class="instructor.status === 'approved' ? 'bg-emerald-500/10 border-emerald-500/50 text-emerald-600' : 'bg-slate-500/10 border-slate-500/50 theme-text-dim'"
                >
                  {{ instructor.status }}
                </div>
                <span class="text-[7px] font-bold theme-text-dim opacity-40 uppercase group-hover/status:opacity-100 transition-opacity">Click to Toggle</span>
              </button>
            </div>

            <!-- Modern Action Dock -->
            <div class="col-span-2 text-right pr-4">
              <div class="flex items-center justify-end">
                <div class="relative group/actions flex items-center">
                  <!-- Sliding Action Menu -->
                  <div class="absolute right-0 flex items-center gap-1.5 px-2.5 py-2 theme-bg-card border theme-border rounded-[2rem] shadow-2xl opacity-0 invisible translate-x-4 scale-90 group-hover/actions:opacity-100 group-hover/actions:visible group-hover/actions:translate-x-[-48px] group-hover/actions:scale-100 transition-all duration-500 cubic-bezier(0.34, 1.56, 0.64, 1) z-20 backdrop-blur-xl">
                    <router-link 
                      :to="{ name: 'instructors.show', params: { id: instructor.id } }"
                      class="w-10 h-10 flex items-center justify-center rounded-2xl text-indigo-500 hover:bg-indigo-500/10 transition-all active:scale-90"
                      title="View Profile"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </router-link>
                    
                    <div class="w-px h-4 bg-slate-700/30"></div>
                    
                    <router-link 
                      :to="{ name: 'instructors.edit', params: { id: instructor.id } }"
                      class="w-10 h-10 flex items-center justify-center rounded-2xl text-amber-500 hover:bg-amber-500/10 transition-all active:scale-90"
                      title="Update Profile"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </router-link>
                    
                    <div class="w-px h-4 bg-slate-700/30"></div>
                    
                    <button 
                      @click="triggerDelete(instructor)"
                      class="w-10 h-10 flex items-center justify-center rounded-2xl text-rose-500 hover:bg-rose-500/10 transition-all active:scale-90"
                      title="Purge Account"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                  </div>

                  <!-- Dot Trigger -->
                  <button class="w-11 h-11 flex items-center justify-center rounded-2xl theme-bg-element border-2 theme-border theme-text-dim hover:theme-text-main hover:border-indigo-500/50 transition-all group-hover/actions:rotate-90 group-hover/actions:bg-indigo-600 group-hover/actions:text-white group-hover/actions:shadow-[0_0_25px_rgba(79,70,229,0.4)] z-30">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination Component -->
        <div class="mt-12 flex justify-center">
          <Pagination :pagination="pagination" @change="fetchInstructors" />
        </div>
      </template>
    </div>

    <!-- Global Action Dialog -->
    <ActionDialog
      :show="showDeleteModal"
      title="Irreversible Account Purge"
      :message="`You are about to permanently delete '${instructorToDelete?.name}'. This profile, their credentials, and all associated analytics will be erased from the secure cluster. Continue?`"
      :loading="deleting"
      @confirm="confirmDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { instructorService } from '../../../services/instructorService';
import ActionDialog from '../../../components/common/ActionDialog.vue';
import Pagination from '../../../components/common/Pagination.vue';
import SkeletonLoader from '../../../components/common/SkeletonLoader.vue';
import EmptyState from '../../../components/common/EmptyState.vue';
import { useToast } from '../../../composables/useToast';

const toast = useToast();
const instructors = ref([]);
const loading = ref(true);
const search = ref('');
const deleting = ref(false);
const showDeleteModal = ref(false);
const instructorToDelete = ref(null);

const pagination = reactive({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0
});

const fetchInstructors = async (page = 1) => {
  loading.value = true;
  try {
    const data = await instructorService.index({ 
      page, 
      search: search.value,
      per_page: pagination.per_page 
    });
    
    // Smooth transition delay
    await new Promise(resolve => setTimeout(resolve, 300));
    
    instructors.value = data.data;
    const meta = data.meta;
    pagination.current_page = meta.current_page;
    pagination.last_page = meta.last_page;
    pagination.total = meta.total;
    pagination.from = meta.from;
    pagination.to = meta.to;
  } catch (error) {
    toast.error('Sync failed: Could not fetch educators');
  } finally {
    loading.value = false;
  }
};

let debounceTimer;
const debounceSearch = () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    fetchInstructors(1);
  }, 600);
};

const toggleStatus = async (instructor) => {
  try {
    const data = await instructorService.toggleStatus(instructor.id);
    instructor.status = data.instructor.status;
    toast.success(`Access updated: ${data.instructor.status}`);
  } catch (error) {
    toast.error('Governance update failed');
  }
};

const toggleFeatured = async (instructor) => {
  try {
    await instructorService.toggleFeatured(instructor.id);
    instructor.is_featured = !instructor.is_featured;
    toast.success(instructor.is_featured ? 'Highlighted on Mainframe' : 'Removed from Spotlight');
  } catch (error) {
    toast.error('Highlighting failed');
  }
};

const triggerDelete = (instructor) => {
  instructorToDelete.value = instructor;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  if (!instructorToDelete.value) return;
  
  deleting.value = true;
  try {
    await instructorService.destroy(instructorToDelete.value.id);
    toast.success('Nucleus purged: Mentor account deleted');
    showDeleteModal.value = false;
    instructorToDelete.value = null;
    fetchInstructors(pagination.current_page);
  } catch (error) {
    toast.error(error.response?.data?.message || 'Purge interrupted');
  } finally {
    deleting.value = false;
  }
};

onMounted(() => {
  fetchInstructors();
});
</script>

<style scoped>
.shadow-2xl {
  box-shadow: 0 25px 50px -12px rgba(67, 56, 202, 0.15);
}
</style>
