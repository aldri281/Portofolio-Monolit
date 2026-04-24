<script setup>
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success');

const hideToast = () => {
    show.value = false;
};

const triggerToast = (msg, toastType) => {
    message.value = msg;
    type.value = toastType;
    show.value = true;
    
    setTimeout(() => {
        hideToast();
    }, 5000);
};

// Watch for flash messages from Inertia
watch(() => page.props.flash?.success, (msg) => {
    if (msg) triggerToast(msg, 'success');
}, { immediate: true });

watch(() => page.props.flash?.error, (msg) => {
    if (msg) triggerToast(msg, 'error');
}, { immediate: true });

watch(() => page.props.errors, (errs) => {
    if (errs && Object.keys(errs).length > 0) {
        // Take the first error message to display in the toast
        const firstError = Object.values(errs)[0];
        triggerToast(firstError, 'error');
    }
}, { deep: true, immediate: true });

onMounted(() => {
    window.addEventListener('show-toast', (e) => {
        triggerToast(e.detail.message, e.detail.type);
    });
});
</script>

<template>
    <Transition name="toast">
        <div v-if="show" 
             class="fixed top-6 right-6 z-[9999] flex items-center p-4 min-w-[300px] max-w-md rounded-2xl border backdrop-blur-xl shadow-2xl overflow-hidden"
             :class="type === 'success' 
                ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' 
                : 'bg-rose-500/10 border-rose-500/20 text-rose-400'">
            
            <!-- Glass Background Shine -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>

            <!-- Icon -->
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 mr-4 border border-white/10">
                <svg v-if="type === 'success'" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <svg v-else class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Content -->
            <div class="flex-1 mr-4">
                <p class="text-sm font-semibold tracking-wide uppercase opacity-60 mb-0.5">
                    {{ type === 'success' ? 'Success' : 'Attention' }}
                </p>
                <p class="text-sm text-white/90 leading-relaxed font-medium">
                    {{ message }}
                </p>
            </div>

            <!-- Close Button -->
            <button @click="hideToast" class="flex-shrink-0 hover:bg-white/10 p-1.5 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Progress Bar Animation -->
            <div class="absolute bottom-0 left-0 h-1 bg-current opacity-20 animate-toast-progress"></div>
        </div>
    </Transition>
</template>

<style scoped>
.toast-enter-active {
    animation: toast-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.toast-leave-active {
    animation: toast-in 0.4s cubic-bezier(0.6, -0.28, 0.735, 0.045) reverse;
}

@keyframes toast-in {
    0% { transform: translateX(100%) scale(0.9); opacity: 0; }
    100% { transform: translateX(0) scale(1); opacity: 1; }
}

@keyframes toast-progress {
    0% { width: 100%; }
    100% { width: 0%; }
}

.animate-toast-progress {
    animation: toast-progress 5s linear forwards;
}
</style>
