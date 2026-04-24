<template>
  <div>
    <div class="fixed inset-0 pointer-events-none bg-grid z-0"></div>
    
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-b border-slate-50 dark:border-slate-800 transition-colors duration-300">
      <div class="max-w-7xl mx-auto px-6 md:px-12 h-16 md:h-20 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-3">
          <span class="material-symbols-outlined text-accent-secondary text-2xl">account_tree</span>
          <span class="font-bold text-xl tracking-tight text-slate-900 dark:text-white" v-html="settings?.site_logo_text || 'Aldri<span class=\'text-accent-primary\'>.</span>'"></span>
        </div>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-10 text-[15px] font-medium text-slate-500 dark:text-slate-400">
          <a class="relative pb-1 hover:text-slate-900 dark:hover:text-white transition-colors" :class="{ 'text-slate-900 dark:text-white font-semibold': activeSection === 'about' }" href="#about">
            About
            <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-accent-primary to-accent-secondary transition-all duration-300 rounded-full" :class="activeSection === 'about' ? 'w-full opacity-100' : 'w-0 opacity-0'"></span>
          </a>
          <a class="relative pb-1 hover:text-slate-900 dark:hover:text-white transition-colors" :class="{ 'text-slate-900 dark:text-white font-semibold': activeSection === 'projects' }" href="#projects">
            Case Studies
            <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-accent-primary to-accent-secondary transition-all duration-300 rounded-full" :class="activeSection === 'projects' ? 'w-full opacity-100' : 'w-0 opacity-0'"></span>
          </a>
          <a class="relative pb-1 hover:text-slate-900 dark:hover:text-white transition-colors" :class="{ 'text-slate-900 dark:text-white font-semibold': activeSection === 'skills' }" href="#skills">
            Toolbox
            <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-accent-primary to-accent-secondary transition-all duration-300 rounded-full" :class="activeSection === 'skills' ? 'w-full opacity-100' : 'w-0 opacity-0'"></span>
          </a>
          <a class="relative pb-1 hover:text-slate-900 dark:hover:text-white transition-colors" :class="{ 'text-slate-900 dark:text-white font-semibold': activeSection === 'certificates' }" href="#certificates">
            Certificates
            <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-accent-primary to-accent-secondary transition-all duration-300 rounded-full" :class="activeSection === 'certificates' ? 'w-full opacity-100' : 'w-0 opacity-0'"></span>
          </a>
          <button @click="toggleColorMode" class="w-12 h-12 rounded-full flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
            <span class="material-symbols-outlined">{{ colorMode === 'dark' ? 'light_mode' : 'dark_mode' }}</span>
          </button>
        </div>

        <!-- Mobile: Dark mode + Hamburger -->
        <div class="flex md:hidden items-center gap-2">
          <button @click="toggleColorMode" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
            <span class="material-symbols-outlined text-xl">{{ colorMode === 'dark' ? 'light_mode' : 'dark_mode' }}</span>
          </button>
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" aria-label="Toggle menu">
            <span class="material-symbols-outlined text-xl">{{ mobileMenuOpen ? 'close' : 'menu' }}</span>
          </button>
        </div>
      </div>

      <!-- Mobile Dropdown Menu -->
      <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-2">
        <div v-if="mobileMenuOpen" class="md:hidden border-t border-slate-100 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl px-4 py-4 flex flex-col gap-1">
          <a v-for="item in navItems" :key="item.href" :href="item.href" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 font-medium transition-colors" :class="{ 'bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-semibold': activeSection === item.section }">
            <span class="material-symbols-outlined text-lg text-accent-primary">{{ item.icon }}</span>
            {{ item.label }}
          </a>
        </div>
      </Transition>
    </nav>
    
    <!-- Main Content -->
    <main class="relative z-10 pt-24 md:pt-28 pb-40 px-4 md:px-8 max-w-7xl mx-auto">
      <slot />
    </main>
    
    <!-- Footer -->
    <footer class="border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 transition-colors duration-300 relative z-10 mt-32">
      <div class="max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-16 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-10 text-center md:text-left">
        <div class="flex items-center gap-3">
          <span class="material-symbols-outlined text-accent-secondary text-2xl">account_tree</span>
          <span class="font-bold text-xl text-slate-900 dark:text-white">{{ settings?.site_footer_name || 'Aldri Hardiansyah' }}</span>
        </div>
        <p class="text-slate-400 dark:text-slate-500 text-sm font-light tracking-wide">© {{ new Date().getFullYear() }} {{ settings?.site_footer_name || 'Aldri Hardiansyah' }}. {{ settings?.site_footer_copyright || 'Data Engineer Portfolio.' }}</p>
        <div class="flex items-center gap-6">
          <a class="text-slate-400 dark:text-slate-500 hover:text-accent-primary transition-colors" :href="settings?.social_email || '#'">
            <span class="material-symbols-outlined">mail</span>
          </a>
          <a class="text-slate-400 dark:text-slate-500 hover:text-accent-secondary transition-colors" :href="settings?.social_link || '#'">
            <span class="material-symbols-outlined">link</span>
          </a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Access globabl settings passed from Laravel
const page = usePage();
const settings = computed(() => page.props.settings || {});

const colorMode = ref('light');
const activeSection = ref('');
const mobileMenuOpen = ref(false);
let observer = null;

const navItems = [
  { href: '#about', section: 'about', label: 'About', icon: 'person' },
  { href: '#projects', section: 'projects', label: 'Case Studies', icon: 'folder_open' },
  { href: '#skills', section: 'skills', label: 'Toolbox', icon: 'build' },
  { href: '#certificates', section: 'certificates', label: 'Certificates', icon: 'workspace_premium' },
];

const toggleColorMode = () => {
  colorMode.value = colorMode.value === 'dark' ? 'light' : 'dark';
  if (colorMode.value === 'dark') {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};

onMounted(() => {
  // Init color mode
  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    colorMode.value = 'dark';
    document.documentElement.classList.add('dark');
  } else {
    colorMode.value = 'light';
    document.documentElement.classList.remove('dark');
  }

  observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        activeSection.value = entry.target.id;
      }
    });
  }, { rootMargin: '-20% 0px -80% 0px' });

  setTimeout(() => {
    const sections = document.querySelectorAll('section[id]');
    sections.forEach((section) => observer?.observe(section));
  }, 100);
});

onUnmounted(() => {
  observer?.disconnect();
});
</script>
