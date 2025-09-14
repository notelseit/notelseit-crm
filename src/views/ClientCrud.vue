<template>
  <div>
    <h2>Clienti</h2>
    <div class="filters">
      <input v-model="filter.nome" placeholder="Filtra per Ragione Sociale"/>
      <input v-model="filter.settore" placeholder="Filtra per Settore"/>
      <button @click="load">Applica filtri</button>
    </div>
    <button @click="openForm()">Aggiungi Cliente</button>
    <table>
      <thead>
        <tr>
          <th @click="sortBy('ragione_sociale')">Ragione Sociale</th>
          <th @click="sortBy('settore')">Settore</th>
          <th>Email</th>
          <th>Azioni</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="client in pagedClients" :key="client.id">
          <td>{{ client.ragione_sociale }}</td>
          <td>{{ client.settore }}</td>
          <td>{{ client.email }}</td>
          <td>
            <button @click="openForm(client)">Modifica</button>
            <button @click="del(client.id)">Elimina</button>
            <button @click="viewDetails(client)">Dettagli</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <button @click="page--" :disabled="page===1">Prev</button>
      <span>Pagina {{page}}/{{totalPages}}</span>
      <button @click="page++" :disabled="page===totalPages">Next</button>
    </div>

    <!-- Modale dettagli -->
    <div v-if="showDetails" class="modal">
      <h3>Dettagli Cliente</h3>
      <div>
        <strong>Contatti:</strong>
        <ul>
          <li v-for="c in details.contacts" :key="c.id">{{c.nome}} - {{c.email}}</li>
        </ul>
        <strong>Lead:</strong>
        <ul>
          <li v-for="l in details.leads" :key="l.id">{{l.nome}} - {{l.stato}}</li>
        </ul>
        <strong>Attività:</strong>
        <ul>
          <li v-for="a in details.activities" :key="a.id">{{a.tipo}} - {{a.oggetto}} - {{a.data}}</li>
        </ul>
        <strong>Offerte:</strong>
        <ul>
          <li v-for="o in details.offers" :key="o.id">{{o.titolo}} - {{o.stato}}</li>
        </ul>
        <!-- Allegati -->
        <strong>Allegati:</strong>
        <ul>
          <li v-for="f in details.attachments" :key="f.id">
            <a :href="f.url" target="_blank">{{f.filename}}</a>
          </li>
        </ul>
      </div>
      <input type="file" @change="uploadAttachment($event, details.id)" />
      <button @click="showDetails=false">Chiudi</button>
    </div>

    <!-- Form CRUD (come prima, omesso per brevità) -->

    <Toast ref="toast"/>
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import Toast from '@/components/Toast.vue'
const clients = ref([])
const filter = ref({nome: '', settore: ''})
const sortKey = ref('ragione_sociale')
const sortAsc = ref(true)
const page = ref(1)
const pageSize = 10
const showDetails = ref(false)
const details = ref({})
const toast = ref(null)

async function load() {
  // Qui puoi passare parametri di filtro/sort/paginazione all'API Laravel (consigliato!)
  let url = `/api/clients`
  const params = []
  if (filter.value.nome) params.push(`ragione_sociale_like=${filter.value.nome}`)
  if (filter.value.settore) params.push(`settore_like=${filter.value.settore}`)
  if (params.length) url += `?${params.join('&')}`
  clients.value = await (await fetch(url)).json()
  page.value = 1
}
onMounted(load)

const sortedClients = computed(() => {
  return [...clients.value].sort((a,b) => {
    const ka = a[sortKey.value]?.toString().toLowerCase()
    const kb = b[sortKey.value]?.toString().toLowerCase()
    if (ka > kb) return sortAsc.value ? 1 : -1
    if (ka < kb) return sortAsc.value ? -1 : 1
    return 0
  })
})
const totalPages = computed(() => Math.ceil(sortedClients.value.length/pageSize))
const pagedClients = computed(() =>
  sortedClients.value.slice((page.value-1)*pageSize, page.value*pageSize)
)
function sortBy(key) {
  if (sortKey.value === key) sortAsc.value = !sortAsc.value
  else { sortKey.value = key; sortAsc.value = true }
}

async function viewDetails(client) {
  // API Laravel: /api/clients/{id} con include di relazioni
  details.value = await (await fetch(`/api/clients/${client.id}?include=contacts,leads,activities,offers,attachments`)).json()
  showDetails.value = true
}
async function uploadAttachment(evt, clientId) {
  const file = evt.target.files[0]
  if (!file) return
  const formData = new FormData()
  formData.append('file', file)
  await fetch(`/api/clients/${clientId}/attachments`, {
    method: 'POST',
    body: formData
  })
  toast.value.show('Allegato caricato')
  await viewDetails({id: clientId})
}
function openForm() { /* come da esempio precedente */ }
function del(id) { /* come da esempio precedente */ }

</script>
<style>
.filters { margin-bottom: 1rem; }
.pagination { margin: 1rem; }
.modal { background: #fff; border: 1px solid #ccc; padding: 1rem; position: fixed; top: 20%; left: 30%; z-index: 10; width: 500px; }
table thead th { cursor: pointer; }
</style>