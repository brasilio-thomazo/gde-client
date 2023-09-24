import { defineStore } from 'pinia'
import { ref } from 'vue'
import lodash from 'lodash'

export const useDepartmentStore = defineStore('partition.store', () => {
  const rows = ref<Department[]>([])

  function create(payload: Department) {
    rows.value.unshift(payload)
  }

  function edit(payload: Department) {
    rows.value = rows.value.map((r) => (r.id === payload.id ? payload : r))
  }

  function destroy(payload: Department) {
    const index = lodash.findIndex(rows.value, { id: payload.id })
    if (index >= 0) rows.value.splice(index, 1)
  }

  function setRows(payload: Department[]) {
    rows.value = payload
  }

  return { rows, create, edit, destroy, setRows }
})
