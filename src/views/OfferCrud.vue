<template>
  <div>
    <h2>Offerte</h2>
    <button @click="openForm()">Aggiungi Offerta</button>
    <ul>
      <li v-for="offer in offers" :key="offer.id">
        {{ offer.titolo }} - €{{ offer.importo }} - {{ offer.stato }} - Cliente: {{ getClientName(offer.client_id) }}
        <button @click="openForm(offer)">Modifica</button>
        <button @click="del(offer.id)">Elimina</button>
      </li>
    </ul>

    <div v-if="showForm" class="modal">
      <form @submit.prevent="save">
        <input v-model="form.titolo" placeholder="Titolo" required/>
        <input v-model="form.importo" type="number" placeholder="Importo" required/>
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
const offers = ref([])
const clients = ref([])
const showForm = ref(false)
const form = ref({ id: null, titolo: '', importo: '', stato: '', client_id: '' })
const toast = ref(null)

async function load() {
  offers.value = await (await fetch('/api/offers')).json()
  clients.value = await (await fetch('/api/clients')).json()
}
onMounted(load)

function getClientName(id) {
  const c = clients.value.find(c => c.id === id)
  return c ? c.ragione_sociale : ''
}
function openForm(offer = null) {
  if (offer) form.value = { ...offer }
  else form.value = { id: null, titolo: '', importo: '', stato: '', client_id: '' }
  showForm.value = true
}
function closeForm() { showForm.value = false }
async function save() {
  if (!form.value.titolo || !form.value.importo || !form.value.stato || !form.value.client_id) return toast.value.show('Campi obbligatori!')
  if (form.value.id) {
    await fetch(`/api/offers/${form.value.id}`, {
      method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Offerta aggiornata')
  } else {
    await fetch('/api/offers', {
      method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(form.value)
    })
    toast.value.show('Offerta creata')
  }
  showForm.value = false
  await load()
}
async function del(id) {
  if (confirm('Sicuro di eliminare?')) {
    await fetch(`/api/offers/${id}`, { method: 'DELETE' })
    toast.value.show('Offerta eliminata')
    await load()
  }
}
</script>
<style>.modal { background: #fff; border: 1px solid #ccc; padding: 1rem; position: fixed; top: 20%; left: 40%; z-index: 10; }</style>