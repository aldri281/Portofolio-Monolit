<template>
  <section class="min-h-[75vh] flex flex-col md:flex-row items-center justify-between gap-12 md:gap-24 pb-16 md:pb-24 scroll-mt-32" id="about">
    <div class="flex-1 space-y-10">
      <div class="inline-flex items-center gap-3 px-5 py-2.5 soft-radius glass-chip dark:bg-slate-900/50 text-sm font-mono text-slate-800 dark:text-slate-200 border border-slate-100 dark:border-slate-800 transition-colors duration-300">
        <span class="w-2.5 h-2.5 rounded-full bg-accent-primary animate-pulse"></span>
        {{ settings?.hero_badge || 'Forestry to Data Engineering' }}
      </div>
      <h1 class="text-4xl sm:text-5xl md:text-[5.5rem] font-extrabold tracking-tight leading-[1.05] text-slate-900 dark:text-white" v-html="settings?.hero_title || 'Architecting <br/><span class=\'gradient-text\'>Complex Data</span> <br/>Systems'">
      </h1>
      <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl leading-[1.7] font-light">
        {{ profile?.bio || 'Data Engineer with a Forestry Engineering background, bringing systematic precision to data processing. Specializing in Data Warehouse construction, PostgreSQL optimization, and provincial-scale education data analysis.' }}
      </p>
      <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4 w-full sm:w-auto">
        <a class="px-8 py-4 md:px-10 md:py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 button-radius font-semibold hover:scale-105 transition-all shadow-xl shadow-slate-200 dark:shadow-black/50 text-center" href="#projects">
          View Case Studies
        </a>
        <a 
          v-if="profile?.resume_url"
          class="px-8 py-4 md:px-10 md:py-5 bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 button-radius font-semibold hover:border-accent-secondary dark:hover:border-accent-secondary hover:text-accent-secondary dark:hover:text-accent-secondary transition-all text-center" 
          :href="profile.resume_url"
          target="_blank"
        >
          Download Resume
        </a>
      </div>
    </div>
    
    <!-- Code-Based Data Engineering Visualization -->
    <div class="hidden md:block flex-1 relative w-full max-w-xs sm:max-w-sm md:max-w-lg mx-auto md:mx-0 group">
      <!-- Glow Effect -->
      <div class="absolute -inset-10 bg-gradient-to-r from-accent-primary/15 via-accent-tertiary/10 to-accent-secondary/15 blur-3xl opacity-50 rounded-full animate-pulse"></div>
      
      <!-- Tilted backdrop -->
      <div class="absolute inset-0 bg-gradient-to-tr from-accent-secondary/8 to-accent-tertiary/8 soft-radius transform rotate-2 border border-white/30 dark:border-white/5 transition-all duration-700 group-hover:rotate-4"></div>
      
      <!-- Main Card -->
      <div class="relative bg-white dark:bg-[#0c1222] soft-radius shadow-2xl shadow-slate-200/50 dark:shadow-black/60 border border-slate-100 dark:border-slate-800/60 overflow-hidden transition-all duration-500">
        <div class="p-6 space-y-4">

          <!-- Card Header: Terminal Bar -->
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="w-3 h-3 rounded-full bg-red-400/80"></span>
              <span class="w-3 h-3 rounded-full bg-yellow-400/80"></span>
              <span class="w-3 h-3 rounded-full bg-green-400/80"></span>
            </div>
            <span class="text-[10px] font-mono tracking-widest uppercase text-slate-400 dark:text-slate-500">data_pipeline.yml</span>
          </div>

          <!-- Origin Badge -->
          <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-green-50 dark:bg-green-900/15 border border-green-200/60 dark:border-green-800/30">
            <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">eco</span>
            <span class="text-[11px] font-semibold text-green-700 dark:text-green-400">Forestry Engineering</span>
            <span class="material-symbols-outlined text-xs text-slate-400">arrow_forward</span>
            <span class="material-symbols-outlined text-base text-accent-secondary">engineering</span>
            <span class="text-[11px] font-semibold text-accent-secondary">Data Engineering</span>
          </div>

          <!-- Data Sources Row -->
          <div class="space-y-2">
            <span class="text-[9px] font-mono tracking-wider uppercase text-slate-400 dark:text-slate-500 px-1">Sources</span>
            <div class="flex gap-2">
              <div class="flex-1 flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/70 border border-slate-100 dark:border-slate-700/70">
                <span class="material-symbols-outlined text-base text-accent-primary">database</span>
                <div>
                  <p class="text-[11px] font-bold text-slate-800 dark:text-slate-200 leading-none">PostgreSQL</p>
                  <p class="text-[9px] text-slate-400 font-mono mt-0.5">optimized queries</p>
                </div>
              </div>
              <div class="flex-1 flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/70 border border-slate-100 dark:border-slate-700/70">
                <span class="material-symbols-outlined text-base text-accent-secondary">cloud_sync</span>
                <div>
                  <p class="text-[11px] font-bold text-slate-800 dark:text-slate-200 leading-none">Education API</p>
                  <p class="text-[9px] text-slate-400 font-mono mt-0.5">provincial data</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Flow Arrow -->
          <div class="flex items-center justify-center gap-1.5 py-0.5">
            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-accent-tertiary/30 to-transparent"></div>
            <span class="material-symbols-outlined text-sm text-accent-tertiary/50 animate-bounce">keyboard_arrow_down</span>
            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-accent-tertiary/30 to-transparent"></div>
          </div>

          <!-- ETL Layer -->
          <div class="px-4 py-3 rounded-2xl bg-gradient-to-r from-accent-primary/5 via-accent-tertiary/8 to-accent-secondary/5 dark:from-accent-primary/10 dark:via-accent-tertiary/12 dark:to-accent-secondary/10 border border-dashed border-accent-tertiary/25 dark:border-accent-tertiary/15">
            <div class="flex items-center gap-2.5">
              <span class="material-symbols-outlined text-xl text-accent-tertiary">transform</span>
              <div class="flex-1">
                <p class="text-[11px] font-bold text-slate-800 dark:text-slate-200">ETL Pipeline</p>
                <p class="text-[9px] text-slate-500 dark:text-slate-400 font-mono">clean → validate → aggregate → load</p>
              </div>
            </div>
          </div>

          <!-- Flow Arrow -->
          <div class="flex items-center justify-center gap-1.5 py-0.5">
            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-accent-tertiary/30 to-transparent"></div>
            <span class="material-symbols-outlined text-sm text-accent-tertiary/50 animate-bounce">keyboard_arrow_down</span>
            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-accent-tertiary/30 to-transparent"></div>
          </div>

          <!-- Output: Warehouse + Dashboard -->
          <div class="flex gap-2">
            <div class="flex-1 px-3 py-2.5 rounded-xl bg-accent-secondary/5 dark:bg-accent-secondary/10 border border-accent-secondary/15">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-accent-secondary">warehouse</span>
                <p class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Data Warehouse</p>
              </div>
              <div class="mt-2 space-y-1">
                <div class="h-1.5 rounded-full bg-accent-secondary/20 overflow-hidden"><div class="h-full w-[85%] rounded-full bg-accent-secondary/60"></div></div>
                <div class="h-1.5 rounded-full bg-accent-secondary/20 overflow-hidden"><div class="h-full w-[62%] rounded-full bg-accent-secondary/40"></div></div>
                <div class="h-1.5 rounded-full bg-accent-secondary/20 overflow-hidden"><div class="h-full w-[94%] rounded-full bg-accent-secondary/50"></div></div>
              </div>
            </div>
            <div class="flex-1 px-3 py-2.5 rounded-xl bg-accent-primary/5 dark:bg-accent-primary/10 border border-accent-primary/15">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-accent-primary">monitoring</span>
                <p class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Analytics</p>
              </div>
              <div class="mt-2 flex items-end gap-1 h-[22px]">
                <div class="flex-1 bg-accent-primary/30 rounded-sm" style="height: 40%"></div>
                <div class="flex-1 bg-accent-primary/40 rounded-sm" style="height: 65%"></div>
                <div class="flex-1 bg-accent-primary/30 rounded-sm" style="height: 50%"></div>
                <div class="flex-1 bg-accent-primary/50 rounded-sm" style="height: 90%"></div>
                <div class="flex-1 bg-accent-primary/60 rounded-sm" style="height: 75%"></div>
                <div class="flex-1 bg-accent-primary/40 rounded-sm" style="height: 100%"></div>
                <div class="flex-1 bg-accent-primary/50 rounded-sm" style="height: 55%"></div>
              </div>
            </div>
          </div>

          <!-- Scale Badge -->
          <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-base text-accent-tertiary">public</span>
              <span class="text-[11px] font-semibold text-slate-700 dark:text-slate-300">Provincial-Scale Processing</span>
            </div>
            <div class="flex items-center gap-4 text-[10px] font-mono">
              <span class="text-slate-400"><span class="text-accent-secondary font-bold">34</span> districts</span>
              <span class="text-slate-400"><span class="text-accent-primary font-bold">1.2M</span> rows</span>
            </div>
          </div>

          <!-- Status Bar -->
          <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800/80">
            <div class="flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
              <span class="text-[10px] font-mono text-green-500 dark:text-green-400">All systems operational</span>
            </div>
            <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500">5 stages • 99.8% uptime</span>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const settings = computed(() => page.props.settings || {});
const profile = computed(() => page.props.profile || {});
</script>
