<script setup lang="ts">
import { defineProps, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

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
  router.put(`/employees/${props.employee.id}`, form)
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6 flex items-center justify-center">
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-white/20 w-full max-w-lg">
      <h1 class="text-2xl font-bold mb-6 text-gray-800">✏️ Edit Karyawan</h1>
      <form @submit.prevent="submit" class="space-y-5">
        <input v-model="form.name" placeholder="Nama" class="w-full p-3 rounded-xl border focus:ring-2 focus:ring-green-500" />
        <input v-model="form.email" placeholder="Email" class="w-full p-3 rounded-xl border focus:ring-2 focus:ring-green-500" />
        <input v-model="form.position" placeholder="Jabatan" class="w-full p-3 rounded-xl border focus:ring-2 focus:ring-green-500" />
        <div class="flex justify-end gap-3">
          <a href="/employees" class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300">Batal</a>
          <button type="submit" class="px-4 py-2 rounded-xl bg-green-600 hover:bg-green-700">Update</button>
        </div>
      </form>
    </div>
  </div>
</template>
