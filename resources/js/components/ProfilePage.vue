<template>
  <div>
    <h2>Profilo Utente</h2>
    <div v-if="user">
      <p><strong>Nome:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Ruolo:</strong> {{ user.role }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() { return { user: null } },
  mounted() {
    fetch('/api/profile', { headers: { 'X-Admin-Key': 'fanculo2025' } })
      .then(res => res.json())
      .then(data => this.user = data);
  }
}
</script>