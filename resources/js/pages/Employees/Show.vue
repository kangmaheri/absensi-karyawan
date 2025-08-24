<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { showToast } from '@/app'
import { getInitials, getAvatarColor } from '@/utils/employee'

interface Employee {
  id: number
  name: string
  email: string
  position: string
}

const props = defineProps<{
  employee: Employee
}>()

function destroy(id: number) {
  if (confirm('Yakin ingin menghapus karyawan ini?')) {
    router.delete(`/employees/${id}`, {
      onSuccess: () => showToast('success', 'Karyawan berhasil dihapus 🗑️'),
      onError: () => showToast('error', 'Gagal menghapus karyawan ⚠️'),
    })
  }
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
    <!-- Header -->
    <div class="max-w-4xl mx-auto mb-8">
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-white/20">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </div>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-blue-800 bg-clip-text text-transparent">
              Detail Karyawan
            </h1>
            <p class="text-gray-600 mt-1">Informasi lengkap karyawan</p>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-4xl mx-auto">
      <!-- Employee Profile Card -->
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">
        
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-white relative overflow-hidden">
          <!-- Background Pattern -->
          <div class="absolute inset-0 opacity-10">
            <div class="absolute top-4 right-4 w-32 h-32 bg-white rounded-full transform rotate-12"></div>
            <div class="absolute bottom-4 left-4 w-24 h-24 bg-white rounded-full transform -rotate-12"></div>
            <div class="absolute top-1/2 left-1/2 w-16 h-16 bg-white rounded-full transform -translate-x-1/2 -translate-y-1/2 rotate-45"></div>
          </div>
          
          <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <!-- Large Avatar -->
            <div :class="`w-24 h-24 bg-gradient-to-br ${getAvatarColor(employee.name)} rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-2xl ring-4 ring-white/20`">
              {{ getInitials(employee.name) }}
            </div>
            
            <!-- Employee Info -->
            <div class="text-center sm:text-left flex-1">
              <h2 class="text-3xl font-bold mb-2">{{ employee.name }}</h2>
              <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span class="text-sm font-medium">ID: {{ employee.id }}</span>
                </div>
                <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                  </svg>
                  <span class="text-sm font-medium">{{ employee.position }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Employee Details -->
        <div class="p-8">
          <div class="grid md:grid-cols-2 gap-8">
            
            <!-- Personal Information -->
            <div class="space-y-6">
              <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-6">
                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                Informasi Personal
              </h3>
              
              <!-- Name -->
              <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-4 border border-gray-200/50">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mt-1">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Nama Lengkap</p>
                    <p class="text-lg font-semibold text-gray-900">{{ employee.name }}</p>
                  </div>
                </div>
              </div>

              <!-- Email -->
              <div class="bg-gradient-to-r from-gray-50 to-green-50 rounded-xl p-4 border border-gray-200/50">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mt-1">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Email Address</p>
                    <p class="text-lg font-semibold text-gray-900">{{ employee.email }}</p>
                    <a :href="`mailto:${employee.email}`" 
                      class="text-sm text-green-600 hover:text-green-700 font-medium mt-1 inline-block hover:underline">
                      Kirim Email
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Work Information -->
            <div class="space-y-6">
              <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-6">
                <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                  </svg>
                </div>
                Informasi Pekerjaan
              </h3>

              <!-- Position -->
              <div class="bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl p-4 border border-gray-200/50">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mt-1">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Jabatan</p>
                    <div class="flex items-center gap-2">
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-purple-100 to-blue-100 text-purple-800 border border-purple-200">
                        {{ employee.position }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Employee ID -->
              <div class="bg-gradient-to-r from-gray-50 to-indigo-50 rounded-xl p-4 border border-gray-200/50">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mt-1">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Employee ID</p>
                    <p class="text-lg font-semibold text-gray-900">#{{ employee.id.toString().padStart(4, '0') }}</p>
                    <p class="text-sm text-gray-500 mt-1">Unique identifier</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="border-t border-gray-200/50 p-6 bg-gray-50/50">
          <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Back Button -->
            <a href="/employees" 
              class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-md order-last sm:order-first">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Kembali ke Daftar
            </a>

            <!-- Action Buttons -->
            <div class="flex gap-3">
              <a :href="`/employees/${employee.id}/edit`"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
              </a>
              
              <button @click="destroy(employee.id)"
                      class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Info Card -->
      <div class="mt-6 bg-blue-50/50 backdrop-blur-sm rounded-xl p-6 border border-blue-200/30">
        <div class="flex items-center gap-3 text-blue-700">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div>
            <p class="text-sm font-medium">Informasi Sistem</p>
            <p class="text-xs text-blue-600">Data karyawan ini dapat diubah atau dihapus melalui tombol aksi di atas.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>