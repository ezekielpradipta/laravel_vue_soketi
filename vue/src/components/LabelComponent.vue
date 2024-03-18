<template>
  <label for="{{ title }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
    >{{ title }}
    <span v-if="props.penting" class="text-red-700 dark:text-red-600">*</span>
    <slot></slot>
  </label>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    default: ''
  },
  penting: Boolean
})
</script>

<style lang="scss" scoped></style>
