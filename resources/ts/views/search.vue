<template>
  <div id="search-view">
    <div class="search-pane">
      <ul class="search-bar">
        <li><span class="brand">Pesquisa</span></li>
        <li v-for="(s, i) in search.rows">
          <button
            @click="loadSearch(i)"
            type="button"
            :class="[{ active: searchIndex === i }]"
          >
            <span class="material-icons">search</span>
            <span class="text">{{ s.name }}</span>
          </button>
        </li>
      </ul>
      <div class="tab">
        <FormSearch
          :fields="search.rows[searchIndex].fields"
          @search="onSearch"
        />
        <DocumentList
          v-if="page?.data && page.data.length > 0"
          :page="page"
          @navigate="navigate"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import DocumentList from '@/components/DocumentList.vue'
import FormSearch from '@/components/FormSearch.vue'
import { useTypeStore } from '@/store/type-store'
import { useDepartmentStore } from '@/store/department-store'
import { useSearchStore } from '@/store/search-store'
import axios from 'axios'
import { inject, ref } from 'vue'

const searchIndex = ref(0)
const page = ref<Page<Document>>()
const http = inject('http', axios)

const dtype = useTypeStore()
const department = useDepartmentStore()
const search = useSearchStore()

function loadSearch(i: number) {
  searchIndex.value = i
}

async function onSearch(request: SearchRequest) {
  try {
    const identity = request.identity.replace(/[^\d]/g, '')
    const form = { ...request, identity }
    const { data } = await http.get<Page<Document>>('document/search', {
      params: form,
    })
    page.value = data
  } catch ({ response }: any) {}
}

async function navigate(url: string) {
  try {
    const { data } = await http.get<Page<Document>>(url)
    page.value = data
  } catch ({ response }: any) {}
}

try {
  if (dtype.rows.length === 0) {
    const { data } = await http.get<DocType[]>('type')
    dtype.setRows(data)
  }
  if (search.rows.length === 0) {
    const { data } = await http.get<Search[]>('search')
    search.setRows(data)
  }
  if (department.rows.length === 0) {
    const { data } = await http.get<Department[]>('department')
    department.setRows(data)
  }
} catch ({ response }: any) {
  console.log('ERROR: ', response)
}
</script>
