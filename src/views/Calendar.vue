<template>
  <div>
    <FullCalendar :options="calendarOptions" />
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const events = ref([])

onMounted(async () => {
  const activities = await (await fetch('/api/activities')).json()
  events.value = activities.map(a => ({
    title: `${a.tipo}: ${a.oggetto}`,
    start: a.data,
    description: a.descrizione
  }))
})

const calendarOptions = ref({
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  events: events,
  eventClick: ({ event }) => {
    alert(event.title + '\n' + event.extendedProps.description)
  }
})
</script>