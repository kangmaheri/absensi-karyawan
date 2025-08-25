<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{
  attendance: {
    id: number
    employee: {
      id: number
      name: string
      email: string
      position?: string
    }
    check_in?: string | null
    check_out?: string | null
    status: string
  }
}>()
</script>

<template>
  <div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Detail Kehadiran</h1>

    <div class="bg-white p-6 rounded-lg shadow space-y-4">
      <!-- Data Karyawan -->
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-blue-500 text-white font-bold flex items-center justify-center rounded-lg text-xl">
          {{ attendance.employee.name.charAt(0).toUpperCase() }}
        </div>
        <div>
          <p class="text-lg font-semibold">{{ attendance.employee.name }}</p>
          <p class="text-gray-600">{{ attendance.employee.email }}</p>
          <p v-if="attendance.employee.position" class="text-gray-500 text-sm">{{ attendance.employee.position }}</p>
        </div>
      </div>

      <!-- Jam Masuk -->
      <div>
        <p class="text-gray-600 font-medium">Jam Masuk:</p>
        <p>{{ attendance.check_in ?? '-' }}</p>
      </div>

      <!-- Jam Keluar -->
      <div>
        <p class="text-gray-600 font-medium">Jam Keluar:</p>
        <p>{{ attendance.check_out ?? '-' }}</p>
      </div>

      <!-- Status -->
      <div>
        <p class="text-gray-600 font-medium">Status:</p>
        <span
          class="px-3 py-1 rounded text-sm font-semibold"
          :class="{
            'bg-green-100 text-green-700': attendance.status === 'Present',
            'bg-yellow-100 text-yellow-700': attendance.status === 'Permission',
            'bg-blue-100 text-blue-700': attendance.status === 'Sick',
            'bg-red-100 text-red-700': attendance.status === 'Absent'
          }"
        >
          <!-- kita mapping status ke Indonesia -->
          {{
            attendance.status === 'Present'
              ? 'Hadir'
              : attendance.status === 'Permission'
              ? 'Izin'
              : attendance.status === 'Sick'
              ? 'Sakit'
              : 'Alpha'
          }}
        </span>
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-3 mt-4">
        <button
          @click="router.visit(route('attendances.index'))"
          class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
        >
          Kembali
        </button>
        <button
          @click="router.visit(route('attendances.edit', attendance.id))"
          class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700"
        >
          Ubah
        </button>
      </div>
    </div>
  </div>
</template>
