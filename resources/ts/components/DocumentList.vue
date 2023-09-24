<template>
  <div class="table">
    <table>
      <caption>
        <div class="header">
          <div class="text">
            A pesquisa retornou um total {{ props.page.total }} resultados.
          </div>
          <div class="pagination">
            <button
              v-if="props.page.prev_page_url"
              type="button"
              @click="emit('navigate', props.page.prev_page_url)"
            >
              <span class="material-icons">arrow_back</span>
            </button>
            <div class="page">
              Pagina {{ props.page.current_page }} de {{ props.page.last_page }}
            </div>
            <button
              v-if="props.page.next_page_url"
              class="pagination-buttons"
              type="button"
              @click="emit('navigate', props.page.next_page_url)"
            >
              <span class="material-icons">arrow_forward</span>
            </button>
          </div>
        </div>
      </caption>
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Departamento</th>
          <th>Identificador</th>
          <th>Razão social</th>
          <th>CPF/CNPJ</th>
          <th>Guarda</th>
          <th>Data</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in props.page.data">
          <td>{{ row.doc_type.name }}</td>
          <td>{{ row.department.name }}</td>
          <td>{{ row.entity }}</td>
          <td>{{ row.name }}</td>
          <td>{{ mask(row.identity) }}</td>
          <td>{{ row.storage }}</td>
          <td>{{ parseDate(row.doc_date) }}</td>
          <td>
            <div class="buttons">
              <a
                :href="`/document/${row.id}/download`"
                target="_blank"
                rel="noopener noreferrer"
              >
                <span class="material-icons">picture_as_pdf</span>
              </a>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { parseDate, mask } from '@/provider'

const props = defineProps<{ page: Page<Document> }>()
const emit = defineEmits<{ (e: 'navigate', url: string): void }>()
</script>
