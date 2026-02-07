<template>
  <div class="min-h-screen theme-bg-main pb-24 animate-in fade-in duration-1000">
    <!-- Fluid Decoration Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-[10%] -left-[5%] w-[40%] h-[40%] bg-indigo-500/5 blur-[120px] rounded-full animate-pulse"></div>
      <div class="absolute top-[20%] -right-[10%] w-[35%] h-[45%] bg-blue-500/5 blur-[100px] rounded-full animate-float"></div>
      <div class="absolute -bottom-[10%] left-[20%] w-[50%] h-[30%] bg-violet-500/5 blur-[120px] rounded-full"></div>
    </div>

    <!-- Premium Header -->
    <div class="relative pt-12 pb-16 px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div class="space-y-4">
          <router-link 
            to="/admin/instructors" 
            class="inline-flex items-center gap-2 theme-text-dim hover:theme-text-main transition-all text-[10px] font-black uppercase tracking-[0.2em] group"
          >
            <div class="w-8 h-8 rounded-full theme-bg-element flex items-center justify-center border theme-border group-hover:border-indigo-500/50 transition-colors">
              <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </div>
            Back to Registry
          </router-link>
          <div>
            <h1 class="text-6xl font-black theme-text-main tracking-tighter leading-none mb-4">
              Add New <span class="bg-gradient-to-r from-indigo-500 to-violet-500 bg-clip-text text-transparent">Instructor</span>
            </h1>
            <p class="text-lg theme-text-muted font-medium max-w-xl">Register a new educator to the platform. Complete these steps to set up their professional profile and access.</p>
          </div>
        </div>

        <!-- Progress Indicator -->
        <div class="flex items-center gap-3">
          <div 
            v-for="(tab, index) in tabs" 
            :key="tab.id"
            class="flex items-center gap-3 transition-all duration-500"
            :class="activeTab === tab.id ? 'opacity-100' : 'opacity-40'"
          >
            <div 
              class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-xs transition-all duration-500"
              :class="activeTab === tab.id ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30 active-step' : 'theme-bg-element theme-text-dim'"
            >
              0{{ index + 1 }}
            </div>
            <div v-if="index < tabs.length - 1" class="w-8 h-[2px] theme-bg-element"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Layout -->
    <div class="max-w-7xl mx-auto px-8 relative z-10">
      <div class="grid grid-cols-12 gap-10">
        
        <!-- Tab Navigation (Compact Sidebar Style) -->
        <div class="col-span-12 lg:col-span-3">
          <div class="sticky top-8 space-y-4">
            <button 
              v-for="tab in tabs" 
              :key="tab.id"
              @click="activeTab = tab.id"
              class="w-full flex items-center justify-between p-5 rounded-[2rem] border-2 transition-all duration-500 group"
              :class="activeTab === tab.id 
                ? 'theme-bg-card border-indigo-500/50 shadow-2xl shadow-indigo-500/10' 
                : 'theme-bg-element/50 border-transparent hover:border-theme-border'"
            >
              <div class="flex items-center gap-4">
                <div 
                  class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors shadow-inner"
                  :class="activeTab === tab.id ? 'bg-indigo-500/10 text-indigo-500' : 'theme-bg-element theme-text-dim group-hover:theme-text-main'"
                  v-html="tab.icon"
                ></div>
                <div class="text-left">
                  <div class="text-[10px] font-black uppercase tracking-widest leading-none mb-1 transition-colors"
                    :class="activeTab === tab.id ? 'theme-text-main' : 'theme-text-dim group-hover:theme-text-main'">
                    {{ tab.subtitle }}
                  </div>
                  <div class="text-sm font-black theme-text-main">{{ tab.name }}</div>
                </div>
              </div>
              <svg 
                class="w-4 h-4 transition-all duration-500" 
                :class="activeTab === tab.id ? 'text-indigo-500 translate-x-0' : 'theme-text-dim opacity-0 -translate-x-4'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>

            <!-- Quick Actions Card -->
            <div class="mt-8 p-8 theme-bg-card border theme-border rounded-[2.5rem] shadow-xl relative overflow-hidden group">
              <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl transition-transform group-hover:scale-150 duration-700"></div>
              <h4 class="text-[10px] font-black theme-text-dim uppercase tracking-widest mb-6">Real-time Metrics</h4>
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-bold theme-text-muted">Fields Filled</span>
                  <span class="text-sm font-black theme-text-main">{{ filledPercentage }}%</span>
                </div>
                <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                  <div 
                    class="h-full bg-indigo-500 transition-all duration-1000 ease-out"
                    :style="{ width: `${filledPercentage}%` }"
                  ></div>
                </div>
                <p class="text-[10px] font-bold theme-text-dim italic leading-relaxed pt-2 border-t theme-border">
                  "Excellence is not an act, but a habit."
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Content -->
        <div class="col-span-12 lg:col-span-9 space-y-10">
          <form @submit.prevent="saveInstructor" class="space-y-10">
            
            <!-- Step 1: Base Identity -->
            <div v-show="activeTab === 'general'" class="space-y-8 animate-in slide-in-from-bottom-10 duration-700">
              <div class="theme-bg-card border theme-border rounded-[3rem] p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-12 opacity-[0.03] pointer-events-none">
                  <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
                  <!-- Left Side: Basic Info -->
                  <div class="space-y-8">
                    <FormInput 
                      v-model="form.name"
                      label="Full Legal Name"
                      placeholder="e.g. John Doe"
                      icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      :error="errors.name?.[0]"
                    />
                    
                    <FormInput 
                      v-model="form.email"
                      type="email"
                      label="Official Email Address"
                      placeholder="instructor@example.com"
                      icon="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                      :error="errors.email?.[0]"
                    />

                    <FormInput 
                      v-model="form.phone"
                      label="Phone / WhatsApp Number"
                      placeholder="+880 1XXX XXXXXX"
                      icon="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                      :error="errors.phone?.[0]"
                    />

                    <FormInput 
                      v-model="form.password"
                      type="password"
                      label="Login Password"
                      placeholder="Create a strong password"
                      icon="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                      :error="errors.password?.[0]"
                    />
                  </div>

                  <!-- Right Side: Profile Photo -->
                  <div class="flex flex-col items-center">
                    <label class="text-[10px] font-black theme-text-dim uppercase tracking-[0.2em] mb-6 self-start ml-4">Profile Portrait</label>
                    <div class="relative group">
                      <div class="absolute -inset-4 bg-linear-to-tr from-indigo-500/20 to-violet-500/20 rounded-[3rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                      <ImageUploader 
                        v-model="form.avatar" 
                        folder="instructors/avatars"
                        aspect="square"
                        class="relative"
                      />
                    </div>
                    <div class="mt-8 p-6 theme-bg-element rounded-[2rem] border-2 border-dashed theme-border text-center max-w-[280px]">
                      <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest leading-relaxed">Square format (1:1) works best for instructor cards.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 2: Expert Profile -->
            <div v-show="activeTab === 'professional'" class="space-y-8 animate-in slide-in-from-bottom-10 duration-700">
              <div class="theme-bg-card border theme-border rounded-[3rem] p-12 shadow-2xl space-y-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                  <FormInput 
                    v-model="form.headline"
                    label="Professional Title / Designation"
                    placeholder="e.g. Senior Software Engineer & Trainer"
                    icon="M13 10V3L4 14h7v7l9-11h-7z"
                    :error="errors.headline?.[0]"
                  />
                  <FormInput 
                    v-model="form.expertise"
                    label="Subjects / Skills of Expertise"
                    placeholder="e.g. Graphic Design, Web Development"
                    icon="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                    :error="errors.expertise?.[0]"
                  />
                </div>

                <div class="space-y-8">
                  <div class="space-y-4">
                    <div class="flex items-center justify-between ml-2">
                      <label class="text-[10px] font-black theme-text-dim uppercase tracking-[0.2em]">Detailed Biography / Experience</label>
                      <span class="text-[10px] theme-text-dim font-bold">{{ form.bio?.length || 0 }} / 2000</span>
                    </div>
                    <textarea 
                      v-model="form.bio"
                      rows="8"
                      placeholder="Write about the instructor's background, teaching experience, and achievements..." 
                      class="w-full px-8 py-8 rounded-[2.5rem] theme-bg-element border-2 theme-border outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm font-bold theme-text-main leading-relaxed"
                    ></textarea>
                  </div>

                  <FormInput 
                    v-model="form.short_bio"
                    label="Short Summary (Max 160 characters)"
                    placeholder="Quick intro for the list page..."
                    icon="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                    :error="errors.short_bio?.[0]"
                  />
                </div>
              </div>
            </div>

            <!-- Step 3: Accolades (Certifications & Achievements) -->
            <div v-show="activeTab === 'accolades'" class="space-y-8 animate-in slide-in-from-bottom-10 duration-700">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Certifications -->
                <div class="theme-bg-card border theme-border rounded-[3rem] p-10 shadow-2xl space-y-8">
                  <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black theme-text-main uppercase tracking-widest">Certifications</h3>
                    <button 
                      type="button" @click="addCertification"
                      class="w-10 h-10 rounded-xl bg-indigo-500 shadow-lg shadow-indigo-500/20 text-white flex items-center justify-center hover:scale-110 active:scale-90 transition-all"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                  </div>
                  
                  <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    <div v-for="(cert, index) in form.certifications" :key="index" class="group relative flex gap-4 p-5 theme-bg-element rounded-2xl border-2 theme-border hover:border-indigo-500/30 transition-all">
                      <div class="flex-1 space-y-4">
                        <input v-model="form.certifications[index].name" placeholder="Certification Name" class="w-full bg-transparent border-none outline-none text-sm font-black theme-text-main placeholder:theme-text-dim/50">
                        <input v-model="form.certifications[index].issuer" placeholder="Issuing Body (e.g. AWS, Microsoft)" class="w-full bg-transparent border-none outline-none text-[10px] font-bold theme-text-dim">
                      </div>
                      <button @click="removeCertification(index)" type="button" class="opacity-0 group-hover:opacity-100 text-rose-500 hover:scale-125 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                      </button>
                    </div>
                    <div v-if="!form.certifications.length" class="text-center py-12 border-2 border-dashed theme-border rounded-[2rem]">
                      <p class="text-[10px] font-black theme-text-dim uppercase tracking-widest">No certifications added yet</p>
                    </div>
                  </div>
                </div>

                <!-- Achievements -->
                <div class="theme-bg-card border theme-border rounded-[3rem] p-10 shadow-2xl space-y-8">
                   <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black theme-text-main uppercase tracking-widest">Achievements</h3>
                    <button 
                      type="button" @click="addAchievement"
                      class="w-10 h-10 rounded-xl bg-violet-500 shadow-lg shadow-violet-500/20 text-white flex items-center justify-center hover:scale-110 active:scale-90 transition-all"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                  </div>

                  <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    <div v-for="(ach, index) in form.achievements" :key="index" class="group relative flex gap-4 p-5 theme-bg-element rounded-2xl border-2 theme-border hover:border-violet-500/30 transition-all">
                      <div class="w-10 h-10 rounded-xl bg-violet-500/5 flex items-center justify-center text-violet-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                      </div>
                      <input v-model="form.achievements[index]" placeholder="e.g. 50,000+ Students Worldwide" class="flex-1 bg-transparent border-none outline-none text-sm font-bold theme-text-main placeholder:theme-text-dim/50">
                      <button @click="removeAchievement(index)" type="button" class="opacity-0 group-hover:opacity-100 text-rose-500 hover:scale-125 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                      </button>
                    </div>
                    <div v-if="!form.achievements.length" class="text-center py-12 border-2 border-dashed theme-border rounded-[2rem]">
                      <p class="text-[10px] font-black theme-text-dim uppercase tracking-widest">No achievements added yet</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 4: Digital Footprint -->
            <div v-show="activeTab === 'social'" class="space-y-8 animate-in slide-in-from-bottom-10 duration-700">
              <div class="theme-bg-card border theme-border rounded-[3rem] p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-indigo-500/5 blur-[100px] rounded-full"></div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-violet-500/5 blur-[100px] rounded-full"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10 relative z-10">
                  <div v-for="social in socialInputs" :key="social.id">
                    <FormInput 
                      v-model="form[social.id]"
                      :label="social.label"
                      :placeholder="social.placeholder"
                      :icon="social.icon"
                      :error="errors[social.id]?.[0]"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 5: Advanced Controls -->
            <div v-show="activeTab === 'settings'" class="space-y-8 animate-in slide-in-from-bottom-10 duration-700">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Commission Card -->
                <div class="theme-bg-card border theme-border rounded-[2.5rem] p-8 shadow-xl space-y-6">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-black theme-text-main uppercase tracking-widest">Revenue Model</span>
                  </div>
                  <div class="space-y-2">
                    <label class="text-[9px] font-black theme-text-dim uppercase tracking-[0.2em] ml-2">Platform Percentage (%)</label>
                    <div class="relative group">
                      <input 
                        v-model="form.commission_rate"
                        type="number" 
                        class="w-full px-8 py-5 rounded-2xl theme-bg-element border-2 theme-border outline-none focus:border-indigo-500/50 transition-all text-xl font-black theme-text-main"
                      >
                      <span class="absolute right-8 top-1/2 -translate-y-1/2 text-xl font-black theme-text-dim/50">%</span>
                    </div>
                  </div>
                  <div class="p-4 theme-bg-element rounded-xl space-y-1">
                    <p class="text-[10px] theme-text-dim font-bold">Instructor Earnings: <span class="theme-text-main font-black">{{ 100 - form.commission_rate }}%</span></p>
                    <div class="h-1 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                      <div class="h-full bg-emerald-500 transition-all duration-500" :style="{ width: `${100 - form.commission_rate}%` }"></div>
                    </div>
                  </div>
                </div>

                <!-- Status Card -->
                <div class="theme-bg-card border theme-border rounded-[2.5rem] p-8 shadow-xl space-y-6">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-black theme-text-main uppercase tracking-widest">Account Status</span>
                  </div>
                  <FormDropdown 
                    v-model="form.status"
                    :options="accountStatusOptions"
                    :error="errors.status"
                  />
                  <p class="text-[10px] theme-text-dim font-bold italic border-t theme-border pt-4">Set whether the instructor can start creating courses immediately.</p>
                </div>

                <!-- Feature Toggle -->
                <div class="theme-bg-card border theme-border rounded-[2.5rem] p-8 shadow-xl space-y-6">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <span class="text-[10px] font-black theme-text-main uppercase tracking-widest">Promotion</span>
                  </div>
                  
                  <div @click="form.is_featured = !form.is_featured" class="flex flex-col gap-4 p-5 theme-bg-element border-2 theme-border rounded-2xl cursor-pointer hover:border-amber-500/30 transition-all group relative overflow-hidden">
                    <div v-if="form.is_featured" class="absolute inset-0 bg-amber-500/5 animate-pulse"></div>
                    <div class="flex items-center justify-between relative z-10 w-full">
                      <div class="flex flex-col">
                        <span class="text-sm font-black theme-text-main uppercase tracking-widest">Featured Status</span>
                        <span class="text-[9px] theme-text-dim font-bold">Showcase on landing pages</span>
                      </div>
                      <div 
                        class="w-12 h-6 rounded-full p-1 transition-all duration-500 relative"
                        :class="form.is_featured ? 'bg-amber-500' : 'bg-slate-700/30'"
                      >
                        <div 
                          class="w-4 h-4 bg-white rounded-full transition-transform duration-500 shadow-sm"
                          :class="form.is_featured ? 'translate-x-6' : 'translate-x-0'"
                        ></div>
                      </div>
                    </div>
                  </div>
                  <p class="text-[9px] theme-text-dim font-bold leading-relaxed">Featured instructors receive 3.5x more engagement on average.</p>
                </div>
              </div>
            </div>

            <!-- Global Action Bar -->
            <div class="mt-12 flex items-center justify-between p-6 theme-bg-card border theme-border rounded-[2.5rem] shadow-2xl">
              <div class="flex items-center gap-6">
                <div class="hidden md:flex items-center gap-2 px-4 py-2 theme-bg-element rounded-full border theme-border">
                  <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                  <span class="text-[10px] font-black theme-text-main uppercase tracking-widest">System Ready</span>
                </div>
                <div class="text-[10px] theme-text-dim font-bold uppercase tracking-widest">Step {{ currentTabIndex + 1 }} of {{ tabs.length }}</div>
              </div>

              <div class="flex gap-4">
                <button 
                  v-if="currentTabIndex > 0"
                  type="button"
                  @click="activeTab = tabs[currentTabIndex - 1].id"
                  class="px-8 py-4 rounded-2xl theme-bg-element theme-text-main border theme-border font-black text-[10px] uppercase tracking-widest hover:theme-bg-card hover:border-indigo-500/50 transition-all"
                >
                  Previous
                </button>

                <button 
                  v-if="currentTabIndex < tabs.length - 1"
                  type="button"
                  @click="activeTab = tabs[currentTabIndex + 1].id"
                  class="px-10 py-4 rounded-2xl bg-indigo-600/10 theme-text-indigo font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-xl shadow-indigo-600/5 border border-indigo-500/20"
                >
                  <span>Next Phase</span>
                </button>

                <button 
                  v-else
                  type="submit"
                  :disabled="saving"
                  class="bg-indigo-600 hover:bg-indigo-500 text-white px-12 py-4 rounded-2xl font-black shadow-2xl shadow-indigo-600/40 active:scale-95 transition-all flex items-center justify-center gap-3 disabled:opacity-50 text-[10px] uppercase tracking-[0.2em]"
                >
                  <svg v-if="saving" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                  <span>Save & Register</span>
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { instructorService } from '../../../services/instructorService';
import FormDropdown from '../../../components/common/FormDropdown.vue';
import FormInput from '../../../components/common/FormInput.vue';
import ImageUploader from '../../../components/common/ImageUploader.vue';
import { useToast } from '../../../composables/useToast';

const router = useRouter();
const toast = useToast();
const saving = ref(false);
const errors = ref({});
const activeTab = ref('general');

const tabs = [
  { 
    id: 'general', 
    name: 'Base Identity', 
    subtitle: 'Step 01',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'
  },
  { 
    id: 'professional', 
    name: 'Professional', 
    subtitle: 'Step 02',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
  },
  { 
    id: 'accolades', 
    name: 'Accolades', 
    subtitle: 'Step 03',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'
  },
  { 
    id: 'social', 
    name: 'Footprint', 
    subtitle: 'Step 04',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9"/></svg>'
  },
  { 
    id: 'settings', 
    name: 'Settings', 
    subtitle: 'Step 05',
    icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
  }
];

const currentTabIndex = computed(() => tabs.findIndex(t => t.id === activeTab.value));

const accountStatusOptions = [
  { label: 'Pending Review', value: 'pending' },
  { label: 'Direct Approval', value: 'approved' },
  { label: 'Suspended', value: 'suspended' }
];

const form = reactive({
  name: '',
  email: '',
  phone: '',
  password: '',
  avatar: '',
  headline: '',
  short_bio: '',
  bio: '',
  expertise: '',
  website: '',
  linkedin: '',
  facebook: '',
  twitter: '',
  youtube: '',
  github: '',
  commission_rate: 70,
  status: 'pending',
  is_featured: false,
  certifications: [],
  achievements: []
});

const socialInputs = [
  { id: 'website', label: 'Portfolio Website', placeholder: 'https://...', icon: 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9' },
  { id: 'linkedin', label: 'LinkedIn Profile', placeholder: 'https://linkedin.com/in/...', icon: 'M7 8H3v10h4V8zm0-3c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zm14 8v7h-4v-7c0-1.1-.9-2-2-2s-2 .9-2 2v7h-4V8h4v1.24c.48-.73 1.38-1.24 2.5-1.24 2.21 0 4 1.79 4 4z' },
  { id: 'facebook', label: 'Facebook Page', placeholder: 'https://facebook.com/...', icon: 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z' },
  { id: 'twitter', label: 'Twitter (X) handle', placeholder: 'https://twitter.com/...', icon: 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z' },
  { id: 'youtube', label: 'YouTube Channel', placeholder: 'https://youtube.com/...', icon: 'M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 00-1.94 2C1 8.14 1 12 1 12s0 3.86.46 5.58a2.78 2.78 0 001.94 2c1.72.42 8.6.42 8.6.42s6.88 0 8.6-.42a2.78 2.78 0 001.94-2C23 15.86 23 12 23 12s0-3.86-.46-5.58zM9.75 15.02V8.98L15.3 12l-5.55 3.02z' },
  { id: 'github', label: 'GitHub Repository', placeholder: 'https://github.com/...', icon: 'M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12' },
];

const filledPercentage = computed(() => {
  const fields = ['name', 'email', 'phone', 'password', 'avatar', 'headline', 'bio', 'expertise'];
  const filled = fields.filter(f => !!form[f]).length;
  return Math.round((filled / fields.length) * 100);
});

const addCertification = () => {
  form.certifications.push({ name: '', issuer: '' });
};

const removeCertification = (index) => {
  form.certifications.splice(index, 1);
};

const addAchievement = () => {
  form.achievements.push('');
};

const removeAchievement = (index) => {
  form.achievements.splice(index, 1);
};

const saveInstructor = async () => {
  saving.value = true;
  errors.value = {};
  try {
    await instructorService.store(form);
    toast.success('Instructor successfully deployed to registry');
    router.push({ name: 'instructors' });
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
      toast.error('Component validation failed. See diagnostics.');
      
      // Auto-focus logic for UX
      if (errors.value.name || errors.value.email || errors.value.phone || errors.value.password) activeTab.value = 'general';
      else if (errors.value.headline || errors.value.bio || errors.value.expertise) activeTab.value = 'professional';
    } else {
      toast.error('Critical system error during deployment');
    }
  } finally {
    saving.value = false;
  }
};
</script>

<style scoped>
.theme-text-indigo { color: #6366f1; }

.animate-float {
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

.active-step {
  animation: pulse-ring 2s infinite;
}

@keyframes pulse-ring {
  0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
  70% { box-shadow: 0 0 0 15px rgba(99, 102, 241, 0); }
  100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
}

.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
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
