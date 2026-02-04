<template>
  <div class="relative min-h-screen">
    <!-- Home Hero (Header logic included in layout) -->
    <HomeHero />

    <!-- Home Stats -->
    <HomeStats />

    <!-- Course Category Section -->
    <HomeCategories />

    <!-- Course Module Card Section -->
    <HomeCourses />

    <!-- Instructor List Section -->
    <HomeInstructors />

    <!-- Blog Section Highlights -->
    <HomeBlog />

    <!-- Final CTA -->
    <HomeCTA />
  </div>
</template>

<script setup>
import HomeHero from '../../../components/frontend/home/HomeHero.vue';
import HomeStats from '../../../components/frontend/home/HomeStats.vue';
import HomeCategories from '../../../components/frontend/home/HomeCategories.vue';
import HomeCourses from '../../../components/frontend/home/HomeCourses.vue';
import HomeInstructors from '../../../components/frontend/home/HomeInstructors.vue';
import HomeBlog from '../../../components/frontend/home/HomeBlog.vue';
import HomeCTA from '../../../components/frontend/home/HomeCTA.vue';
</script>
