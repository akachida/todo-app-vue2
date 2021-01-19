<template>
  <b-modal id="editForm" title="Editar Tarefa" @ok="handleOk">
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
import { Component, Prop, Vue, Watch } from 'vue-property-decorator'
import { namespace } from 'vuex-class'

import { Todo as TodoType } from '@/types/Todo/Todo'
import { BvModalEvent } from 'bootstrap-vue'

const todoStore = namespace('todo')

@Component
export default class EditForm extends Vue {
  @Prop() public todo!: TodoType

  public titulo = ''

  public descricao? = ''

  @todoStore.Action
  public updateTodo!: (todo: TodoType) => boolean | Error

  public hideModal(): void {
    this.$bvModal.hide('editForm')
  }

  public handleOk(event: BvModalEvent): void {
    event.preventDefault()
    this.onSubmit()
  }

  public onSubmit(): void {
    const updatedTodo: TodoType = {
      ...this.todo,
      title: this.titulo,
      description: this.descricao,
    }

    try {
      if (this.updateTodo(updatedTodo)) {
        this.$bvToast.toast(
          'Tarefa atualizada',
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

  @Watch('todo')
  public updateProps(current: TodoType): void {
    this.titulo = current.title
    this.descricao = current.description
  }
}
</script>
