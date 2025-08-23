<script setup lang="ts">
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
  name: '',
  email: '',
  position: ''
})

function submit() {
  router.post('/employees', form)
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6 flex items-center justify-center">
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-white/20 w-full max-w-lg">
      <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Tambah Karyawan</h1>
      <form @submit.prevent="submit" class="space-y-5">
        <input v-model="form.name" placeholder="Nama" class="w-full p-3 rounded-xl border focus:ring-2 focus:ring-blue-500" />
        <input v-model="form.email" placeholder="Email" class="w-full p-3 rounded-xl border focus:ring-2 focus:ring-blue-500" />
        <input v-model="form.position" placeholder="Jabatan" class="w-full p-3 rounded-xl border focus:ring-2 focus:ring-blue-500" />
        <div class="flex justify-end gap-3">
          <a href="/employees" class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300">Batal</a>
          <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</template>
