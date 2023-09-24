<template>
  <div id="user-view">
    <div class="tabpane">
      <div class="header">
        <div
          v-for="(tab, i) in tabs"
          :class="['title', { active: tabIndex === i }]"
        >
          <button @click="tabIndex = i" type="button">
            <span v-if="tab.icon" class="material-symbols-outlined">
              {{ tab.icon }}
            </span>
            <span class="text">{{ tab.title }}</span>
          </button>
          <button
            v-if="i !== 0"
            @click="closeFromIndex(i)"
            type="button"
            class="material-symbols-outlined"
          >
            close
          </button>
        </div>
      </div>
      <div class="content">
        <div class="tab">
          <KeepAlive exclude="UserEdit">
            <component
              :is="tabs[tabIndex].slot"
              @edit="edit"
              @close="close"
              @show="show"
              :data="current"
            />
          </KeepAlive>
        </div>
      </div>
      <div class="buttons">
        <button @click="create" type="button">
          <span class="material-icons">add</span>
          <span class="text">Novo usuário</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import UserList from '@/components/UserList.vue'
import { inject, ref, shallowRef } from 'vue'
import { useUserStore } from '@/store/user-store'
import axios from 'axios'
import _ from 'lodash'
import UserCreate from '@/components/UserCreate.vue'
import UserEdit from '@/components/UserEdit.vue'
import UserShow from '@/components/UserShow.vue'
import { useGroupStore } from '@/store/group-store'
import { useDepartmentStore } from '@/store/department-store'
interface Tab {
  slot: any
  icon: string
  type: 'create' | 'edit' | 'list' | 'show'
  title: string
}
const tabIndex = ref<number>(0)
const current = ref<User>()
const tabs = ref<Tab[]>([
  { slot: shallowRef(UserList), icon: 'list', title: 'Usuários', type: 'list' },
])
const store = useUserStore()
const group = useGroupStore()
const department = useDepartmentStore()
const http = inject('http', axios)

function create() {
  const i = _.findIndex(tabs.value, { type: 'create' })
  if (i > 0) {
    tabIndex.value = i
  } else {
    tabs.value.push({
      slot: shallowRef(UserCreate),
      icon: 'add',
      title: 'Cadastro',
      type: 'create',
    })
    tabIndex.value = tabs.value.length - 1
  }
}

function edit(payload: User) {
  closeFromType('edit')
  closeFromType('show')
  tabs.value.push({
    slot: shallowRef(UserEdit),
    icon: 'edit',
    title: payload.name,
    type: 'edit',
  })
  current.value = payload
  tabIndex.value = tabs.value.length - 1
}

function show(payload: User) {
  closeFromType('edit')
  closeFromType('show')
  tabs.value.push({
    slot: shallowRef(UserShow),
    icon: 'preview',
    title: payload.name,
    type: 'show',
  })
  current.value = payload
  tabIndex.value = tabs.value.length - 1
}

function closeFromType(payload: 'create' | 'edit' | 'list' | 'show') {
  const i = _.findIndex(tabs.value, { type: payload })
  if (i >= 0) closeFromIndex(i)
}

function closeFromIndex(payload: number) {
  if (payload - 1 >= 0) tabIndex.value = payload - 1
  tabs.value.splice(payload, 1)
}

function close() {
  closeFromIndex(tabIndex.value)
}

try {
  if (store.rows.length === 0) {
    const { data } = await http.get<User[]>('user')
    store.setRows(data)
  }

  if (group.rows.length === 0) {
    const { data } = await http.get<Group[]>('group')
    group.setRows(data)
  }

  if (department.rows.length === 0) {
    const { data } = await http.get<Department[]>('department')
    department.setRows(data)
  }
} catch ({ response }: any) {
  console.log('ERROR: ', response)
}
</script>
