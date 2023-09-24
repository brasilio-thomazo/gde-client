<template>
  <div id="user-show">
    <div class="show">
      <fieldset>
        <legend>Pessoal</legend>
        <div class="data">
          <div class="line">
            <div class="label">Nome:</div>
            <div class="text">{{ props.data.name }}</div>
          </div>
          <div class="line">
            <div class="label">Cargo:</div>
            <div class="text">{{ props.data.department.name }}</div>
          </div>
          <div class="line">
            <div class="label">CPF/CNPJ:</div>
            <div class="text">{{ mask(props.data.identity) }}</div>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend>Contato</legend>
        <div class="data">
          <div class="line">
            <div class="label">Telefone:</div>
            <div class="text">{{ mask(props.data.phone, true) }}</div>
          </div>
          <div class="line">
            <div class="label">E-mail:</div>
            <div class="text">{{ props.data.email }}</div>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend>Usuário</legend>
        <div class="data">
          <div class="line">
            <div class="label">Usuário:</div>
            <div class="text">{{ props.data.username }}</div>
          </div>
          <div class="line">
            <div class="label">Registro:</div>
            <div class="text">{{ dateFormat(props.data.created_at) }}</div>
          </div>
        </div>
      </fieldset>
    </div>
  </div>
</template>

<script setup lang="ts">
import { dateFormat, mask } from '@/provider'

const props = defineProps<{ data: User }>()
</script>
