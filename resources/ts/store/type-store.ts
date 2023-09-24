import { defineStore } from 'pinia'
import { ref } from 'vue'
import lodash from 'lodash'

export const useTypeStore = defineStore('type.store', () => {
  const rows = ref<DocType[]>([])

  function create(payload: DocType) {
    rows.value.unshift(payload)
  }

  function edit(payload: DocType) {
    rows.value = rows.value.map((r) => (r.id === payload.id ? payload : r))
  }

  function destroy(payload: DocType) {
    const index = lodash.findIndex(rows.value, { id: payload.id })
    if (index >= 0) rows.value.splice(index, 1)
  }

  function setRows(payload: DocType[]) {
    rows.value = payload
  }

  return { rows, create, edit, destroy, setRows }
})
