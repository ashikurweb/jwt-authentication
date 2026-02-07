<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black theme-text-main tracking-tight">Instructor Payouts</h1>
        <p class="text-sm theme-text-muted mt-1 font-medium">Review and process payment requests from instructors.</p>
      </div>
      <div class="flex items-center gap-3">
        <div class="relative group">
          <input 
            v-model="search"
            type="text" 
            placeholder="Search payouts..." 
            class="pl-10 pr-4 py-3 theme-bg-card border theme-border rounded-2xl text-sm font-bold theme-text-main outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all w-64"
            @input="debounceSearch"
          >
          <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 theme-text-dim group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- Modern Floating Table -->
    <div class="relative min-h-[400px]">
      <!-- Column Headers -->
      <div class="grid grid-cols-12 gap-4 px-8 py-4 mb-4 theme-table-header rounded-2xl shadow-sm overflow-hidden relative group/header">
        <div class="absolute inset-x-0 bottom-0 h-px bg-linear-to-r from-transparent via-indigo-500/30 to-transparent"></div>
        <div class="col-span-1 text-[10px] font-black theme-table-header-text uppercase tracking-[0.2em]">SL</div>
        <div class="col-span-3 text-[10px] font-black theme-table-header-text uppercase tracking-[0.2em]">Instructor</div>
        <div class="col-span-2 text-[10px] font-black theme-table-header-text uppercase tracking-[0.2em]">Amount</div>
        <div class="col-span-2 text-[10px] font-black theme-table-header-text uppercase tracking-[0.2em]">Period</div>
        <div class="col-span-2 text-[10px] font-black theme-table-header-text uppercase tracking-[0.2em] text-center">Status</div>
        <div class="col-span-2 text-[10px] font-black theme-table-header-text uppercase tracking-[0.2em] text-right">Actions</div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-32 theme-bg-card border theme-border rounded-[2.5rem] shadow-sm">
         <SkeletonLoader :cols="6" />
      </div>

      <template v-else>
        <!-- Empty State Component -->
        <EmptyState 
          v-if="payouts.length === 0"
          title="No payouts found"
          message="No payout requests have been made yet."
        />

        <!-- Floating Rows -->
        <div class="space-y-3">
          <div 
            v-for="(payout, index) in payouts" 
            :key="payout.id" 
            class="grid grid-cols-12 gap-4 items-center px-8 py-4 theme-bg-card border theme-border rounded-[1.5rem] shadow-sm transition-colors duration-300 group"
          >
            <!-- SL Column -->
            <div class="col-span-1">
              <div class="w-9 h-9 rounded-xl theme-bg-element border theme-border flex items-center justify-center text-[11px] font-black theme-text-dim transition-all">
                {{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}
              </div>
            </div>

            <!-- Instructor Column -->
            <div class="col-span-3">
              <div class="flex flex-col">
                <span class="text-sm font-black theme-text-main tracking-tight">{{ payout.instructor_name }}</span>
                <span class="text-[9px] theme-text-dim font-bold uppercase tracking-widest opacity-70">{{ payout.instructor_email }}</span>
              </div>
            </div>

            <!-- Amount Column -->
            <div class="col-span-2">
              <div class="flex flex-col">
                <span class="text-sm font-black theme-text-main">{{ payout.amount }} {{ payout.currency }}</span>
                <span class="text-[9px] theme-text-dim font-bold uppercase tracking-widest opacity-70">Net: {{ payout.net_amount }}</span>
              </div>
            </div>

            <!-- Period Column -->
            <div class="col-span-2">
              <div class="flex flex-col">
                <span class="text-[10px] font-bold theme-text-main">{{ formatDate(payout.period_start) }}</span>
                <span class="text-[9px] theme-text-dim font-medium uppercase tracking-tighter">to {{ formatDate(payout.period_end) }}</span>
              </div>
            </div>

            <!-- Status Column -->
            <div class="col-span-2 flex justify-center">
              <div 
                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border shadow-sm"
                :class="statusClasses(payout.status)"
              >
                {{ payout.status }}
              </div>
            </div>

            <!-- Actions Column -->
            <div class="col-span-2 text-right">
              <div class="flex items-center justify-end">
                <div class="relative group/actions flex items-center">
                  <!-- Expanded Action Dock -->
                  <div class="absolute right-0 flex items-center gap-1.5 px-2 py-1.5 theme-bg-card border theme-border rounded-2xl shadow-2xl opacity-0 invisible translate-x-4 scale-90 group-hover/actions:opacity-100 group-hover/actions:visible group-hover/actions:translate-x-[-45px] group-hover/actions:scale-100 transition-all duration-500 cubic-bezier(0.34, 1.56, 0.64, 1) z-20 backdrop-blur-xl">
                    <button 
                      @click="viewPayout(payout)"
                      class="w-9 h-9 flex items-center justify-center rounded-xl text-indigo-500 hover:bg-indigo-500/10 transition-all active:scale-90"
                      title="View & Process"
                    >
                      <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <div class="w-px h-4 bg-slate-700/50"></div>
                    <button 
                      @click="triggerDelete(payout)"
                      v-if="payout.status !== 'completed'"
                      class="w-9 h-9 flex items-center justify-center rounded-xl text-rose-500 hover:bg-rose-500/10 transition-all active:scale-90"
                      title="Delete Entry"
                    >
                      <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                  </div>

                  <!-- Main Trigger Button -->
                  <button class="w-10 h-10 flex items-center justify-center rounded-xl theme-bg-element border theme-border theme-text-dim hover:theme-text-main hover:border-indigo-500/50 transition-all group-hover/actions:rotate-90 group-hover/actions:bg-indigo-600 group-hover/actions:text-white group-hover/actions:shadow-[0_0_20px_rgba(79,70,229,0.4)] z-30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination Component -->
        <div class="mt-8">
          <Pagination :pagination="pagination" @change="fetchPayouts" />
        </div>
      </template>
    </div>

    <!-- Payout Details Modal -->
    <transition name="panel">
      <div v-if="showModal" class="fixed inset-0 z-100 overflow-hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal"></div>
        
        <div class="absolute inset-y-0 right-0 w-full max-w-md theme-bg-card border-l theme-border shadow-2xl flex flex-col">
          <div class="p-8 border-b theme-border flex items-center justify-between">
            <div>
              <h2 class="text-xl font-black theme-text-main tracking-tight">Payout Details</h2>
              <p class="text-xs theme-text-dim font-medium">Process or review payout for {{ selectedPayout?.instructor_name }}</p>
            </div>
            <button @click="closeModal" class="p-2 theme-text-muted hover:theme-text-main transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>

          <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            <div v-if="selectedPayout" class="space-y-6">
              <div class="flex flex-col items-center gap-2 py-6 theme-bg-element rounded-3xl border theme-border">
                <span class="text-[10px] font-black theme-text-dim uppercase tracking-widest">Amount to Pay</span>
                <h3 class="text-3xl font-black theme-text-main">{{ selectedPayout.amount }} {{ selectedPayout.currency }}</h3>
                <div 
                  class="mt-2 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider border shadow-sm"
                  :class="statusClasses(selectedPayout.status)"
                >
                  {{ selectedPayout.status }}
                </div>
              </div>

              <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <div class="p-4 theme-bg-element rounded-2xl border theme-border">
                    <span class="text-[9px] font-black theme-text-dim uppercase tracking-widest">Gross Amount</span>
                    <p class="text-sm font-black theme-text-main">{{ selectedPayout.gross_amount }}</p>
                  </div>
                  <div class="p-4 theme-bg-element rounded-2xl border theme-border">
                    <span class="text-[9px] font-black theme-text-dim uppercase tracking-widest">Platform Fee</span>
                    <p class="text-sm font-black text-rose-500">-{{ selectedPayout.platform_fee }}</p>
                  </div>
                </div>

                <div class="p-6 theme-bg-element rounded-3xl border theme-border space-y-4">
                  <h4 class="text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">Payment Information</h4>
                  <div class="space-y-2">
                    <div class="flex justify-between items-center text-xs">
                      <span class="font-bold theme-text-dim uppercase tracking-tighter">Method</span>
                      <span class="font-black theme-text-main uppercase">{{ selectedPayout.payment_method || 'N/A' }}</span>
                    </div>
                    <div v-if="selectedPayout.transaction_id" class="flex justify-between items-center text-xs">
                      <span class="font-bold theme-text-dim uppercase tracking-tighter">Transaction ID</span>
                      <span class="font-black theme-text-main">{{ selectedPayout.transaction_id }}</span>
                    </div>
                  </div>
                </div>

                <div v-if="selectedPayout.status === 'pending' || selectedPayout.status === 'processing'" class="pt-4 space-y-4">
                  <div class="space-y-2">
                    <label class="text-[10px] font-black theme-text-dim uppercase tracking-[0.2em] ml-2">Transaction ID</label>
                    <input 
                      v-model="processForm.transaction_id"
                      type="text" 
                      placeholder="Enter payment reference ID" 
                      class="w-full px-6 py-4 rounded-2xl theme-bg-element border-2 theme-border outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm font-bold theme-text-main"
                    >
                  </div>
                  <div class="flex items-center gap-4">
                    <button 
                      @click="processPayout('completed')"
                      :disabled="processing || !processForm.transaction_id"
                      class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/20 active:scale-95 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
                    >
                      Process Payout
                    </button>
                    <button 
                      @click="processPayout('failed')"
                      :disabled="processing"
                      class="px-6 py-4 rounded-2xl font-bold theme-text-dim hover:theme-text-main border theme-border transition-all"
                    >
                      Fail
                    </button>
                  </div>
                </div>

                <div v-if="selectedPayout.processed_at" class="pt-4 text-center">
                  <p class="text-[9px] font-bold theme-text-dim uppercase tracking-widest">
                    Processed by {{ selectedPayout.processed_by_name }} on {{ formatDate(selectedPayout.processed_at) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>

    <!-- Global Action Dialog -->
    <ActionDialog
      :show="showDeleteModal"
      title="Delete Payout Entry"
      :message="`Are you sure you want to delete this payout entry for '${payoutToDelete?.instructor_name}'? Only pending or failed payouts can be deleted.`"
      :loading="deleting"
      @confirm="confirmDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { payoutService } from '../../../services/payoutService';
import ActionDialog from '../../../components/common/ActionDialog.vue';
import Pagination from '../../../components/common/Pagination.vue';
import SkeletonLoader from '../../../components/common/SkeletonLoader.vue';
import EmptyState from '../../../components/common/EmptyState.vue';
import { useToast } from '../../../composables/useToast';

const toast = useToast();
const payouts = ref([]);
const loading = ref(true);
const processing = ref(false);
const search = ref('');
const showModal = ref(false);
const deleting = ref(false);
const showDeleteModal = ref(false);
const payoutToDelete = ref(null);
const selectedPayout = ref(null);

const processForm = reactive({
  transaction_id: '',
  notes: ''
});

const pagination = reactive({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0
});

const fetchPayouts = async (page = 1) => {
  loading.value = true;
  try {
    const data = await payoutService.index({ 
      page, 
      search: search.value,
      per_page: pagination.per_page 
    });
    await new Promise(resolve => setTimeout(resolve, 500));
    
    payouts.value = data.data;
    const meta = data.meta;
    pagination.current_page = meta.current_page;
    pagination.last_page = meta.last_page;
    pagination.total = meta.total;
    pagination.from = meta.from;
    pagination.to = meta.to;
  } catch (error) {
    toast.error('Failed to fetch payouts');
  } finally {
    loading.value = false;
  }
};

let debounceTimer;
const debounceSearch = () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    fetchPayouts(1);
  }, 500);
};

const viewPayout = (payout) => {
  selectedPayout.value = payout;
  processForm.transaction_id = payout.transaction_id || '';
  processForm.notes = payout.notes || '';
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedPayout.value = null;
};

const processPayout = async (status) => {
  processing.value = true;
  try {
    const data = await payoutService.update(selectedPayout.value.id, { 
      status,
      transaction_id: processForm.transaction_id,
      notes: processForm.notes
    });
    
    selectedPayout.value.status = status;
    selectedPayout.value.transaction_id = processForm.transaction_id;
    
    // Update in list
    const index = payouts.value.findIndex(p => p.id === selectedPayout.value.id);
    if (index !== -1) payouts.value[index] = data.payout;
    
    toast.success(data.message);
    closeModal();
  } catch (error) {
    toast.error(error.response?.data?.message || 'Failed to process payout');
  } finally {
    processing.value = false;
  }
};

const triggerDelete = (payout) => {
  payoutToDelete.value = payout;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  if (!payoutToDelete.value) return;
  
  deleting.value = true;
  try {
    await payoutService.destroy(payoutToDelete.value.id);
    toast.success('Payout entry deleted');
    showDeleteModal.value = false;
    payoutToDelete.value = null;
    fetchPayouts(pagination.current_page);
  } catch (error) {
    toast.error(error.response?.data?.message || 'Failed to delete payout');
  } finally {
    deleting.value = false;
  }
};

const formatDate = (date) => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  });
};

const statusClasses = (status) => {
  switch (status) {
    case 'completed': return 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20';
    case 'pending': return 'bg-amber-500/10 text-amber-500 border-amber-500/20';
    case 'processing': return 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20';
    case 'failed': return 'bg-rose-500/10 text-rose-500 border-rose-500/20';
    default: return 'bg-slate-500/10 text-slate-500 border-slate-500/20';
  }
};

onMounted(() => {
  fetchPayouts();
});
</script>

<style scoped>
.panel-enter-active, .panel-leave-active {
  transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.panel-enter-from, .panel-leave-to {
  transform: translateX(100%);
  opacity: 0;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
  height: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(99, 102, 241, 0.2);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(99, 102, 241, 0.4);
}
</style>
