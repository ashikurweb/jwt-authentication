<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center gap-3 mb-2">
          <router-link 
            :to="{ name: 'settings' }"
            class="p-2 theme-bg-card border theme-border rounded-xl hover:border-indigo-500/50 transition-all"
          >
            <svg class="w-5 h-5 theme-text-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </router-link>
          <h1 class="text-3xl font-black theme-text-main tracking-tight">General Settings</h1>
        </div>
        <p class="text-sm theme-text-muted font-medium">Configure basic application settings like timezone, date format, and more.</p>
      </div>
      <button 
        @click="saveSettings"
        :disabled="saving"
        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-bold text-sm flex items-center gap-2 shadow-lg shadow-indigo-600/20 active:scale-95 transition-all disabled:opacity-70"
      >
        <svg v-if="saving" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>{{ saving ? 'Saving...' : 'Save Changes' }}</span>
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center py-20">
      <div class="flex flex-col items-center gap-4">
        <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
        <p class="text-xs font-black theme-text-dim uppercase tracking-widest">Loading Settings...</p>
      </div>
    </div>

    <!-- Settings Form -->
    <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Timezone Section -->
      <div class="theme-bg-card border theme-border rounded-[2rem] p-6 lg:p-8 shadow-sm">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-black theme-text-main">Timezone Settings</h3>
            <p class="text-sm theme-text-dim">Set the default timezone for your application</p>
          </div>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-xs font-black theme-text-dim uppercase tracking-widest mb-2">Application Timezone</label>
            <div class="relative">
              <select
                v-model="form.app_timezone"
                class="w-full px-4 py-4 pr-12 theme-bg-element border theme-border rounded-2xl text-sm font-bold theme-text-main outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all appearance-none cursor-pointer"
              >
                <optgroup v-for="(zones, region) in timezones" :key="region" :label="region">
                  <option v-for="zone in zones" :key="zone.value" :value="zone.value">
                    {{ zone.label }} ({{ zone.offset }})
                  </option>
                </optgroup>
              </select>
              <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 theme-text-dim pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>
            <p class="text-xs theme-text-muted mt-2">All dates and times will be displayed in this timezone.</p>
          </div>

          <!-- Auto-detect Button -->
          <button
            @click="autoDetectTimezone"
            type="button"
            class="w-full py-3 theme-bg-element border theme-border rounded-2xl text-sm font-bold theme-text-main hover:border-indigo-500/50 flex items-center justify-center gap-2 transition-all"
          >
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Auto-detect from my location
          </button>
        </div>
      </div>

      <!-- Date & Time Format Section -->
      <div class="theme-bg-card border theme-border rounded-[2rem] p-6 lg:p-8 shadow-sm">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-black theme-text-main">Date & Time Format</h3>
            <p class="text-sm theme-text-dim">Customize how dates and times are displayed</p>
          </div>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-xs font-black theme-text-dim uppercase tracking-widest mb-2">Date Format</label>
            <select
              v-model="form.date_format"
              class="w-full px-4 py-4 pr-12 theme-bg-element border theme-border rounded-2xl text-sm font-bold theme-text-main outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all appearance-none cursor-pointer"
            >
              <option value="M d, Y">Feb 07, 2026</option>
              <option value="d M, Y">07 Feb, 2026</option>
              <option value="Y-m-d">2026-02-07</option>
              <option value="d/m/Y">07/02/2026</option>
              <option value="m/d/Y">02/07/2026</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-black theme-text-dim uppercase tracking-widest mb-2">Time Format</label>
            <div class="grid grid-cols-2 gap-3">
              <button
                type="button"
                @click="form.time_format = 'h:i A'"
                :class="[
                  'py-4 rounded-2xl text-sm font-bold border-2 transition-all',
                  form.time_format === 'h:i A' 
                    ? 'bg-indigo-500/10 border-indigo-500 text-indigo-600 dark:text-indigo-400' 
                    : 'theme-bg-element theme-border theme-text-main hover:border-indigo-500/50'
                ]"
              >
                <span class="block text-lg font-black">12-Hour</span>
                <span class="block text-xs theme-text-dim mt-1">01:30 PM</span>
              </button>
              <button
                type="button"
                @click="form.time_format = 'H:i'"
                :class="[
                  'py-4 rounded-2xl text-sm font-bold border-2 transition-all',
                  form.time_format === 'H:i' 
                    ? 'bg-indigo-500/10 border-indigo-500 text-indigo-600 dark:text-indigo-400' 
                    : 'theme-bg-element theme-border theme-text-main hover:border-indigo-500/50'
                ]"
              >
                <span class="block text-lg font-black">24-Hour</span>
                <span class="block text-xs theme-text-dim mt-1">13:30</span>
              </button>
            </div>
          </div>

          <!-- Live Clock Preview -->
          <div class="p-8 theme-bg-element border theme-border rounded-3xl relative overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute inset-0 overflow-hidden">
              <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-indigo-500/10 rounded-full blur-3xl animate-pulse"></div>
              <div class="absolute -bottom-1/2 -right-1/2 w-full h-full bg-violet-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>
            
            <div class="relative z-10">
              <div class="flex items-center justify-center gap-2 mb-6">
                <div class="relative">
                  <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                  <div class="absolute inset-0 w-3 h-3 rounded-full bg-emerald-500 animate-ping"></div>
                </div>
                <span class="text-xs font-black theme-text-dim uppercase tracking-widest">Live Clock Preview</span>
              </div>
              
              <!-- Clock Display -->
              <div class="flex items-center justify-center gap-2">
                <!-- Hours -->
                <div class="clock-digit-wrapper">
                  <div class="clock-digit">
                    <Transition name="flip" mode="out-in">
                      <span :key="clockDisplay.hours" class="text-5xl font-black text-white tabular-nums block">{{ clockDisplay.hours }}</span>
                    </Transition>
                  </div>
                </div>
                
                <!-- Separator -->
                <div class="flex flex-col gap-2 px-1">
                  <div class="clock-dot"></div>
                  <div class="clock-dot" style="animation-delay: 0.5s;"></div>
                </div>
                
                <!-- Minutes -->
                <div class="clock-digit-wrapper">
                  <div class="clock-digit">
                    <Transition name="flip" mode="out-in">
                      <span :key="clockDisplay.minutes" class="text-5xl font-black text-white tabular-nums block">{{ clockDisplay.minutes }}</span>
                    </Transition>
                  </div>
                </div>
                
                <!-- Separator -->
                <div class="flex flex-col gap-2 px-1">
                  <div class="clock-dot-secondary"></div>
                  <div class="clock-dot-secondary" style="animation-delay: 0.5s;"></div>
                </div>
                
                <!-- Seconds -->
                <div class="clock-digit-wrapper-accent">
                  <div class="clock-digit-accent">
                    <Transition name="flip" mode="out-in">
                      <span :key="clockDisplay.seconds" class="text-5xl font-black text-white tabular-nums block">{{ clockDisplay.seconds }}</span>
                    </Transition>
                  </div>
                </div>
                
                <!-- AM/PM Badge -->
                <Transition name="slide-fade">
                  <div v-if="form.time_format === 'h:i A'" class="ml-3 period-badge">
                    <Transition name="flip" mode="out-in">
                      <span :key="clockDisplay.period" class="text-lg font-black text-white block">{{ clockDisplay.period }}</span>
                    </Transition>
                  </div>
                </Transition>
              </div>
              
              <!-- Date & Timezone Display -->
              <div class="mt-6 flex items-center justify-center gap-3">
                <div class="px-4 py-2 rounded-full theme-bg-card border theme-border">
                  <span class="text-sm font-bold theme-text-main">{{ clockDisplay.date }}</span>
                </div>
                <div class="px-3 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20">
                  <span class="text-xs font-black text-indigo-500">{{ form.app_timezone }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Site Info Section -->
      <div class="theme-bg-card border theme-border rounded-[2rem] p-6 lg:p-8 shadow-sm lg:col-span-2">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-12 h-12 rounded-2xl bg-violet-500/10 flex items-center justify-center text-violet-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-black theme-text-main">Site Information</h3>
            <p class="text-sm theme-text-dim">Basic information about your application</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-black theme-text-dim uppercase tracking-widest mb-2">Site Name</label>
            <input
              v-model="form.site_name"
              type="text"
              class="w-full px-4 py-4 theme-bg-element border theme-border rounded-2xl text-sm font-bold theme-text-main outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all"
              placeholder="My Application"
            >
          </div>

          <div>
            <label class="block text-xs font-black theme-text-dim uppercase tracking-widest mb-2">Site Email</label>
            <input
              v-model="form.site_email"
              type="email"
              class="w-full px-4 py-4 theme-bg-element border theme-border rounded-2xl text-sm font-bold theme-text-main outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all"
              placeholder="support@example.com"
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue';
import { settingsService } from '../../../services/settingsService';
import { useToast } from '../../../composables/useToast';

const toast = useToast();
const loading = ref(true);
const saving = ref(false);

const form = reactive({
  app_timezone: 'UTC',
  date_format: 'M d, Y',
  time_format: 'h:i A',
  site_name: '',
  site_email: '',
});

const timezones = ref({});

// Live Clock State
const clockDisplay = reactive({
  hours: '00',
  minutes: '00',
  seconds: '00',
  period: 'AM',
  date: ''
});

let clockInterval = null;

const updateClock = () => {
  try {
    const now = new Date();
    const options = { timeZone: form.app_timezone };
    
    // Get time parts
    const formatter = new Intl.DateTimeFormat('en-US', {
      ...options,
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: form.time_format === 'h:i A'
    });
    
    const parts = formatter.formatToParts(now);
    
    let hours = '00', minutes = '00', seconds = '00', period = '';
    
    parts.forEach(part => {
      if (part.type === 'hour') hours = part.value;
      if (part.type === 'minute') minutes = part.value;
      if (part.type === 'second') seconds = part.value;
      if (part.type === 'dayPeriod') period = part.value;
    });
    
    clockDisplay.hours = hours;
    clockDisplay.minutes = minutes;
    clockDisplay.seconds = seconds;
    clockDisplay.period = period;
    
    // Format date
    const dateFormatter = new Intl.DateTimeFormat('en-US', {
      ...options,
      weekday: 'long',
      month: 'long',
      day: 'numeric',
      year: 'numeric'
    });
    clockDisplay.date = dateFormatter.format(now);
    
  } catch {
    clockDisplay.hours = '--';
    clockDisplay.minutes = '--';
    clockDisplay.seconds = '--';
    clockDisplay.date = 'Invalid timezone';
  }
};

const startClock = () => {
  updateClock();
  clockInterval = setInterval(updateClock, 1000);
};

const autoDetectTimezone = () => {
  const detected = Intl.DateTimeFormat().resolvedOptions().timeZone;
  form.app_timezone = detected;
  updateClock();
  toast.success(`Timezone auto-detected: ${detected}`);
};

const loadSettings = async () => {
  loading.value = true;
  try {
    const [settingsResponse, timezonesResponse] = await Promise.all([
      settingsService.getGeneral(),
      settingsService.getTimezones()
    ]);

    if (settingsResponse.data) {
      Object.assign(form, {
        app_timezone: settingsResponse.data.timezone || 'UTC',
        date_format: settingsResponse.data.date_format || 'M d, Y',
        time_format: settingsResponse.data.time_format || 'h:i A',
        site_name: settingsResponse.data.site_name || '',
        site_email: settingsResponse.data.site_email || '',
      });
    }

    if (timezonesResponse.data) {
      timezones.value = timezonesResponse.data;
    }
  } catch (error) {
    toast.error('Failed to load settings');
    console.error(error);
  } finally {
    loading.value = false;
    startClock();
  }
};

const saveSettings = async () => {
  saving.value = true;
  try {
    await settingsService.update([
      { key: 'app_timezone', value: form.app_timezone, type: 'string', group: 'general' },
      { key: 'date_format', value: form.date_format, type: 'string', group: 'general' },
      { key: 'time_format', value: form.time_format, type: 'string', group: 'general' },
      { key: 'site_name', value: form.site_name, type: 'string', group: 'general' },
      { key: 'site_email', value: form.site_email, type: 'string', group: 'general' },
    ]);
    toast.success('Settings saved successfully!');
  } catch (error) {
    toast.error('Failed to save settings');
    console.error(error);
  } finally {
    saving.value = false;
  }
};

onMounted(() => {
  loadSettings();
});

onUnmounted(() => {
  if (clockInterval) {
    clearInterval(clockInterval);
  }
});
</script>

<style scoped>
/* Clock Digit Wrappers */
.clock-digit-wrapper {
  border-radius: 1rem;
  padding: 0.25rem;
  background: linear-gradient(to bottom, #334155, #1e293b);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.clock-digit {
  background: linear-gradient(to bottom, #1e293b, #0f172a);
  border-radius: 0.75rem;
  padding: 0.75rem 1rem;
  border: 1px solid rgba(255, 255, 255, 0.05);
  box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.1);
}

.clock-digit-wrapper-accent {
  border-radius: 1rem;
  padding: 0.25rem;
  background: linear-gradient(to bottom, #6366f1, #7c3aed);
  box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.4);
}

.clock-digit-accent {
  background: linear-gradient(to bottom, #4f46e5, #6d28d9);
  border-radius: 0.75rem;
  padding: 0.75rem 1rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Period Badge */
.period-badge {
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
  background: linear-gradient(to bottom right, #f59e0b, #ea580c);
  box-shadow: 0 25px 50px -12px rgba(245, 158, 11, 0.3);
}

/* Animated Dots */
.clock-dot {
  width: 0.75rem;
  height: 0.75rem;
  border-radius: 9999px;
  background-color: #6366f1;
  box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.5);
  animation: pulse-glow 1s ease-in-out infinite;
}

.clock-dot-secondary {
  width: 0.625rem;
  height: 0.625rem;
  border-radius: 9999px;
  background-color: #8b5cf6;
  box-shadow: 0 10px 15px -3px rgba(139, 92, 246, 0.5);
  animation: pulse-glow 1s ease-in-out infinite;
}

@keyframes pulse-glow {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(0.7);
    opacity: 0.4;
  }
}

/* Flip Animation */
.flip-enter-active {
  animation: flip-in 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.flip-leave-active {
  animation: flip-out 0.15s cubic-bezier(0.55, 0.085, 0.68, 0.53);
}

@keyframes flip-in {
  0% {
    transform: rotateX(-90deg) scale(0.9);
    opacity: 0;
  }
  100% {
    transform: rotateX(0) scale(1);
    opacity: 1;
  }
}

@keyframes flip-out {
  0% {
    transform: rotateX(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: rotateX(90deg) scale(0.9);
    opacity: 0;
  }
}

/* Slide Fade Animation for AM/PM */
.slide-fade-enter-active {
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.55, 0, 1, 0.45);
}

.slide-fade-enter-from {
  transform: translateX(-20px) scale(0.8);
  opacity: 0;
}

.slide-fade-leave-to {
  transform: translateX(20px) scale(0.8);
  opacity: 0;
}
</style>
