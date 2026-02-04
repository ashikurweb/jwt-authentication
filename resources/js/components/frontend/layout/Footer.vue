<template>
  <footer class="theme-bg-card border-t theme-border pt-40 pb-20 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-linear-to-r from-transparent via-indigo-500/50 to-transparent"></div>
    
    <div class="max-w-[1600px] mx-auto px-8 md:px-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-20 mb-32">
        <div class="space-y-8">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
              <span class="text-white font-black text-lg">N</span>
            </div>
            <span class="text-2xl font-black theme-text-main tracking-tighter uppercase italic">Nexus<span class="text-indigo-600 not-italic">LMS</span></span>
          </div>
          <p class="theme-text-dim text-lg font-medium leading-relaxed max-w-sm">
            Engineering the next generation of technical minds through elite mentorship and complex systems training.
          </p>
        </div>
        
        <div v-for="group in footerLinks" :key="group.title">
          <h4 class="text-[10px] font-black theme-text-main uppercase tracking-[0.4em] mb-10">{{ group.title }}</h4>
          <ul class="space-y-5">
            <li v-for="link in group.links" :key="link">
              <a href="#" class="theme-text-dim hover:text-indigo-600 font-bold transition-all text-sm block">
                {{ link }}
              </a>
            </li>
          </ul>
        </div>
      </div>
      
      <div class="pt-12 border-t theme-border flex flex-col md:flex-row justify-between items-center gap-8 text-[10px] font-black theme-text-dim uppercase tracking-[0.3em]">
          <p>© 2026 NEXUS TECHNICAL SYSTEMS • ALL RIGHTS RESERVED</p>
          <div class="flex gap-12">
              <a href="#" class="hover:theme-text-main transition-colors">Privacy Policy</a>
              <a href="#" class="hover:theme-text-main transition-colors">Terms of Service</a>
              <a href="#" class="hover:theme-text-main transition-colors">Security Schema</a>
          </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
const footerLinks = [
  { title: 'The Academy', links: ['Cloud Engineering', 'System Logic', 'Cyber Security', 'AI Analytics'] },
  { title: 'Nexus Intel', links: ['About the Mission', 'Technical Blog', 'Research Papers', 'Careers'] },
  { title: 'Support Grid', links: ['Common Questions', 'Help Center', 'API Docs', 'Status Hub'] }
];
</script>
