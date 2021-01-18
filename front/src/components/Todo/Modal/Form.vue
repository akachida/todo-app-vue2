<template>
  <b-modal id="todoForm" :title="title" @ok="handleOk">
    <b-form @submit.stop.prevent="onSubmit">
      <input-text
        :label="'Título'"
        :name="'titulo'"
        :id="'id'"
        :required="true"
        :maxlength="30"
        @change="(value) => titulo = value"
      />
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
import { Component, Prop, Vue } from 'vue-property-decorator'
import { v4 as uuidv4 } from 'uuid'
import { namespace } from 'vuex-class'

import InputText from '@/components/core/form/InputText.vue'

import { Todo as TodoType } from '@/types/Todo/Todo'
import { BvModalEvent } from 'bootstrap-vue'
import { Status } from '@/types/Todo/Status'

const todoStore = namespace('todo')

@Component({
  components: {
    InputText,
  },
})
export default class Form extends Vue {
  @Prop({ required: true, default: 'Cadastrar Tarefa' }) public title!: string

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
    const id = uuidv4()

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
      id,
      title: this.titulo,
      description: this.descricao,
      status: [Status.Pending],
    }

    if (this.newTodo(item)) {
      this.titulo = ''
      this.descricao = ''

      this.$nextTick(() => {
        this.hideModal()
      })
    }
  }
}
</script>
