<template>
  <div id="group-view">
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
          <KeepAlive exclude="GroupEdit">
            <component
              :is="tabs[tabIndex].slot"
              @edit="edit"
              @close="close"
              :data="current"
            />
          </KeepAlive>
        </div>
      </div>
      <div class="buttons">
        <button @click="create" type="button">
          <span class="material-icons">add</span>
          <span class="text">Novo grupo</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useGroupStore } from '@/store/group-store'
import GroupList from '@components/GroupList.vue'
import { useTypeStore } from '@/store/type-store'
import { useDepartmentStore } from '@/store/department-store'
import { useSearchStore } from '@/store/search-store'
import { inject, ref, shallowRef } from 'vue'
import axios from 'axios'
import GroupCreate from '@/components/GroupCreate.vue'
import GroupEdit from '@/components/GroupEdit.vue'
import _ from 'lodash'

interface Tab {
  slot: any
  icon: string
  type: 'create' | 'edit' | 'list'
  title: string
}

const store = useGroupStore()
const dtype = useTypeStore()
const department = useDepartmentStore()
const search = useSearchStore()
const http = inject('http', axios)

const tabIndex = ref<number>(0)
const current = ref<Group>()
const tabs = ref<Tab[]>([
  { slot: shallowRef(GroupList), icon: 'list', title: 'Grupos', type: 'list' },
])

async function create() {
  const i = _.findIndex(tabs.value, { type: 'create' })
  if (i > 0) {
    tabIndex.value = i
  } else {
    tabs.value.push({
      slot: shallowRef(GroupCreate),
      icon: 'group_add',
      title: 'Cadastro',
      type: 'create',
    })
    tabIndex.value = tabs.value.length - 1
  }
}

async function edit(payload: Group) {
  closeFromType('edit')
  tabs.value.push({
    slot: shallowRef(GroupEdit),
    icon: 'edit_note',
    title: payload.name,
    type: 'edit',
  })
  current.value = payload
  tabIndex.value = tabs.value.length - 1
}

try {
  if (store.rows.length === 0) {
    const { data } = await http.get<Group[]>('group')
    store.setRows(data)
  }
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

function closeFromType(payload: 'create' | 'edit' | 'list') {
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
</script>
