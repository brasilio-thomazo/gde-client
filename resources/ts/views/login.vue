<template>
  <div id="login">
    <form @submit.prevent="login">
      <div class="form">
        <div class="logo">
          <span class="material-icons">picture_as_pdf</span>
          <span class="app-name">EDContent</span>
        </div>
        <div class="line">
          <label for="username">Usuário:</label>
          <input
            type="text"
            name="username"
            id="username"
            v-model="form.username"
          />
          <span v-if="error?.errors?.username" class="error">
            {{ error.errors.username.join(', ') }}
          </span>
        </div>
        <div class="line">
          <label for="password">Senha:</label>
          <input
            type="password"
            name="password"
            id="password"
            v-model="form.password"
          />
          <span v-if="error?.errors?.password" class="error">
            {{ error.errors.password.join(', ') }}
          </span>
        </div>
        <div v-if="error?.message" class="error">
          {{ error.message }}
        </div>
        <div class="buttons">
          <button type="submit">
            <span class="material-icons">login</span>
            <span class="text">Entrar</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useStore } from '@/store/store'
import axios from 'axios'
import { inject, ref } from 'vue'
import { useRouter } from 'vue-router'

const init = { username: '', password: '', remember: false }

const http = inject('http', axios)
const store = useStore()

const error = ref<AuthError>()
const form = ref<AuthRequest>({ ...init })
const router = useRouter()

async function login() {
  try {
    await http.get('sanctum/csrf-cookie')
    const { data } = await http.post<User>('/login', form.value)
    store.setUser(data)
    router.push({ name: 'search' })
  } catch ({ response }: any) {
    error.value = response?.data
  }
}
</script>
