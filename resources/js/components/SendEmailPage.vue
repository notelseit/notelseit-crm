<template>
  <div>
    <h2>Invia Email</h2>
    <form @submit.prevent="sendEmail">
      <input v-model="email.to" type="email" placeholder="Destinatario" required />
      <span v-if="errors.to">{{ errors.to }}</span>
      <!-- ...altri campi... -->
      <button type="submit" :disabled="loading">Invia</button>
      <span v-if="loading">Invio...</span>
      <span v-if="msg">{{ msg }}</span>
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return { email: { to: '', role: 'admin', subject: '' }, msg: '', errors: {}, loading: false }
  },
  methods: {
    sendEmail() {
      this.errors = {};
      if (!this.email.to) {
        this.errors.to = "Email richiesta!";
        return;
      }
      this.loading = true;
      fetch('/api/send-email', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Admin-Key': 'fanculo2025' },
        body: JSON.stringify(this.email)
      }).then(res => res.json())
        .then(data => this.msg = data.status || 'Email inviata')
        .catch(() => this.msg = 'Errore invio')
        .finally(() => this.loading = false);
    }
  }
}
</script>