<template>
  <div class="min-h-screen bg-slate-950 flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
      <!-- Brand -->
      <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-3xl bg-[var(--accent-primary)] flex items-center justify-center mx-auto mb-4 shadow-2xl shadow-[var(--accent-primary)]/30">
          <span class="material-symbols-outlined text-white text-3xl">lock</span>
        </div>
        <h1 class="text-2xl font-bold text-white">Admin Login</h1>
        <p class="text-slate-500 text-sm mt-1">Portfolio Management Panel</p>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleLogin" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 space-y-4">
        <!-- Error alert -->
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 -translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
        >
          <div v-if="form.errors.email || form.errors.password" class="flex items-center gap-2 p-3 rounded-xl bg-red-900/30 border border-red-800 text-red-400 text-sm">
            <span class="material-symbols-outlined text-base">error</span>
            {{ form.errors.email || form.errors.password }}
          </div>
        </Transition>

        <div class="space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Email</label>
          <input
            v-model="form.email"
            type="email"
            required
            placeholder="admin@example.com"
            class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] focus:ring-2 focus:ring-[var(--accent-primary)]/20 transition-all text-sm"
          />
        </div>

        <div class="space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Password</label>
          <div class="relative">
            <input
              v-model="form.password"
              :type="showPass ? 'text' : 'password'"
              required
              placeholder="••••••••"
              class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] focus:ring-2 focus:ring-[var(--accent-primary)]/20 transition-all text-sm"
            />
            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
              <span class="material-symbols-outlined text-xl">{{ showPass ? 'visibility_off' : 'visibility' }}</span>
            </button>
          </div>
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full py-3.5 rounded-xl bg-[var(--accent-primary)] text-white font-bold text-sm hover:opacity-90 active:scale-[0.98] transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
        >
          <span v-if="form.processing" class="animate-spin material-symbols-outlined text-xl">progress_activity</span>
          <span>{{ form.processing ? 'Logging in...' : 'Login' }}</span>
        </button>
      </form>
    </div>

    <!-- Premium Toast notification -->
    <Toast />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';

const form = useForm({
  email: '',
  password: ''
});

const showPass = ref(false);

const handleLogin = () => {
  form.post('/admin/login', {
    preserveScroll: true,
    onError: (errors) => {
        const firstError = Object.values(errors)[0];
        if (firstError) {
            window.dispatchEvent(new CustomEvent('show-toast', { 
                detail: { message: firstError, type: 'error' } 
            }));
        }
    }
  });
};

// Add a watch to trigger the toast manually for form errors
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
watch(() => form.errors, (newErrors) => {
    if (Object.keys(newErrors).length > 0) {
        // The Toast component will already be watching page.props.errors
        // But we ensure the page state is updated
    }
}, { deep: true });
</script>
