<template>
  <div class="table">
    <table>
      <caption>
        <div class="data">
          <div class="title">Usuários cadastrados</div>
        </div>
      </caption>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Telefone</th>
          <th>Usuário</th>
          <th>Grupos</th>
          <th>Data</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in store.rows">
          <td>{{ row.name }}</td>
          <td>{{ mask(row.phone, true) }}</td>
          <td>{{ row.username }}</td>
          <td>{{ row.groups.map((g) => g.name).join(' | ') }}</td>
          <td>{{ dateFormat(row.created_at) }}</td>
          <td>
            <div class="buttons">
              <button @click="emit('show', row)" type="button" class="icon">
                <span class="material-icons">pageview</span>
              </button>
              <button @click="emit('edit', row)" type="button" class="icon">
                <span class="material-icons">edit</span>
              </button>
              <button @click="destroy(row)" type="button" class="icon">
                <span class="material-icons">delete</span>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { useUserStore } from '@store/user-store'
import axios from 'axios'
import { inject } from 'vue'
import { dateFormat, mask } from '@/provider'
const store = useUserStore()
const http = inject('http', axios)

const emit = defineEmits<{
  (e: 'edit', payload: User): void
  (e: 'show', payload: User): void
}>()

async function destroy(user: User) {
  try {
    if (confirm(`Tem certeza que deseja remover o usuário ${user.username}`)) {
      await http.delete(`user/${user.id}`)
      store.destroy(user)
    }
  } catch ({ response }: any) {}
}
</script>
