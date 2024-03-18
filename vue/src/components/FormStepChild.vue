<template>
  <div v-if="shouldShow">
    <div class="mt-8">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { computed, inject } from 'vue'
const currentIndex = inject('STEP_COUNTER').value++
const formStepIndex = inject('CURRENT_STEP_INDEX')

const shouldShow = computed(() => {
  return currentIndex === formStepIndex.value
})
const props = defineProps({
  title: {
    type: String,
    default: ''
  }
})

const steps = inject('STEPS')
steps.value.push({
  title: props.title,
  index: currentIndex
})
</script>

<style lang="scss" scoped></style>
