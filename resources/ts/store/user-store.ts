import { defineStore } from 'pinia'
import { ref } from 'vue'
import lodash from 'lodash'

export const useUserStore = defineStore('user.store', () => {
  const rows = ref<User[]>([])

  function create(payload: User) {
    rows.value.unshift(payload)
  }

  function edit(payload: User) {
    rows.value = rows.value.map((r) => (r.id === payload.id ? payload : r))
  }

  function destroy(payload: User) {
    const index = lodash.findIndex(rows.value, { id: payload.id })
    if (index >= 0) rows.value.splice(index, 1)
  }

  function setRows(payload: User[]) {
    rows.value = payload
  }

  return { rows, create, edit, destroy, setRows }
})
