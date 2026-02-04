<template>
  <div class="min-h-screen theme-bg-main transition-colors duration-500 selection:bg-indigo-500/30">
    <!-- Modular Navbar -->
    <Navbar 
      :is-scrolled="isScrolled" 
      :nav-items="navItems"
      @toggle-mobile-menu="isMobileMenuOpen = !isMobileMenuOpen"
    />

    <!-- Premium Mobile Menu Overlay -->
    <transition 
      enter-active-class="transition duration-500 ease-out"
      enter-from-class="opacity-0 -translate-y-full"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-400 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-full"
    >
      <div v-if="isMobileMenuOpen" class="fixed inset-0 z-[105] theme-bg-main lg:hidden pt-32 pb-10 px-10 flex flex-col justify-between h-screen">
          <div class="flex flex-col gap-8">
              <router-link 
                  v-for="item in mobileNavItems" 
                  :key="item.name" 
                  :to="item.path"
                  @click="isMobileMenuOpen = false"
                  class="text-6xl font-black theme-text-main tracking-tighter hover:text-indigo-600 transition-colors"
              >
                  {{ item.name }}
              </router-link>
          </div>
          
          <div class="flex flex-col gap-4 pt-10 border-t theme-border">
              <router-link to="/login" @click="isMobileMenuOpen = false" class="text-sm font-black theme-text-main uppercase tracking-[0.2em] py-6 border theme-border rounded-2xl text-center">Identity Access / Login</router-link>
              <router-link to="/pricing" @click="isMobileMenuOpen = false" class="text-sm font-black text-white bg-indigo-600 uppercase tracking-[0.2em] py-6 rounded-2xl text-center shadow-xl shadow-indigo-600/20">View Subscription Plans</router-link>
          </div>
      </div>
    </transition>

    <!-- Content Area -->
    <main>
        <router-view v-slot="{ Component }">
            <transition name="page-fade" mode="out-in">
                <component :is="Component" />
            </transition>
        </router-view>
    </main>

    <!-- Modular Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Navbar from '../../components/frontend/layout/Navbar.vue';
import Footer from '../../components/frontend/layout/Footer.vue';

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const navItems = [
  { name: 'Academy', path: '/courses' },
  { name: 'Blog', path: '/blog' },
  { name: 'Mentors', path: '/instructors' },
];

const mobileNavItems = [
  ...navItems,
  { name: 'Pricing', path: '#' },
];

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.page-fade-enter-active, .page-fade-leave-active {
  transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.page-fade-enter-from { opacity: 0; transform: scale(0.99); }
.page-fade-leave-to { opacity: 0; transform: scale(1.01); }
</style>
