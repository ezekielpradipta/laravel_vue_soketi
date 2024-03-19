<template>
  <button
    type="button"
    :class="[
      'inline-flex h-8 w-8 shrink-0 flex-row items-center justify-center rounded-md disabled:bg-transparent disabled:text-gray-300',
      props.isActive
        ? 'bg-blue-200 text-blue-800 hover:bg-opacity-80'
        : 'text-gray-600 hover:bg-blue-50 dark:text-gray-300'
    ]"
    :aria-label="props.label"
  >
    <slot />
  </button>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    default: ''
  },

  isActive: {
    type: Boolean
  }
})
</script>

<style lang="scss" scoped></style>
