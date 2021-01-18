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
  public append(todo: TodoType): void {
    this.list.push(todo)
  }

  @Mutation
  public remove(id: number): void {
    this.list = this.list.filter((i) => i.id !== id)
  }

  @Action({ rawError: true })
  public newTodo(todo: TodoType): boolean {
    if (this.list.filter((i) => i.id === todo.id).length > 0) {
      throw Error('Não foi possível inserir pois este ID já existe na lista')
    }

    this.context.commit('append', todo)

    return true
  }

  @Action({ rawError: true })
  public removeTodo(id: number): void {
    this.context.commit('remove', id)
  }
}
