<template>
  <div class="p-6 md:p-8 space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-white">Certificates</h1>
        <p class="text-slate-500 text-sm mt-0.5">Manage certifications & achievements</p>
      </div>
      <button @click="showAddModal = true" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 transition-opacity">
        <span class="material-symbols-outlined text-xl">add</span>
        Add Certificate
      </button>
    </div>

    <div v-if="pending" class="flex items-center justify-center py-20">
      <span class="animate-spin material-symbols-outlined text-4xl text-slate-600">progress_activity</span>
    </div>

    <div v-else-if="!certs?.length" class="flex flex-col items-center justify-center py-20 text-center space-y-3">
      <span class="material-symbols-outlined text-6xl text-slate-700">workspace_premium</span>
      <p class="text-slate-400 font-medium">No certificates yet</p>
    </div>

    <div v-else class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
      <div class="divide-y divide-slate-800">
        <div
          v-for="cert in certs"
          :key="cert.id"
          class="group flex items-center gap-4 px-5 py-4 hover:bg-slate-800/50 transition-colors"
        >
          <div class="w-10 h-10 rounded-xl bg-yellow-900/30 border border-yellow-800/50 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-xl text-yellow-400">workspace_premium</span>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-white font-semibold text-sm">{{ cert.name }}</p>
            <p class="text-slate-500 text-xs mt-0.5">{{ cert.organizer }} · {{ cert.duration }}</p>
          </div>
          <div class="flex items-center gap-1 transition-all">
            <a v-if="cert.link" :href="cert.link" target="_blank" class="text-slate-500 hover:text-[var(--accent-primary)] transition-all p-1">
              <span class="material-symbols-outlined text-xl">open_in_new</span>
            </a>
            <button @click="openEditModal(cert)" class="text-slate-500 hover:text-[var(--accent-primary)] transition-all p-1">
              <span class="material-symbols-outlined text-xl">edit_square</span>
            </button>
            <button @click="deleteCert(cert.id)" class="text-slate-500 hover:text-red-400 transition-all p-1">
              <span class="material-symbols-outlined text-xl">delete</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Modal -->
    <Teleport to="body">
      <Transition enter-active-class="transition duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div v-if="showAddModal" 
             class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm" 
             @mousedown="onBackdropMouseDown" 
             @mouseup="onBackdropMouseUp($event, 'add')">
          <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4">
            <h3 class="font-bold text-white text-lg">Add Certificate</h3>
            <div class="space-y-3">
              <input v-model="newCert.name" type="text" placeholder="Certificate name" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="newCert.organizer" type="text" placeholder="Organizer (e.g. Google)" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="newCert.duration" type="text" placeholder="Duration/Year (e.g. 2024)" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="newCert.link" type="url" placeholder="Credential URL (optional)" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
            </div>
            <div class="flex gap-3 pt-1">
              <button @click="showAddModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-400 text-sm font-semibold hover:bg-slate-800 transition-colors">Cancel</button>
              <button @click="addCert" :disabled="saving" class="flex-1 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 disabled:opacity-50 flex items-center justify-center gap-2">
                <span v-if="saving" class="animate-spin material-symbols-outlined text-base">progress_activity</span>
                Save
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Edit Modal -->
    <Teleport to="body">
      <Transition enter-active-class="transition duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div v-if="showEditModal" 
             class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm" 
             @mousedown="onBackdropMouseDown" 
             @mouseup="onBackdropMouseUp($event, 'edit')">
          <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4">
            <h3 class="font-bold text-white text-lg">Edit Certificate</h3>
            <div class="space-y-3">
              <input v-model="editingCert.name" type="text" placeholder="Certificate name" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="editingCert.organizer" type="text" placeholder="Organizer" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="editingCert.duration" type="text" placeholder="Duration/Year" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
              <input v-model="editingCert.link" type="url" placeholder="Credential URL" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
            </div>
            <div class="flex gap-3 pt-1">
              <button @click="showEditModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-400 text-sm font-semibold hover:bg-slate-800 transition-colors">Cancel</button>
              <button @click="updateCert" :disabled="saving" class="flex-1 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 disabled:opacity-50 flex items-center justify-center gap-2">
                <span v-if="saving" class="animate-spin material-symbols-outlined text-base">progress_activity</span>
                Update
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
  certs: Array
})

const showToast = inject('showToast')
const showAddModal = ref(false)
const showEditModal = ref(false)
const saving = ref(false)
const pending = false

// Prevent accidental modal close during text selection
let isBackdropMouseDown = false;
const onBackdropMouseDown = (e) => {
  isBackdropMouseDown = e.target === e.currentTarget;
};
const onBackdropMouseUp = (e, modalType) => {
  if (isBackdropMouseDown && e.target === e.currentTarget) {
    if (modalType === 'add') showAddModal.value = false;
    else showEditModal.value = false;
  }
  isBackdropMouseDown = false;
};

const newCert = ref({ name: '', organizer: '', duration: '', link: '' })
const editingCert = ref({ id: null, name: '', organizer: '', duration: '', link: '' })

const addCert = () => {
  if (!newCert.value.name) return
  saving.value = true
  router.post('/admin/certificates', newCert.value, {
    onSuccess: () => {
      showToast?.('Certificate added!')
      showAddModal.value = false
      newCert.value = { name: '', organizer: '', duration: '', link: '' }
    },
    onError: () => showToast?.('Failed to add certificate', 'error'),
    onFinish: () => saving.value = false
  })
}

const openEditModal = (cert) => {
  editingCert.value = { ...cert }
  showEditModal.value = true
}

const updateCert = () => {
  if (!editingCert.value.name) return
  saving.value = true
  router.put(`/admin/certificates/${editingCert.value.id}`, editingCert.value, {
    onSuccess: () => {
      showToast?.('Certificate updated!')
      showEditModal.value = false
    },
    onError: () => showToast?.('Failed to update certificate', 'error'),
    onFinish: () => saving.value = false
  })
}

const deleteCert = (id) => {
  if (!confirm('Delete this certificate?')) return
  router.delete(`/admin/certificates/${id}`, {
    onSuccess: () => showToast?.('Certificate deleted'),
    onError: () => showToast?.('Failed to delete', 'error')
  })
}
</script>
