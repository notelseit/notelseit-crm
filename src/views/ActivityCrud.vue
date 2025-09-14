<template>
  <div>
    <h2>Attività</h2>
    <button @click="openForm()">Aggiungi Attività</button>
    <ul>
      <li v-for="activity in activities" :key="activity.id">
        {{ activity.tipo }} - {{ activity.oggetto }} - {{ activity.data }} - Cliente: {{ getClientName(activity.client_id) }}
        <button @click="openForm(activity)">Modifica</button>
        <button @click="del(activity.id)">Elimina</button>
      </li>
    </ul>

    <div v-if="showForm" class="modal">
      <form @submit.prevent="save">
        <input v-model="form.tipo" placeholder="Tipo" required/>
        <input v-model="form.oggetto" placeholder="Oggetto" required/>
        <input v-model="form.data" type="datetime-local" required/>
        <select v-model="form.client_id" required>
          <option disabled value="">Seleziona Cliente</option>
          <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.ragione_sociale }}</option>
        </select>
        <button type="submit">Salva</button>
        <button type="button" @click="closeForm">Annulla</button>
      </form>
    </div>
    <Toast ref="toast"/>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import Toast from '@/components/Toast.vue'
const activities = ref([])
const clients = ref([])
const showForm = ref(false)
const form = ref({ id: null, tipo: '', oggetto: '', data: '', client_id: '' })
const toast = ref(null)

async function load() {
  activities.value = await (await fetch('/api/activities')).json()
  clients.value = await (await fetch('/api/clients')).json()
}
onMounted(load)

function getClientName(id) {
  const c = clients.value.find(c => c.id === id)
  return c ? c.ragione_sociale : ''
}
function openForm(activity = null) {
  if (activity) form.value = { ...activity }
  else form.value = { id: null, tipo: '', oggetto: '', data: '', client_id: '' }
  showForm.value = true
}
function closeForm() { showForm.value = false }
async function save() {
  if (!form.value.tipo || !form.value.oggetto || !form.value.data || !form.value.client_id) return toast.value.show('Campi obbligatori!')
  if (form.value.id) {
    await fetch(`/api/activities/${form.value.id}`, {
      method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Attività aggiornata')
  } else {
    await fetch('/api/activities', {
      method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Attività creata')
  }
  showForm.value = false
  await load()
}
async function del(id) {
  if (confirm('Sicuro di eliminare?')) {
    await fetch(`/api/activities/${id}`, { method: 'DELETE' })
    toast.value.show('Attività eliminata')
    await load()
  }
}
</script>
<style>.modal { background: #fff; border: 1px solid #ccc; padding: 1rem; position: fixed; top: 20%; left: 40%; z-index: 10; }</style>