<script setup lang="ts">
import { defineProps } from 'vue'
import { getInitials, getAvatarColor } from '@/utils/employee'

interface Employee {
  id: number
  name: string
  email: string
  position: string
}

defineProps<{
  employees: Employee[]
}>()
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <!-- Header -->
    <div class="max-w-7xl mx-auto mb-8">
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-white/20">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
          </div>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-blue-800 bg-clip-text text-transparent">
              Daftar Karyawan
            </h1>
            <p class="text-gray-600 mt-1">{{ employees.length }} karyawan terdaftar</p>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto">
      <!-- Table view for desktop -->
      <div class="hidden lg:block">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">ID</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Karyawan</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Email</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Jabatan</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200/50">
                <tr 
                  v-for="emp in employees" 
                  :key="emp.id"
                  class="hover:bg-blue-50/50 transition-all duration-300 group"
                >
                  <td class="px-6 py-4">
                    <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg group-hover:bg-blue-100 transition-colors duration-300">
                      <span class="text-sm font-bold text-gray-700 group-hover:text-blue-700">{{ emp.id }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <div :class="`w-10 h-10 bg-gradient-to-br ${getAvatarColor(emp.name)} rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-lg`">
                        {{ getInitials(emp.name) }}
                      </div>
                      <div>
                        <p class="font-semibold text-gray-900">{{ emp.name }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                      <span class="text-gray-700">{{ emp.email }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 border border-blue-200">
                      {{ emp.position }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Card grid for tablet and mobile -->
      <div class="grid gap-4 sm:gap-6 lg:hidden">
        <div 
          v-for="emp in employees" 
          :key="emp.id"
          class="group bg-white/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-white/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
        >
          <div class="flex items-start gap-4">
            <!-- Avatar -->
            <div :class="`w-14 h-14 bg-gradient-to-br ${getAvatarColor(emp.name)} rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300`">
              {{ getInitials(emp.name) }}
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between mb-3">
                <h3 class="text-xl font-bold text-gray-900 truncate">{{ emp.name }}</h3>
                <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg ml-3 group-hover:bg-blue-100 transition-colors duration-300">
                  <span class="text-sm font-bold text-gray-700 group-hover:text-blue-700">{{ emp.id }}</span>
                </div>
              </div>
              
              <div class="space-y-3">
                <!-- Email -->
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                    <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <span class="text-gray-700 text-sm">{{ emp.email }}</span>
                </div>
                
                <!-- Position -->
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                    <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                    </svg>
                  </div>
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 border border-blue-200">
                    {{ emp.position }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
