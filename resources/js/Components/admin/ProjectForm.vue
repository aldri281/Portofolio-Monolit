<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">

    <!-- Basic Info Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
      <h2 class="text-sm font-semibold uppercase tracking-widest text-slate-500">Basic Info</h2>

      <div class="grid md:grid-cols-2 gap-4">
        <div class="md:col-span-2 space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Title *</label>
          <input v-model="form.title" type="text" required placeholder="e.g. SIGESIT JUARA — Enterprise Platform" v-bind="inputClass" />
        </div>

        <div class="space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Icon (Material Symbol)</label>
          <div class="relative">
            <input v-model="form.icon" type="text" placeholder="e.g. account_tree" v-bind="inputClass" class="pr-12" />
            <div class="absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 rounded-lg bg-slate-700 flex items-center justify-center">
              <span class="material-symbols-outlined text-base text-[var(--accent-primary)]">{{ form.icon || 'help' }}</span>
            </div>
          </div>
          <p class="text-xs text-slate-600">Find icons at <a href="https://fonts.google.com/icons" target="_blank" class="text-[var(--accent-primary)] hover:underline">fonts.google.com/icons</a></p>
        </div>

        <div class="space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Data Stack Label</label>
          <input v-model="form.datastack" type="text" placeholder="e.g. PostgreSQL · Redis · Docker" v-bind="inputClass" />
        </div>

        <div class="md:col-span-2 space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Description *</label>
          <textarea v-model="form.description" required rows="4" placeholder="Describe the project and your role..." v-bind="inputClass" class="resize-none"></textarea>
        </div>
      </div>
    </div>

    <!-- Tools Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
      <h2 class="text-sm font-semibold uppercase tracking-widest text-slate-500">Tools & Technologies</h2>
      <div class="flex gap-2">
        <input
          v-model="newTool"
          type="text"
          placeholder="e.g. PostgreSQL"
          @keydown.enter.prevent="addTool"
          v-bind="inputClass"
          class="flex-1"
        />
        <button type="button" @click="addTool" class="px-4 py-2.5 rounded-xl bg-slate-700 text-white text-sm font-semibold hover:bg-slate-600 transition-colors">
          Add
        </button>
      </div>
      <div class="flex flex-wrap gap-2">
        <span
          v-for="(tool, i) in form.tools"
          :key="i"
          class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 border border-slate-700 text-slate-300 text-sm"
        >
          {{ tool }}
          <button type="button" @click="removeTool(i)" class="text-slate-500 hover:text-red-400 transition-colors">
            <span class="material-symbols-outlined text-base">close</span>
          </button>
        </span>
        <span v-if="!form.tools.length" class="text-slate-600 text-sm italic">No tools added yet</span>
      </div>
    </div>

    <!-- Links Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
      <h2 class="text-sm font-semibold uppercase tracking-widest text-slate-500">Links</h2>
      <div class="grid md:grid-cols-2 gap-4">
        <div class="space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Repository URL</label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-xl text-slate-500">code</span>
            <input v-model="form.repo_link" type="url" placeholder="https://github.com/..." class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] focus:ring-2 focus:ring-[var(--accent-primary)]/20 transition-all text-sm" />
          </div>
        </div>
        <div class="space-y-1">
          <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Live Demo URL</label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-xl text-slate-500">open_in_new</span>
            <input v-model="form.demo_link" type="url" placeholder="https://..." class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] focus:ring-2 focus:ring-[var(--accent-primary)]/20 transition-all text-sm" />
          </div>
        </div>
      </div>
    </div>

    <!-- Images Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
      <h2 class="text-sm font-semibold uppercase tracking-widest text-slate-500">Project Images</h2>
      <p class="text-xs text-slate-500">Paste Google Drive share links. Images are managed separately after creating/updating the project via the project list.</p>
      <div class="p-4 rounded-xl bg-slate-800/50 border border-slate-700 border-dashed text-center space-y-2">
        <span class="material-symbols-outlined text-3xl text-slate-600">image</span>
        <p class="text-sm text-slate-500">Images can be added via the Google Drive URL system after saving the project.</p>
      </div>
    </div>

    <!-- Highlights Card (Interactive Builder) -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-8">
      <div>
        <h2 class="text-sm font-semibold uppercase tracking-widest text-slate-500">Architecture Highlights</h2>
        <p class="text-xs text-slate-600 mt-1">Structured data for ETL Pipeline, Stats, and Entities.</p>
      </div>

      <div class="space-y-1">
        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Badge Label (Top left text)</label>
        <input v-model="localHighlights.badge_label" type="text" placeholder="e.g. Architecture Deep Dive" v-bind="inputClass" />
      </div>

      <!-- ETL Builder -->
      <div class="space-y-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-slate-800 pb-2 gap-2">
          <div class="space-y-1 w-full md:w-2/3">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
              <span class="material-symbols-outlined text-orange-400 text-lg">sync</span>
              ETL Pipeline Steps
            </h3>
            <textarea v-model="localHighlights.etl.text" rows="1" placeholder="Enter short description for this section..." class="w-full bg-transparent border-none text-xs text-slate-400 focus:text-white focus:outline-none focus:ring-1 focus:ring-slate-700 rounded px-1 -ml-1 resize-none overflow-hidden"></textarea>
          </div>
          <button type="button" @click="addEtlStep" class="text-xs flex items-center gap-1 shrink-0 text-[var(--accent-primary)] hover:text-white transition-colors bg-slate-800/50 hover:bg-slate-700 px-2.5 py-1.5 rounded-lg border border-slate-700">
            <span class="material-symbols-outlined text-sm">add</span> Add Step
          </button>
        </div>
        
        <div v-if="localHighlights.etl.items.length === 0" class="text-xs text-slate-600 italic">No ETL steps added.</div>
        
        <div v-for="(step, i) in visibleEtl" :key="`etl-${i}`" class="relative group p-4 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-slate-700 transition-colors space-y-3">
          <button type="button" @click="removeEtlStep(i)" class="absolute top-3 right-3 text-slate-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined text-lg">delete</span>
          </button>
          
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pr-8">
            <div class="space-y-1">
              <label class="text-[10px] font-semibold uppercase text-slate-500">Step Type</label>
              <input v-model="step.step" type="text" placeholder="EXTRACT" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none" />
            </div>
            <div class="space-y-1">
              <label class="text-[10px] font-semibold uppercase text-slate-500">Icon</label>
              <input v-model="step.icon" type="text" placeholder="cloud_download" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none" />
            </div>
            <div class="col-span-2 md:col-span-2 space-y-1">
              <label class="text-[10px] font-semibold uppercase text-slate-500">Title</label>
              <input v-model="step.label" type="text" placeholder="Multi-Source Extraction" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none" />
            </div>
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-semibold uppercase text-slate-500">Description</label>
            <textarea v-model="step.desc" rows="2" placeholder="Short description..." class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none resize-none"></textarea>
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-semibold uppercase text-slate-500">Technical Details</label>
            <textarea v-model="step.detail" rows="2" placeholder="Technical implementation details..." class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none resize-none"></textarea>
          </div>
        </div>
        
        <div v-if="localHighlights.etl.items.length > 1" class="flex justify-center mt-2">
          <button type="button" @click="showAllEtl = !showAllEtl" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1">
            {{ showAllEtl ? 'Show Less' : `Show ${localHighlights.etl.items.length - 1} More` }}
            <span class="material-symbols-outlined text-sm transition-transform duration-300" :class="{ 'rotate-180': showAllEtl }">expand_more</span>
          </button>
        </div>
      </div>

      <!-- Stats Builder -->
      <div class="space-y-4 pt-4 border-t border-slate-800">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-slate-800 pb-2 gap-2">
          <div class="space-y-1 w-full md:w-2/3">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
              <span class="material-symbols-outlined text-blue-400 text-lg">query_stats</span>
              Data Scale & Stats
            </h3>
            <textarea v-model="localHighlights.stats.text" rows="1" placeholder="Enter short description for this section..." class="w-full bg-transparent border-none text-xs text-slate-400 focus:text-white focus:outline-none focus:ring-1 focus:ring-slate-700 rounded px-1 -ml-1 resize-none overflow-hidden"></textarea>
          </div>
          <button type="button" @click="addStatItem" class="text-xs flex items-center gap-1 shrink-0 text-[var(--accent-primary)] hover:text-white transition-colors bg-slate-800/50 hover:bg-slate-700 px-2.5 py-1.5 rounded-lg border border-slate-700">
            <span class="material-symbols-outlined text-sm">add</span> Add Stat
          </button>
        </div>
        
        <div v-if="localHighlights.stats.items.length === 0" class="text-xs text-slate-600 italic">No stats added.</div>

        <div class="grid md:grid-cols-2 gap-4">
          <div v-for="(stat, i) in visibleStats" :key="`stat-${i}`" class="relative group p-3 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-slate-700 transition-colors">
            <button type="button" @click="removeStatItem(i)" class="absolute top-2 right-2 text-slate-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity">
              <span class="material-symbols-outlined text-base">close</span>
            </button>
            <div class="grid grid-cols-2 gap-2 text-xs">
              <input v-model="stat.value" type="text" placeholder="Value (e.g. 62.000+)" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-[var(--accent-primary)] focus:outline-none" />
              <input v-model="stat.label" type="text" placeholder="Label (e.g. Data Pegawai)" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-[var(--accent-primary)] focus:outline-none" />
              <input v-model="stat.icon" type="text" placeholder="Icon (e.g. people)" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-[var(--accent-primary)] focus:outline-none" />
              <select v-model="stat.color" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-[var(--accent-primary)] focus:outline-none appearance-none cursor-pointer">
                <option value="blue">Blue</option>
                <option value="green">Green</option>
                <option value="purple">Purple</option>
                <option value="orange">Orange</option>
                <option value="teal">Teal</option>
                <option value="red">Red</option>
                <option value="indigo">Indigo</option>
                <option value="yellow">Yellow</option>
                <option value="slate">Slate</option>
              </select>
            </div>
          </div>
        </div>

        <div v-if="localHighlights.stats.items.length > 2" class="flex justify-center mt-2">
          <button type="button" @click="showAllStats = !showAllStats" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1">
            {{ showAllStats ? 'Show Less' : `Show ${localHighlights.stats.items.length - 2} More` }}
            <span class="material-symbols-outlined text-sm transition-transform duration-300" :class="{ 'rotate-180': showAllStats }">expand_more</span>
          </button>
        </div>
      </div>

      <!-- Databases Builder -->
      <div class="space-y-4 pt-4 border-t border-slate-800">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-slate-800 pb-2 gap-2">
          <div class="space-y-1 w-full md:w-2/3">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
              <span class="material-symbols-outlined text-green-400 text-lg">database</span>
              Main Databases
            </h3>
            <p class="text-[10px] text-slate-500">E.g. Main DB, SIMPEG, Dapodik</p>
          </div>
          <button type="button" @click="addDatabaseItem" class="text-xs flex items-center gap-1 shrink-0 text-[var(--accent-primary)] hover:text-white transition-colors bg-slate-800/50 hover:bg-slate-700 px-2.5 py-1.5 rounded-lg border border-slate-700">
            <span class="material-symbols-outlined text-sm">add</span> Add DB
          </button>
        </div>
        
        <div v-if="localHighlights.databases.length === 0" class="text-xs text-slate-600 italic">No databases added.</div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
          <div v-for="(db, i) in localHighlights.databases" :key="`db-${i}`" class="relative group p-3 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-slate-700 transition-colors">
            <button type="button" @click="removeDatabaseItem(i)" class="absolute top-2 right-2 text-slate-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity">
              <span class="material-symbols-outlined text-base">close</span>
            </button>
            <div class="space-y-2 text-xs">
              <input v-model="db.name" type="text" placeholder="DB Name (e.g. Main DB)" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-[var(--accent-primary)] focus:outline-none" />
              <input v-model="db.desc" type="text" placeholder="Desc (e.g. Core warehouse)" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-[var(--accent-primary)] focus:outline-none" />
            </div>
          </div>
        </div>
      </div>

      <!-- Entities Builder -->
      <div class="space-y-4 pt-4 border-t border-slate-800">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b border-slate-800 pb-2 gap-2">
          <div class="space-y-1 w-full md:w-2/3">
            <h3 class="text-sm font-semibold text-white flex items-center gap-2">
              <span class="material-symbols-outlined text-purple-400 text-lg">schema</span>
              Data Entities / Domains
            </h3>
            <textarea v-model="localHighlights.entities.text" rows="1" placeholder="Enter short description for this section..." class="w-full bg-transparent border-none text-xs text-slate-400 focus:text-white focus:outline-none focus:ring-1 focus:ring-slate-700 rounded px-1 -ml-1 resize-none overflow-hidden"></textarea>
          </div>
          <button type="button" @click="addEntityItem" class="text-xs flex items-center gap-1 shrink-0 text-[var(--accent-primary)] hover:text-white transition-colors bg-slate-800/50 hover:bg-slate-700 px-2.5 py-1.5 rounded-lg border border-slate-700">
            <span class="material-symbols-outlined text-sm">add</span> Add Entity
          </button>
        </div>
        
        <div v-if="localHighlights.entities.items.length === 0" class="text-xs text-slate-600 italic">No entities added.</div>

        <div v-for="(ent, i) in visibleEntities" :key="`ent-${i}`" class="relative group p-4 rounded-xl bg-slate-800/30 border border-slate-800 hover:border-slate-700 transition-colors space-y-3">
          <button type="button" @click="removeEntityItem(i)" class="absolute top-3 right-3 text-slate-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined text-lg">delete</span>
          </button>
          
          <div class="grid md:grid-cols-2 gap-3 pr-8">
            <div class="space-y-1">
              <label class="text-[10px] font-semibold uppercase text-slate-500">Entity Name</label>
              <input v-model="ent.name" type="text" placeholder="e.g. m_sekolah" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none" />
            </div>
            <div class="space-y-1">
              <label class="text-[10px] font-semibold uppercase text-slate-500">Source</label>
              <input v-model="ent.source" type="text" placeholder="e.g. Dapodik API" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none" />
            </div>
          </div>
          <div class="space-y-1">
             <label class="text-[10px] font-semibold uppercase text-slate-500">Description</label>
             <textarea v-model="ent.desc" rows="2" placeholder="Describe the entity..." class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-[var(--accent-primary)] focus:outline-none resize-none"></textarea>
          </div>
        </div>
        
        <div v-if="localHighlights.entities.items.length > 1" class="flex justify-center mt-2">
          <button type="button" @click="showAllEntities = !showAllEntities" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1">
            {{ showAllEntities ? 'Show Less' : `Show ${localHighlights.entities.items.length - 1} More` }}
            <span class="material-symbols-outlined text-sm transition-transform duration-300" :class="{ 'rotate-180': showAllEntities }">expand_more</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <div class="flex items-center gap-4 pb-10">
      <button
        type="submit"
        :disabled="loading"
        class="flex items-center gap-2 px-6 py-3 rounded-xl bg-[var(--accent-primary)] text-white font-semibold text-sm hover:opacity-90 active:scale-[0.98] transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-[var(--accent-primary)]/20"
      >
        <span v-if="loading" class="animate-spin material-symbols-outlined text-xl">progress_activity</span>
        <span class="material-symbols-outlined text-xl" v-else>save</span>
        {{ loading ? 'Saving...' : 'Save Project' }}
      </button>
      <Link href="/admin/projects" class="text-slate-500 hover:text-white text-sm font-medium transition-colors">
        Cancel
      </Link>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

interface EtlStep { step: string; icon: string; label: string; desc: string; detail: string }
interface StatItem { value: string; label: string; icon: string; color: string }
interface EntityItem { name: string; source: string; desc: string }
interface DatabaseItem { name: string; desc: string }

interface HighlightGroup<T> {
  text: string
  items: T[]
}

interface ProjectHighlights {
  badge_label?: string
  databases: DatabaseItem[]
  etl: HighlightGroup<EtlStep>
  stats: HighlightGroup<StatItem>
  entities: HighlightGroup<EntityItem>
}

interface ProjectData {
  title: string
  description: string
  datastack: string
  icon: string
  tools: string[]
  repo_link: string
  demo_link: string
  highlights?: any | null // Use any from backend, map safely below
}

const props = defineProps<{
  initialData?: Partial<ProjectData>
  loading?: boolean
}>()

const emit = defineEmits<{
  submit: [payload: unknown]
}>()

const inputClass = {
  class: 'w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] focus:ring-2 focus:ring-[var(--accent-primary)]/20 transition-all text-sm'
}

const form = ref({
  title: props.initialData?.title ?? '',
  description: props.initialData?.description ?? '',
  datastack: props.initialData?.datastack ?? '',
  icon: props.initialData?.icon ?? '',
  tools: props.initialData?.tools ?? [] as string[],
  repo_link: props.initialData?.repo_link ?? '',
  demo_link: props.initialData?.demo_link ?? '',
})

const newTool = ref('')

// Safely map existing backend data or initialize new structure
const initH = props.initialData?.highlights || {}

const mapGroup = <T>(data: any): HighlightGroup<T> => {
  if (Array.isArray(data)) {
    // Legacy migration: If backend only has an array, move it to items and set text to empty
    return { text: '', items: [...data] }
  } else if (data && typeof data === 'object') {
    return { text: data.text || '', items: Array.isArray(data.items) ? [...data.items] : [] }
  }
  return { text: '', items: [] }
}

const localHighlights = ref<ProjectHighlights>({
  badge_label: initH.badge_label || '',
  databases: Array.isArray(initH.databases) ? [...initH.databases] : [],
  etl: mapGroup<EtlStep>(initH.etl),
  stats: mapGroup<StatItem>(initH.stats),
  entities: mapGroup<EntityItem>(initH.entities)
})

// UI states for expanding builder arrays
const showAllEtl = ref(false)
const showAllStats = ref(false)
const showAllEntities = ref(false)

const visibleEtl = computed(() => showAllEtl.value ? localHighlights.value.etl.items : localHighlights.value.etl.items.slice(0, 1))
const visibleStats = computed(() => showAllStats.value ? localHighlights.value.stats.items : localHighlights.value.stats.items.slice(0, 2))
const visibleEntities = computed(() => showAllEntities.value ? localHighlights.value.entities.items : localHighlights.value.entities.items.slice(0, 1))

// Methods to mutate the builder arrays
const addEtlStep = () => {
  localHighlights.value.etl.items.push({ step: '', icon: 'cloud_download', label: '', desc: '', detail: '' })
  showAllEtl.value = true
}
const removeEtlStep = (i: number) => {
  localHighlights.value.etl.items.splice(i, 1)
  if (localHighlights.value.etl.items.length <= 1) showAllEtl.value = false
}

const addStatItem = () => {
  localHighlights.value.stats.items.push({ value: '', label: '', icon: 'star', color: 'blue' })
  showAllStats.value = true
}
const removeStatItem = (i: number) => {
  localHighlights.value.stats.items.splice(i, 1)
  if (localHighlights.value.stats.items.length <= 2) showAllStats.value = false
}

const addEntityItem = () => {
  localHighlights.value.entities.items.push({ name: '', source: '', desc: '' })
  showAllEntities.value = true
}
const removeEntityItem = (i: number) => {
  localHighlights.value.entities.items.splice(i, 1)
  if (localHighlights.value.entities.items.length <= 1) showAllEntities.value = false
}

const addDatabaseItem = () => {
  localHighlights.value.databases.push({ name: '', desc: '' })
}
const removeDatabaseItem = (i: number) => {
  localHighlights.value.databases.splice(i, 1)
}

const addTool = () => {
  const t = newTool.value.trim()
  if (t && !form.value.tools.includes(t)) {
    form.value.tools.push(t)
  }
  newTool.value = ''
}

const removeTool = (i: number) => {
  form.value.tools.splice(i, 1)
}

// Clean up highlights payload by strictly retaining populated items
const cleanHighlightsPayload = () => {
  const etlItems = localHighlights.value.etl.items.filter(s => s.step || s.label)
  const statsItems = localHighlights.value.stats.items.filter(s => s.value || s.label)
  const entitiesItems = localHighlights.value.entities.items.filter(s => s.name || s.source)
  const databasesItems = localHighlights.value.databases.filter(d => d.name || d.desc)

  if (etlItems.length === 0 && statsItems.length === 0 && entitiesItems.length === 0 && databasesItems.length === 0 && !localHighlights.value.etl.text && !localHighlights.value.stats.text && !localHighlights.value.entities.text && !localHighlights.value.badge_label) {
    return null
  }

  return {
    badge_label: localHighlights.value.badge_label,
    databases: databasesItems,
    etl: { text: localHighlights.value.etl.text, items: etlItems },
    stats: { text: localHighlights.value.stats.text, items: statsItems },
    entities: { text: localHighlights.value.entities.text, items: entitiesItems }
  }
}

const handleSubmit = () => {
  const payload = {
    ...form.value,
    highlights: cleanHighlightsPayload(),
  }
  emit('submit', payload)
}
</script>
