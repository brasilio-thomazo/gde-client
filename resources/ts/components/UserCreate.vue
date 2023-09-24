<template>
  <div id="user-create">
    <form @submit.prevent="save">
      <div class="form">
        <div class="line">
          <label for="name">Nome:</label>
          <input type="text" id="name" v-model="form.name" required />
          <span v-if="error?.errors?.name" class="error">
            {{ error.errors.name.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="identity">CPF/CNPJ:</label>
          <input
            type="tel"
            id="identity"
            v-model="form.identity"
            v-maska="identity"
            data-maska="['###.###.###-##', '##.###.###/####-##']"
            pattern="^[0-9]{2,3}\.[0-9]{3}\.[0-9]{3}((\/[0-9]{4})?)-[0-9]{2}$"
            required
          />
          <span v-if="error?.errors?.identity" class="error">
            {{ error.errors.identity.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="department">Departamento:</label>
          <select name="" id="department_id" v-model="form.department_id">
            <option value="2">Clientes</option>
            <option v-for="value in department.rows" :value="value.id">
              {{ value.name }}
            </option>
          </select>
          <span v-if="error?.errors?.department_id" class="error">
            {{ error.errors.department_id.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="phone">Telefone:</label>
          <input
            type="tel"
            id="phone"
            v-model="form.phone"
            v-maska="phone"
            data-maska="['(##) #####-####', '(##) ####-####']"
            pattern="^\([0-9]{2}\) (9?)[0-9]{4}-[0-9]{4}$"
            required
          />
          <span v-if="error?.errors?.phone" class="error">
            {{ error.errors.phone.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="email">E-mail:</label>
          <input type="email" id="email" v-model="form.email" />
          <span v-if="error?.errors?.email" class="error">
            {{ error.errors.email.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="username">Usuário:</label>
          <input type="text" id="username" v-model="form.username" />
          <span v-if="error?.errors?.username" class="error">
            {{ error.errors.username.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="password">Senha:</label>
          <input type="password" id="password" v-model="form.password" />
          <span v-if="error?.errors?.password" class="error">
            {{ error.errors.password.join(',') }}
          </span>
        </div>
        <div class="line">
          <label for="password_confirmation">Confirme a senha:</label>
          <input
            type="password"
            id="password_confirmation"
            v-model="form.password_confirmation"
          />
        </div>
        <div class="line">
          <label for="group">Grupos:</label>
          <div class="items">
            <div class="item" v-for="group in gStore.rows">
              <label class="box" :for="`group_${group.id}`">
                <input
                  type="checkbox"
                  v-model="form.groups"
                  :value="group.id"
                  :id="`group_${group.id}`"
                />
                <span class="icon"></span>
                <span class="text">{{ group.name }}</span>
              </label>
            </div>
          </div>
          <span v-if="error?.errors?.groups" class="error">
            {{ error.errors.groups.join(',') }}
          </span>
        </div>
        <div class="buttons">
          <button type="submit">
            <span class="material-icons">save</span>
            <span class="text">Salvar</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useGroupStore } from '@/store/group-store'
import { useUserStore } from '@/store/user-store'
import { inject, ref } from 'vue'
import { vMaska, MaskaDetail } from 'maska'
import axios from 'axios'
import { useDepartmentStore } from '@/store/department-store'
const init: UserRequest = {
  name: '',
  identity: '',
  department_id: 2,
  phone: '',
  email: '',
  username: '',
  password: '',
  password_confirmation: '',
  groups: [],
}

const maskDetail = {
  masked: '',
  unmasked: '',
  completed: false,
}

const emit = defineEmits<{ (e: 'close'): void }>()

const http = inject('http', axios)

const gStore = useGroupStore()
const store = useUserStore()
const department = useDepartmentStore()

const error = ref<UserError>()
const form = ref<UserRequest>({ ...init })

const identity = ref<MaskaDetail>({ ...maskDetail })
const phone = ref<MaskaDetail>({ ...maskDetail })

async function save() {
  try {
    const request = {
      ...form.value,
      identity: identity.value.unmasked,
      phone: phone.value.unmasked,
    }
    const { data } = await http.post<User>('user', request)
    store.create(data)
    emit('close')
  } catch ({ response }: any) {
    error.value = response?.data
  }
}

if (gStore.rows.length === 0) {
  try {
    const { data } = await http.get<Group[]>('group')
    gStore.rows = data
  } catch ({ response }: any) {}
}
</script>
