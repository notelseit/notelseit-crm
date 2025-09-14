<!-- ...dentro il template... -->
<button @click="confirmDelete(user.id)">Elimina</button>
<!-- ... -->
<div v-if="confirmId !== null" class="dialog">
  Confermi eliminazione utente?
  <button @click="deleteUser(confirmId)">Si</button>
  <button @click="confirmId=null">No</button>
</div>
<!-- ... -->
<script>
export default {
  data() { return { /* ... */, confirmId: null } },
  methods: {
    confirmDelete(id) { this.confirmId = id; },
    deleteUser(id) {
      fetch(`/api/users/${id}`, { method: 'DELETE', headers: { 'X-Admin-Key': 'fanculo2025' } })
        .then(() => this.users = this.users.filter(u => u.id !== id))
        .finally(() => this.confirmId = null);
    }
  }
}
</script>
<style>
.dialog { background: #eee; padding: 1em; border: 1px solid #ccc; }
</style>