<template>
  <div class="min-h-screen flex items-center justify-center p-6 theme-bg-main relative overflow-hidden selection:bg-indigo-500/30">
    <!-- Abstract Background Decor -->
    <div class="absolute inset-0 opacity-20 bg-grid-white/[0.05] [mask-image:radial-gradient(white,transparent_70%)]"></div>
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-violet-600/20 blur-[120px] rounded-full"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="reveal-up opacity-0 text-center space-y-6 mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-indigo-600/20 text-indigo-500 mb-4 border border-indigo-500/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h1 class="text-4xl font-black theme-text-main tracking-tighter">Verify Identity</h1>
            <p class="theme-text-dim font-medium max-w-xs mx-auto">
                We've transmitted a 6-digit cryptographic code to <span class="text-indigo-500 font-bold">{{ email }}</span>.
            </p>
        </div>

        <form @submit.prevent="handleVerify" class="reveal-up opacity-0 space-y-8">
            <!-- OTP Input Group -->
            <div class="flex justify-between gap-2 md:gap-4">
                <input 
                    v-for="(digit, index) in 6" 
                    :key="index"
                    :id="'otp-' + index"
                    v-model="otpDigits[index]"
                    type="text"
                    maxlength="1"
                    class="w-12 h-16 md:w-14 md:h-20 text-center text-2xl font-black theme-bg-element border-2 theme-border rounded-2xl focus:border-indigo-500 focus:ring-0 transition-all outline-none theme-text-main"
                    @input="handleInput($event, index)"
                    @keydown.backspace="handleBackspace($event, index)"
                    @paste="handlePaste"
                    required
                >
            </div>

            <!-- Alert Message -->
            <transition name="fade">
                <div v-if="error" class="p-5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500 text-xs font-bold flex gap-4">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ error }}
                </div>
            </transition>

            <button 
                type="submit" 
                :disabled="loading || !isComplete"
                class="w-full py-6 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-indigo-600/30 active:scale-[0.98] transition-all flex items-center justify-center gap-4 disabled:opacity-50 disabled:cursor-not-allowed group"
            >
                <span v-if="!loading">Verify Protocol</span>
                <span v-else class="animate-pulse">Validating OTP...</span>
                <svg v-if="!loading" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 8l5 5-5 5M6 8l5 5-5 5"/></svg>
            </button>

            <div class="text-center space-y-4">
                <p class="text-sm theme-text-dim font-medium">
                    Didn't receive the transmission?
                </p>
                <button 
                    type="button" 
                    @click="handleResend" 
                    :disabled="resendLoading || resendTimer > 0"
                    class="text-indigo-500 hover:text-indigo-400 font-black uppercase tracking-widest text-[10px] disabled:opacity-50 transition-all"
                >
                    {{ resendTimer > 0 ? `Resend available in ${resendTimer}s` : 'Request New Code' }}
                </button>
            </div>
        </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuth } from '../../../composables/useAuth';
import gsap from 'gsap';

const router = useRouter();
const route = useRoute();
const { verifyEmail, resendOtp, loading, error } = useAuth();

const email = ref(route.query.email || 'your email');
const otpDigits = reactive(Array(6).fill(''));
const resendLoading = ref(false);
const resendTimer = ref(0);

const isComplete = computed(() => otpDigits.every(d => d !== ''));

const handleInput = (e, index) => {
    const val = e.target.value;
    if (val && index < 5) {
        document.getElementById(`otp-${index + 1}`).focus();
    }
};

const handleBackspace = (e, index) => {
    if (!otpDigits[index] && index > 0) {
        document.getElementById(`otp-${index - 1}`).focus();
    }
};

const handlePaste = (e) => {
    const paste = e.clipboardData.getData('text');
    if (paste.length === 6 && /^\d+$/.test(paste)) {
        paste.split('').forEach((char, i) => otpDigits[i] = char);
    }
};

const handleVerify = async () => {
    try {
        const otp = otpDigits.join('');
        await verifyEmail({ otp });
        router.push({ name: 'dashboard' });
    } catch (err) {
        console.error('Verification failed', err);
    }
};

const handleResend = async () => {
    resendLoading.value = true;
    try {
        await resendOtp();
        resendTimer.value = 60;
        const interval = setInterval(() => {
            resendTimer.value--;
            if (resendTimer.value <= 0) clearInterval(interval);
        }, 1000);
    } finally {
        resendLoading.value = false;
    }
};

onMounted(() => {
    gsap.to(".reveal-up", {
        y: 0,
        opacity: 1,
        duration: 1.2,
        stagger: 0.15,
        ease: "power4.out",
        delay: 0.3
    });
    
    // Focus first input
    document.getElementById('otp-0')?.focus();
});
</script>

<style scoped>
.reveal-up { transform: translateY(30px); }
.fade-enter-active, .fade-leave-active { transition: opacity 0.5s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
