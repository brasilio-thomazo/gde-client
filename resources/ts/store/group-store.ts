import { defineStore } from 'pinia'
import { ref } from 'vue'
import lodash from 'lodash'

export const useGroupStore = defineStore('group.store', () => {
  const rows = ref<Group[]>([])

  function create(payload: Group) {
    rows.value.unshift(payload)
  }

  function edit(payload: Group) {
    rows.value = rows.value.map((r) => (r.id === payload.id ? payload : r))
  }

  function destroy(payload: Group) {
    const index = lodash.findIndex(rows.value, { id: payload.id })
    if (index >= 0) rows.value.splice(index, 1)
  }

  function setRows(payload: Group[]) {
    rows.value = payload
  }

  return { rows, create, edit, destroy, setRows }
})
