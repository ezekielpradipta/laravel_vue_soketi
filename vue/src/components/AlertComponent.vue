<template>
  <div
    id="alert-additional-content-1"
    class="p-4 mb-4"
    :class="{
      'text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800':
        color === 'primary',
      'text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800':
        color === 'red'
    }"
    role="alert"
  >
    <div class="flex items-center">
      <svg
        aria-hidden="true"
        class="w-5 h-5 mr-2"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
          clip-rule="evenodd"
        ></path>
      </svg>
      <span class="sr-only">Info</span>
      <h3 class="text-lg font-medium">{{ props.title }}</h3>
    </div>
    <slot></slot>
  </div>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    default: ''
  },

  color: {
    type: String,
    default: 'primary'
  }
})
</script>

<style lang="scss" scoped></style>
