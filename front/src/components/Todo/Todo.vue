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
                :options="filterTypes"
                @change="printa"
              />
            </div>
            <div class="col text-right">
              <b-badge class="mr-1" variant="primary">Total {{ total }}</b-badge>
              <b-badge class="mr-1" variant="success">Finalizadas {{ done }}</b-badge>
              <b-badge class="mr-1" variant="warning">Pendentes {{ pending }}</b-badge>
              <b-badge>Arquivadas {{ archived }}</b-badge>
            </div>
          </div>
          <Listagem />
        </b-form>
      </b-card-body>
    </b-card>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { namespace } from 'vuex-class'

import { Todo as TodoType } from '@/types/Todo/Todo'
import { Status } from '@/types/Todo/Status'

import ModalForm from './Modal/Form.vue'
import Calendario from './Calendario.vue'
import Busca from './Busca.vue'
import Listagem from './Listagem.vue'

const todoStore = namespace('todo')

@Component({
  components: {
    Calendario,
    Busca,
    Listagem,
    ModalForm,
  },
})
export default class Todo extends Vue {
  @todoStore.State
  public list!: Array<TodoType>

  public total = 0

  public done = 0

  public pending = 0

  public archived = 0

  public filterTypes = [
    { text: 'Finalizadas', value: 'finalizadas' },
    { text: 'Pendentes', value: 'pendentes' },
    { text: 'Arquivadas', value: 'arquivadas' },
  ]

  public filtros: Array<string> = []

  mounted() {
    this.list.forEach((todo) => {
      if (todo.status.includes(Status.Done)) this.done += 1
      if (todo.status.includes(Status.Pending)) this.pending += 1
      if (todo.status.includes(Status.Archived)) this.archived += 1
    })
  }
}
</script>

<style lang="sass">
  @import '@/assets/style/views/todo.sass'
</style>
