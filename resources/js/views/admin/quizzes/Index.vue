<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black theme-text-main tracking-tight">Interactive Quizzes</h1>
        <p class="text-sm theme-text-muted mt-1 font-medium">Create and manage assessments to validate student learning.</p>
      </div>
      <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/20 active:scale-95 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Create Quiz</span>
      </button>
    </div>

    <!-- Quiz Lists -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div v-for="quiz in quizzes" :key="quiz.id" 
           class="group theme-bg-card border theme-border rounded-[2.5rem] p-8 hover:border-indigo-500/30 transition-all shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-indigo-500/10 transition-colors"></div>
        
        <div class="relative z-10 space-y-6">
          <div class="flex items-center justify-between">
            <div class="w-14 h-14 rounded-2xl theme-bg-element flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-right">
                <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest">Questions</p>
                <p class="text-xl font-black theme-text-main">{{ quiz.questions }}</p>
            </div>
          </div>

          <div>
            <h3 class="text-xl font-bold theme-text-main group-hover:text-indigo-600 transition-colors mb-2">{{ quiz.title }}</h3>
            <p class="text-sm theme-text-dim font-medium leading-relaxed">{{ quiz.description }}</p>
          </div>

          <div class="flex items-center gap-6 py-4 border-y theme-border">
            <div>
                <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest mb-1">Duration</p>
                <p class="text-xs font-bold theme-text-main">{{ quiz.duration }} mins</p>
            </div>
            <div>
                <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest mb-1">Pass Score</p>
                <p class="text-xs font-bold theme-text-main">{{ quiz.passScore }}%</p>
            </div>
             <div>
                <p class="text-[10px] theme-text-dim font-black uppercase tracking-widest mb-1">Difficulty</p>
                <p class="text-xs font-bold theme-text-main uppercase tracking-widest text-indigo-500">{{ quiz.difficulty }}</p>
            </div>
          </div>

          <div class="flex items-center justify-between pt-2">
            <span class="text-[11px] font-black theme-text-muted uppercase tracking-widest">{{ quiz.attempts }} Attempts</span>
            <button class="px-6 py-2.5 theme-bg-element hover:theme-bg-hover theme-text-main text-xs font-black uppercase tracking-widest rounded-xl transition-all border theme-border">Edit Quiz</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const quizzes = [
  { id: 1, title: 'Javascript Core Concepts', description: 'Test your knowledge on closures, prototypes, and async/await behavior in modern JS.', questions: 20, duration: 30, passScore: 80, difficulty: 'Intermediate', attempts: 1240 },
  { id: 2, title: 'PHP 8.x Advanced Features', description: 'Assess mastery of attributes, JIT, named arguments, and match expressions.', questions: 15, duration: 25, passScore: 75, difficulty: 'Advanced', attempts: 850 }
];
</script>
