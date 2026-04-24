<template>
  <section class="py-24 scroll-mt-32" id="certificates">
    <div class="text-center max-w-3xl mx-auto space-y-6 mb-24">
      <h2 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight">{{ settings?.section_certificates_title || 'Certificates & Training' }}</h2>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 font-light">{{ settings?.section_certificates_subtitle || 'Continuous learning and professional development achievements.' }}</p>
    </div>

    <!-- Fallback/Loading State -->
    <div v-if="pending" class="text-center py-10 text-slate-500">
      Loading certificates...
    </div>

    <div v-else-if="error" class="text-center py-10 text-red-500">
      Failed to load certificates. Please try again later.
    </div>

    <div v-else class="space-y-6">
      <div 
        v-for="(cert, index) in certificates" 
        :key="cert.id"
        class="group relative bg-white dark:bg-slate-900/50 soft-radius p-8 border border-slate-100 dark:border-slate-800 hover:border-accent-secondary/50 dark:hover:border-accent-secondary/50 transition-all duration-300 overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6"
      >
        <!-- Background Gradient Hover Effect -->
        <div class="absolute inset-0 opacity-0 group-hover:opacity-10 dark:group-hover:opacity-5 bg-gradient-to-r from-accent-primary/20 via-transparent to-accent-secondary/20 transition-opacity duration-500 pointer-events-none"></div>

        <div class="flex items-start gap-6 relative z-10 w-full md:w-auto">
          <div class="w-12 h-12 shrink-0 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center text-accent-secondary transition-colors duration-300">
             <span class="material-symbols-outlined text-2xl">workspace_premium</span>
          </div>
          <div class="space-y-2">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white transition-colors duration-300 group-hover:text-accent-secondary">
              {{ cert.name }}
            </h3>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-slate-600 dark:text-slate-400 text-sm font-medium">
              <span class="flex items-center gap-1.5 border border-slate-100 dark:border-slate-800 px-3 py-1 rounded-lg bg-slate-50 dark:bg-slate-800/50 transition-colors duration-300">
                <span class="material-symbols-outlined text-[16px]">apartment</span>
                {{ cert.organizer }}
              </span>
              <span class="flex items-center gap-1.5 border border-slate-100 dark:border-slate-800 px-3 py-1 rounded-lg bg-slate-50 dark:bg-slate-800/50 transition-colors duration-300">
                <span class="material-symbols-outlined text-[16px]">schedule</span>
                {{ cert.duration }}
              </span>
            </div>
          </div>
        </div>
        
        <a 
          v-if="cert.link"
          :href="cert.link" 
          target="_blank" 
          rel="noopener noreferrer"
          class="relative z-10 w-full md:w-auto shrink-0 px-6 py-3.5 bg-slate-50 hover:bg-accent-secondary dark:bg-slate-800 dark:hover:bg-accent-secondary text-slate-600 dark:text-slate-300 hover:text-white dark:hover:text-white border border-slate-200 dark:border-slate-700 hover:border-transparent dark:hover:border-transparent rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-sm hover:shadow-lg hover:shadow-accent-secondary/20 shadow-slate-200/50 dark:shadow-slate-900/50"
        >
          <span>View Certificate</span>
          <span class="material-symbols-outlined text-lg">open_in_new</span>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const settings = computed(() => page.props.settings || {});
const pending = false;
const error = null;

const certificates = computed(() => page.props.certificates || []);
</script>
