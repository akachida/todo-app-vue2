<template>
  <b-modal id="todoForm" title="Cadastrar Tarefa" @ok="handleOk">
    <b-form @submit.stop.prevent="onSubmit">
      <b-form-group label="Título *" label-for="titulo" class="required">
        <b-input id="id" required aria-required="true" maxlength="50" v-model="titulo" />
      </b-form-group>
      <b-form-group>
        <label for="createdAt">Data da tarefa*</label>
        <b-datepicker name="createdAt" id="createdAt" v-model="createdAt" />
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
import { Component, Vue, Watch } from 'vue-property-decorator'
import { BvModalEvent } from 'bootstrap-vue'
import { v4 as uuidv4 } from 'uuid'
import { namespace } from 'vuex-class'

import TodoService from '@/services/todo.service'
import { Todo as TodoType } from '@/types/Todo/Todo'
import { Status } from '@/types/Todo/Status'

const todoStore = namespace('todo')

@Component
export default class Form extends Vue {
  public titulo = ''

  public descricao = ''

  public createdAt = new Date()

  @todoStore.Action
  private newTodo!: (todo: TodoType) => boolean

  public hideModal(): void {
    this.$bvModal.hide('todoForm')
  }

  public handleOk(event: BvModalEvent): void {
    event.preventDefault()
    this.onSubmit()
  }

  private isSameDate(): boolean {
    const curDay = this.$store.state.curDate.getDate()
    const curMonth = this.$store.state.curDate.getMonth()
    const curYear = this.$store.state.curDate.getFullYear()

    const formDay = this.createdAt.getDate()
    const formMonth = this.createdAt.getMonth()
    const formYear = this.createdAt.getFullYear()

    return (
      curDay === formDay
      && curMonth === formMonth
      && curYear === formYear
    )
  }

  public async onSubmit(): Promise<void> {
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

    if (!this.createdAt) {
      this.$bvToast.toast(
        'A data deve ser cadastrada',
        {
          title: 'Atenção',
          variant: 'danger',
        },
      )
      return
    }

    this.createdAt = new Date(`${this.createdAt} 00:00:00`)

    const item: TodoType = {
      uuid: uuidv4(),
      title: this.titulo,
      description: this.descricao,
      status: [Status.Pending],
      createdAt: this.createdAt,
    }

    try {
      const todoService = new TodoService()
      await todoService.add(item)
        .then((response) => {
          if (this.isSameDate()) {
            this.newTodo(item)
          }

          this.titulo = ''
          this.descricao = ''

          this.$bvToast.toast(
            response.data.message,
            {
              title: 'Atenção',
              variant: 'success',
            },
          )

          this.$nextTick(() => {
            this.hideModal()
          })
        })
        .catch((reason) => {
          throw Error(reason)
        })
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
