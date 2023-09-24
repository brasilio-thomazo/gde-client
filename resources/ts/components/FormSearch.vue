<template>
  <form @submit.prevent="emit('search', form)" @reset="reset">
    <div class="form">
      <div v-if="props.fields.department" class="line">
        <label for="partiion_id">Departamento:</label>
        <select id="partiion_id" v-model="form.department_id">
          <option value="0">DEPARTAMENTOS</option>
          <option v-for="item in department.rows" :value="item.id">
            {{ item.name.toLocaleUpperCase() }}
          </option>
        </select>
      </div>
      <div v-if="props.fields.doc_type" class="line">
        <label for="doc_type_id">Tipos de documento:</label>
        <select id="doc_type_id" v-model="form.doc_type_id">
          <option value="0">TIPOS DE DOCUMENTO</option>
          <option v-for="item in dtype.rows" :value="item.id">
            {{ item.name.toLocaleUpperCase() }}
          </option>
        </select>
      </div>
      <div class="line">
        <label for="entity">Identificador:</label>
        <input type="text" id="entity" v-model="form.entity" />
      </div>
      <div v-if="props.fields.identity" class="line">
        <label for="identity">CPF/CNPJ:</label>
        <input
          type="tel"
          id="identity"
          v-model="form.identity"
          v-maska="identity"
          data-maska="['###.###.###-##', '##.###.###/####-##']"
        />
      </div>
      <div v-if="props.fields.name" class="line">
        <label for="name">Razão Social:</label>
        <input type="text" id="name" v-model="form.name" />
      </div>
      <div v-if="props.fields.comment" class="line">
        <label for="comment">Observação:</label>
        <input type="text" id="comment" v-model="form.comment" />
      </div>
      <div v-if="props.fields.storage" class="line">
        <label for="storage">Guarda:</label>
        <input type="text" id="storage" v-model="form.storage" />
      </div>
      <div class="line">
        <label for="storage">Data inicial:</label>
        <input type="date" id="storage" v-model="form.start_date" />
      </div>
      <div class="line">
        <label for="storage">Data final:</label>
        <input type="date" id="storage" v-model="form.end_date" />
      </div>
      <div class="buttons">
        <button type="reset">
          <span class="material-icons">clear</span>
          <span class="text">Limpar</span>
        </button>
        <button type="submit">
          <span class="material-icons">search</span>
          <span class="text">Pesquisar</span>
        </button>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useTypeStore } from '@/store/type-store'
import { useDepartmentStore } from '@/store/department-store'
import { vMaska, MaskaDetail } from 'maska'

const props = defineProps<{ fields: SearchField }>()
const emit = defineEmits<{ (e: 'search', form: SearchRequest): void }>()
const init: SearchRequest = {
  department_id: 0,
  doc_type_id: 0,
  entity: '',
  identity: '',
  name: '',
  comment: '',
  storage: '',
  start_date: '',
  end_date: '',
}

const maskDetail = {
  masked: '',
  unmasked: '',
  completed: false,
}

const identity = ref<MaskaDetail>({ ...maskDetail })

const dtype = useTypeStore()
const department = useDepartmentStore()

const form = ref<SearchRequest>({ ...init })

function reset() {
  form.value = { ...init }
}
</script>
