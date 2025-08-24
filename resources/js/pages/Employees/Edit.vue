<script setup lang="ts">
import { defineProps, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { getInitials, getAvatarColor } from '@/utils/employee'
import { showToast } from '@/app'

interface Employee {
  id: number
  name: string
  email: string
  position: string
}

const props = defineProps<{ employee: Employee }>()

const form = reactive({
  name: props.employee.name,
  email: props.employee.email,
  position: props.employee.position,
})

function submit() {
  router.put(`/employees/${props.employee.id}`, form, {
    onSuccess: () => showToast('success', 'Data karyawan berhasil diupdate ✅'),
    onError: () => showToast('error', 'Update gagal ⚠️'),
  })
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-3 sm:p-4 md:p-6">
    <!-- Header -->
    <div class="max-w-2xl mx-auto mb-6 sm:mb-8">
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-4 sm:p-6 shadow-lg border border-white/20">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
          <!-- Icon -->
          <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-orange-600 to-amber-600 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
          </div>

          <!-- Title -->
          <div class="flex-1">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-gray-900 to-blue-800 bg-clip-text text-transparent">
              Edit Karyawan
            </h1>
            <p class="text-gray-600 text-sm sm:text-base mt-1">Perbarui informasi karyawan</p>
          </div>

          <!-- Avatar -->
          <div class="flex items-center gap-2 sm:gap-3">
            <div :class="`w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br ${getAvatarColor(employee.name)} rounded-full flex items-center justify-center text-white font-semibold shadow-lg`">
              {{ getInitials(employee.name) }}
            </div>
            <div class="text-right text-xs sm:text-sm break-words max-w-[120px] sm:max-w-none">
              <p class="font-semibold text-gray-900 truncate">{{ employee.name }}</p>
              <p class="text-gray-500">ID: {{ employee.id }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form -->
    <div class="max-w-2xl mx-auto">
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">
        <form @submit.prevent="submit" class="p-4 sm:p-6 md:p-8">
          <div class="space-y-5 sm:space-y-6">
            <!-- Info Banner -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-3 sm:p-4 border border-blue-200/30">
              <div class="flex items-center gap-3 text-blue-700">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <p class="text-xs sm:text-sm font-medium">Mengedit data karyawan</p>
                  <p class="text-[11px] sm:text-xs text-blue-600">Data yang diubah akan langsung tersimpan</p>
                </div>
              </div>
            </div>

            <!-- Name Field -->
            <div class="group">
              <label for="name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                  <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Nama Lengkap
                  </div>
                  <span class="text-[11px] sm:text-xs text-gray-400">Sebelumnya: {{ employee.name }}</span>
                </div>
              </label>
              <div class="relative">
                <input 
                  id="name"
                  v-model="form.name" 
                  type="text"
                  placeholder="Masukkan nama lengkap"
                  class="w-full px-3 sm:px-4 py-2.5 sm:py-3 pl-10 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                  required
                />
                
                <div v-if="form.name !== employee.name" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                  <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                </div>
              </div>
            </div>

            <!-- Email Field -->
            <div class="group">
              <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                  <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email Address
                  </div>
                  <span class="text-[11px] sm:text-xs text-gray-400">Sebelumnya: {{ employee.email }}</span>
                </div>
              </label>
              <div class="relative">
                <input 
                  id="email"
                  v-model="form.email" 
                  type="email"
                  placeholder="nama@perusahaan.com"
                  class="w-full px-3 sm:px-4 py-2.5 sm:py-3 pl-10 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                  required
                />
                
                <div v-if="form.email !== employee.email" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                  <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                </div>
              </div>
            </div>

            <!-- Position Field -->
            <div class="group">
              <label for="position" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                  <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                    </svg>
                    Jabatan
                  </div>
                  <span class="text-[11px] sm:text-xs text-gray-400">Sebelumnya: {{ employee.position }}</span>
                </div>
              </label>
              <div class="relative">
                <input 
                  id="position"
                  v-model="form.position" 
                  type="text"
                  placeholder="Contoh: Software Engineer, Manager, Designer"
                  class="w-full px-3 sm:px-4 py-2.5 sm:py-3 pl-10 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                  required
                />
                
                <div v-if="form.position !== employee.position" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                  <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
            <a href="/employees" 
              class="w-full sm:w-auto inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-md">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Batal
            </a>
            <button 
              type="submit" 
              class="w-full sm:w-auto inline-flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
              </svg>
              Update Karyawan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Changes Summary -->
    <div class="max-w-2xl mx-auto mt-4 sm:mt-6">
      <div v-if="form.name !== employee.name || form.email !== employee.email || form.position !== employee.position"
        class="bg-orange-50/50 backdrop-blur-sm rounded-xl p-3 sm:p-4 border border-orange-200/30">
        <div class="flex items-start gap-3 text-orange-700 text-xs sm:text-sm break-words">
          <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5C3.312 16.333 4.274 18 5.814 18z" />
          </svg>
          <div class="space-y-1">
            <p class="font-medium">Perubahan Terdeteksi</p>
            <div v-if="form.name !== employee.name" class="flex items-center gap-1.5">
              <span class="w-1 h-1 bg-orange-500 rounded-full"></span>
              <span>Nama: "{{ employee.name }}" → "{{ form.name }}"</span>
            </div>
            <div v-if="form.email !== employee.email" class="flex items-center gap-1.5">
              <span class="w-1 h-1 bg-orange-500 rounded-full"></span>
              <span>Email: "{{ employee.email }}" → "{{ form.email }}"</span>
            </div>
            <div v-if="form.position !== employee.position" class="flex items-center gap-1.5">
              <span class="w-1 h-1 bg-orange-500 rounded-full"></span>
              <span>Jabatan: "{{ employee.position }}" → "{{ form.position }}"</span>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="bg-green-50/50 backdrop-blur-sm rounded-xl p-3 sm:p-4 border border-green-200/30">
        <div class="flex items-center gap-3 text-green-700 text-xs sm:text-sm">
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p><strong>Tidak ada perubahan.</strong> Data sama dengan yang tersimpan.</p>
        </div>
      </div>
    </div>
  </div>
</template>
