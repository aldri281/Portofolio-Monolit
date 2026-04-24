<template>
  <section class="py-24 space-y-20 scroll-mt-32" id="projects">
    <div class="text-center max-w-3xl mx-auto space-y-6">
      <h2 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight">{{ settings?.section_projects_title || 'Featured Architecture' }}</h2>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 font-light">{{ settings?.section_projects_subtitle || 'Deep dives into enterprise-scale data infrastructure and business logic engineering.' }}</p>
    </div>

    <!-- Fallback/Loading State -->
    <div v-if="pending" class="text-center py-10 text-slate-500">
      Loading projects...
    </div>

    <div v-else-if="error" class="text-center py-10 text-red-500">
      Failed to load projects. Please try again later.
    </div>

    <!-- Dynamic Projects List -->
    <div v-else>
      <div v-for="(project, index) in projects" :key="project.id" class="mb-20 bg-white dark:bg-slate-900 soft-radius shadow-2xl shadow-slate-100 dark:shadow-slate-900/50 border border-slate-50 dark:border-slate-800 overflow-hidden group transition-colors duration-300">
        <div class="grid md:grid-cols-2 gap-0">
          <div :class="['p-8 md:p-16 space-y-8 flex flex-col justify-center transition-colors duration-300', index % 2 === 0 ? 'bg-slate-50/50 dark:bg-slate-800/50 border-r border-slate-100 dark:border-slate-800 order-1 md:order-1' : 'bg-white dark:bg-slate-900 order-1 md:order-2']">
            <div :class="['w-14 h-14 rounded-2xl border flex items-center justify-center transition-colors duration-300 border-slate-100 dark:border-slate-700', index % 2 === 0 ? 'bg-white dark:bg-slate-800 text-accent-primary shadow-sm' : 'bg-slate-50 dark:bg-slate-800 text-accent-tertiary']">
              <span class="material-symbols-outlined text-3xl">{{ project.icon || 'dns' }}</span>
            </div>
            <div class="space-y-2">
              <h3 class="text-2xl md:text-4xl font-bold text-slate-900 dark:text-white">{{ project.title }}</h3>
              <p class="text-xl font-semibold mt-2" :class="index % 2 === 0 ? 'text-accent-primary' : 'text-accent-tertiary'">{{ project.datastack }}</p>
            </div>
            <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed font-light">
              {{ project.description }}
            </p>
            <ul class="space-y-4 pt-4 text-slate-600 dark:text-slate-400">
              <li class="flex items-start gap-4" v-if="project.tools && project.tools.length > 0">
                <span class="material-symbols-outlined text-2xl" :class="index % 2 === 0 ? 'text-accent-primary' : 'text-accent-tertiary'">check_circle</span>
                <span class="text-lg"><strong class="text-slate-900 dark:text-white font-semibold">Tools:</strong> {{ project.tools.join(', ') }}</span>
              </li>
              <li class="flex items-start gap-4" v-if="project.repo_link">
                 <span class="material-symbols-outlined text-2xl" :class="index % 2 === 0 ? 'text-accent-primary' : 'text-accent-tertiary'">link</span>
                 <a :href="project.repo_link" target="_blank" class="text-lg hover:underline"><strong class="text-slate-900 dark:text-white font-semibold">Repository</strong></a>
              </li>
               <li class="flex items-start gap-4" v-if="project.demo_link">
                 <span class="material-symbols-outlined text-2xl" :class="index % 2 === 0 ? 'text-accent-primary' : 'text-accent-tertiary'">open_in_new</span>
                 <a :href="project.demo_link" target="_blank" class="text-lg hover:underline"><strong class="text-slate-900 dark:text-white font-semibold">Live Demo</strong></a>
              </li>
            </ul>
            <!-- View Architecture Button (only if highlights exist) -->
            <div v-if="project.highlights" class="pt-2">
              <button
                @click="openDetailPanel(project)"
                :class="['group/btn flex items-center gap-3 px-5 py-3 rounded-2xl border-2 font-semibold text-sm transition-all hover:scale-105 active:scale-95', index % 2 === 0 ? 'border-accent-primary text-accent-primary hover:bg-accent-primary hover:text-white' : 'border-accent-tertiary text-accent-tertiary hover:bg-accent-tertiary hover:text-white']"
              >
                <span class="material-symbols-outlined text-xl transition-transform group-hover/btn:rotate-12">account_tree</span>
                View Architecture
                <span class="material-symbols-outlined text-base opacity-50">arrow_forward</span>
              </button>
            </div>
          </div>

          <!-- Graphic/Gallery Section -->
          <div :class="['flex items-center justify-center min-h-[500px] transition-colors duration-300 overflow-hidden', index % 2 === 0 ? 'bg-slate-900 dark:bg-slate-950 order-2 md:order-2' : 'bg-slate-50/50 dark:bg-slate-800/50 border-r border-slate-100 dark:border-slate-800 order-2 md:order-1']">
            
            <!-- Multiple Images Gallery with CSS Scroll Snap -->
            <div v-if="project.images && project.images.length > 0" class="relative group/gallery w-full h-full min-h-[300px] md:min-h-[500px]">
                <div :id="'gallery-' + project.id" class="w-full h-full flex overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbars gap-0" @scroll="handleGalleryScroll(project.id)" @mouseenter="pauseAutoSlide" @mouseleave="resumeAutoSlide">
                    <div v-for="(img, imgIndex) in project.images" :key="img.id" class="snap-center shrink-0 w-full h-full relative cursor-pointer overflow-hidden" @click="openLightbox(project, imgIndex)">
                       <img 
                        :src="formatDriveUrl(img.image_url)" 
                        :alt="project.title" 
                        class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" 
                        loading="lazy" 
                        referrerpolicy="no-referrer"
                       />
                       <!-- Overlay gradient -->
                       <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-40 pointer-events-none"></div>
                    </div>
                </div>

                <!-- Navigation Arrows (High Contrast Glass) -->
                <div v-if="project.images.length > 1" class="absolute inset-x-2 inset-y-0 flex items-center justify-between pointer-events-none z-20">
                    <button 
                        @click.stop="scrollGallery('gallery-' + project.id, -1)"
                        class="pointer-events-auto w-12 h-12 flex items-center justify-center rounded-full bg-black/40 backdrop-blur-md text-white opacity-0 group-hover/gallery:opacity-100 transition-all hover:scale-110 hover:bg-black/60 active:scale-95 border border-white/20 shadow-lg"
                    >
                        <span class="material-symbols-outlined text-3xl">chevron_left</span>
                    </button>
                    <button 
                        @click.stop="scrollGallery('gallery-' + project.id, 1)"
                        class="pointer-events-auto w-12 h-12 flex items-center justify-center rounded-full bg-black/40 backdrop-blur-md text-white opacity-0 group-hover/gallery:opacity-100 transition-all hover:scale-110 hover:bg-black/60 active:scale-95 border border-white/20 shadow-lg"
                    >
                        <span class="material-symbols-outlined text-3xl">chevron_right</span>
                    </button>
                </div>

                <!-- Navigation Dots -->
                <div v-if="project.images.length > 1" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10 px-3 py-1.5 bg-black/30 backdrop-blur-md rounded-full border border-white/10 shadow-lg" @mouseenter="pauseAutoSlide" @mouseleave="resumeAutoSlide">
                    <div 
                        v-for="(_, i) in project.images" 
                        :key="i"
                        class="h-1.5 rounded-full transition-all duration-300 shadow-sm cursor-pointer"
                        :style="{ width: i === (activeImageIndices[project.id] || 0) ? '20px' : '6px' }"
                        :class="i === (activeImageIndices[project.id] || 0) ? 'bg-white' : 'bg-white/40 hover:bg-white/60'" 
                        @click="scrollToImage('gallery-' + project.id, i)"
                    ></div>
                </div>
            </div>

            <!-- Generic placeholder graphic for projects without image -->
             <div v-else class="w-full h-full soft-radius border bg-white dark:bg-slate-800 p-10 flex flex-col gap-8 font-mono text-sm shadow-sm transition-colors duration-300" :class="index % 2 === 0 ? 'border-white/10 dark:border-slate-700 bg-slate-900/50 shadow-inner text-slate-400' : 'border-slate-200 dark:border-slate-700'">
                 <div class="flex justify-between items-center pb-4 border-b" :class="index % 2 === 0 ? 'border-white/5 dark:border-slate-700' : 'border-slate-50 dark:border-slate-700 text-slate-400'">
                   <span class="uppercase tracking-widest text-xs">System Architecture</span>
                   <span class="material-symbols-outlined text-lg">settings_b_roll</span>
                 </div>
                 
                 <!-- Generic abstract representation -->
                <div class="flex-1 flex flex-col items-center justify-center gap-6 text-center">
                    <div class="p-5 rounded-xl border w-full md:w-auto shadow-lg transition-colors duration-300" :class="index % 2 === 0 ? 'bg-slate-900/80 dark:bg-slate-900 text-[var(--accent-segment)] border-[var(--accent-secondary)]/30 shadow-[var(--accent-secondary)]/5' : 'bg-white dark:bg-slate-900 text-[var(--accent-primary)] border-slate-100 dark:border-slate-800 shadow-sm'">Database Layer</div>
                    <span class="material-symbols-outlined text-slate-600">arrow_downward</span>
                    <div class="p-6 rounded-2xl border font-bold w-full max-w-xs text-center shadow-lg transition-colors duration-300" :class="index % 2 === 0 ? 'bg-slate-900/80 dark:bg-slate-900 text-[var(--accent-primary)] border-[var(--accent-primary)]/30 shadow-[var(--accent-primary)]/5' : 'bg-slate-50 dark:bg-slate-900 text-[var(--accent-primary)] border-[var(--accent-primary)]/20 shadow-[var(--accent-primary)]/5'">Data Transformation & Logic</div>
                     <span class="material-symbols-outlined text-slate-600">arrow_downward</span>
                     <div class="p-5 rounded-xl border w-full md:w-auto shadow-lg transition-colors duration-300" :class="index % 2 === 0 ? 'bg-slate-900/80 dark:bg-slate-900 text-[var(--accent-tertiary)] border-[var(--accent-tertiary)]/30 shadow-[var(--accent-tertiary)]/5' : 'bg-white dark:bg-slate-900 text-[var(--accent-secondary)] border-slate-100 dark:border-slate-800 shadow-sm'">Visualization / API</div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Lightbox Modal -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="lightbox.isOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10 bg-slate-950/95 backdrop-blur-3xl select-none" @click.self="closeLightbox">
          
          <!-- Header/Controls -->
          <div class="absolute top-0 inset-x-0 p-6 flex items-center justify-between z-[110] bg-gradient-to-b from-black/50 to-transparent">
            <div class="text-white/90">
                <p class="text-sm font-mono opacity-60">FEATURED ARCHITECTURE</p>
                <h4 class="text-lg font-bold">{{ lightbox.project?.title }}</h4>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Zoom Controls -->
                <div class="flex items-center bg-white/10 rounded-full p-1 backdrop-blur-md border border-white/10">
                    <button @click="adjustZoom(-0.5)" class="w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded-full text-white transition-colors" title="Zoom Out">
                        <span class="material-symbols-outlined">zoom_out</span>
                    </button>
                    <span class="px-2 text-white font-mono text-sm min-w-[3rem] text-center">{{ Math.round(lightbox.zoom * 100) }}%</span>
                    <button @click="adjustZoom(0.5)" class="w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded-full text-white transition-colors" title="Zoom In">
                        <span class="material-symbols-outlined">zoom_in</span>
                    </button>
                </div>

                <button 
                  @click="closeLightbox" 
                  class="w-12 h-12 flex items-center justify-center text-white/70 hover:text-white transition-colors rounded-full bg-white/10 hover:bg-white/20"
                >
                  <span class="material-symbols-outlined text-3xl">close</span>
                </button>
            </div>
          </div>
          
          <!-- Navigation Arrows -->
          <div v-if="lightbox.project && lightbox.project.images.length > 1" class="absolute inset-x-0 flex items-center justify-between px-4 md:px-10 z-[105] pointer-events-none">
            <button 
                @click="navigateLightbox(-1)"
                class="pointer-events-auto w-14 h-14 flex items-center justify-center rounded-full bg-white/5 backdrop-blur-md text-white border border-white/5 hover:bg-white/10 transition-all hover:scale-110"
            >
                <span class="material-symbols-outlined text-3xl">chevron_left</span>
            </button>
            <button 
                @click="navigateLightbox(1)"
                class="pointer-events-auto w-14 h-14 flex items-center justify-center rounded-full bg-white/5 backdrop-blur-md text-white border border-white/5 hover:bg-white/10 transition-all hover:scale-110"
            >
                <span class="material-symbols-outlined text-3xl">chevron_right</span>
            </button>
          </div>

          <!-- Image Container -->
          <div 
            class="relative w-full h-full flex items-center justify-center overflow-hidden"
            @mousemove="moveDrag"
            @mouseup="stopDrag"
            @mouseleave="stopDrag"
            @wheel.prevent="handleWheelZoom"
          >
            <img 
              v-if="lightbox.project && lightbox.project.images[lightbox.index]"
              :src="formatDriveUrl(lightbox.project?.images[lightbox.index]?.image_url || '')" 
              class="max-w-full max-h-full object-contain transition-transform duration-300 ease-out shadow-[0_0_100px_rgba(0,0,0,0.5)]"
              :class="lightbox.zoom > 1 ? 'cursor-move' : 'cursor-zoom-in'"
              :style="{ 
                transform: `scale(${lightbox.zoom}) translate(${lightbox.offsetX / lightbox.zoom}px, ${lightbox.offsetY / lightbox.zoom}px)` 
              }"
              alt="Full view"
              referrerpolicy="no-referrer"
              @mousedown="startDrag"
              @dblclick="handleDoubleClick"
              @dragstart.prevent
            />
          </div>

          <!-- Footer/Counter -->
          <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/60">
            <p class="text-sm font-mono">{{ lightbox.index + 1 }} / {{ lightbox.project?.images.length }}</p>
            <div class="flex gap-1.5">
                <div v-for="(_, i) in lightbox.project?.images" :key="i" 
                  class="h-1 rounded-full transition-all duration-300"
                  :class="i === lightbox.index ? 'w-8 bg-white' : 'w-2 bg-white/20'"
                ></div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Architecture Detail Panel -->
    <ProjectDetailPanel
      :is-open="detailPanel.isOpen"
      :project="detailPanel.project"
      @close="closeDetailPanel"
    />
  </section>
</template>

<style scoped>
/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scrollbars::-webkit-scrollbar {
  display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.hide-scrollbars {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ProjectDetailPanel from '@/Components/ProjectDetailPanel.vue'

const page = usePage()
const settings = computed(() => page.props.settings || {})

// Lightbox State
const lightbox = ref({
  isOpen: false,
  project: null as Project | null,
  index: 0,
  zoom: 1,
  offsetX: 0,
  offsetY: 0,
  isDragging: false,
  dragStart: { x: 0, y: 0 }
})

/**
 * Opens the lightbox for a specific project and image index
 */
const openLightbox = (project: Project, index: number) => {
  lightbox.value = {
    ...lightbox.value,
    isOpen: true,
    project,
    index,
    zoom: 1,
    offsetX: 0,
    offsetY: 0
  }
  // Disable scroll when lightbox is open
  document.body.style.overflow = 'hidden'
}

/**
 * Closes the lightbox
 */
const closeLightbox = () => {
  lightbox.value.isOpen = false
  lightbox.value.zoom = 1
  lightbox.value.offsetX = 0
  lightbox.value.offsetY = 0
  document.body.style.overflow = 'auto'
}

/**
 * Navigates to next/prev image in lightbox
 */
const navigateLightbox = (direction: number) => {
  if (!lightbox.value.project) return
  
  const total = lightbox.value.project.images.length
  lightbox.value.index = (lightbox.value.index + direction + total) % total
  lightbox.value.zoom = 1 // Reset zoom on navigate
  lightbox.value.offsetX = 0
  lightbox.value.offsetY = 0
}

/**
 * Handles zooming
 */
const adjustZoom = (delta: number) => {
  const newZoom = Math.min(Math.max(lightbox.value.zoom + delta, 1), 5)
  if (newZoom === 1) {
    lightbox.value.offsetX = 0
    lightbox.value.offsetY = 0
  }
  lightbox.value.zoom = newZoom
}

/**
 * Handles zooming via mouse wheel or trackpad pinch
 */
const handleWheelZoom = (e: WheelEvent) => {
  if (!lightbox.value.isOpen) return
  
  // Use a smaller adjustment factor for smoother wheel zoom
  const zoomFactor = e.deltaY < 0 ? 0.15 : -0.15;
  adjustZoom(zoomFactor)
}

/**
 * Handles double-click to zoom dynamically where the user clicked
 */
const handleDoubleClick = (e: MouseEvent) => {
  if (!lightbox.value.isOpen) return
  
  if (lightbox.value.zoom > 1) {
    // Zoom out completely
    lightbox.value.zoom = 1
    lightbox.value.offsetX = 0
    lightbox.value.offsetY = 0
  } else {
    // Target zoom level
    const newZoom = 2.5
    
    // Get the image element and its bounding rect
    const target = e.target as HTMLElement
    const rect = target.getBoundingClientRect()
    
    // Calculate click position relative to the center of the image on screen
    const clickX = e.clientX - (rect.left + rect.width / 2)
    const clickY = e.clientY - (rect.top + rect.height / 2)
    
    // Calculate offsets so the clicked point stays stationary
    lightbox.value.offsetX = clickX * (1 - newZoom)
    lightbox.value.offsetY = clickY * (1 - newZoom)
    
    // Apply zoom
    lightbox.value.zoom = newZoom
  }
}

/**
 * Drag to pan logic
 */
const startDrag = (e: MouseEvent) => {
  if (lightbox.value.zoom <= 1) return
  lightbox.value.isDragging = true
  lightbox.value.dragStart = {
    x: e.clientX - lightbox.value.offsetX,
    y: e.clientY - lightbox.value.offsetY
  }
}

const moveDrag = (e: MouseEvent) => {
  if (!lightbox.value.isDragging) return
  lightbox.value.offsetX = e.clientX - lightbox.value.dragStart.x
  lightbox.value.offsetY = e.clientY - lightbox.value.dragStart.y
}

const stopDrag = () => {
  lightbox.value.isDragging = false
}

// Keyboard shortcuts
const handleKeyDown = (e: KeyboardEvent) => {
  if (!lightbox.value.isOpen) return
  
  if (e.key === 'ArrowLeft') navigateLightbox(-1)
  if (e.key === 'ArrowRight') navigateLightbox(1)
  if (e.key === 'Escape') closeLightbox()
  if (e.key === '+' || e.key === '=') adjustZoom(0.5)
  if (e.key === '-') adjustZoom(-0.5)
}

import { onMounted, onUnmounted } from 'vue'
onMounted(() => {
  window.addEventListener('keydown', handleKeyDown)
  startAutoSlide()
})
onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown)
  stopAutoSlide()
})

interface ProjectImage {
  id: number;
  image_url: string;
  is_primary: boolean;
  order: number;
}

interface Project {
  id: number;
  title: string;
  description: string;
  datastack: string;
  icon: string | null;
  tools: string[];
  images: ProjectImage[];
  highlights: Record<string, unknown> | null;
  repo_link: string | null;
  demo_link: string | null;
}

// Detail Panel State
const detailPanel = ref<{ isOpen: boolean; project: Project | null }>({
  isOpen: false,
  project: null,
})

const openDetailPanel = (project: Project) => {
  detailPanel.value = { isOpen: true, project }
}

const closeDetailPanel = () => {
  detailPanel.value.isOpen = false
}

const projects = computed(() => page.props.projects || [])
const pending = ref(false)
const error = ref(null)

/**
 * Scrolls the gallery based on the direction
 */
const scrollGallery = (id: string, direction: number) => {
  const container = document.getElementById(id)
  if (container) {
    const scrollAmount = container.clientWidth
    container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' })
  }
}

/**
 * Scrolls the gallery to a specific image index
 */
const scrollToImage = (id: string, index: number) => {
  const container = document.getElementById(id)
  if (container) {
    const scrollAmount = container.clientWidth
    container.scrollTo({ left: index * scrollAmount, behavior: 'smooth' })
  }
}

// Active Image Tracking
const activeImageIndices = ref<Record<number, number>>({})

const handleGalleryScroll = (projectId: number) => {
  const container = document.getElementById('gallery-' + projectId)
  if (container) {
    const scrollLeft = container.scrollLeft
    const width = container.clientWidth
    if (width > 0) {
      const index = Math.round(scrollLeft / width)
      activeImageIndices.value[projectId] = index
    }
  }
}

// Auto Slide Logic
let slideTimer: ReturnType<typeof setInterval> | null = null

const startAutoSlide = () => {
  if (slideTimer) return
  slideTimer = setInterval(() => {
    if (!projects.value) return
    projects.value.forEach(project => {
      if (project.images && project.images.length > 1) {
        const currentIdx = activeImageIndices.value[project.id] || 0
        const nextIdx = (currentIdx + 1) % project.images.length
        scrollToImage('gallery-' + project.id, nextIdx)
        // Note: the scroll event will seamlessly update the activeIndex
      }
    })
  }, 3000)
}

const stopAutoSlide = () => {
  if (slideTimer) {
    clearInterval(slideTimer)
    slideTimer = null
  }
}

// Allow pausing auto-slide on hover
const pauseAutoSlide = () => stopAutoSlide()
const resumeAutoSlide = () => startAutoSlide()


/**
 * Transforms a Google Drive sharing link into a direct thumbnail link
 */
const formatDriveUrl = (url: string) => {
  if (!url) return ''
  
  // Check if it's a Google Drive link
  if (url.includes('drive.google.com')) {
    let fileId = ''
    
    // Pattern: /file/d/FILE_ID/
    const idMatch = url.match(/\/file\/d\/([^\/?]+)/)
    if (idMatch && idMatch[1]) {
      fileId = idMatch[1]
    } else if (url.includes('?')) {
      // Pattern: id=FILE_ID
      const parts = url.split('?')
      if (parts.length > 1) {
        const params = new URLSearchParams(parts[1])
        fileId = params.get('id') || ''
      }
    }
    
    if (fileId) {
      return `https://lh3.googleusercontent.com/d/${fileId}`
    }
  }
  
  return url
}
</script>
