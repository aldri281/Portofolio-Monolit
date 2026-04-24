<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen"
        class="fixed inset-0 z-[200] flex items-end md:items-center justify-center p-0 md:p-6 bg-slate-950/90 backdrop-blur-xl"
        @click.self="$emit('close')"
      >
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="translate-y-full md:translate-y-4 opacity-0 scale-95"
          enter-to-class="translate-y-0 opacity-100 scale-100"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="translate-y-0 opacity-100 scale-100"
          leave-to-class="translate-y-full md:translate-y-4 opacity-0 scale-95"
        >
          <div
            v-if="isOpen"
            class="relative w-full md:max-w-5xl bg-white dark:bg-slate-900 rounded-t-3xl md:rounded-3xl shadow-2xl overflow-hidden flex flex-col"
            style="max-height: 92dvh;"
          >
            <!-- Header -->
            <div class="flex-shrink-0 px-6 pt-6 pb-4 border-b border-slate-100 dark:border-slate-800">
              <!-- Mobile drag handle -->
              <div class="w-10 h-1 bg-slate-200 dark:bg-slate-700 rounded-full mx-auto mb-4 md:hidden"></div>

              <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 rounded-2xl bg-slate-900 dark:bg-slate-800 flex items-center justify-center text-accent-primary flex-shrink-0 shadow-lg shadow-accent-primary/10">
                    <span class="material-symbols-outlined text-2xl">{{ project?.icon || 'account_tree' }}</span>
                  </div>
                  <div>
                    <p class="text-[10px] font-mono uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 mb-1 leading-none">{{ highlights?.badge_label || 'Architecture Deep Dive' }}</p>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white leading-tight tracking-tight">{{ project?.title }}</h3>
                  </div>
                </div>
                <button
                  @click="$emit('close')"
                  class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors flex-shrink-0"
                >
                  <span class="material-symbols-outlined text-xl">close</span>
                </button>
              </div>

              <!-- Tabs -->
              <div class="flex gap-1.5 mt-6 bg-slate-100/80 dark:bg-slate-800/80 rounded-xl p-1.5 border border-slate-200/50 dark:border-white/5">
                <button
                  v-for="tab in tabs"
                  :key="tab.id"
                  @click="activeTab = tab.id"
                  :class="[
                    'flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-xs md:text-sm font-bold transition-all duration-300',
                    activeTab === tab.id
                      ? 'bg-white dark:bg-slate-700 text-slate-950 dark:text-white shadow-md shadow-slate-200/50 dark:shadow-black/20 ring-1 ring-slate-200/50 dark:ring-white/10'
                      : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-white/50 dark:hover:bg-white/5'
                  ]"
                >
                  <span class="material-symbols-outlined text-[18px]">{{ tab.icon }}</span>
                  <span class="hidden xs:inline">{{ tab.label }}</span>
                </button>
              </div>
            </div>

            <!-- Body (scrollable) -->
            <div class="flex-1 overflow-y-auto overscroll-contain">

              <!-- TAB 1: ETL Pipeline -->
              <div v-if="activeTab === 'etl'" class="p-6 space-y-4">
                <p class="text-sm text-[var(--text-muted)] font-light leading-relaxed">
                  {{ highlights?.etl?.text || 'Pipeline data end-to-end yang memproses jutaan record dari sumber eksternal ke data warehouse setiap harinya.' }}
                </p>

                <div class="space-y-3 mt-4">
                  <div
                    v-for="(step, i) in (highlights?.etl?.items || highlights?.etl)"
                    :key="i"
                    class="group relative"
                  >
                    <!-- Connector line -->
                    <div v-if="Number(i) < (((highlights?.etl?.items || highlights?.etl) as any[])?.length ?? 0) - 1" class="absolute left-[40px] top-[80px] -bottom-4 w-px bg-gradient-to-b from-slate-200 via-slate-200 to-transparent dark:from-slate-700 dark:via-slate-700 z-0"></div>

                    <div class="relative z-10 flex gap-4 p-4 md:p-5 rounded-2xl border border-slate-100 dark:border-slate-800/50 bg-white dark:bg-slate-800/20 hover:border-accent-tertiary/20 dark:hover:border-accent-tertiary/20 transition-all duration-300">
                      <!-- Step badge + icon -->
                      <div class="flex-shrink-0 flex flex-col items-center gap-2 w-12">
                        <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm', stepColors[Number(i) % stepColors.length]]">
                          <span class="material-symbols-outlined text-xl">{{ step.icon }}</span>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest opacity-60 text-center leading-none">{{ step.step }}</span>
                      </div>

                      <!-- Content -->
                      <div class="flex-1 min-w-0 pt-0.5">
                        <h4 class="font-bold text-slate-900 dark:text-white text-base mb-1">{{ step.label }}</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-light">{{ step.desc }}</p>
                        <div class="mt-3 p-3 rounded-xl bg-slate-950 dark:bg-black/40 border border-slate-800 dark:border-white/5 group-hover:border-slate-700 transition-colors">
                          <p class="text-[11px] font-mono text-slate-400 dark:text-slate-500 leading-normal">{{ step.detail }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- TAB 2: Data Scale -->
              <div v-if="activeTab === 'stats'" class="p-6">
                <p class="text-sm text-[var(--text-muted)] font-light leading-relaxed mb-6">
                  {{ highlights?.stats?.text || 'Skala platform yang mencerminkan kompleksitas sistem data kepegawaian provinsi Jawa Barat.' }}
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                  <div
                    v-for="(stat, i) in (highlights?.stats?.items || highlights?.stats)"
                    :key="i"
                    :class="['group p-5 rounded-2xl border transition-all hover:scale-105 cursor-default', statCardClass(stat.color)]"
                  >
                    <div class="flex items-start justify-between mb-3">
                      <span :class="['material-symbols-outlined text-2xl', statIconClass(stat.color)]">{{ stat.icon }}</span>
                    </div>
                    <div :class="['text-3xl font-black mb-1', statValueClass(stat.color)]">{{ stat.value }}</div>
                    <div class="text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wide leading-tight">{{ stat.label }}</div>
                  </div>
                </div>

                <!-- Architecture badges -->
                <div class="mt-6 p-5 rounded-2xl bg-slate-900 dark:bg-slate-950 text-white">
                  <p class="text-xs font-mono uppercase tracking-widest text-slate-400 mb-3">Tech Stack</p>
                  <div class="flex flex-wrap gap-2">
                    <span
                      v-for="tool in project?.tools"
                      :key="tool"
                      class="px-3 py-1.5 rounded-lg bg-white/10 border border-white/10 text-sm font-mono text-slate-200"
                    >{{ tool }}</span>
                  </div>
                </div>
              </div>

              <!-- TAB 3: Data Modeling -->
              <div v-if="activeTab === 'entities'" class="p-6 space-y-3">
                <p class="text-sm text-[var(--text-muted)] font-light leading-relaxed mb-4">
                  {{ highlights?.entities?.text || 'Arsitektur database relasional dengan multi-connection PostgreSQL — memisahkan data SIMPEG, Dapodik, Peer Review, dan EOTM ke skema khusus.' }}
                </p>

                <!-- Multi-DB architecture visual -->
                <div v-if="(highlights?.databases || databases).length" class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
                  <div v-for="db in (highlights?.databases?.length ? highlights.databases : databases)" :key="db.name" class="p-3 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 text-center">
                    <span class="material-symbols-outlined text-2xl text-[var(--accent-primary)] block mb-1">database</span>
                    <p class="text-xs font-bold text-[var(--text-main)]">{{ db.name }}</p>
                    <p class="text-[10px] text-[var(--text-muted)] mt-0.5">{{ db.desc }}</p>
                  </div>
                </div>

                <!-- Entity cards -->
                <div class="space-y-2">
                  <div
                    v-for="(entity, i) in (highlights?.entities?.items || highlights?.entities)"
                    :key="i"
                    class="flex gap-4 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-800/30 hover:border-slate-200 dark:hover:border-slate-700 transition-colors"
                  >
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-[var(--accent-primary)]/10 flex items-center justify-center">
                      <span class="material-symbols-outlined text-lg text-[var(--accent-primary)]">table_chart</span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <div class="flex items-center gap-2 flex-wrap mb-1">
                        <code class="text-sm font-bold text-[var(--text-main)] bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md">{{ entity.name }}</code>
                        <span class="text-[10px] font-semibold uppercase tracking-wide px-2 py-0.5 rounded-full bg-[var(--accent-primary)]/10 text-[var(--accent-primary)]">{{ entity.source }}</span>
                      </div>
                      <p class="text-sm text-[var(--text-muted)] leading-relaxed">{{ entity.desc }}</p>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Footer -->
            <div class="flex-shrink-0 px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
              <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 tracking-wider">
                {{ project?.datastack }}
              </p>
              <div class="flex items-center gap-3">
                <a
                  v-if="project?.repo_link"
                  :href="project.repo_link"
                  target="_blank"
                  class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                >
                  <span class="material-symbols-outlined text-base">code</span>
                  Source
                </a>
                <a
                  v-if="project?.demo_link"
                  :href="project.demo_link"
                  target="_blank"
                  class="flex items-center gap-2 px-5 py-2 rounded-xl bg-slate-950 dark:bg-white text-white dark:text-slate-950 text-xs font-bold hover:opacity-90 transition-opacity"
                >
                  <span class="material-symbols-outlined text-base">open_in_new</span>
                  <span>Live Project</span>
                </a>
              </div>
            </div>

          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'

interface EtlStep {
  step: string
  icon: string
  label: string
  desc: string
  detail: string
}

interface Stat {
  value: string
  label: string
  icon: string
  color: string
}

interface Entity {
  name: string
  source: string
  desc: string
}

interface DatabaseItem {
  name: string
  desc: string
}

interface HighlightGroup<T> {
  text?: string
  items?: T[]
}

interface Highlights {
  badge_label?: string
  databases?: DatabaseItem[]
  etl?: EtlStep[] | HighlightGroup<EtlStep> | any
  stats?: Stat[] | HighlightGroup<Stat> | any
  entities?: Entity[] | HighlightGroup<Entity> | any
}

interface Project {
  id: number
  title: string
  description: string
  datastack: string
  icon: string | null
  tools: string[]
  highlights: Highlights | null
  demo_link: string | null
  repo_link: string | null
}

const props = defineProps<{
  isOpen: boolean
  project: Project | null
}>()

defineEmits<{ close: [] }>()

const activeTab = ref('etl')

// Reset to first tab when project changes
watch(() => props.project, () => { activeTab.value = 'etl' })
// Close scroll lock
watch(() => props.isOpen, (val) => {
  document.body.style.overflow = val ? 'hidden' : ''
})

const highlights = ref<Highlights | null>(null)
watch(() => props.project, (p) => {
  highlights.value = p?.highlights ?? null
}, { immediate: true })

const tabs = [
  { id: 'etl',      label: 'ETL Pipeline',   icon: 'account_tree' },
  { id: 'stats',    label: 'Data Scale',      icon: 'bar_chart' },
  { id: 'entities', label: 'Data Modeling',   icon: 'table_chart' },
]

const stepColors = [
  'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400',
  'bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400',
  'bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400',
  'bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400',
  'bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400',
]

const databases = [
  { name: 'Main DB', desc: 'Core warehouse' },
  { name: 'SIMPEG', desc: 'Kepegawaian PNS' },
  { name: 'Dapodik', desc: 'Data sekolah' },
  { name: 'EOTM', desc: 'Peer Review' },
]

const statCardClass = (color: string) => {
  const map: Record<string, string> = {
    blue:   'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-900/40',
    green:  'bg-green-50 dark:bg-green-900/20 border-green-100 dark:border-green-900/40',
    purple: 'bg-purple-50 dark:bg-purple-900/20 border-purple-100 dark:border-purple-900/40',
    orange: 'bg-orange-50 dark:bg-orange-900/20 border-orange-100 dark:border-orange-900/40',
    teal:   'bg-teal-50 dark:bg-teal-900/20 border-teal-100 dark:border-teal-900/40',
    red:    'bg-red-50 dark:bg-red-900/20 border-red-100 dark:border-red-900/40',
    indigo: 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-100 dark:border-indigo-900/40',
    yellow: 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-100 dark:border-yellow-900/40',
  }
  return map[color] ?? map.blue
}

const statIconClass = (color: string) => {
  const map: Record<string, string> = {
    blue:   'text-blue-500',
    green:  'text-green-500',
    purple: 'text-purple-500',
    orange: 'text-orange-500',
    teal:   'text-teal-500',
    red:    'text-red-500',
    indigo: 'text-indigo-500',
    yellow: 'text-yellow-500',
  }
  return map[color] ?? map.blue
}

const statValueClass = (color: string) => {
  const map: Record<string, string> = {
    blue:   'text-blue-600 dark:text-blue-400',
    green:  'text-green-600 dark:text-green-400',
    purple: 'text-purple-600 dark:text-purple-400',
    orange: 'text-orange-600 dark:text-orange-400',
    teal:   'text-teal-600 dark:text-teal-400',
    red:    'text-red-600 dark:text-red-400',
    indigo: 'text-indigo-600 dark:text-indigo-400',
    yellow: 'text-yellow-600 dark:text-yellow-400',
  }
  return map[color] ?? map.blue
}
</script>
