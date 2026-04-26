<template>
  <div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Global Site Settings</h1>
        <p class="text-slate-400 mt-1">Manage texts, links, and icons across the entire website.</p>
      </div>
    </div>

    <div v-if="pending" class="text-slate-400 p-8 text-center bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-center gap-3">
      <span class="animate-spin material-symbols-outlined">progress_activity</span>
      Loading settings...
    </div>

    <!-- Main Settings Form -->
    <form v-else @submit.prevent="saveSettings" class="space-y-6">
      
      <!-- Section 1: Hero & Identity -->
      <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-xl">
        <div class="flex items-center gap-3 border-b border-slate-800 pb-4 mb-2 text-white">
          <span class="material-symbols-outlined text-blue-400 text-xl">home</span>
          <h2 class="text-lg font-semibold tracking-tight">Hero & Identity</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-4">
          <div class="space-y-1 md:col-span-2">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Site Logo (HTML allowed)</label>
            <input v-model="form.site_logo_text" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Hero Badge Text</label>
            <input v-model="form.hero_badge" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1 md:col-span-2">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Hero Title (HTML allowed)</label>
            <textarea v-model="form.hero_title" rows="3" v-bind="inputClass" class="resize-y font-mono text-xs leading-relaxed max-h-40 min-h-[5rem]"></textarea>
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Hero Icon 1</label>
            <input v-model="form.hero_icon_1" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Hero Icon 2</label>
            <input v-model="form.hero_icon_2" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Resume Link (English)</label>
            <input v-model="form.resume_link_en" type="text" v-bind="inputClass" placeholder="https://drive.google.com/..." />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Resume Link (Indonesia)</label>
            <input v-model="form.resume_link_id" type="text" v-bind="inputClass" placeholder="https://drive.google.com/..." />
          </div>
        </div>
      </div>

      <!-- Section 2: Sections Configuration -->
      <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-xl">
        <div class="flex items-center gap-3 border-b border-slate-800 pb-4 mb-2 text-white">
          <span class="material-symbols-outlined text-[var(--accent-primary)] text-xl">layers</span>
          <h2 class="text-lg font-semibold tracking-tight">Sections Configuration</h2>
        </div>
        
        <div class="space-y-6">
          <div class="grid md:grid-cols-3 gap-4 border border-slate-800 p-4 bg-slate-800/20 rounded-xl relative hover:border-slate-700 transition-colors">
            <span class="absolute -top-3 left-4 bg-slate-900 px-2 text-xs font-bold uppercase tracking-wider text-slate-500">Projects Section</span>
            <div class="space-y-1 md:col-span-1">
              <label class="text-[10px] uppercase text-slate-500">Title</label>
              <input v-model="form.section_projects_title" type="text" v-bind="inputClass" />
            </div>
            <div class="space-y-1 md:col-span-2">
              <label class="text-[10px] uppercase text-slate-500">Subtitle</label>
              <input v-model="form.section_projects_subtitle" type="text" v-bind="inputClass" />
            </div>
          </div>

          <div class="grid md:grid-cols-3 gap-4 border border-slate-800 p-4 bg-slate-800/20 rounded-xl relative hover:border-slate-700 transition-colors">
            <span class="absolute -top-3 left-4 bg-slate-900 px-2 text-xs font-bold uppercase tracking-wider text-slate-500">Skills Section</span>
            <div class="space-y-1 md:col-span-1">
              <label class="text-[10px] uppercase text-slate-500">Title</label>
              <input v-model="form.section_skills_title" type="text" v-bind="inputClass" />
            </div>
            <div class="space-y-1 md:col-span-2">
              <label class="text-[10px] uppercase text-slate-500">Subtitle</label>
              <input v-model="form.section_skills_subtitle" type="text" v-bind="inputClass" />
            </div>
          </div>

          <div class="grid md:grid-cols-3 gap-4 border border-slate-800 p-4 bg-slate-800/20 rounded-xl relative hover:border-slate-700 transition-colors">
            <span class="absolute -top-3 left-4 bg-slate-900 px-2 text-xs font-bold uppercase tracking-wider text-slate-500">Certificates Section</span>
            <div class="space-y-1 md:col-span-1">
              <label class="text-[10px] uppercase text-slate-500">Title</label>
              <input v-model="form.section_certificates_title" type="text" v-bind="inputClass" />
            </div>
            <div class="space-y-1 md:col-span-2">
              <label class="text-[10px] uppercase text-slate-500">Subtitle</label>
              <input v-model="form.section_certificates_subtitle" type="text" v-bind="inputClass" />
            </div>
          </div>
        </div>
      </div>

      <!-- Section 3: Footer & Socials -->
      <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-xl">
        <div class="flex items-center gap-3 border-b border-slate-800 pb-4 mb-2 text-white">
          <span class="material-symbols-outlined text-[var(--accent-secondary)] text-xl">contact_page</span>
          <h2 class="text-lg font-semibold tracking-tight">Footer & Socials</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-4">
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Footer Name</label>
            <input v-model="form.site_footer_name" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Footer Copyright Text</label>
            <input v-model="form.site_footer_copyright" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Email URL / Mailto</label>
            <input v-model="form.social_email" type="text" v-bind="inputClass" />
          </div>
          <div class="space-y-1">
            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">LinkedIn / Link URL</label>
            <input v-model="form.social_link" type="text" v-bind="inputClass" />
          </div>
        </div>
      </div>

      <!-- Save Button -->
      <div class="flex items-center gap-4 pb-12">
        <button
          type="submit"
          :disabled="saving"
          class="flex items-center gap-2 px-6 py-3 rounded-xl bg-[var(--accent-primary)] text-white font-semibold text-sm hover:opacity-90 active:scale-[0.98] transition-all disabled:opacity-50 shadow-lg shadow-[var(--accent-primary)]/20"
        >
          <span v-if="saving" class="animate-spin material-symbols-outlined text-xl">progress_activity</span>
          <span class="material-symbols-outlined text-xl" v-else>save</span>
          {{ saving ? 'Saving Changes...' : 'Save Settings' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const page = usePage()
const saving = ref(false)
const pending = false

const inputClass = {
  class: 'w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] focus:ring-2 focus:ring-[var(--accent-primary)]/20 transition-all text-sm'
}

const form = ref({})

// Initialize form from props
watch(() => page.props.settings, (newSettings) => {
  if (newSettings) {
    form.value = { ...newSettings }
  }
}, { immediate: true, deep: true })

const saveSettings = () => {
  saving.value = true
  router.post('/admin/settings', { settings: form.value }, {
    onSuccess: () => {
      alert('Settings saved successfully!')
    },
    onError: () => {
      alert('Failed to save settings. Check console for details.')
    },
    onFinish: () => {
      saving.value = false
    }
  })
}
</script>
