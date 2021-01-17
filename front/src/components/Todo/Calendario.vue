<template>
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
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component
export default class Calendario extends Vue {
}
</script>
