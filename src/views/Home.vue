<template>
  <div class="home">
    <div class="row">
      <div class="col mt-5">
        <Todo />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Todo from '@/components/Todo/Todo.vue'

@Component({
  components: {
    Todo,
  },
})
export default class Home extends Vue {}
</script>
