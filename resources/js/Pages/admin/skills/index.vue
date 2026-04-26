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
        <div class="flex items-center gap-1 transition-all">
          <button @click="openEditModal(skill)" class="text-slate-500 hover:text-[var(--accent-primary)] transition-all p-1">
            <span class="material-symbols-outlined text-xl">edit_square</span>
          </button>
          <button @click="deleteSkill(skill.id)" class="text-slate-500 hover:text-red-400 transition-all p-1">
            <span class="material-symbols-outlined text-xl">delete</span>
          </button>
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
            <h3 class="font-bold text-white text-lg">Add Skill</h3>

            <div class="space-y-3 relative z-50">
              <div class="relative">
                <input v-model="newSkill.name" @focus="showSuggestionsAdd = true" @blur="hideSuggestions('add')" type="text" placeholder="Skill name (e.g. PostgreSQL)" class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 rounded-lg bg-slate-900 border border-slate-700 shadow-inner">
                  <img v-if="newSkill.name && !previewErrorAdd" :src="getIconUrl(newSkill.name)" @error="previewErrorAdd = true" @load="previewErrorAdd = false" class="w-5 h-5 object-contain filter grayscale" />
                  <span v-else class="material-symbols-outlined text-sm text-slate-500">image</span>
                </div>
                <!-- Suggestions Add -->
                <div v-if="showSuggestionsAdd && filteredSuggestionsAdd.length > 0" class="absolute z-[100] w-full mt-2 bg-slate-800 border border-slate-700 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                  <button v-for="s in filteredSuggestionsAdd" :key="s" @click.prevent="selectSuggestionAdd(s)" class="w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-[var(--accent-primary)] hover:text-white transition-colors border-b border-slate-700/50 last:border-0">
                    {{ s }}
                  </button>
                </div>
              </div>
              <input v-model="newSkill.category" type="text" placeholder="Category (e.g. Database)" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm relative z-40" />
              <div class="relative z-30">
                <input v-model="newSkill.icon" type="text" placeholder="Material Icon (e.g. storage)" class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
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

    <!-- Edit Modal -->
    <Teleport to="body">
      <Transition enter-active-class="transition duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100">
        <div v-if="showEditModal" 
             class="fixed inset-0 z-[300] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-sm" 
             @mousedown="onBackdropMouseDown" 
             @mouseup="onBackdropMouseUp($event, 'edit')">
          <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4">
            <h3 class="font-bold text-white text-lg">Edit Skill</h3>

            <div class="space-y-3 relative z-50">
              <div class="relative">
                <input v-model="editingSkill.name" @focus="showSuggestionsEdit = true" @blur="hideSuggestions('edit')" type="text" placeholder="Skill name" class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 rounded-lg bg-slate-900 border border-slate-700 shadow-inner">
                  <img v-if="editingSkill.name && !previewErrorEdit" :src="getIconUrl(editingSkill.name)" @error="previewErrorEdit = true" @load="previewErrorEdit = false" class="w-5 h-5 object-contain filter grayscale" />
                  <span v-else class="material-symbols-outlined text-sm text-slate-500">image</span>
                </div>
                <!-- Suggestions Edit -->
                <div v-if="showSuggestionsEdit && filteredSuggestionsEdit.length > 0" class="absolute z-[100] w-full mt-2 bg-slate-800 border border-slate-700 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                  <button v-for="s in filteredSuggestionsEdit" :key="s" @click.prevent="selectSuggestionEdit(s)" class="w-full text-left px-4 py-2.5 text-sm text-slate-300 hover:bg-[var(--accent-primary)] hover:text-white transition-colors border-b border-slate-700/50 last:border-0">
                    {{ s }}
                  </button>
                </div>
              </div>
              <input v-model="editingSkill.category" type="text" placeholder="Category" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm relative z-40" />
              <div class="relative z-30">
                <input v-model="editingSkill.icon" type="text" placeholder="Material Icon" class="w-full px-4 py-3 pr-12 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-600 focus:outline-none focus:border-[var(--accent-primary)] text-sm" />
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                  <span class="material-symbols-outlined text-xl text-[var(--accent-primary)]">{{ editingSkill.icon || 'help' }}</span>
                </div>
              </div>
            </div>

            <div class="flex gap-3 pt-1">
              <button @click="showEditModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-400 text-sm font-semibold hover:bg-slate-800 transition-colors">Cancel</button>
              <button @click="updateSkill" :disabled="saving" class="flex-1 py-2.5 rounded-xl bg-[var(--accent-primary)] text-white text-sm font-semibold hover:opacity-90 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
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
import { ref, inject, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  skills: Array
})

const showToast = inject('showToast')
const showAddModal = ref(false)
const showEditModal = ref(false)
const saving = ref(false)
const pending = false

const newSkill = ref({ name: '', category: '', icon: '' })
const editingSkill = ref({ id: null, name: '', category: '', icon: '' })

// Suggestions Logic
const commonTools = [
  // Data Engineering & Science
  'Python', 'R', 'Jupyter', 'Pandas', 'NumPy', 'Scikit-learn', 'TensorFlow', 'PyTorch', 'Apache Spark', 'Apache Kafka', 'Apache Hadoop', 'Apache Airflow', 'Snowflake', 'Databricks', 'Tableau', 'Power BI', 'Looker', 'Google BigQuery', 'Amazon Redshift', 'dbt',
  // Databases
  'PostgreSQL', 'MySQL', 'SQLite', 'MariaDB', 'MongoDB', 'Redis', 'Cassandra', 'Elasticsearch', 'Firebase', 'Supabase', 'PlanetScale', 'Couchbase', 'Neo4j', 'Oracle', 'Microsoft SQL Server',
  // GIS
  'QGIS', 'ArcGIS', 'Esri', 'OpenStreetMap', 'Mapbox', 'Leaflet', 'PostGIS', 'Google Earth',
  // Programming Languages
  'HTML5', 'CSS3', 'JavaScript', 'TypeScript', 'PHP', 'Ruby', 'Go', 'Rust', 'C', 'C++', 'C#', 'Java', 'Kotlin', 'Swift', 'Dart', 'Scala', 'Haskell', 'Lua', 'Perl',
  // Frameworks & Libraries
  'Vue.js', 'React', 'Angular', 'Svelte', 'Next.js', 'Nuxt.js', 'Vite', 'Webpack', 'Tailwind CSS', 'Bootstrap', 'Sass', 'Node.js', 'Express', 'NestJS', 'Laravel', 'Symfony', 'Django', 'Flask', 'FastAPI', 'Spring Boot', 'ASP.NET', 'GraphQL', 'Apollo GraphQL', 'jQuery', 'Redux', 'Prisma', 'Drizzle ORM',
  // Cloud & DevOps
  'Docker', 'Kubernetes', 'AWS', 'Microsoft Azure', 'Google Cloud', 'Vercel', 'Netlify', 'Heroku', 'DigitalOcean', 'Cloudflare', 'Terraform', 'GitHub Actions', 'GitLab CI', 'CircleCI', 'Jenkins', 'Ansible', 'Prometheus', 'Grafana',
  // Design & Office
  'Figma', 'Adobe Photoshop', 'Adobe Illustrator', 'Adobe Premiere Pro', 'Adobe After Effects', 'Canva', 'Notion', 'Microsoft Office', 'Microsoft Excel', 'Microsoft Word', 'Microsoft PowerPoint', 'Slack', 'Discord', 'Trello', 'Asana', 'Jira',
  // Version Control & Editor
  'Git', 'GitHub', 'GitLab', 'Bitbucket', 'Visual Studio Code', 'IntelliJ IDEA', 'PyCharm', 'WebStorm', 'Android Studio', 'Xcode', 'Vim', 'Neovim', 'Sublime Text'
];

const showSuggestionsAdd = ref(false)
const showSuggestionsEdit = ref(false)
const previewErrorAdd = ref(false)
const previewErrorEdit = ref(false)

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

const filteredSuggestionsAdd = computed(() => {
  if (!newSkill.value.name) return commonTools;
  return commonTools.filter(t => t.toLowerCase().includes(newSkill.value.name.toLowerCase()) && t.toLowerCase() !== newSkill.value.name.toLowerCase());
});

const filteredSuggestionsEdit = computed(() => {
  if (!editingSkill.value.name) return commonTools;
  return commonTools.filter(t => t.toLowerCase().includes(editingSkill.value.name.toLowerCase()) && t.toLowerCase() !== editingSkill.value.name.toLowerCase());
});

const selectSuggestionAdd = (s) => {
  newSkill.value.name = s;
  showSuggestionsAdd.value = false;
  previewErrorAdd.value = false;
};

const selectSuggestionEdit = (s) => {
  editingSkill.value.name = s;
  showSuggestionsEdit.value = false;
  previewErrorEdit.value = false;
};

const hideSuggestions = (type) => {
  setTimeout(() => {
    if (type === 'add') showSuggestionsAdd.value = false;
    if (type === 'edit') showSuggestionsEdit.value = false;
  }, 200);
};

const getIconUrl = (name) => {
  if (!name) return '';
  
  // Map standard titles to Simple Icons slugs
  let slug = name.toLowerCase()
    .replace(/\+/g, 'plus')
    .replace(/\#/g, 'sharp')
    .replace(/\./g, 'dot')
    .replace(/[^a-z0-9]/g, '');

  // Handle specific overrides where the above logic isn't perfect
  const overrides = {
    'vuejs': 'vuedotjs',
    'nodejs': 'nodedotjs',
    'nextjs': 'nextdotjs',
    'nuxtjs': 'nuxtdotjs',
    'd3js': 'd3dotjs',
    'googleearth': 'googleearth',
    'googlecloud': 'googlecloud',
    'microsoftoffice': 'microsoftoffice',
    'microsoftexcel': 'microsoftexcel',
    'microsoftword': 'microsoftword',
    'microsoftpowerpoint': 'microsoftpowerpoint',
    'aws': 'amazonwebservices',
    'amazonwebservices': 'amazonwebservices',
    'amazons3': 'amazons3',
    'cplusplus': 'cplusplus',
    'csharp': 'csharp',
    'dotnet': 'dotnet',
  };

  return `https://cdn.simpleicons.org/${overrides[slug] || slug}`;
};

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

const openEditModal = (skill) => {
  editingSkill.value = { ...skill }
  showEditModal.value = true
}

const updateSkill = () => {
  if (!editingSkill.value.name) return
  saving.value = true
  router.put(`/admin/skills/${editingSkill.value.id}`, editingSkill.value, {
    onSuccess: () => {
      showToast?.('Skill updated!')
      showEditModal.value = false
    },
    onError: () => showToast?.('Failed to update skill', 'error'),
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
