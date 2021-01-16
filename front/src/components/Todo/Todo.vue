 <template>
  <div>
    <b-card no-body class="mb-3 todo-card shadow-lg">
      <b-card-header>
        <h1 class="float-left">To-do List</h1>
        <b-button class="bt-cadastrar big">
          <b-icon-plus />
        </b-button>
        <b-button class="bt-tags float-right" variant="outline-light">
          Tags
        </b-button>
      </b-card-header>
      <b-card-body>
        <b-form>
          <div class="row calendario">
            <div class="col text-center">
              <a href="#">
                <b-iconstack>
                  <b-icon stacked icon="chevron-compact-left" />
                  <b-icon stacked icon="chevron-compact-left" shift-h="3" />
                </b-iconstack>
              </a>
              13/JAN
              <a href="#">
                <b-iconstack>
                  <b-icon stacked icon="chevron-compact-right" shift-h="-3" />
                  <b-icon stacked icon="chevron-compact-right" />
                </b-iconstack>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col mt-2 mb-3">
              <b-form-input class="busca shadow" placeholder="Buscar..." />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b-form-checkbox-group>
                <b-form-checkbox name="finalizadas">Finalizadas</b-form-checkbox>
                <b-form-checkbox name="pendentes">Pendentes</b-form-checkbox>
                <b-form-checkbox name="arquivadas">Arquivadas</b-form-checkbox>
              </b-form-checkbox-group>
            </div>
            <div class="col text-right">
              <b-badge class="mr-1" variant="primary">Total 123456</b-badge>
              <b-badge class="mr-1" variant="success">Finalizadas 12</b-badge>
              <b-badge class="mr-1" variant="warning">Pendentes 34</b-badge>
              <b-badge>Arquivadas 56</b-badge>
            </div>
          </div>
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
        </b-form>
      </b-card-body>
    </b-card>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component({})
export default class Todo extends Vue {}
</script>

<style lang="sass">
  @import '@/assets/style/views/todo.sass'
</style>
