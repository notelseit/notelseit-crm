<template>
  <div>
    <h1>CRM Dashboard</h1>
    <div class="dashboard-cards">
      <div class="card">
        <h2>Clienti</h2>
        <p>{{ stats.clients }}</p>
      </div>
      <div class="card">
        <h2>Lead</h2>
        <p>{{ stats.leads }}</p>
      </div>
      <div class="card">
        <h2>Attività</h2>
        <p>{{ stats.activities }}</p>
      </div>
      <div class="card">
        <h2>Offerte</h2>
        <p>{{ stats.offers }}</p>
      </div>
    </div>
    <div class="dashboard-lists">
      <h3>Ultimi Clienti</h3>
      <ul>
        <li v-for="client in lastClients" :key="client.id">
          {{ client.ragione_sociale }} - {{ client.email }}
        </li>
      </ul>

      <h3>Ultimi Lead</h3>
      <ul>
        <li v-for="lead in lastLeads" :key="lead.id">
          {{ lead.nome }} - {{ lead.stato }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stats: {
        clients: 0,
        leads: 0,
        activities: 0,
        offers: 0
      },
      lastClients: [],
      lastLeads: []
    }
  },
  async created() {
    // Chiamata API per statistiche
    const resClients = await fetch("/api/clients");
    const clients = await resClients.json();
    this.stats.clients = clients.length;
    this.lastClients = clients.slice(-5);

    const resLeads = await fetch("/api/leads");
    const leads = await resLeads.json();
    this.stats.leads = leads.length;
    this.lastLeads = leads.slice(-5);

    const resActivities = await fetch("/api/activities");
    const activities = await resActivities.json();
    this.stats.activities = activities.length;

    const resOffers = await fetch("/api/offers");
    const offers = await resOffers.json();
    this.stats.offers = offers.length;
  }
}
</script>

<style>
.dashboard-cards { display: flex; gap: 2rem; }
.card { background: #eee; padding: 1rem; border-radius: 8px; width: 150px; }
.dashboard-lists { margin-top: 2rem; }
</style>