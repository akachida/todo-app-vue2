<template>
  <b-modal id="tagsForm" title="Tags" @ok="handleOk">
    <b-form @submit.stop.prevent="onSubmit">
      <b-form-group label="Nome *" label-for="name" class="required">
        <b-input id="name" required aria-required="true" maxlength="50" v-model="name" />
      </b-form-group>
      <b-form-group label="Cor de fundo *" label-for="color" class="required">
        <b-input id="color" v-model="color" type="color" @change="setColor" />
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
      <template #modal-footer>
        <b-button @click="hideModal">Cancelar</b-button>
        <b-button type="submit">Cadastrar</b-button>
      </template>
    </b-form>
  </b-modal>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator'
import { BvModalEvent } from 'bootstrap-vue'
import { namespace } from 'vuex-class'

import TagService from '@/services/tag.service'
import { Tag as TagType } from '@/types/Tag/Tag'

const tagStore = namespace('tag')

@Component
export default class Tags extends Vue {
  public name = ''

  public color = '#000000'

  @tagStore.Action
  private newTag!: (tag: TagType) => boolean

  public hideModal(): void {
    this.$bvModal.hide('todoForm')
  }

  public handleOk(event: BvModalEvent): void {
    event.preventDefault()
    this.onSubmit()
  }

  public setColor(): void {
    console.log(this.color)
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
      uuid: '',
      name: this.name,
      color: this.color,
    }

    try {
      const tagService = new TagService()
      await tagService.add(item)
        .then((response) => {
          this.name = ''
          this.color = '#000000'

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
