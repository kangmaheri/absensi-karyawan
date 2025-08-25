<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { showToast } from '@/app'
import { getInitials, getAvatarColor } from '@/utils/employee'

interface Employee {
  id: number
  name: string
  email?: string
  position?: string
}

interface Attendance {
  id: number
  employee_id?: number
  employee?: Employee | null
  tanggal?: string | null
  check_in?: string | null
  check_out?: string | null
  status?: string | null
  created_at?: string
  updated_at?: string
}

const props = defineProps<{
  attendances?: Attendance[]
}>()

const loading = ref(false)
const attendances = ref<Attendance[]>(props.attendances ? props.attendances : [])

// Mapping status backend -> frontend (Indonesia)
const statusMap: Record<string, string> = {
  Present: 'Hadir',
  Permission: 'Izin',
  Sick: 'Sakit',
  Absent: 'Alpha',
}

function getStatusLabel(status?: string | null) {
  if (!status) return '-'
  return statusMap[status] ?? status // fallback kalau belum terdaftar
}

function getStatusClass(status?: string | null) {
  switch (status) {
    case 'Present':
      return 'bg-green-100 text-green-800 border border-green-200'
    case 'Permission':
      return 'bg-yellow-100 text-yellow-800 border border-yellow-200'
    case 'Sick':
      return 'bg-orange-100 text-orange-800 border border-orange-200'
    case 'Absent':
      return 'bg-red-100 text-red-800 border border-red-200'
    default:
      return 'bg-gray-100 text-gray-600 border border-gray-200'
  }
}

async function loadAttendances() {
  if (props.attendances && props.attendances.length) return
  loading.value = true
  try {
    const res = await fetch('/attendances', {
      method: 'GET',
      headers: { Accept: 'application/json' },
    })
    if (!res.ok) throw new Error('Gagal memuat data absensi')
    const json = await res.json()
    attendances.value = Array.isArray(json) ? json : (json.data ?? [])
  } catch (err) {
    console.error(err)
    showToast('error', 'Gagal memuat data absensi')
  } finally {
    loading.value = false
  }
}

function formatDateTime(input?: string | null) {
  if (!input) return '-'
  const d = new Date(input)
  if (Number.isNaN(d.getTime())) return input
  return d.toLocaleString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

function formatDate(input?: string | null) {
  if (!input) return '-'
  const d = new Date(input)
  if (Number.isNaN(d.getTime())) return input
  return d.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })
}

function destroyAttendance(id: number) {
  if (!confirm('Yakin ingin menghapus absensi ini?')) return

  router.delete(`/attendances/${id}`, {
    onSuccess: () => {
      attendances.value = attendances.value.filter(a => a.id !== id)
      showToast('success', 'Data absensi berhasil dihapus')
    },
    onError: () => {
      showToast('error', 'Gagal menghapus data absensi')
    },
  })
}

onMounted(() => {
  loadAttendances()
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- header -->
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-white/20 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Data Absensi</h1>
          <p class="text-gray-600 mt-1">{{ attendances.length }} data</p>
        </div>
        <div class="flex items-center gap-3">
          <a href="/attendances/create"
            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Absensi
          </a>
        </div>
      </div>

      <!-- loading -->
      <div v-if="loading" class="max-w-7xl mx-auto text-center py-8 text-gray-500">
        Sedang memuat data absensi...
      </div>

      <!-- table desktop -->
      <div v-if="!loading" class="hidden lg:block">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Karyawan</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Tanggal</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Masuk</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Pulang</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                  <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200/50">
                <tr v-for="att in attendances" :key="att.id" class="hover:bg-blue-50/20 transition-all duration-200">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <div :class="`w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold ${getAvatarColor(att.employee?.name ?? String(att.employee_id))}`">
                        {{ getInitials(att.employee?.name ?? ('K' + (att.employee_id ?? ''))) }}
                      </div>
                      <div class="min-w-0">
                        <div class="font-medium text-gray-900 truncate">{{ att.employee?.name ?? ('Karyawan #' + (att.employee_id ?? '-')) }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ att.employee?.position ?? '' }}</div>
                      </div>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-700">{{ formatDate(att.tanggal ?? att.check_in ?? att.created_at) }}</div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-700">{{ formatDateTime(att.check_in) }}</div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-700">{{ formatDateTime(att.check_out) }}</div>
                  </td>

                  <td class="px-6 py-4">
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                      :class="getStatusClass(att.status)"
                    >
                      {{ getStatusLabel(att.status) }}
                    </span>
                  </td>

                  <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                      <a :href="`/attendances/${att.id}`" class="text-sm text-blue-600 hover:underline">Detail</a>
                      <a :href="`/attendances/${att.id}/edit`" class="text-sm text-yellow-600 hover:underline">Ubah</a>
                      <button @click="destroyAttendance(att.id)" class="text-sm text-red-600 hover:underline">Hapus</button>
                    </div>
                  </td>
                </tr>

                <tr v-if="attendances.length === 0">
                  <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    Tidak ada data absensi.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- cards mobile -->
      <div v-if="!loading" class="grid gap-4 sm:grid-cols-2 lg:hidden">
        <div v-for="att in attendances" :key="att.id" class="group bg-white/80 backdrop-blur-lg rounded-2xl p-4 shadow-lg border border-white/20 hover:shadow-xl transition-all">
          <div class="flex items-start gap-4">
            <div :class="`w-14 h-14 rounded-2xl flex items-center justify-center text-white font-bold text-lg ${getAvatarColor(att.employee?.name ?? String(att.employee_id))}`">
              {{ getInitials(att.employee?.name ?? ('K' + (att.employee_id ?? ''))) }}
            </div>

            <div class="flex-1 min-w-0">
              <div class="flex justify-between mb-2">
                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ att.employee?.name ?? ('Karyawan #' + (att.employee_id ?? '-')) }}</h3>
                <div class="text-xs text-gray-500">{{ formatDate(att.tanggal ?? att.check_in ?? att.created_at) }}</div>
              </div>

              <div class="space-y-2 text-sm text-gray-700">
                <div>
                  <div class="text-xs text-gray-500">Masuk</div>
                  <div>{{ formatDateTime(att.check_in) }}</div>
                </div>
                <div>
                  <div class="text-xs text-gray-500">Pulang</div>
                  <div>{{ formatDateTime(att.check_out) }}</div>
                </div>
                <div>
                  <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-2"
                    :class="getStatusClass(att.status)">
                    {{ getStatusLabel(att.status) }}
                  </div>
                </div>

                <div class="flex justify-end gap-3 mt-3">
                  <a :href="`/attendances/${att.id}`" class="text-blue-600 hover:underline">Detail</a>
                  <a :href="`/attendances/${att.id}/edit`" class="text-yellow-600 hover:underline">Ubah</a>
                  <button @click="destroyAttendance(att.id)" class="text-red-600 hover:underline">Hapus</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="attendances.length === 0" class="col-span-full text-center text-gray-500 py-8">
          Tidak ada data absensi.
        </div>
      </div>
    </div>
  </div>
</template>