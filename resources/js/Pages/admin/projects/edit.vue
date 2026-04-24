<template>
  <div class="p-6 md:p-8 max-w-3xl space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
      <Link href="/admin/projects" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
        <span class="material-symbols-outlined">arrow_back</span>
      </Link>
      <div>
        <h1 class="text-2xl font-bold text-white">Edit Project</h1>
        <p class="text-slate-500 text-sm mt-0.5">Update project details</p>
      </div>
    </div>

    <ProjectForm v-if="project" :initial-data="project" :loading="saving" @submit="handleUpdate" />
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ProjectForm from '@/Components/admin/ProjectForm.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  project: Object
})

const saving = ref(false)
const showToast = inject('showToast')

const handleUpdate = (payload) => {
  saving.value = true
  router.put(`/admin/projects/${props.project.id}`, payload, {
    onSuccess: () => {
      showToast?.('Project updated successfully!')
    },
    onError: () => {
      showToast?.('Failed to update project', 'error')
    },
    onFinish: () => {
      saving.value = false
    }
  })
}
</script>
