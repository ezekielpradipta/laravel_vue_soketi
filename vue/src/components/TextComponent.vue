<template>
  <LabelComponent :title="props.title" :penting="props.penting"></LabelComponent>
  <input
    :type="props.type"
    :value="modelValue"
    @input="onChange"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    :placeholder="props.placeholder"
    :disabled="props.disabled"
  />
</template>

<script setup>
import LabelComponent from './LabelComponent.vue'
const emit = defineEmits(['update:modelValue'])
const props = defineProps({
  title: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  modelValue: {
    type: String,
    default: ''
  },
  penting: {
    type: Boolean,
    default: false
  },
  type: {
    type: String,
    default: 'text'
  },
  disabled: {
    type: Boolean,
    default: false
  }
})
const onChange = (e) => {
  emit('update:modelValue', e.currentTarget.value)
}
</script>

<style lang="scss" scoped></style>
