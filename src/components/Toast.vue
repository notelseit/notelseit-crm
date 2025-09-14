<template>
  <div v-if="visible" class="toast">{{ message }}</div>
</template>
<script setup>
import { ref } from 'vue'
const visible = ref(false)
const message = ref('')
function show(msg) {
  message.value = msg
  visible.value = true
  setTimeout(() => visible.value = false, 3000)
}
defineExpose({ show })
</script>
<style>
.toast { position: fixed; top: 20px; right: 20px; background: #41b883; color: #fff; border-radius: 5px; padding: 1rem; }
</style>