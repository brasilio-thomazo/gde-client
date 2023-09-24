import { defineStore } from 'pinia'
import { ref } from 'vue'
import lodash from 'lodash'

export const usePartitionStore = defineStore('partition.store', () => {
  const rows = ref<DocPartition[]>([])

  function create(payload: DocPartition) {
    rows.value.unshift(payload)
  }

  function edit(payload: DocPartition) {
    rows.value = rows.value.map((r) => (r.id === payload.id ? payload : r))
  }

  function destroy(payload: DocPartition) {
    const index = lodash.findIndex(rows.value, { id: payload.id })
    if (index >= 0) rows.value.splice(index, 1)
  }

  function setRows(payload: DocPartition[]) {
    rows.value = payload
  }

  return { rows, create, edit, destroy, setRows }
})
