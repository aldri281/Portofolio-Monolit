<template>
  <section class="py-24 scroll-mt-32" id="skills">
    <div class="text-center max-w-3xl mx-auto space-y-6 mb-24">
      <h2 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight">{{ settings?.section_skills_title || 'Technical Toolbox' }}</h2>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 font-light">{{ settings?.section_skills_subtitle || 'The technologies powering the infrastructure.' }}</p>
    </div>

    <!-- Fallback/Loading State -->
    <div v-if="pending" class="text-center py-10 text-slate-500">
      Loading skills...
    </div>

    <div v-else-if="error" class="text-center py-10 text-red-500">
      Failed to load skills. Please try again later.
    </div>

    <div v-else class="grid md:grid-cols-3 gap-10">
      
      <!-- Dynamic Categories -->
      <div v-for="(categorySkills, categoryName) in groupedSkills" :key="categoryName" class="glass-chip dark:bg-slate-900/50 soft-radius p-6 md:p-10 space-y-8 border border-slate-50 dark:border-slate-800 hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-slate-900/50 transition-all duration-300">
        <div class="flex items-center gap-5 border-b border-slate-100 dark:border-slate-800 pb-6 transition-colors duration-300">
          <div :class="['w-12 h-12 rounded-xl shadow-sm flex items-center justify-center transition-colors duration-300', getIconColorClass(categoryName)]" class="bg-white dark:bg-slate-800">
            <span class="material-symbols-outlined text-2xl">{{ getCategoryIcon(categoryName) }}</span>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">{{ categoryName }}</h3>
        </div>
        <div class="flex flex-wrap gap-3">
          <span v-for="skill in categorySkills" :key="skill.id" class="px-5 py-2.5 bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-medium text-sm shadow-sm transition-colors duration-300">
            {{ skill.name }}
          </span>
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
const pending = false;
const error = null;

const skills = computed(() => page.props.skills || []);

// Group skills by category
const groupedSkills = computed(() => {
  if (!skills.value) return {}
  
  const currentSkills = skills.value || [];

  return currentSkills.reduce((acc, skill) => {
    if (!acc[skill.category]) {
      acc[skill.category] = []
    }
    acc[skill.category]!.push(skill)
    return acc
  }, {} as Record<string, any[]>)
})

// Helper to assign icons to categories based on name
const getCategoryIcon = (category: string) => {
  const cat = category.toLowerCase()
  if (cat.includes('database')) return 'database'
  if (cat.includes('language') || cat.includes('code')) return 'code'
  if (cat.includes('tool') || cat.includes('infra') || cat.includes('orchestrator')) return 'build'
  return 'widgets'
}

// Helper to assign consistent colors to categories (primary, secondary, tertiary)
const getIconColorClass = (category: string) => {
  const cat = category.toLowerCase()
  if (cat.includes('database')) return 'text-accent-primary'
  if (cat.includes('language') || cat.includes('code')) return 'text-accent-secondary'
  return 'text-accent-tertiary'
}
</script>
