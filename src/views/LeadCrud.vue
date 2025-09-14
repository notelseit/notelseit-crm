<template>
  <div>
    <h2>Lead</h2>
    <button @click="openForm()">Aggiungi Lead</button>
    <ul>
      <li v-for="lead in leads" :key="lead.id">
        {{ lead.nome }} - {{ lead.stato }} - Cliente: {{ getClientName(lead.client_id) }}
        <button @click="openForm(lead)">Modifica</button>
        <button @click="del(lead.id)">Elimina</button>
      </li>
    </ul>

    <div v-if="showForm" class="modal">
      <form @submit.prevent="save">
        <input v-model="form.nome" placeholder="Nome Lead" required/>
        <input v-model="form.stato" placeholder="Stato" required/>
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
const leads = ref([])
const clients = ref([])
const showForm = ref(false)
const form = ref({ id: null, nome: '', stato: '', client_id: '' })
const toast = ref(null)

async function load() {
  leads.value = await (await fetch('/api/leads')).json()
  clients.value = await (await fetch('/api/clients')).json()
}
onMounted(load)

function getClientName(id) {
  const c = clients.value.find(c => c.id === id)
  return c ? c.ragione_sociale : ''
}
function openForm(lead = null) {
  if (lead) form.value = { ...lead }
  else form.value = { id: null, nome: '', stato: '', client_id: '' }
  showForm.value = true
}
function closeForm() { showForm.value = false }
async function save() {
  if (!form.value.nome || !form.value.stato || !form.value.client_id) return toast.value.show('Campi obbligatori!')
  if (form.value.id) {
    await fetch(`/api/leads/${form.value.id}`, {
      method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Lead aggiornato')
  } else {
    await fetch('/api/leads', {
      method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Lead creato')
  }
  showForm.value = false
  await load()
}
async function del(id) {
  if (confirm('Sicuro di eliminare?')) {
    await fetch(`/api/leads/${id}`, { method: 'DELETE' })
    toast.value.show('Lead eliminato')
    await load()
  }
}
</script>
<style>.modal { background: #fff; border: 1px solid #ccc; padding: 1rem; position: fixed; top: 20%; left: 40%; z-index: 10; }</style>