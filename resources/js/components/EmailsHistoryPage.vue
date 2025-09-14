<template>
  <div>
    <h2>Storico Email Inviate</h2>
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Destinatario</th>
          <th>Ruolo</th>
          <th>Oggetto</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="mail in emails" :key="mail.id">
          <td>{{ mail.sent_at }}</td>
          <td>{{ mail.to }}</td>
          <td>{{ mail.role }}</td>
          <td>{{ mail.subject }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() { return { emails: [] } },
  mounted() {
    fetch('/api/emails-history', { headers: { 'X-Admin-Key': 'fanculo2025' } })
      .then(res => res.json())
      .then(data => this.emails = data);
  }
}
</script>