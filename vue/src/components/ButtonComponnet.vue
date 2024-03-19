<template>
  <div class="mt-4 mb-4" :class="props.right ? ' flex-auto flex flex-row-reverse' : ''">
    <button
      :type="props.type"
      class="inline-flex items-center justify-start overflow-hidden rounded-md font-medium"
      :class="{
        'rounded-lg': props.block === 'props.block',
        'rounded-full': props.block === 'round',
        'px-3 py-2 text-xs': props.size === 'xs',
        'px-3 py-2 text-sm ': props.size === 'sm',
        'px-5 py-2.5 text-sm ': props.size === 'base',
        'px-5 py-3 text-base ': props.size === 'lg',
        'px-6 py-3.5 text-base  ': props.size === 'xl',
        'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800':
          props.color === 'primary',
        'text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700':
          props.color === 'dark',
        'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-new-dark-secondary dark:text-white dark:border-new-dark-darker ':
          props.color === 'light',
        'text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800':
          props.color === 'green',
        'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300  dark:bg-red-800 dark:hover:bg-red-700 dark:focus:ring-red-900':
          props.color === 'red',
        'text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-700':
          props.color === 'yellow',
        'text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900':
          props.color === 'purple'
      }"
    >
      <svg
        v-if="props.icon && props.icon != ''"
        class="w-6 h-6"
        :class="props.text && props.text != '' ? ' ' : ''"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        fill="none"
        viewBox="0 0 24 24"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          :d="pathIcon[props.icon]"
        />
      </svg>
      <p v-if="props.text && props.text != ''">
        {{ props.text }}
      </p>
      <slot></slot>
    </button>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const props = defineProps({
  size: {
    type: String,
    default: 'base'
  },
  block: {
    type: String,
    default: 'block'
  },
  color: {
    type: String,
    default: 'primary'
  },
  right: {
    type: Boolean,
    default: false
  },
  icon: {
    type: String
  },
  text: {
    type: String
  },
  type: {
    type: String,
    default: 'button'
  }
})

const pathIcon = reactive({
  plus: 'M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
  trash:
    'M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z',
  back: 'M5 12h14M5 12l4-4m-4 4 4 4',
  next: 'M19 12H5m14 0-4 4m4-4-4-4',
  save: 'M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01'
})
</script>

<style lang="scss" scoped></style>
