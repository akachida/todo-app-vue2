<template>
  <div class="row calendario">
    <div class="col text-center">
      <a href="javascript:void(0)" class="bt-prev" @click="prevDate">
        <b-iconstack>
          <b-icon stacked icon="chevron-compact-left" />
          <b-icon stacked icon="chevron-compact-left" shift-h="3" />
        </b-iconstack>
      </a>
      <a href="javascript:void(0)">
        {{ formatedDate }}
      </a>
      <a href="javascript:void(0)" class="bt-next" @click="nextDate">
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
  public showDate = ''

  public formatedDate = ''

  public formatDate(): void {
    const day = this.$store.state.curDate.getDate()
    const month = this.$store.state.curDate.getMonth()
    let fullMonth

    switch (month) {
      case 0: fullMonth = 'JAN'; break
      case 1: fullMonth = 'FEV'; break
      case 2: fullMonth = 'MAR'; break
      case 3: fullMonth = 'ABR'; break
      case 4: fullMonth = 'MAI'; break
      case 5: fullMonth = 'JUN'; break
      case 6: fullMonth = 'JUL'; break
      case 7: fullMonth = 'AGO'; break
      case 8: fullMonth = 'SET'; break
      case 9: fullMonth = 'OUT'; break
      case 10: fullMonth = 'NOV'; break
      default: fullMonth = 'DEZ'
    }

    this.formatedDate = `${day}/${fullMonth}`
  }

  public nextDate(): void {
    const cloneDate = this.$store.state.curDate
    cloneDate.setDate(cloneDate.getDate() + 1)

    this.$store.dispatch('toggleLoading')
    this.$store.dispatch('changeCurDate', cloneDate)
    this.$emit('change', cloneDate)
    this.formatDate()
  }

  public prevDate(): void {
    const cloneDate = this.$store.state.curDate
    cloneDate.setDate(cloneDate.getDate() - 1)

    this.$store.dispatch('toggleLoading')
    this.$store.dispatch('changeCurDate', cloneDate)
    this.$emit('change', cloneDate)
    this.formatDate()
  }

  /**
   * Lifecycle
   */
  mounted() {
    this.showDate = this.formatDate()
  }
}
</script>
