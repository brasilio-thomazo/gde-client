<template>
  <div id="group-create">
    <form @submit.prevent="save" @reset.prevent="reset">
      <div class="form">
        <div class="line">
          <label for="name">Nome:</label>
          <input type="text" id="name" v-model="form.name" />
          <span v-if="error?.errors?.name" class="error">
            {{ error.errors.name.join(',') }}
          </span>
        </div>
        <div class="line">
          <p class="label">Privilégios:</p>
          <div class="groups">
            <fieldset class="group">
              <legend>Grupos:</legend>
              <label class="box" for="group_read">
                <input
                  type="radio"
                  name="group"
                  value="r"
                  v-model="form.privileges.group"
                  id="group_read"
                />
                <span class="icon"></span>
                <span class="text">Leitura</span>
              </label>
              <label class="box" for="group_write">
                <input
                  type="radio"
                  name="group"
                  value="rw"
                  v-model="form.privileges.group"
                  id="group_write"
                />
                <span class="icon"></span>
                <span class="text">Escrita</span>
              </label>
            </fieldset>
            <fieldset class="group">
              <legend>Usuários:</legend>
              <label class="box" for="user_read">
                <input
                  type="radio"
                  name="user"
                  value="r"
                  v-model="form.privileges.user"
                  id="user_read"
                />
                <span class="text">Leitura</span>
              </label>
              <label class="box" for="user_write">
                <input
                  type="radio"
                  name="user"
                  value="rw"
                  v-model="form.privileges.user"
                  id="user_write"
                />
                <span class="text">Escrita</span>
              </label>
            </fieldset>
            <fieldset class="group">
              <legend>Pesquisas:</legend>
              <label class="box" for="client_read">
                <input
                  type="radio"
                  name="client"
                  value="r"
                  v-model="form.privileges.search"
                  id="client_read"
                />
                <span class="text">Leitura</span>
              </label>
              <label class="box" for="client_write">
                <input
                  type="radio"
                  name="client"
                  value="rw"
                  v-model="form.privileges.search"
                  id="client_write"
                />
                <span class="text">Escrita</span>
              </label>
            </fieldset>
            <fieldset class="group">
              <legend>Documentos:</legend>
              <label class="box" for="app_read">
                <input
                  type="radio"
                  name="app"
                  value="r"
                  v-model="form.privileges.document"
                  id="app_read"
                />
                <span class="text">Leitura</span>
              </label>
              <label class="box" for="app_write">
                <input
                  type="radio"
                  name="app"
                  value="rw"
                  v-model="form.privileges.document"
                  id="app_write"
                />
                <span class="text">Escrita</span>
              </label>
            </fieldset>
          </div>
          <span v-if="error?.errors?.privileges" class="error">
            {{ error.errors.privileges.join(',') }}
          </span>
        </div>
        <div v-if="form.privileges.document" class="line">
          <label for="type_0">Tipos de documento:</label>
          <div class="items">
            <div class="item">
              <label class="box" for="type_0">
                <input
                  type="checkbox"
                  :value="0"
                  v-model="form.types"
                  id="type_0"
                />
                <span class="text">Todos</span>
              </label>
            </div>
            <div v-for="t in dtype.rows" class="item">
              <label class="box" :for="`type_${t.id}`">
                <input
                  type="checkbox"
                  :value="t.id"
                  v-model="form.types"
                  :id="`type_${t.id}`"
                  :disabled="form.types.indexOf(0) >= 0"
                />
                <span class="text">{{ t.name }}</span>
              </label>
            </div>
          </div>
          <span v-if="error?.errors?.types" class="error">
            {{ error.errors.types.join(',') }}
          </span>
        </div>
        <div v-if="form.privileges.document" class="line">
          <label for="department_0">Departamentos:</label>
          <div class="items">
            <div class="item">
              <label class="box" for="department_0">
                <input
                  type="checkbox"
                  :value="0"
                  v-model="form.departments"
                  id="department_0"
                />
                <span class="text">Todos</span>
              </label>
            </div>
            <div v-for="value in department.rows" class="item">
              <label class="box" :for="`department_${value.id}`">
                <input
                  type="checkbox"
                  :value="value.id"
                  v-model="form.departments"
                  :id="`department_${value.id}`"
                  :disabled="form.departments.indexOf(0) >= 0"
                />
                <span class="text">{{ value.name }}</span>
              </label>
            </div>
          </div>
          <span v-if="error?.errors?.departments" class="error">
            {{ error.errors.departments.join(',') }}
          </span>
        </div>
        <div v-if="form.privileges.document" class="line">
          <label for="search_0">Pesquisas:</label>
          <div class="items">
            <div class="item">
              <label class="box" for="search_0">
                <input
                  type="checkbox"
                  :value="0"
                  v-model="form.searches"
                  id="search_0"
                />
                <span class="text">Todos</span>
              </label>
            </div>
            <div v-for="value in search.rows" class="item">
              <label class="box" :for="`search_${value.id}`">
                <input
                  type="checkbox"
                  :value="value.id"
                  v-model="form.searches"
                  :id="`search_${value.id}`"
                  :disabled="form.searches.indexOf(0) >= 0"
                />
                <span class="text">{{ value.name }}</span>
              </label>
            </div>
          </div>
          <span v-if="error?.errors?.searches" class="error">
            {{ error.errors.searches.join(',') }}
          </span>
        </div>
        <div v-if="form.privileges.document" class="line">
          <label for="documents">Personalizados:</label>
          <div class="items">
            <div class="item">
              <select name="" id="documents" v-model="rules.documents">
                <option v-for="(value, key) in documents" :value="key">
                  DOCUMENTO.{{ value.toLocaleUpperCase() }}
                </option>
              </select>
            </div>
            <span class="material-icons">equal</span>
            <div class="item">
              <select name="" id="users" v-model="rules.users">
                <option v-for="(value, key) in users" :value="key">
                  USUÁRIO.{{ value.toLocaleUpperCase() }}
                </option>
              </select>
            </div>
            <button @click="addRule" type="button">
              <span class="material-icons">add</span>
            </button>
          </div>
          <div class="custom-rules">
            <div class="rule" v-for="value in form.custom">
              <span class="text">
                documento.{{ documents[value.documents] }}
              </span>
              <span class="material-icons">equal</span>
              <span class="text">usuário.{{ users[value.users] }}</span>
            </div>
          </div>
        </div>
        <div v-if="error?.message" class="error">{{ error.message }}</div>
        <div class="buttons">
          <button @click="reset" type="button">
            <span class="material-icons">clear_all</span>
            <span class="text">Limpar</span>
          </button>
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
import { inject, ref, watchEffect } from 'vue'
import axios from 'axios'
import { useTypeStore } from '@/store/type-store'
import { useDepartmentStore } from '@/store/department-store'
import { useSearchStore } from '@/store/search-store'

const emit = defineEmits<{ (e: 'close'): void }>()
const init = {
  name: '',
  privileges: {},
  types: [],
  departments: [],
  searches: [],
  custom: [],
}

const http = inject('http', axios)

const store = useGroupStore()
const dtype = useTypeStore()
const department = useDepartmentStore()
const search = useSearchStore()

const rules = ref<RuleCustom>({ documents: 'identity', users: 'identity' })
const error = ref<GroupError>()
const form = ref<GroupRequest>({ ...init })
const documents = {
  department_id: 'Departamento',
  identity: 'CPF/CNPJ',
  name: 'Razão Social',
}

const users = {
  name: 'Razão Social',
  identity: 'CPF/CNJP',
  department_id: 'Departamento',
}

async function save() {
  try {
    const request = { ...form.value }
    const { data } = await http.post<Group>('group', request)
    store.create(data)
    emit('close')
  } catch ({ response }: any) {
    error.value = response?.data
  }
}

function reset() {
  form.value = { ...init, privileges: {}, custom: [] }
}

function addRule() {
  if (rules.value !== undefined)
    form.value.custom.push({
      documents: rules.value.documents,
      users: rules.value.users,
    })
}

function setReadPermission() {
  const user = form.value.privileges.user
  const group = form.value.privileges.group
  if (user === 'rw' && group === undefined) {
    form.value.privileges.group = 'r'
  }

  if (form.value.types.indexOf(0) >= 0)
    if (form.value.types.length > 1) form.value.types = [0]

  if (form.value.departments.indexOf(0) >= 0)
    if (form.value.departments.length > 1) form.value.departments = [0]

  if (form.value.searches.indexOf(0) >= 0)
    if (form.value.searches.length > 1) form.value.searches = [0]
}

watchEffect(setReadPermission)
</script>
