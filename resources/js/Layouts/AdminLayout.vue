<template>
  <div class="min-h-screen bg-slate-950 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 border-r border-slate-800 flex-shrink-0 hidden md:flex flex-col">
      <!-- Brand -->
      <div class="px-6 py-5 border-b border-slate-800">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-[var(--accent-primary)] flex items-center justify-center">
            <span class="material-symbols-outlined text-white text-xl">person</span>
          </div>
          <div>
            <p class="text-white font-bold text-sm leading-none">Admin Panel</p>
            <p class="text-slate-500 text-xs mt-0.5">Portofolio</p>
          </div>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-3 py-4 space-y-1">
        <Link
          v-for="nav in navItems"
          :key="nav.path"
          :href="nav.path"
          :class="[
            'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all',
            isActive(nav.path)
              ? 'bg-[var(--accent-primary)] text-white shadow-lg shadow-[var(--accent-primary)]/20'
              : 'text-slate-400 hover:text-white hover:bg-slate-800'
          ]"
        >
          <span class="material-symbols-outlined text-xl">{{ nav.icon }}</span>
          {{ nav.label }}
        </Link>
      </nav>

      <!-- Footer -->
      <div class="px-3 py-4 border-t border-slate-800 space-y-1">
        <Link
          href="/"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800 transition-all"
        >
          <span class="material-symbols-outlined text-xl">open_in_new</span>
          View Portfolio
        </Link>
        <Link
          href="/logout"
          method="post"
          as="button"
          class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:text-red-400 hover:bg-red-900/20 transition-all text-left"
        >
          <span class="material-symbols-outlined text-xl">logout</span>
          Logout
        </Link>
      </div>
    </aside>

    <!-- Mobile top bar -->
    <div class="md:hidden fixed top-0 left-0 right-0 z-50 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-4 h-14">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[var(--accent-primary)] flex items-center justify-center">
          <span class="material-symbols-outlined text-white text-base">person</span>
        </div>
        <span class="text-white font-bold text-sm">Admin</span>
      </div>
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-400 hover:text-white">
        <span class="material-symbols-outlined">menu</span>
      </button>
    </div>

    <!-- Mobile menu -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="mobileMenuOpen" class="md:hidden fixed top-14 left-0 right-0 z-40 bg-slate-900 border-b border-slate-800 px-3 py-3 space-y-1">
        <Link
          v-for="nav in navItems"
          :key="nav.path"
          :href="nav.path"
          @click="mobileMenuOpen = false"
          :class="[
            'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all',
            isActive(nav.path)
              ? 'bg-[var(--accent-primary)] text-white'
              : 'text-slate-400 hover:text-white hover:bg-slate-800'
          ]"
        >
          <span class="material-symbols-outlined text-xl">{{ nav.icon }}</span>
          {{ nav.label }}
        </Link>
      </div>
    </Transition>

    <!-- Main content -->
    <main class="flex-1 overflow-auto pt-14 md:pt-0">
      <slot />
    </main>

    <!-- Premium Toast notification -->
    <Toast />
  </div>
</template>

<script setup>
import { ref, watch, provide } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';

const mobileMenuOpen = ref(false);
const page = usePage();

const navItems = [
  { path: '/admin/projects', label: 'Projects', icon: 'folder_open' },
  { path: '/admin/skills',   label: 'Skills',   icon: 'code' },
  { path: '/admin/certificates', label: 'Certificates', icon: 'workspace_premium' },
  { path: '/admin/settings', label: 'Global Settings', icon: 'settings' },
];

const isActive = (path) => {
  return page.url.startsWith(path);
};

// Legacy provide if child pages use it
const showToast = (message, type = 'success') => {
    // This is handled automatically by the Toast component via Inertia Flash
    // but we can manually trigger if needed by updating flash props locally or just leave it
};
provide('showToast', showToast);
</script>
