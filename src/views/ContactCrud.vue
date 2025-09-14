<template>
  <div>
    <h2>Contatti</h2>
    <button @click="openForm()">Aggiungi Contatto</button>
    <ul>
      <li v-for="contact in contacts" :key="contact.id">
        {{ contact.nome }} - {{ contact.email }} - {{ contact.ruolo }} - Cliente: {{ getClientName(contact.client_id) }}
        <button @click="openForm(contact)">Modifica</button>
        <button @click="del(contact.id)">Elimina</button>
      </li>
    </ul>

    <div v-if="showForm" class="modal">
      <form @submit.prevent="save">
        <input v-model="form.nome" placeholder="Nome" required/>
        <input v-model="form.email" placeholder="Email" required/>
        <input v-model="form.ruolo" placeholder="Ruolo"/>
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
const contacts = ref([])
const clients = ref([])
const showForm = ref(false)
const form = ref({ id: null, nome: '', email: '', ruolo: '', client_id: '' })
const toast = ref(null)

async function load() {
  contacts.value = await (await fetch('/api/contacts')).json()
  clients.value = await (await fetch('/api/clients')).json()
}
onMounted(load)

function getClientName(id) {
  const c = clients.value.find(c => c.id === id)
  return c ? c.ragione_sociale : ''
}
function openForm(contact = null) {
  if (contact) form.value = { ...contact }
  else form.value = { id: null, nome: '', email: '', ruolo: '', client_id: '' }
  showForm.value = true
}
function closeForm() { showForm.value = false }
async function save() {
  if (!form.value.nome || !form.value.email || !form.value.client_id) return toast.value.show('Campi obbligatori!')
  if (form.value.id) {
    await fetch(`/api/contacts/${form.value.id}`, {
      method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Contatto aggiornato')
  } else {
    await fetch('/api/contacts', {
      method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Contatto creato')
  }
  showForm.value = false
  await load()
}
async function del(id) {
  if (confirm('Sicuro di eliminare?')) {
    await fetch(`/api/contacts/${id}`, { method: 'DELETE' })
    toast.value.show('Contatto eliminato')
    await load()
  }
}
</script>
<style>.modal { background: #fff; border: 1px solid #ccc; padding: 1rem; position: fixed; top: 20%; left: 40%; z-index: 10; }</style>