<template>
  <div class="p-5">
    <div class="overflow-x-scroll">
      <ol class="flex items-center w-full text-sm font-medium text-center sm:text-base">
        <li
          v-for="(step, index) in steps"
          :key="index"
          class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-300 after:border-1 after:hidden sm:after:inline-block after:mx-2.5 xl:after:mx-5 dark:after:border-gray-700"
          :class="[
            index === currentStepIndex
              ? 'text-blue-600 dark:text-blue-500'
              : 'text-gray-600 dark:text-gray-300'
          ]"
        >
          <span
            @click="goToStep(index)"
            v-if="index === currentStepIndex"
            class="uppercase flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-300 dark:after:text-gray-500"
          >
            <svg
              class="w-3.5 h-3.5 sm:w-4 sm:h-4 me-2.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"
              />
            </svg>
            {{ step.title }}
          </span>

          <span
            @click="goToStep(index)"
            v-else
            class="uppercase flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-300 dark:after:text-gray-500"
          >
            <span class="me-2">{{ index + 1 }}</span>
            {{ step.title }}
          </span>
        </li>
      </ol>
    </div>
    <form @submit.prevent="onSubmit" enctype="multipart/form-data">
      <slot></slot>
      <div class="flex p-2 mt-10 mb-10">
        <ButtonComponnet icon="back" text="Kembali" v-if="hasPrevious" @click="goToPrev">
        </ButtonComponnet>

        <ButtonComponnet
          type="submit"
          right
          size="xs"
          v-if="props.mode !== 'detail' || !isLastStep"
          :icon="!isLastStep ? 'next' : 'save'"
          :text="!isLastStep ? 'Selanjutnya' : 'Simpan'"
        >
        </ButtonComponnet>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, provide } from 'vue'
import ButtonComponnet from './ButtonComponnet.vue'
const FormData = ref({})
const emit = defineEmits(['next', 'submit'])
const currentStepIndex = ref(0)
const stepCounter = ref(0)
const steps = ref([])
provide('STEP_COUNTER', stepCounter)
provide('CURRENT_STEP_INDEX', currentStepIndex)
provide('STEPS', steps)

const isLastStep = computed(() => {
  return currentStepIndex.value === stepCounter.value - 1
})
const props = defineProps({
  mode: {
    type: String,
    default: 'edit'
  }
})

const hasPrevious = computed(() => {
  return currentStepIndex.value > 0
})

const goToPrev = () => {
  if (currentStepIndex.value === 0) {
    return
  }
  currentStepIndex.value--
}
const goToStep = (index) => {
  currentStepIndex.value = index
}
const onSubmit = async (value) => {
  FormData.value = {
    ...FormData.value,
    ...value
  }
  if (!isLastStep.value) {
    currentStepIndex.value++
    emit('next', FormData.value)
    return
  }
  emit('submit', FormData.value)
}
</script>

<style lang="scss" scoped>
li {
  list-style-type: none;
}
::-webkit-scrollbar {
  width: 0.5em; /* Adjust the width as needed */
}
::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.2); /* Adjust the scrollbar thumb color as needed */
  border-radius: 0.25em; /* Adjust the border-radius as needed */
}
::-webkit-scrollbar-thumb:hover {
  background-color: rgba(0, 0, 0, 0.3); /* Adjust the scrollbar thumb color on hover as needed */
}
* {
  scrollbar-color: rgba(0, 0, 0, 0.2) transparent; /* Adjust the scrollbar color as needed */
  scrollbar-width: thin; /* Adjust the scrollbar width as needed */
}
</style>
