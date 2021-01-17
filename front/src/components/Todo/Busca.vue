<template>
  <div class="row">
    <div class="col mt-2 mb-3">
      <b-form-input class="busca shadow" placeholder="Buscar..." />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component
export default class Busca extends Vue {
}
</script>
