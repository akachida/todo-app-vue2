<template>
  <div>
    <ModalEditForm :todo="editTodo" />
    <b-list-group class="mt-2">
      <b-list-group-item
        v-for="todo in list"
        :key="todo.uuid"
        :class="{
        'arquivada': todo.status.includes(Status.Archived),
        'undone': !todo.status.includes(Status.Done),
        'done': todo.status.includes(Status.Done)
      }"
      >
      <span class="mr-2 titulo align-middle d-inline-block">
        {{ todo.title }}
      </span>
        <div class="d-inline-block tags">
          <b-badge class="mr-1">tags</b-badge>
          <b-badge>tags</b-badge>
        </div>
        <div class="float-right actions">
          <div class="d-sm-block d-md-none">
            <a href="#">
              <b-icon-three-dots font-scale="1.5" />
            </a>
          </div>
          <div class="d-none d-md-block">
            <a
              v-if="!todo.status.includes(Status.Done)"
              href="javascript:void(0);"
              @click="markAsDone(todo)"
            >
              <b-button class="mr-1" v-b-tooltip.hover title="Finalizar">
                <b-icon-square />
              </b-button>
            </a>
            <a
              v-else
              href="javascript:void(0);"
              @click="markAsUndone(todo)"
            >
              <b-button class="mr-1" v-b-tooltip.hover title="Finalizar">
                <b-iconstack>
                  <b-icon-square stacked />
                  <b-icon-check stacked />
                </b-iconstack>
              </b-button>
            </a>

            <a
              v-if="!todo.status.includes(Status.Archived)"
              href="javascript:void(0);"
              @click="archive(todo)"
            >
              <b-button class="mr-1" v-b-tooltip.hover title="Arquivar">
                <b-icon-archive-fill />
              </b-button>
            </a>
            <a
              v-else
              href="javascript:void(0);"
              @click="unarchive(todo)"
            >
              <b-button v-b-tooltip.hover title="Desarquivar">
                <b-iconstack class="bt-desarquivar">
                  <b-icon icon="archive-fill" />
                  <b-icon icon="arrow-up-short" shift-v="12" />
                </b-iconstack>
              </b-button>
            </a>

            <a href="javascript:void(0);">
              <b-button class="mr-1" v-b-tooltip.hover title="Editar" @click="edit(todo)">
                <b-icon-pencil-fill />
              </b-button>
            </a>

            <a href="javascript:void(0);">
              <b-button v-b-tooltip.hover title="Excluir" @click="confirmDelete(todo)">
                <b-icon-trash-fill />
              </b-button>
            </a>
          </div>
        </div>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import { namespace } from 'vuex-class'
import Swal from 'sweetalert2'

import TodoService from '@/services/todo.service'
import { Todo as TodoType } from '@/types/Todo/Todo'
import { Status } from '@/types/Todo/Status'

import ModalEditForm from './Modal/EditForm.vue'

const todoStore = namespace('todo')

@Component({
  components: {
    ModalEditForm,
  },
})
export default class Listagem extends Vue {
  @Prop() public list!: Array<TodoType>

  @todoStore.Action
  public removeTodo!: (id: string) => void

  @todoStore.Action
  public updateTodo!: (todo: TodoType) => void

  public Status = Status

  public editTodo: TodoType = {
    uuid: '',
    title: '',
    description: '',
    status: [],
  }

  public async updateTodoService(todo: TodoType): Promise<void> {
    const todoService = new TodoService()
    await todoService.update(todo)
      .then(() => {
        this.updateTodo(todo)
      })
      .catch((reason) => {
        this.$bvToast.toast(
          reason,
          {
            title: 'Atenção',
            variant: 'danger',
          },
        )
      })
  }

  public markAsDone(todo: TodoType): void {
    const newItem = todo
    console.log(todo)
    newItem.status = todo.status.filter((status) => status !== Status.Pending)
    newItem.status.push(Status.Done)

    this.updateTodoService(newItem)
  }

  public markAsUndone(todo: TodoType): void {
    const newItem = todo
    newItem.status = todo.status.filter((value) => value !== Status.Done)
    newItem.status.push(Status.Pending)

    this.updateTodoService(newItem)
  }

  public archive(todo: TodoType): void {
    todo.status.push(Status.Archived)

    this.updateTodoService(todo)
  }

  public unarchive(todo: TodoType): void {
    const newItem = todo
    newItem.status = todo.status.filter((value) => value !== Status.Archived)

    this.updateTodoService(newItem)
  }

  public edit(todo: TodoType): void {
    this.editTodo = todo
    this.$bvModal.show('editForm')
  }

  public confirmDelete(todo: TodoType): void {
    Swal.fire({
      title: 'Deletar Tarefa',
      text: `Tem certeza que deseja deletar "${todo.title}"`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Deletar',
      cancelButtonText: 'Cancelar',
    }).then(async (result) => {
      if (result.value) {
        const todoService = new TodoService()
        await todoService.destroy(todo)
          .then(() => {
            this.removeTodo(todo.uuid)

            Swal.fire(
              'Deletado!',
              'Tarefa deletada com sucesso!',
              'success',
            )
          })
          .catch((reason) => {
            this.$bvToast.toast(
              reason,
              {
                title: 'Atenção',
                variant: 'danger',
              },
            )
          })
      }
    })
  }
}
</script>
