import { defineStore } from 'pinia'
import { ref } from 'vue'
import lodash from 'lodash'

export const useSearchStore = defineStore('search.store', () => {
  const rows = ref<Search[]>([])

  function create(payload: Search) {
    rows.value.unshift(payload)
  }

  function edit(payload: Search) {
    rows.value = rows.value.map((r) => (r.id === payload.id ? payload : r))
  }

  function destroy(payload: Search) {
    const index = lodash.findIndex(rows.value, { id: payload.id })
    if (index >= 0) rows.value.splice(index, 1)
  }

  function setRows(payload: Search[]) {
    rows.value = payload
  }

  return { rows, create, edit, destroy, setRows }
})
