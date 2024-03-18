<template>
  <div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
      <div
        class="mt-4 flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
      >
        <select
          v-model="selectedPerPage"
          id="per-page"
          name="per-page"
          class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
        >
          <option
            v-for="option in perPageOptions"
            :key="option"
            :value="option"
            placeholder="Per-Page"
            class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
          >
            <p class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
              Per-Page {{ option }}
            </p>
          </option>
        </select>
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
          <div
            class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none"
          >
            <svg
              class="w-5 h-5 text-gray-500 dark:text-gray-400"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </div>
          <input
            v-model="searchQuery"
            @input="search"
            type="text"
            id="table-search"
            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search Something.."
          />
        </div>
      </div>

      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th v-if="props.number" scope="col" class="px-6 py-3">#</th>

            <th
              scope="col"
              class="px-6 py-3"
              v-for="{ key, label, button } in props.headers"
              :key="key"
            >
              <p v-if="button">Action</p>
              <p v-else>
                {{ label }}
              </p>
            </th>
          </tr>
        </thead>
        <tbody v-if="props.dataTable.data.length === 0">
          <tr
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <td class="px-6 py-4">Data Not Found</td>
          </tr>
        </tbody>
        <tbody
          class="text-gray-700 dark:text-gray-400"
          v-else
          v-for="(p, index) in props.dataTable.data"
          :key="p"
        >
          <tr
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <td v-if="props.number" class="px-6 py-1 w-3 text-center">
              {{ (props.dataTable.page - 1) * props.dataTable.per_page + index + 1 }}
            </td>

            <td
              v-for="{ key, button, condition } in headers"
              :key="key"
              class="px-6 whitespace-nowrap"
            >
              <div v-if="button">
                <div class="flex items-center space-x-4 text-sm">
                  <div v-for="btn in button" :key="btn">
                    <button
                      @click.prevent="handleClick(btn, p)"
                      :class="buttonClasses[btn]"
                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 rounded-lg focus:outline-none focus:shadow-outline-gray"
                      :aria-label="btn"
                    >
                      <svg class="w-5 h-5" aria-hidden="true" fill="none" viewBox="0 0 24 24">
                        <path
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          :d="svgPaths[btn]"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div
                v-else-if="condition && condition[p[key]]"
                class="flex items-center space-x-4 text-sm"
              >
                <span
                  class="text-xs font-semibold inline-block py-1 last:mr-0 mr-1 px-2 uppercase rounded-full"
                  :class="conditionClasses[condition[p[key]].color]"
                >
                  {{ condition[p[key]].name }}
                </span>
              </div>
              <div v-else>
                {{ p[key] }}
              </div>
            </td>
            <td v-if="props.hidden">
              <button
                type="button"
                @click.prevent="buttonToggleHiddenIndex(index)"
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-500 rounded-lg dark:text-yellow-400 focus:outline-none focus:shadow-outline-gray"
              >
                <svg
                  class="w-6 h-6 text-gray-800 dark:text-white"
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
                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                  />
                </svg>
              </button>
            </td>
          </tr>

          <tr v-if="props.hidden && openHiddenIndex === index">
            <td colspan="5" class="px-6 py-4">
              <div class="border rounded-md overflow-hidden shadow-md dark:border-new-dark-light">
                <table class="w-full dark:bg-new-dark-secondary">
                  <tbody>
                    <tr v-for="{ hidden_key, hidden_label } in props.hidden" :key="hidden_key">
                      <td class="py-2 px-4 border-r border-b dark:border-new-dark-light">
                        {{ hidden_label }}
                      </td>
                      <td class="py-2 px-4 border-b dark:border-new-dark-light">
                        {{ p[hidden_key] }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Mobile Responsive Table -->
    <!-- Pagination -->
    <nav
      class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
      aria-label="Table navigation"
    >
      <span
        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto"
        >Showing
        <span class="font-semibold text-gray-900 dark:text-white"
          >{{ props.dataTable.from }}-{{ props.dataTable.to }}</span
        >
        of
        <span class="font-semibold text-gray-900 dark:text-white">{{
          props.dataTable.total
        }}</span></span
      >
      <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
        <li>
          <a
            href="#"
            @click.prevent="onClickPreviousPage"
            :class="hitung.isInFirstPage ? 'disabled' : ''"
            :disabled="hitung.isInFirstPage"
            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >Previous</a
          >
        </li>
        <li v-for="page in hitung.pages" :key="page.id">
          <a
            href="#"
            @click.prevent="onClickPage(page.name)"
            :disabled="page.isDisabled"
            :class="[
              isPageActive(page.name)
                ? ' dark:bg-gray-700 dark:text-white dark:border-gray-700 hover:text-blue-700 hover:bg-blue-100 bg-blue-50 text-blue-600 '
                : ' dark:hover:bg-gray-700 dark:hover:text-white dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 hover:bg-gray-100 bg-white leading-tight text-gray-500'
            ]"
            class="flex items-center justify-center px-3 h-8 border border-gray-300 dark:border-gray-700"
          >
            {{ page.name }}</a
          >
        </li>
        <li v-if="!hitung.isInLastPage && !hitung.isInFirstPage && props.dataTable.last_page - 1">
          <a
            href="#"
            :disabled="hitung.isInLastPage"
            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >...</a
          >
        </li>
        <li v-if="!hitung.isInLastPage && !hitung.isInFirstPage && props.dataTable.last_page - 1">
          <a
            href="#"
            @click.prevent="onClickPage(props.dataTable.last_page)"
            :disabled="hitung.isInLastPage"
            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >{{ props.dataTable.last_page }}</a
          >
        </li>
        <li>
          <a
            href="#"
            :class="hitung.isInLastPage ? 'disabled' : ''"
            :disabled="hitung.isInLastPage"
            @click.prevent="onClickNextPage"
            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >Next</a
          >
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue'

const props = defineProps({
  headers: {
    type: Array,
    required: true
  },
  hidden: {
    type: Array,
    required: false
  },

  number: {
    type: Boolean,
    default: true
  },

  maxVisibleButtons: {
    type: Number,
    required: false,
    default: 3
  },

  dataTable: {
    type: Object,
    required: true
  }
})

const emit = defineEmits([
  'per_page',
  'search',
  'pagechanged',
  'delete',
  'valid',
  'restore',
  'file',
  'cancel',
  'detail',
  'edit',
  'print'
])

const buttonClasses = reactive({
  Delete: '  text-red-500  dark:text-red-400 ',
  Edit: ' text-blue-500  dark:text-blue-400 ',
  Detail: ' text-yellow-500 dark:text-yellow-500',
  Restore: 'text-green-500 dark:text-green-500',
  File: 'text-green-500 dark:text-green-500',
  Print: 'text-blue-500  dark:text-blue-400',
  Valid: 'text-green-500 dark:text-green-500',
  Cancel: 'text-red-500  dark:text-red-400'
})
const conditionClasses = reactive({
  green: 'text-green-600 bg-green-200',
  gray: 'text-gray-600 bg-gray-200',
  red: 'text-red-600 bg-red-200',
  yellow: 'text-yellow-600 bg-yellow-200',
  blue: 'text-blue-600 bg-blue-200',
  indigo: 'text-indigo-600 bg-indigo-200',
  purple: 'text-purple-600 bg-purple-200',
  pink: 'text-pink-600 bg-pink-200'
})
const svgPaths = reactive({
  Delete:
    'M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z',
  Edit: 'm14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z',
  Detail:
    'M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z',
  Restore: 'M3 9h13a5 5 0 0 1 0 10H7M3 9l4-4M3 9l4 4',
  File: 'M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z',
  Print:
    ' M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z',
  Valid: 'M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
  Cancel: 'm15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'
})

const handleClick = (button, p) => {
  if (button === 'Delete') {
    deleteThis(p)
  } else if (button === 'Edit') {
    editThis(p)
  } else if (button === 'Detail') {
    detailThis(p)
  } else if (button === 'Restore') {
    restoreThis(p)
  } else if (button === 'File') {
    fileThis(p)
  } else if (button === 'Print') {
    printThis(p)
  } else if (button === 'Valid') {
    validThis(p)
  } else if (button === 'Cancel') {
    cancelThis(p)
  }
}
const selectedPerPage = ref(0)
const searchQuery = ref('')
const perPageOptions = [5, 25, 50, 100]
const openHiddenIndex = ref(null)

const buttonToggleHiddenIndex = async (index) => {
  openHiddenIndex.value = openHiddenIndex.value === index ? null : index
}

const emitPerPageChange = () => {
  emit('per_page', selectedPerPage.value)
}
const search = () => {
  emit('search', searchQuery.value)
}
watch(
  () => props.dataTable.per_page,
  (newPageSize) => {
    selectedPerPage.value = newPageSize
  }
)
watch(selectedPerPage, () => {
  emitPerPageChange()
})
const deleteThis = (e) => {
  emit('delete', e)
}

const editThis = (e) => {
  emit('edit', e)
}
const detailThis = (e) => {
  emit('detail', e)
}
const restoreThis = (e) => {
  emit('restore', e)
}
const validThis = (e) => {
  emit('valid', e)
}
const fileThis = (e) => {
  emit('file', e)
}
const cancelThis = (e) => {
  emit('cancel', e)
}
const printThis = (e) => {
  emit('print', e)
}
const onClickPreviousPage = () => {
  if (hitung.isInFirstPage) {
    return false
  }
  emit('pagechanged', props.dataTable.page - 1)
}
const onClickPage = (page) => {
  emit('pagechanged', page)
}
const onClickNextPage = () => {
  if (hitung.isInLastPage) {
    return false
  }
  emit('pagechanged', props.dataTable.page + 1)
}
const isPageActive = (page) => {
  return props.dataTable.page === page
}
const hitung = reactive({
  isInFirstPage: computed(() => {
    return props.dataTable.page === 1
  }),
  isInLastPage: computed(() => {
    if (props.dataTable.last_page === 0) {
      return true
    }
    return props.dataTable.page === props.dataTable.last_page
  }),

  startPage: computed(() => {
    if (props.dataTable.page === 1) {
      return 1
    }
    if (props.dataTable.last_page < props.maxVisibleButtons) {
      return 1
    }
    if (props.dataTable.page === props.dataTable.last_page) {
      return props.dataTable.last_page - props.maxVisibleButtons + 1
    }
    return props.dataTable.page - 1
  }),
  endPage: computed(() => {
    if (props.dataTable.last_page === 0) {
      return 1
    }
    if (props.dataTable.last_page < props.maxVisibleButtons) {
      return props.dataTable.last_page
    }
    return Math.min(hitung.startPage + props.maxVisibleButtons - 1, props.dataTable.last_page)
  }),
  pages: computed(() => {
    const range = []
    for (let i = hitung.startPage; i <= hitung.endPage; i++) {
      range.push({
        name: i,
        isDisabled: i === props.dataTable.page
      })
    }
    return range
  })
})
</script>

<style lang="scss" scoped></style>
