<template>
  <b-modal id="todoForm" title="Cadastrar Tarefa" @ok="handleOk">
    <b-form @submit.stop.prevent="onSubmit">
      <b-form-group label="Título *" label-for="titulo" class="required">
        <b-input id="id" required aria-required="true" maxlength="50" v-model="titulo" />
      </b-form-group>
      <b-form-group label="Descrição" label-for="descricao">
        <b-textarea id="descricao" v-model="descricao"></b-textarea>
      </b-form-group>
      <template #modal-footer>
        <b-button @click="hideModal">Cancelar</b-button>
        <b-button type="submit">Cadastrar</b-button>
      </template>
    </b-form>
  </b-modal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { BvModalEvent } from 'bootstrap-vue'
import { v4 as uuidv4 } from 'uuid'
import { namespace } from 'vuex-class'

import { Todo as TodoType } from '@/types/Todo/Todo'
import { Status } from '@/types/Todo/Status'

const todoStore = namespace('todo')

@Component
export default class Form extends Vue {
  public titulo = ''

  public descricao = ''

  @todoStore.Action
  public newTodo!: (todo: TodoType) => boolean

  hideModal(): void {
    this.$bvModal.hide('todoForm')
  }

  handleOk(event: BvModalEvent): void {
    event.preventDefault()
    this.onSubmit()
  }

  onSubmit(): void {
    if (!this.titulo) {
      this.$bvToast.toast(
        'Título é obrigatório',
        {
          title: 'Atenção',
          variant: 'danger',
          solid: true,
        },
      )
      return
    }

    if (this.titulo.length < 5) {
      this.$bvToast.toast(
        'Título deve conter pelo menos 5 caracteres',
        {
          title: 'Atenção',
          variant: 'danger',
        },
      )
      return
    }

    const item: TodoType = {
      uuid: uuidv4(),
      title: this.titulo,
      description: this.descricao,
      status: [Status.Pending],
    }

    try {
      if (this.newTodo(item)) {
        this.titulo = ''
        this.descricao = ''

        this.$bvToast.toast(
          'Tarefa cadastrada',
          {
            title: 'Atenção',
            variant: 'success',
          },
        )

        this.$nextTick(() => {
          this.hideModal()
        })
      }
    } catch (e) {
      this.$bvToast.toast(
        e.message,
        {
          title: 'Atenção',
          variant: 'danger',
        },
      )
    }
  }
}
</script>
