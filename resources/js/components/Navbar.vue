<!-- resources/js/Components/Navbar.vue -->
<template>
  <nav class="bg-white/80 backdrop-blur-lg shadow-lg border-b border-gray-200/40 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl text-white font-bold text-lg shadow-lg">A</span>
          <span class="font-bold text-xl text-gray-900 tracking-tight">Attendance App</span>
        </div>
        <!-- Navigation -->
        <div class="flex space-x-6">
          <Link 
            href="/employees" 
            :class="[$page.url.startsWith('/employees') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700', 'hover:text-blue-600 font-medium transition-colors duration-200 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500']"
          >Karyawan</Link>
          <Link 
            href="/attendances" 
            :class="[$page.url.startsWith('/attendances') ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-700', 'hover:text-purple-600 font-medium transition-colors duration-200 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500']"
          >Absensi</Link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
const $page = usePage()
</script>

<style scoped>
nav {
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
</style>