<template>
  <div class="p-6 md:p-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-white">Projects</h1>
        <p class="text-slate-500 text-sm mt-0.5">Manage portfolio projects</p>
      </div>
      <Link
        href="/admin/projects/create"
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 transition-opacity shadow-lg shadow-[var(--accent-primary)]/20"
      >
        <span class="material-symbols-outlined text-xl">add</span>
        Add Project
      </Link>
    </div>

    <!-- Loading -->
    <div v-if="pending" class="flex items-center justify-center py-20">
      <span class="animate-spin material-symbols-outlined text-4xl text-slate-600">progress_activity</span>
    </div>

    <!-- Empty state -->
    <div v-else-if="!projects?.length" class="flex flex-col items-center justify-center py-20 text-center space-y-3">
      <span class="material-symbols-outlined text-6xl text-slate-700">folder_open</span>
      <p class="text-slate-400 font-medium">No projects yet</p>
      <Link href="/admin/projects/create" class="text-[var(--accent-primary)] text-sm hover:underline">Add your first project →</Link>
    </div>

    <!-- Table -->
    <div v-else class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-slate-800">
              <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Project</th>
              <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500 hidden md:table-cell">Stack</th>
              <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500 hidden lg:table-cell">Tools</th>
              <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-widest text-slate-500 hidden md:table-cell">Architecture</th>
              <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-widest text-slate-500">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800">
            <tr
              v-for="project in projects"
              :key="project.id"
              class="hover:bg-slate-800/50 transition-colors"
            >
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-lg text-[var(--accent-primary)]">{{ project.icon || 'folder' }}</span>
                  </div>
                  <div>
                    <p class="text-white font-semibold text-sm leading-tight">{{ project.title }}</p>
                    <p class="text-slate-500 text-xs mt-0.5 line-clamp-1 max-w-[200px]">{{ project.description }}</p>
                  </div>
                </div>
              </td>
              <td class="px-5 py-4 hidden md:table-cell">
                <span class="text-slate-400 text-xs font-mono">{{ project.datastack }}</span>
              </td>
              <td class="px-5 py-4 hidden lg:table-cell">
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="tool in (project.tools ?? []).slice(0, 3)"
                    :key="tool"
                    class="px-2 py-0.5 rounded-md bg-slate-800 text-slate-400 text-xs font-mono border border-slate-700"
                  >{{ tool }}</span>
                  <span v-if="(project.tools ?? []).length > 3" class="px-2 py-0.5 rounded-md bg-slate-800 text-slate-500 text-xs">
                    +{{ project.tools.length - 3 }}
                  </span>
                </div>
              </td>
              <td class="px-5 py-4 hidden md:table-cell">
                <span
                  :class="[
                    'inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold',
                    project.highlights
                      ? 'bg-green-900/40 border border-green-800 text-green-400'
                      : 'bg-slate-800 border border-slate-700 text-slate-500'
                  ]"
                >
                  <span class="material-symbols-outlined text-sm">{{ project.highlights ? 'check_circle' : 'radio_button_unchecked' }}</span>
                  {{ project.highlights ? 'Has Highlights' : 'None' }}
                </span>
              </td>
              <td class="px-5 py-4">
                <div class="flex items-center justify-end gap-2">
                  <Link
                    :href="`/admin/projects/${project.id}/edit`"
                    class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-slate-700 transition-all"
                    title="Edit"
                  >
                    <span class="material-symbols-outlined text-xl">edit</span>
                  </Link>
                  <button
                    @click="confirmDelete(project)"
                    class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-red-400 hover:bg-red-900/20 transition-all"
                    title="Delete"
                  >
                    <span class="material-symbols-outlined text-xl">delete</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Delete Confirm Modal -->
    <Teleport to="body">
      <Transition enter-active-class="transition duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div v-if="deleteModal.show" class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm" @click.self="deleteModal.show = false">
          <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="w-12 h-12 rounded-2xl bg-red-900/40 border border-red-800 flex items-center justify-center mb-4">
              <span class="material-symbols-outlined text-red-400 text-2xl">delete_forever</span>
            </div>
            <h3 class="font-bold text-white text-lg mb-1">Delete Project?</h3>
            <p class="text-slate-400 text-sm mb-5">
              "<strong class="text-white">{{ deleteModal.project?.title }}</strong>" will be permanently deleted. This cannot be undone.
            </p>
            <div class="flex gap-3">
              <button @click="deleteModal.show = false" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-400 text-sm font-semibold hover:bg-slate-800 transition-colors">
                Cancel
              </button>
              <button @click="executeDelete" :disabled="deleteModal.loading" class="flex-1 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-500 transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                <span v-if="deleteModal.loading" class="animate-spin material-symbols-outlined text-base">progress_activity</span>
                Delete
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
import { Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  projects: Array
})

const showToast = inject('showToast')

const deleteModal = ref({
  show: false, project: null, loading: false,
})

const pending = false

const confirmDelete = (project) => {
  deleteModal.value = { show: true, project, loading: false }
}

const executeDelete = () => {
  if (!deleteModal.value.project) return
  deleteModal.value.loading = true
  router.delete(`/admin/projects/${deleteModal.value.project.id}`, {
    onSuccess: () => {
      showToast?.('Project deleted successfully')
      deleteModal.value.show = false
    },
    onError: () => showToast?.('Failed to delete project', 'error'),
    onFinish: () => deleteModal.value.loading = false
  })
}
</script>
