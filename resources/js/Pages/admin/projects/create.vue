<template>
  <div class="p-6 md:p-8 max-w-3xl space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
      <Link href="/admin/projects" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
        <span class="material-symbols-outlined">arrow_back</span>
      </Link>
      <div>
        <h1 class="text-2xl font-bold text-white">Add New Project</h1>
        <p class="text-slate-500 text-sm mt-0.5">Create a new portfolio project</p>
      </div>
    </div>

    <ProjectForm :loading="loading" @submit="handleSubmit" />
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ProjectForm from '@/Components/admin/ProjectForm.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const loading = ref(false)
const showToast = inject('showToast')

const handleSubmit = (payload) => {
  loading.value = true
  router.post('/admin/projects', payload, {
    onSuccess: () => {
      showToast?.('Project created successfully!')
    },
    onError: () => {
      showToast?.('Failed to create project', 'error')
    },
    onFinish: () => {
      loading.value = false
    }
  })
}
</script>
