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
      <b-form-group>
        <b-form-checkbox-group>
          <b-form-checkbox
            v-for="tag in tags"
            v-model="tagsSelected"
            :key="tag.uuid"
            :value="tag.uuid"
            name="tags[]"
          >
            <b-badge :style="`background-color: ${tag.color}`">{{ tag.name }}</b-badge>
          </b-form-checkbox>
        </b-form-checkbox-group>
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
import { namespace } from 'vuex-class'

import TodoService from '@/services/todo.service'
import TagService from '@/services/tag.service'
import { Todo as TodoType } from '@/types/Todo/Todo'
import { Tag as TagType } from '@/types/Tag/Tag'
import { Status } from '@/types/Todo/Status'

const todoStore = namespace('todo')
const tagStore = namespace('tag')

@Component
export default class Form extends Vue {
  /**
   * Props
   */
  public titulo = ''

  public descricao = ''

  public createdAt: string | Date = new Date()

  public tagsSelected = []

  public currentDate = this.$store.state.curDate

  /**
   * Stores
   */
  @tagStore.State
  public tags!: Array<TagType>

  @todoStore.Action
  private newTodo!: (todo: TodoType) => boolean

  @tagStore.Action
  private loadTags!: (tags: Array<TagType>) => boolean | Error

  /**
   * LifeCycles
   */
  mounted(): void {
    const tagService = new TagService()

    tagService.findAll({})
      .then((response) => {
        try {
          this.loadTags(response.data)
        } catch (e) {
          this.$bvToast.toast(
            e.message,
            {
              title: 'Atenção',
              variant: 'danger',
            },
          )
        }
      })
      .catch((reason) => {
        console.error(reason)
      })
  }

  /**
   * Methods
   */
  public hideModal(): void {
    this.$bvModal.hide('todoForm')
  }

  public handleOk(event: BvModalEvent): void {
    event.preventDefault()
    this.onSubmit()
  }

  public updateDate(): void {
    const curDate = (`0${this.$store.state.curDate.getDate()}`).substr(-2, 2)
    const curMont = (`0${this.$store.state.curDate.getMonth() + 1}`).substr(-2, 2)
    const curYear = this.$store.state.curDate.getFullYear()

    this.createdAt = `${curYear}-${curMont}-${curDate}`
  }

  private isSameDate(): boolean {
    if (this.createdAt instanceof Date) {
      const curDay = this.$store.state.curDate.getDate()
      const curMonth = this.$store.state.curDate.getMonth()
      const curYear = this.$store.state.curDate.getFullYear()

      const formDay = this.createdAt.getUTCDate()
      const formMonth = this.createdAt.getUTCMonth()
      const formYear = this.createdAt.getUTCFullYear()

      return (
        curDay === formDay
        && curMonth === formMonth
        && curYear === formYear
      )
    }

    return false
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

    const currentDate = new Date()
    const currentHours = currentDate.getHours()
    const currentMinutes = currentDate.getMinutes()
    const currentSeconds = currentDate.getSeconds()
    const currentTime = `${currentHours}:${currentMinutes}:${currentSeconds}`

    this.createdAt = new Date(`${this.createdAt}T${currentTime}Z`)

    const item: TodoType = {
      uuid: '',
      title: this.titulo,
      description: this.descricao,
      status: [Status.Pending],
      createdAt: this.createdAt,
      tags: this.tagsSelected,
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
