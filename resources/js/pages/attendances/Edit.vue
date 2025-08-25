<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

interface Employee {
  id: number
  name: string
}

const props = defineProps<{
  attendance: {
    id: number
    employee_id: number
    check_in?: string | null
    check_out?: string | null
    status: string
  }
  employees: Employee[]
}>()

// mapping status backend ↔ frontend
const statusOptions: Record<string, string> = {
  Present: 'Hadir',
  Permission: 'Izin',
  Sick: 'Sakit',
  Absent: 'Alpha',
}

// form inertia
const form = useForm({
  employee_id: props.attendance.employee_id,
  check_in: props.attendance.check_in,
  check_out: props.attendance.check_out,
  status: props.attendance.status, // tetap pakai bahasa Inggris
})

const submit = () => {
  form.put(route('attendances.update', props.attendance.id), {
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Kehadiran</h1>

    <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded-lg shadow">
      <!-- Employee -->
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

      <!-- Check In -->
      <div>
        <label class="block text-sm font-medium mb-1">Jam Masuk</label>
        <input
          type="datetime-local"
          v-model="form.check_in"
          class="w-full border rounded-lg px-3 py-2"
        />
        <div v-if="form.errors.check_in" class="text-red-600 text-sm mt-1">
          {{ form.errors.check_in }}
        </div>
      </div>

      <!-- Check Out -->
      <div>
        <label class="block text-sm font-medium mb-1">Jam Pulang</label>
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
          <option
            v-for="(label, value) in statusOptions"
            :key="value"
            :value="value"
          >
            {{ label }}
          </option>
        </select>
        <div v-if="form.errors.status" class="text-red-600 text-sm mt-1">
          {{ form.errors.status }}
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex justify-end gap-3">
        <button
          type="button"
          @click="router.visit(route('attendances.index'))"
          class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
        >
          Batal
        </button>
        <button
          type="submit"
          class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700"
          :disabled="form.processing"
        >
          Simpan
        </button>
      </div>
    </form>
  </div>
</template>