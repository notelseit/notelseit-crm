<template>
  <canvas ref="canvas"></canvas>
</template>
<script setup>
import { onMounted, ref, watch } from 'vue'
import Chart from 'chart.js/auto'

const props = defineProps({
  labels: Array,
  data: Array,
})

const canvas = ref(null)
let chart = null

onMounted(() => draw())
watch(() => [props.labels, props.data], draw)

function draw() {
  if (chart) chart.destroy()
  chart = new Chart(canvas.value, {
    type: 'bar',
    data: {
      labels: props.labels,
      datasets: [{
        label: 'Lead per Stato',
        data: props.data,
        backgroundColor: '#42a5f5'
      }]
    }
  })
}
</script>