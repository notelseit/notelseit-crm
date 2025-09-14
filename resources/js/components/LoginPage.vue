<template>
  <div>
    <h2>Login CRM</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Login</button>
    </form>
    <div v-if="error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  data() { return { email: '', password: '', error: '' } },
  methods: {
    login() {
      fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: this.email, password: this.password })
      }).then(res => res.json())
        .then(data => {
          if(data.token) {
            localStorage.setItem('token', data.token);
            this.$router.push('/');
          } else {
            this.error = 'Credenziali non valide';
          }
        });
    }
  }
}
</script>