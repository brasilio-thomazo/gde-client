<template>
  <div id="group-list">
    <div class="table">
      <table>
        <caption>
          <div class="data">
            <div class="title">Grupos cadastrados</div>
          </div>
        </caption>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Grupos</th>
            <th>Usuários</th>
            <th>Pesquisas</th>
            <th>Documentos</th>
            <th>Tipos</th>
            <th>Departamentos</th>
            <th>Pesquisas</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in store.rows" :key="row.id">
            <td>{{ row.name }}</td>
            <td>
              <div class="permits">
                <div v-if="row.privileges?.group === 'rw'">
                  <span class="material-icons">check</span>
                  <span class="text">Escrita</span>
                </div>
                <div v-else-if="row.privileges?.group === 'r'">
                  <span class="material-icons">check</span>
                  <span class="text">Leitura</span>
                </div>
              </div>
            </td>
            <td>
              <div class="permits">
                <div v-if="row.privileges?.user === 'rw'">
                  <span class="material-icons">check</span>
                  <span class="text">Escrita</span>
                </div>
                <div v-else-if="row.privileges?.user === 'r'">
                  <span class="material-icons">check</span>
                  <span class="text">Leitura</span>
                </div>
              </div>
            </td>
            <td>
              <div class="permits">
                <div v-if="row.privileges?.search === 'rw'">
                  <span class="material-icons">check</span>
                  <span class="text">Escrita</span>
                </div>
                <div v-else-if="row.privileges?.search === 'r'">
                  <span class="material-icons">check</span>
                  <span class="text">Leitura</span>
                </div>
              </div>
            </td>
            <td>
              <div class="permits">
                <div v-if="row.privileges?.document === 'rw'">
                  <span class="material-icons">check</span>
                  <span class="text">Escrita</span>
                </div>
                <div v-else-if="row.privileges?.document === 'r'">
                  <span class="material-icons">check</span>
                  <span class="text">Leitura</span>
                </div>
              </div>
            </td>
            <td>{{ makeTypes(row.types).join(' | ') }}</td>
            <td>{{ makeDepartment(row.departments).join(' | ') }}</td>
            <td>{{ makeSearch(row.searches).join(' | ') }}</td>
            <td>
              <div class="buttons">
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
  </div>
</template>

<script setup lang="ts">
import axios from 'axios'
import { inject } from 'vue'
import { useGroupStore } from '@/store/group-store'
import { useTypeStore } from '@/store/type-store'
import { useDepartmentStore } from '@/store/department-store'
import { useSearchStore } from '@/store/search-store'
const store = useGroupStore()
const http = inject('http', axios)

const dtype = useTypeStore()
const department = useDepartmentStore()
const search = useSearchStore()

const emit = defineEmits<{ (e: 'edit', payload: Group): void }>()

async function destroy(group: Group) {
  try {
    if (confirm(`Tem certeza que deseja remover o grupo ${group.name}`)) {
      await http.delete(`group/${group.id}`)
      store.destroy(group)
    }
  } catch ({ response }: any) {}
}

function makeTypes(ids: number[]) {
  if (ids.length === 0) return ['Nenhum']
  if (ids.indexOf(0) >= 0) return ['Todos']
  const names: string[] = []
  dtype.rows.forEach((t) => {
    if (ids.indexOf(t.id) >= 0) {
      names.push(t.name)
    }
  })
  return names
}

function makeDepartment(ids: number[]) {
  if (ids.length === 0) return ['Nenhum']
  if (ids.indexOf(0) >= 0) return ['Todos']
  const names: string[] = []
  department.rows.forEach((t) => {
    if (ids.indexOf(t.id) >= 0) {
      names.push(t.name)
    }
  })
  return names
}

function makeSearch(ids: number[]) {
  if (ids.length === 0) return ['Nenhuma']
  if (ids.indexOf(0) >= 0) return ['Todas']
  const names: string[] = []
  search.rows.forEach((t) => {
    if (ids.indexOf(t.id) >= 0) {
      names.push(t.name)
    }
  })
  return names
}
</script>
