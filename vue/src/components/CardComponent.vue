<template>
  <div class="flex flex-col bg-white dark:bg-gray-900 dark:text-gray-400 rounded-lg shadow-md p-4">
    <div v-if="props.title" class="p-4 pl-5 pr-5 border-b border-gray-300 dark:border-gray-500">
      <p class="font-bold text-base text-gray-700 dark:text-white text-center">
        {{ props.title }}
      </p>
    </div>
    <div :class="{ 'card-body': true, 'p-0': props.noPadding }">
      <slot />
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  noPadding: Boolean,
  title: {
    type: String,
    default: ''
  }
})
</script>

<style lang="scss" scoped></style>
