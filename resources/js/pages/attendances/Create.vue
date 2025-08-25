<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3'

interface Employee {
  id: number
  name: string
}

const props = defineProps<{
  employees: Employee[]
}>()

// pakai inertia form biar otomatis handle error & reset
const form = useForm({
  employee_id: '',
  check_in: '',
  check_out: '',
  status: 'Hadir',
})

const submit = () => {
  form.post('/attendances', {
    onSuccess: () => {
      form.reset()
      router.visit('/attendances')
    },
  })
}
</script>

<template>
  <div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Absensi</h1>

    <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded-lg shadow">
      <!-- Karyawan -->
      <div>
        <label class="block text-sm font-medium mb-1">Karyawan</label>
        <select
          v-model="form.employee_id"
          class="w-full border rounded-lg px-3 py-2"
          required
        >
          <option value="">-- Pilih Karyawan --</option>
          <option
            v-for="emp in props.employees"
            :key="emp.id"
            :value="emp.id"
          >
            {{ emp.name }}
          </option>
        </select>
        <div v-if="form.errors.employee_id" class="text-red-600 text-sm mt-1">
          {{ form.errors.employee_id }}
        </div>
      </div>

      <!-- Waktu Masuk -->
      <div>
        <label class="block text-sm font-medium mb-1">Waktu Masuk</label>
        <input
          type="datetime-local"
          v-model="form.check_in"
          class="w-full border rounded-lg px-3 py-2"
        />
        <div v-if="form.errors.check_in" class="text-red-600 text-sm mt-1">
          {{ form.errors.check_in }}
        </div>
      </div>

      <!-- Waktu Pulang -->
      <div>
        <label class="block text-sm font-medium mb-1">Waktu Pulang</label>
        <input
          type="datetime-local"
          v-model="form.check_out"
          class="w-full border rounded-lg px-3 py-2"
        />
        <div v-if="form.errors.check_out" class="text-red-600 text-sm mt-1">
          {{ form.errors.check_out }}
        </div>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select
          v-model="form.status"
          class="w-full border rounded-lg px-3 py-2"
        >
          <option value="Present">Hadir</option>
          <option value="Permission">Izin</option>
          <option value="Sick">Sakit</option>
          <option value="Absent">Alpha</option>
        </select>
        <div v-if="form.errors.status" class="text-red-600 text-sm mt-1">
          {{ form.errors.status }}
        </div>
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-3">
        <button
          type="button"
          @click="router.visit('/attendances')"
          class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
        >
          Batal
        </button>
        <button
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
          :disabled="form.processing"
        >
          Simpan
        </button>
      </div>
    </form>
  </div>
</template>
