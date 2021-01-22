import {
  VuexModule,
  Module,
  Mutation,
  Action,
} from 'vuex-module-decorators'

import { Todo as TodoType } from '@/types/Todo/Todo'

@Module({ namespaced: true })
export default class Todo extends VuexModule {
  public list: Array<TodoType> = []

  get listTodo(): Array<TodoType> {
    return this.list
  }

  @Mutation
  public loadData(todos: Array<TodoType>): void {
    this.list = todos
  }

  @Mutation
  public append(todo: TodoType): void {
    this.list = [todo, ...this.list]
  }

  @Mutation
  public remove(uuid: string): void {
    this.list = this.list.filter((i) => i.uuid !== uuid)
  }

  @Mutation
  public update(todo: TodoType): void {
    this.list = this.list.map((item) => {
      let value = item

      if (value.uuid === todo.uuid) value = todo

      return value
    })
  }

  @Action({ rawError: true })
  public loadTodos(todos: Array<TodoType>): boolean | Error {
    if (!(todos instanceof Object)) {
      throw Error('Listagem não está no formato correto.')
    }

    this.context.commit('loadData', todos)

    return true
  }

  @Action({ rawError: true })
  public newTodo(todo: TodoType): boolean | Error {
    if (this.list.filter((i) => i.uuid === todo.uuid).length > 0) {
      throw Error('Não foi possível inserir pois este ID já existe na lista')
    }

    this.context.commit('append', todo)

    return true
  }

  @Action({ rawError: true })
  public removeTodo(uuid: string): void {
    this.context.commit('remove', uuid)
  }

  @Action({ rawError: true })
  public updateTodo(todo: TodoType): boolean | Error {
    if (!this.list.filter((i) => i.uuid === todo.uuid).length) {
      throw Error('Não foi possível encontrar o ID da Tarefa')
    }

    this.context.commit('update', todo)

    return true
  }
}
