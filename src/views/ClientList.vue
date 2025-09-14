<template>
  <div>
    <h2>Clienti</h2>
    <ul>
      <li v-for="client in clients" :key="client.id">
        {{ client.ragione_sociale }} - {{ client.email }}
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  data() { return { clients: [] } },
  async created() {
    const res = await fetch("/api/clients");
    this.clients = await res.json();
  }
}
</script>