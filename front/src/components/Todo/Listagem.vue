<template>
  <b-list-group class="mt-2">
    <b-list-group-item>
      <span class="mr-2 titulo align-middle d-inline-block">
        Item aqui
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
          <a href="#">
            <b-button class="mr-1" v-b-tooltip.hover title="Finalizar">
              <b-icon-square />
            </b-button>
          </a>
          <a href="#">
            <b-button class="mr-1" v-b-tooltip.hover title="Arquivar">
              <b-icon-archive-fill />
            </b-button>
          </a>
          <a href="#">
            <b-button class="mr-1" v-b-tooltip.hover title="Editar">
              <b-icon-pencil-fill />
            </b-button>
          </a>
          <a href="#">
            <b-button v-b-tooltip.hover title="Excluir">
              <b-icon-trash-fill />
            </b-button>
          </a>
        </div>
      </div>
    </b-list-group-item>
    <b-list-group-item class="arquivada">
      <span class="mr-2 titulo align-middle d-inline-block">
        Arquivada
      </span>
      <div class="d-inline-block tags">
      </div>
      <div class="float-right actions">
        <div class="d-sm-block d-md-none">
          <a href="#">
            <b-icon-three-dots font-scale="1.5" />
          </a>
        </div>
        <div class="d-none d-md-block">
          <a href="#">
            <b-button v-b-tooltip.hover title="Desarquivar">
              <b-iconstack class="bt-desarquivar">
                <b-icon icon="archive-fill" />
                <b-icon icon="arrow-up-short" shift-v="12" />
              </b-iconstack>
            </b-button>
          </a>
          <a href="#">
            <b-button class="mr-1" v-b-tooltip.hover title="Editar">
              <b-icon-pencil-fill />
            </b-button>
          </a>
          <a href="#">
            <b-button v-b-tooltip.hover title="Excluir">
              <b-icon-trash-fill />
            </b-button>
          </a>
        </div>
      </div>
    </b-list-group-item>
  </b-list-group>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import { Todo as TodoType } from '@/types/Todo/Todo'

@Component
export default class Listagem extends Vue {
  @Prop({ required: true }) public list!: Array<TodoType>
}
</script>
