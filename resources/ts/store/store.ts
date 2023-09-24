import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useStore = defineStore('main.store', () => {
  const user = ref<User>()

  function setUser(payload: User) {
    user.value = payload
  }

  return { setUser, user }
})
