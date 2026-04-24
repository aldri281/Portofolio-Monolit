<template>
  <div class="p-6 md:p-8 space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-white">Skills</h1>
        <p class="text-slate-500 text-sm mt-0.5">Manage technical skills</p>
      </div>
      <button @click="showAddModal = true" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 transition-opacity">
        <span class="material-symbols-outlined text-xl">add</span>
        Add Skill
      </button>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <span class="animate-spin material-symbols-outlined text-4xl text-slate-600">progress_activity</span>
    </div>

    <div v-else-if="!skills?.length" class="flex flex-col items-center justify-center py-20 text-center space-y-3">
      <span class="material-symbols-outlined text-6xl text-slate-700">code</span>
      <p class="text-slate-400 font-medium">No skills yet</p>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <div
        v-for="skill in skills"
        :key="skill.id"
        class="group bg-slate-900 border border-slate-800 rounded-2xl p-5 flex items-start gap-4 hover:border-slate-700 transition-all"
      >
        <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center flex-shrink-0">
          <span class="material-symbols-outlined text-xl text-[var(--accent-primary)]">{{ skill.icon || 'code' }}</span>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-white font-semibold truncate">{{ skill.name }}</p>
          <p class="text-slate-500 text-xs mt-0.5">{{ skill.category }}</p>
        </div>
        <button @click="deleteSkill(skill.id)" class="opacity-0 group-hover:opacity-100 text-slate-600 hover:text-red-400 transition-all">
          <span class="material-symbols-outlined text-xl">delete</span>
        </button>
      </div>
    </div>

    <!-- Add Modal -->
    <Teleport to="body">
      <Transition enter-active-class="transition duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div v-if="showAddModal" class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm" @click.self="showAddModal = false">
          <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4">
            <h3 class="font-bold text-white text-lg">Add Skill</h3>

            <div class="space-y-3">
              <input v-model="newSkill.name" type="text" placeholder="Skill name (e.g. PostgreSQL)" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="newSkill.category" type="text" placeholder="Category (e.g. Database)" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <div class="relative">
                <input v-model="newSkill.icon" type="text" placeholder="Icon (e.g. storage)" class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                  <span class="material-symbols-outlined text-xl text-[var(--accent-primary)]">{{ newSkill.icon || 'help' }}</span>
                </div>
              </div>
            </div>

            <div class="flex gap-3 pt-1">
              <button @click="showAddModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-400 text-sm font-semibold hover:bg-slate-800 transition-colors">Cancel</button>
              <button @click="addSkill" :disabled="saving" class="flex-1 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                <span v-if="saving" class="animate-spin material-symbols-outlined text-base">progress_activity</span>
                Save
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  skills: Array
})

const showToast = inject('showToast')
const showAddModal = ref(false)
const saving = ref(false)
const pending = false

const newSkill = ref({ name: '', category: '', icon: '' })

const addSkill = () => {
  if (!newSkill.value.name) return
  saving.value = true
  router.post('/admin/skills', newSkill.value, {
    onSuccess: () => {
      showToast?.('Skill added!')
      showAddModal.value = false
      newSkill.value = { name: '', category: '', icon: '' }
    },
    onError: () => showToast?.('Failed to add skill', 'error'),
    onFinish: () => saving.value = false
  })
}

const deleteSkill = (id) => {
  if (!confirm('Delete this skill?')) return
  router.delete(`/admin/skills/${id}`, {
    onSuccess: () => showToast?.('Skill deleted'),
    onError: () => showToast?.('Failed to delete', 'error')
  })
}
</script>
