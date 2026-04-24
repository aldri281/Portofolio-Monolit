<template>
  <Head title="Aldri Hardiansyah | Data Engineer" />
  <div class="space-y-32">
    <HeroSection />
    <ProjectList />
    <SkillList />
    <CertificateList />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import ProjectList from '@/Components/ProjectList.vue';
import SkillList from '@/Components/SkillList.vue';
import CertificateList from '@/Components/CertificateList.vue';

defineOptions({ layout: DefaultLayout });
</script>
