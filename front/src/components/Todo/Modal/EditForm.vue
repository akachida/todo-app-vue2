<template>
  <b-modal id="editForm" title="Editar Tarefa" @ok="handleOk">
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
          >
            <b-badge :style="`background-color: ${tag.color}`">
              {{ tag.name }}
            </b-badge>
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
import { Component, Prop, Vue, Watch } from 'vue-property-decorator'
import { BvModalEvent } from 'bootstrap-vue'
import { namespace } from 'vuex-class'

import TagService from '@/services/tag.service'
import { Todo as TodoType } from '@/types/Todo/Todo'
import { Tag as TagType } from '@/types/Tag/Tag'

const todoStore = namespace('todo')
const tagStore = namespace('tag')

@Component
export default class EditForm extends Vue {
  /**
   * Props
   */
  @Prop() public todo!: TodoType

  public titulo = ''

  public descricao? = ''

  public createdAt = this.todo?.createdAt

  public tagsSelected?: Array<string> = []

  /**
   * Stores
   */
  @tagStore.State
  public tags!: Array<TagType>

  @todoStore.Action
  public updateTodo!: (todo: TodoType) => boolean | Error

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
   * Watchers
   */
  @Watch('todo')
  onTodoUpdate(current: TodoType): void {
    this.$nextTick(() => {
      this.createdAt = new Date(current.createdAt)
      this.tagsSelected = this.todo.tags?.map((tag) => tag.uuid)
    })
  }

  /**
   * Methods
   */
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
