 <template>
  <div>
    <b-card no-body class="mb-3 todo-card shadow-lg">
      <b-card-header>
        <h1 class="float-left">To-do List</h1>
        <b-button class="bt-cadastrar big" v-b-modal.todoForm>
          <b-icon-plus />
        </b-button>
        <ModalForm :title="'Cadastrar Tarefa'" />
        <b-button class="bt-tags float-right" variant="outline-light" @click="printa">
          Tags
        </b-button>
      </b-card-header>
      <b-card-body>
        <b-form>
          <Calendario />
          <Busca />
          <div class="row">
            <div class="col">
              <b-form-checkbox-group
                id="filtros"
                v-model="filtros"
                name="filtros"
                @change="printa"
              >
                <b-form-checkbox value="finalizadas">Finalizadas</b-form-checkbox>
                <b-form-checkbox value="pendentes">Pendentes</b-form-checkbox>
                <b-form-checkbox value="arquivadas">Arquivadas</b-form-checkbox>
              </b-form-checkbox-group>
            </div>
            <div class="col text-right">
              <b-badge class="mr-1" variant="primary">Total {{ total }}</b-badge>
              <b-badge class="mr-1" variant="success">Finalizadas {{finalizadas }}</b-badge>
              <b-badge class="mr-1" variant="warning">Pendentes {{ pendentes }}</b-badge>
              <b-badge>Arquivadas {{ arquivadas }}</b-badge>
            </div>
          </div>
          <Listagem :list="list" />
        </b-form>
      </b-card-body>
    </b-card>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { namespace } from 'vuex-class'

import { Todo as TodoType } from '@/types/Todo/Todo'

import ModalForm from './Modal/Form.vue'
import Calendario from './Calendario.vue'
import Busca from './Busca.vue'
import Listagem from './Listagem.vue'

const todo = namespace('todo')

@Component({
  components: {
    Calendario,
    Busca,
    Listagem,
    ModalForm,
  },
})
export default class Todo extends Vue {
  @todo.State
  public list!: Array<TodoType>

  public total = 0

  public finalizadas = 0

  public pendentes = 0

  public arquivadas = 0

  public tiposFiltros = [
    { text: 'Finalizadas', value: 'finalizadas' },
    { text: 'Pendentes', value: 'pendentes' },
    { text: 'Arquivadas', value: 'arquivadas' },
  ]

  public filtros: Array<string> = []

  public printa(): void {
    console.log(this.filtros)
  }
}
</script>

<style lang="sass">
  @import '@/assets/style/views/todo.sass'
</style>
