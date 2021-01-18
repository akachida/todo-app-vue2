<template>
  <b-form-group
    :label="`${label} ${required? '*':''}`"
    :label-for="id"
    :class="{ 'required': required }"
  >
    <b-input
      :id="id"
      :required="required"
      :aria-required="required"
      :maxlength="maxlength"
      v-model="value"
      @change="$emit('change', value)"
    ></b-input>
  </b-form-group>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class InputText extends Vue {
  @Prop({ required: true }) public label!: string

  @Prop({ required: true }) public id!: string

  @Prop({ required: true }) public name!: string

  @Prop({ default: false }) public required!: boolean

  @Prop({ default: 100 }) public maxlength!: boolean

  public value = ''
}
</script>
