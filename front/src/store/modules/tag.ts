import {
  VuexModule,
  Module,
  Mutation,
  Action,
} from 'vuex-module-decorators'

import { Tag as TagType } from '@/types/Tag/Tag'

@Module({ namespaced: true })
export default class Tag extends VuexModule {
  public list: Array<TagType> = []

  get listTag(): Array<TagType> {
    return this.list
  }

  @Mutation
  public loadData(tags: Array<TagType>): void {
    this.list = tags
  }

  @Mutation
  public append(tag: TagType): void {
    this.list = [tag, ...this.list]
  }

  @Mutation
  public remove(uuid: string): void {
    this.list = this.list.filter((i) => i.uuid !== uuid)
  }

  @Mutation
  public update(tag: TagType): void {
    this.list = this.list.map((item) => {
      let value = item

      if (value.uuid === tag.uuid) value = tag

      return value
    })
  }

  @Action({ rawError: true })
  public loadTags(tags: Array<TagType>): boolean | Error {
    if (!(tags instanceof Object)) {
      throw Error('Listagem não está no formato correto.')
    }

    this.context.commit('loadData', tags)

    return true
  }

  @Action({ rawError: true })
  public newTag(tag: TagType): boolean | Error {
    if (this.list.filter((i) => i.uuid === tag.uuid).length > 0) {
      throw Error('Não foi possível inserir pois este ID já existe na lista')
    }

    this.context.commit('append', tag)

    return true
  }

  @Action({ rawError: true })
  public removeTag(uuid: string): void {
    this.context.commit('remove', uuid)
  }

  @Action({ rawError: true })
  public updateTag(tag: TagType): boolean | Error {
    if (!this.list.filter((i) => i.uuid === tag.uuid).length) {
      throw Error('Não foi possível encontrar o ID da Tag')
    }

    this.context.commit('update', tag)

    return true
  }
}
