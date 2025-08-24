<script setup lang="ts">
import { ref } from 'vue'

interface ToastMessage {
  id: number
  type: 'success' | 'error' | 'warning' | 'info'
  title: string
  message: string
  duration?: number
}

const messages = ref<ToastMessage[]>([])
let id = 0

function showToast(
  type: 'success' | 'error' | 'warning' | 'info', 
  message: string, 
  title?: string, 
  duration: number = 4000
) {
  const toast: ToastMessage = { 
    id: ++id, 
    type, 
    title: title || getDefaultTitle(type),
    message, 
    duration 
  }
  
  messages.value.push(toast)
  
  setTimeout(() => {
    removeToast(toast.id)
  }, duration)
}

function removeToast(toastId: number) {
  messages.value = messages.value.filter(m => m.id !== toastId)
}

function getDefaultTitle(type: ToastMessage['type']): string {
  const titles = {
    success: 'Berhasil!',
    error: 'Error!',
    warning: 'Peringatan!',
    info: 'Info'
  }
  return titles[type]
}

function getToastStyles(type: ToastMessage['type']) {
  const styles = {
    success: {
      bg: 'from-emerald-500 to-green-600',
      icon: 'text-emerald-100',
      border: 'border-emerald-300/30'
    },
    error: {
      bg: 'from-red-500 to-rose-600', 
      icon: 'text-red-100',
      border: 'border-red-300/30'
    },
    warning: {
      bg: 'from-amber-500 to-orange-600',
      icon: 'text-amber-100', 
      border: 'border-amber-300/30'
    },
    info: {
      bg: 'from-blue-500 to-indigo-600',
      icon: 'text-blue-100',
      border: 'border-blue-300/30'
    }
  }
  return styles[type]
}

defineExpose({ showToast })
</script>

<template>
  <div class="fixed top-6 right-6 z-50 flex flex-col gap-3 max-w-sm">
    <transition-group name="toast" tag="div" class="space-y-3">
      <div
        v-for="msg in messages"
        :key="msg.id"
        :class="`
          relative bg-gradient-to-r ${getToastStyles(msg.type).bg} 
          backdrop-blur-lg rounded-2xl shadow-2xl border ${getToastStyles(msg.type).border}
          transform transition-all duration-300 hover:scale-105 cursor-pointer
          min-h-[80px] overflow-hidden
        `"
        @click="removeToast(msg.id)"
      >
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-2 right-2 w-16 h-16 bg-white rounded-full transform rotate-12"></div>
          <div class="absolute bottom-2 left-2 w-12 h-12 bg-white rounded-full transform -rotate-12"></div>
        </div>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/20 rounded-b-2xl overflow-hidden">
          <div 
            class="h-full bg-white/40 animate-progress origin-left"
            :style="`animation-duration: ${msg.duration}ms`"
          ></div>
        </div>

        <!-- Content -->
        <div class="relative p-4 flex items-start gap-3">
          <!-- Icon -->
          <div class="flex-shrink-0 mt-0.5">
            <!-- Success Icon -->
            <svg v-if="msg.type === 'success'" 
                 :class="`w-6 h-6 ${getToastStyles(msg.type).icon}`" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            
            <!-- Error Icon -->
            <svg v-else-if="msg.type === 'error'" 
                 :class="`w-6 h-6 ${getToastStyles(msg.type).icon}`" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            
            <!-- Warning Icon -->
            <svg v-else-if="msg.type === 'warning'" 
                 :class="`w-6 h-6 ${getToastStyles(msg.type).icon}`" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5C3.312 16.333 4.274 18 5.814 18z" />
            </svg>
            
            <!-- Info Icon -->
            <svg v-else 
                 :class="`w-6 h-6 ${getToastStyles(msg.type).icon}`" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>

          <!-- Text Content -->
          <div class="flex-1 min-w-0">
            <h4 class="text-white font-semibold text-sm leading-tight">
              {{ msg.title }}
            </h4>
            <p class="text-white/90 text-sm mt-1 leading-relaxed">
              {{ msg.message }}
            </p>
          </div>

          <!-- Close Button -->
          <button 
            @click.stop="removeToast(msg.id)"
            class="flex-shrink-0 text-white/70 hover:text-white transition-colors duration-200 p-1 rounded-lg hover:bg-white/10"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<style scoped>
/* Toast animations */
.toast-enter-active {
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.toast-leave-active {
  transition: all 0.3s ease-in;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100%) scale(0.8);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100%) scale(0.9);
}

.toast-move {
  transition: transform 0.3s ease;
}

/* Progress bar animation */
@keyframes progress {
  from {
    transform: scaleX(1);
  }
  to {
    transform: scaleX(0);
  }
}

.animate-progress {
  animation: progress linear forwards;
}

/* Hover effects */
.toast-enter-active:hover {
  transform: scale(1.02) translateX(-5px);
}
</style>