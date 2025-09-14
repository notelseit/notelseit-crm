<template>
  <div>
    <h1>CRM Admin Dashboard</h1>
    <nav>
      <router-link to="/settings">Impostazioni SMTP/Email</router-link> |
      <router-link to="/users">Gestione Utenti</router-link> |
      <router-link to="/send-email">Invia Email</router-link> |
      <router-link to="/emails-history">Storico Email</router-link> |
      <router-link to="/profile">Profilo</router-link>
      <button @click="logout">Logout</button>
    </nav>
    <router-view/>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    }
  }
}
</script>