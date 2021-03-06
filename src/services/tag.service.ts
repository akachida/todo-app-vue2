import Vue from 'vue'
import axios, { AxiosResponse } from 'axios'

import { Tag as TagType } from '@/types/Tag/Tag'
import { ServiceInterface } from '@/services/ServiceInterface'

export default class TagService extends Vue implements ServiceInterface<TagType> {
  public async findAll(params: Record<string, string>): Promise<AxiosResponse> {
    return axios.get(`${this.$data.todoApiUrl}/tag/list`, {
      responseType: 'json',
      params,
    })
  }

  public async find(uuid: string): Promise<AxiosResponse> {
    return axios.get(`${this.$data.todoApiUrl}/tag/${uuid}`, {
      responseType: 'json',
    })
  }

  public async add(tag: TagType): Promise<AxiosResponse> {
    return axios.post(`${this.$data.todoApiUrl}/tag`, tag)
  }

  public async update(tag: TagType): Promise<AxiosResponse> {
    return axios.put(`${this.$data.todoApiUrl}/tag/${tag.uuid}`, tag)
  }

  public async destroy(tag: TagType): Promise<AxiosResponse> {
    return axios.delete(`${this.$data.todoApiUrl}/tag/${tag.uuid}`)
  }
}
