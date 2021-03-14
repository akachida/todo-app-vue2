import Vue from 'vue'
import axios, { AxiosResponse } from 'axios'

import { Todo as TodoType } from '@/types/Todo/Todo'
import { ServiceInterface } from '@/services/ServiceInterface'

export default class TodoService extends Vue implements ServiceInterface<TodoType> {
  public async findAll(params: Record<string, string|Date>): Promise<AxiosResponse> {
    return axios.get(`${this.$data.todoApiUrl}/todo/list`, {
      responseType: 'json',
      params,
    })
  }

  public async find(uuid: string): Promise<AxiosResponse> {
    return axios.get(`${this.$data.todoApiUrl}/todo/${uuid}`, {
      responseType: 'json',
    })
  }

  public async add(todo: TodoType): Promise<AxiosResponse> {
    return axios.post(`${this.$data.todoApiUrl}/todo`, todo)
  }

  public async update(todo: TodoType): Promise<AxiosResponse> {
    return axios.put(`${this.$data.todoApiUrl}/todo/${todo.uuid}`, todo)
  }

  public async destroy(todo: TodoType): Promise<AxiosResponse> {
    return axios.delete(`${this.$data.todoApiUrl}/todo/${todo.uuid}`)
  }
}
