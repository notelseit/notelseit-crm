<template>
  <div>
    <h2>Impostazioni SMTP & Email</h2>
    <form @submit.prevent="save">
      <!-- ...campi... -->
      <button type="submit" :disabled="loading">Salva</button>
      <span v-if="loading">Salvataggio...</span>
      <span v-if="error" class="error">{{ error }}</span>
      <span v-if="success" class="success">{{ success }}</span>
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return { setting: {}, loading: false, error: '', success: '' }
  },
  mounted() {
    this.loading = true;
    fetch('/api/settings', { headers: { 'X-Admin-Key': 'fanculo2025' } })
      .then(res => res.json())
      .then(data => this.setting = data || {})
      .catch(() => this.error = 'Errore caricamento')
      .finally(() => this.loading = false);
  },
  methods: {
    save() {
      this.loading = true;
      this.error = '';
      this.success = '';
      fetch('/api/settings', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Admin-Key': 'fanculo2025' },
        body: JSON.stringify(this.setting)
      }).then(res => res.json())
        .then(() => this.success = 'Salvato!')
        .catch(() => this.error = 'Errore salvataggio')
        .finally(() => this.loading = false);
    }
  }
}
</script>
<style>
.error { color: red; }
.success { color: green; }
</style>