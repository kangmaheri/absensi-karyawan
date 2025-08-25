<script setup lang="ts">
import Navbar from '@/components/Navbar.vue'

// Props supaya halaman bisa mengirim konten
const props = defineProps<{
  title?: string
}>()
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-100">
    <!-- Navbar -->
    <Navbar />

    <!-- Judul halaman (opsional) -->
    <header v-if="props.title" class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">
          {{ props.title }}
        </h1>
      </div>
    </header>

    <!-- Konten utama -->
    <main class="flex-1">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
  </div>
</template>
