 <template>
  <div>
    <b-card no-body class="mb-3 todo-card shadow-lg">
      <b-card-header>
        <h1 class="float-left">To-do List</h1>
        <b-button class="bt-cadastrar big" v-b-modal.todoForm>
          <b-icon-plus />
        </b-button>
        <ModalAddForm />
        <b-button class="bt-tags float-right" variant="outline-light">
          Tags
        </b-button>
      </b-card-header>
      <b-card-body>
        <Calendario />
        <div class="row">
          <div class="col mt-2 mb-3">
            <b-form-input
              class="busca shadow"
              placeholder="Buscar..."
              v-model="textSearch"
              @keydown="typingTextSearch"
            />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <b-form-checkbox-group
              id="filtros"
              v-model="filtros"
              name="filtros"
              :options="filterTypes"
              @change="filterList"
            />
          </div>
          <div class="col text-right">
            <b-badge class="mr-1" variant="primary">Total {{ total }}</b-badge>
            <b-badge class="mr-1" variant="success">Finalizadas {{ done }}</b-badge>
            <b-badge class="mr-1" variant="warning">Pendentes {{ pending }}</b-badge>
            <b-badge>Arquivadas {{ archived }}</b-badge>
          </div>
        </div>
        <Listagem :list="viewList" />
      </b-card-body>
    </b-card>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator'
import { namespace } from 'vuex-class'

import { Todo as TodoType } from '@/types/Todo/Todo'
import { Status } from '@/types/Todo/Status'

import ModalAddForm from './Modal/Form.vue'
import Calendario from './Calendario.vue'
import Listagem from './Listagem.vue'

const todoStore = namespace('todo')

@Component({
  components: {
    Calendario,
    Listagem,
    ModalAddForm,
  },
})
export default class Todo extends Vue {
  @todoStore.State
  public list!: Array<TodoType>

  public viewList: Array<TodoType> = []

  public total = 0

  public done = 0

  public pending = 0

  public archived = 0

  public filterTypes = [
    { text: 'Finalizadas', value: Status.Done },
    { text: 'Pendentes', value: Status.Pending },
    { text: 'Arquivadas', value: Status.Archived },
  ]

  public filtros: Array<string> = []

  public textSearch = ''

  public textSearchTimeout?

  @Watch('list')
  public updateListCounts(current: Array<TodoType>) {
    this.filterList()

    this.done = 0
    this.pending = 0
    this.archived = 0

    current.forEach((todo) => {
      if (todo.status.includes(Status.Done)) this.done += 1
      if (todo.status.includes(Status.Pending)) this.pending += 1
      if (todo.status.includes(Status.Archived)) this.archived += 1
    })
  }

  public filterList(): void {
    this.viewList = this.list
    this.filterPerStatus()
    this.filterTextSearch()
  }

  public filterPerStatus(): void {
    if (this.filtros.length > 0 && this.list.length > 0) {
      this.viewList = this.viewList.filter(
        (todo) => this.filtros.some((filtro) => todo.status.includes(filtro)),
      )
    }
  }

  public typingTextSearch(): void {
    clearInterval(this.textSearchTimeout)

    this.textSearchTimeout = setTimeout(this.filterList, 500)
  }

  public filterTextSearch(): void {
    if (this.textSearch.length > 0) {
      this.viewList = this.viewList.filter((todo) => todo.title.search(this.textSearch) >= 0)
    }
  }
}
</script>

<style lang="sass">
  @import '@/assets/style/views/todo.sass'
</style>
