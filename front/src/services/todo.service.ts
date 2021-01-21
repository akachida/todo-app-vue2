import Vue from 'vue'
import axios, { AxiosResponse } from 'axios'

import { Todo as TodoType } from '@/types/Todo/Todo'

export default class TodoService extends Vue {
  public async findAll(): Promise<AxiosResponse> {
    return axios.get(`${this.$data.apiUrl}/todo/list`, {
      responseType: 'json',
    })
  }

  public async find(uuid: string): Promise<AxiosResponse> {
    return axios.get(`${this.$data.apiUrl}/todo/${uuid}`, {
      responseType: 'json',
    })
  }

  public async add(todo: TodoType): Promise<AxiosResponse> {
    return axios.post(`${this.$data.apiUrl}/todo`, todo)
  }

  public async update(todo: TodoType): Promise<AxiosResponse> {
    return axios.post(`${this.$data.apiUrl}/todo${todo.uuid}`, todo)
  }

  public async destroy(todo: TodoType): Promise<AxiosResponse> {
    return axios.delete(`${this.$data.apiUrl}/todo${todo.uuid}`)
  }
}
