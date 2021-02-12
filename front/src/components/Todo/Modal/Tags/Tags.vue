<template>
  <b-modal id="tagsForm" title="Tags" @ok="handleOk" size="lg" hide-footer>
    <b-row>
      <b-col>
        <b-form @submit.stop.prevent="onSubmit">
          <input type="hidden" name="uuid" v-model="uuid" />
          <b-row>
            <b-col>
              <b-form-group label="Nome *" label-for="name" class="required">
                <b-input id="name" required aria-required="true" maxlength="20" v-model="name" />
              </b-form-group>
              <b-form-group label="Cor de fundo *" label-for="color" class="required">
                <b-input id="color" v-model="color" type="color" />
              </b-form-group>
              <div class="row">
                <div class="col">
                  <label>Preview</label>
                  <div class="bt-tags">
                    <b-badge :style="{ backgroundColor: color }">
                      {{ name }}
                    </b-badge>
                  </div>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="mt-3">
            <b-col v-if="editing">
              <b-button @click="clearModel" class="mr-1">Cancelar</b-button>
              <b-button type="submit" variant="primary">Editar</b-button>
            </b-col>
            <b-col v-else>
              <b-button @click="hideModal" class="mr-1">Fechar</b-button>
              <b-button type="submit" variant="primary">Cadastrar</b-button>
            </b-col>
          </b-row>
        </b-form>
      </b-col>
      <b-col>
        <b-table striped hover :items="tableData">
          <template #cell(color)="data">
            <b-badge :style="`background-color: ${data.value}`">{{ data.value }}</b-badge>
          </template>
          <template #cell(actions)="data" title="Ações">
            <b-button size="sm" variant="primary" @click="openUpdateTag(data)" class="mr-1">
              <b-icon-pencil />
            </b-button>
            <b-button size="sm" variant="danger" @click="confirmDelete(data.value)">
              <b-icon-trash />
            </b-button>
          </template>
        </b-table>
      </b-col>
    </b-row>
  </b-modal>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator'
import { BvModalEvent } from 'bootstrap-vue'
import { namespace } from 'vuex-class'
import Swal from 'sweetalert2'

import TagService from '@/services/tag.service'
import { Tag as TagType } from '@/types/Tag/Tag'

const tagStore = namespace('tag')

@Component
export default class Tags extends Vue {
  /**
   * Props
   */
  public uuid = ''

  public name = ''

  public color = '#000000'

  public tableData: Array<Record<string, string>> = []

  public editing = false

  /**
   * Stores
   */
  @tagStore.State
  public tags!: Array<TagType>

  @tagStore.Action
  private loadTags!: (tags: Array<TagType>) => boolean | Error

  @tagStore.Action
  private newTag!: (tag: TagType) => boolean

  @tagStore.Action
  private removeTag!: (uuid: string) => boolean

  @tagStore.Action
  private updateTag!: (tag: TagType) => boolean | Error

  /**
   * LifeCycles
   */
  mounted(): void {
    const tagService = new TagService()

    tagService.findAll({})
      .then((response) => {
        try {
          this.loadTags(response.data)
          this.tableData = response.data.map(
            (tag: TagType) => ({
              name: tag.name,
              color: tag.color,
              actions: 'excluir',
            }),
          )
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
  @Watch('tags')
  public updateListCounts(current: Array<TagType>) {
    this.tableData = current.map(
      (tag: TagType) => ({
        name: tag.name,
        color: tag.color,
        actions: tag.uuid,
      }),
    )
  }

  /**
   * Methods
   */
  public clearModel(): void {
    this.editing = false
    this.uuid = ''
    this.name = ''
    this.color = '#000000'
  }

  public hideModal(): void {
    this.$bvModal.hide('tagsForm')
  }

  public handleOk(event: BvModalEvent): void {
    event.preventDefault()
    this.onSubmit()
  }

  public confirmDelete(uuid: string): void {
    const tag = this.tags.filter((i) => i.uuid === uuid)[0]

    Swal.fire({
      title: 'Deletar Tag',
      text: `Tem certeza que deseja deletar "${tag.name}"`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Deletar',
      cancelButtonText: 'Cancelar',
    }).then(async (result) => {
      if (result.value) {
        const tagService = new TagService()
        await tagService.destroy(tag)
          .then(() => {
            this.removeTag(tag.uuid)

            Swal.fire(
              'Deletado!',
              'Tag deletada com sucesso!',
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

  // eslint-disable-next-line
  public openUpdateTag(data: Record<string, any>) {
    this.editing = true
    this.uuid = data.value
    this.name = data.item?.name
    this.color = data.item?.color
  }

  public async onSubmit(): Promise<void> {
    if (!this.name) {
      this.$bvToast.toast(
        'Nome é obrigatório',
        {
          title: 'Atenção',
          variant: 'danger',
          solid: true,
        },
      )
      return
    }

    if (this.color.length !== 7) {
      this.$bvToast.toast(
        'A cor não está no formato correto',
        {
          title: 'Atenção',
          variant: 'danger',
        },
      )
      return
    }

    const item: TagType = {
      uuid: this.uuid,
      name: this.name,
      color: this.color,
    }

    try {
      const tagService = new TagService()

      if (this.editing) {
        await tagService.update(item)
          .then((response) => {
            this.updateTag(item)

            this.uuid = ''
            this.name = ''
            this.color = '#000000'
            this.editing = false

            this.$bvToast.toast(
              response.data.message,
              {
                title: 'Atenção',
                variant: 'success',
              },
            )
          })
          .catch((reason) => {
            throw Error(reason)
          })

        return
      }

      await tagService.add(item)
        .then((response) => {
          this.newTag({
            uuid: response.data.uuid,
            name: this.name,
            color: this.color,
          })

          this.name = ''
          this.color = '#000000'

          this.$bvToast.toast(
            'Tag cadastrada com sucesso',
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
