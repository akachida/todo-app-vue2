<template>
  <b-modal id="todoForm" :title="title">
    <p>Teste</p>
  </b-modal>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'

@Component
export default class Form extends Vue {
  @Prop({ required: true, default: 'Cadastrar Tarefa' }) public title!: string
}
</script>
