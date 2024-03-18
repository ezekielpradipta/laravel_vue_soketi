<!-- eslint-disable vue/require-v-for-key -->
<template>
  <div class="w-full overflow-hidden rounded-lg shadow-xs hidden md:block">
    <div class="w-full overflow-x-auto">
      <table class="w-full whitespace-no-wrap table-auto">
        <thead
          class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-50 bg-gray-50 dark:text-gray-300 dark:bg-new-dark-primary"
        >
          <th
            v-if="props.nomor"
            scope="col"
            class="px-6 py-3 bg-white divide-y dark:text-gray-300 dark:bg-new-dark-primary"
          >
            #
          </th>
          <th
            scope="col"
            class="px-6 py-3 bg-white divide-y dark:text-gray-300 dark:bg-new-dark-primary"
            v-for="{ key, label, button } in headers"
            :key="key"
          >
            <p v-if="button">Aksi</p>
            <p v-else>
              {{ label }}
            </p>
          </th>
        </thead>
        <tbody
          v-if="props.items.length == 0"
          class="mb-4 bg-white dark:text-gray-300 dark:bg-new-dark-primary"
        >
          <tr>
            Data Tidak Ditemukan
          </tr>
        </tbody>
        <tbody
          v-else
          v-for="(p, index) in props.items"
          class="mb-4 bg-white dark:text-gray-300 dark:bg-new-dark-primary"
        >
          <!--  -->
          <tr
            class="text-gray-700 dark:text-gray-400 hover:bg-blue-50 dark:hover:bg-new-dark-secondary dark:hover:text-gray-300"
          >
            <td v-if="props.tipe === 'base' && props.nomor" class="px-6 py-1 w-3 text-center">
              {{ index + 1 }}
            </td>
            <td v-if="props.tipe === 'pagination' && props.nomor" class="px-6 py-1 w-3 text-center">
              {{ (props.pages - 1) * props.pageSize + index + 1 }}
            </td>

            <td v-for="{ key, button, view } in headers" :key="key" class="px-6 whitespace-nowrap">
              <slot v-if="button">
                <div class="flex items-center space-x-4 text-sm">
                  <div v-for="btn in button">
                    <div v-if="btn === 'Hapus'">
                      <button
                        @click.prevent="deleteThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-500 rounded-lg dark:text-red-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Hapus"
                      >
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </button>
                    </div>
                    <!--  -->
                    <div v-if="btn === 'Edit'">
                      <button
                        @click.prevent="editThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg dark:text-blue-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit"
                      >
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                          ></path>
                        </svg>
                      </button>
                    </div>
                    <!--  -->
                    <div v-if="btn === 'Detail'">
                      <button
                        @click.prevent="detailThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-500 rounded-lg dark:text-yellow-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Detail"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 24 24"
                          fill="currentColor"
                          class="w-5 h-5"
                        >
                          <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                          <path
                            fill-rule="evenodd"
                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>
                    </div>
                    <div v-if="btn === 'Restore'">
                      <button
                        @click.prevent="restoreThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Restore"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                          />
                        </svg>
                      </button>
                    </div>
                    <div v-if="btn === 'File'">
                      <button
                        @click.prevent="fileThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="File"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"
                          />
                        </svg>
                      </button>
                    </div>
                    <div v-if="btn === 'Print'">
                      <button
                        @click.prevent="printThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Print"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                          />
                        </svg>
                      </button>
                    </div>
                    <div v-if="btn === 'Valid'">
                      <button
                        @click.prevent="validThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Valid"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                      </button>
                    </div>
                    <div v-if="btn === 'Cancel'">
                      <button
                        @click.prevent="cancelThis(p)"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-500 rounded-lg dark:text-red-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Cancel"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-5 h-5"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              </slot>
              <slot v-else-if="view && view === 'xhr'" :value="p[key]" :name="`(${key})`">
                <p class="blog" v-html="p[key]"></p>
              </slot>
              <slot v-else :name="`(${key})`" :value="p[key]" :item="p">
                {{ p[key] }}
              </slot>
            </td>
            <td v-if="isHidden">
              <slot v-if="isHidden">
                <button
                  type="button"
                  @click.prevent="buttonToggleHiddenIndex(index)"
                  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-500 rounded-lg dark:text-yellow-400 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Delete"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </button>
              </slot>
            </td>
          </tr>

          <tr v-if="isHidden && openHiddenIndex === index">
            <td colspan="5" class="px-6 py-4">
              <div class="border rounded-md overflow-hidden shadow-md dark:border-new-dark-light">
                <table class="w-full dark:bg-new-dark-secondary">
                  <tbody>
                    <tr v-for="{ hidden_key, hidden_label } in props.hidden">
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
  </div>

  <!-- mobile responsive -->
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
    <div class="grid grid-cols-12 gap-4" v-for="(p, index) in props.items">
      <div class="col-span-12 relative w-auto max-w-6xl">
        <div
          class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white dark:bg-new-dark-secondary outline-none focus:outline-none"
        >
          <div
            v-for="{ key, label, view, button } in headers"
            class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
          >
            <div v-if="view && view === 'title'" class="text-base font-semibold">
              <p
                v-if="props.nomor && props.tipe === 'base'"
                class="text-blue-500 font-bold hover:underline dark:text-blue-400"
              >
                #{{ index + 1 }}
              </p>
              <p
                v-if="props.nomor && props.tipe === 'pagination'"
                class="text-blue-500 font-bold hover:underline dark:text-blue-400"
              >
                {{ (props.pages - 1) * props.pageSize + index + 1 }}
              </p>
              {{ p[key] }}
            </div>
            <div v-else class="text-gray-800 dark:text-gray-300 text-sm">
              <p v-if="label">
                <span class="font-semibold">{{ label }} :</span> {{ p[key] }}
              </p>
            </div>
            <div v-if="button" class="flex items-center justify-end">
              <div v-for="btn in button">
                <div v-if="btn === 'Hapus'">
                  <button
                    @click.prevent="deleteThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-500 rounded-lg dark:text-red-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Delete"
                  >
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </button>
                </div>
                <!--  -->
                <div v-if="btn === 'Edit'">
                  <button
                    @click.prevent="editThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg dark:text-blue-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Delete"
                  >
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                      ></path>
                    </svg>
                  </button>
                </div>
                <!--  -->
                <div v-if="btn === 'Detail'">
                  <button
                    @click.prevent="detailThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-yellow-500 rounded-lg dark:text-yellow-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Delete"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="w-5 h-5"
                    >
                      <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                      <path
                        fill-rule="evenodd"
                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </div>
                <div v-if="btn === 'Restore'">
                  <button
                    @click.prevent="restoreThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Restore"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"
                      />
                    </svg>
                  </button>
                </div>
                <div v-if="btn === 'File'">
                  <button
                    @click.prevent="fileThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="File"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"
                      />
                    </svg>
                  </button>
                </div>
                <div v-if="btn === 'Print'">
                  <button
                    @click.prevent="printThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Print"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"
                      />
                    </svg>
                  </button>
                </div>
                <div v-if="btn === 'Valid'">
                  <button
                    @click.prevent="validThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Valid"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                </div>
                <div v-if="btn === 'Cancel'">
                  <button
                    @click.prevent="cancelThis(p)"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-500 rounded-lg dark:text-red-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Cancel"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!--  -->
          </div>

          <!--  -->
          <div
            v-for="{ hidden_key, hidden_label } in props.hidden"
            class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
          >
            <div class="text-gray-800 dark:text-gray-300 text-sm">
              <p v-if="hidden_label">
                <span class="font-semibold">{{ hidden_label }} :</span>
                {{ p[hidden_key] }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div
    v-if="props.tipe === 'pagination'"
    class="bg-white px-4 py-3 flex items-center justify-between sm:px-6 mt-4 dark:bg-new-dark-primary"
  >
    <!-- mobile mode -->
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        href="#"
        @click.prevent="onClickPreviousPage"
        :class="hitung.isInFirstPage ? 'disabled' : ''"
        :disabled="hitung.isInFirstPage"
        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-new-dark-darker text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-new-dark-secondary dark:text-blue-400"
      >
        <span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-5 h-5"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </span>
      </a>
      <a
        href="#"
        @click.prevent="onClickNextPage"
        :class="hitung.isInLastPage ? 'disabled' : ''"
        :disabled="hitung.isInLastPage"
        class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 dark:border-new-dark-darker text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-new-dark-secondary dark:text-blue-400"
      >
        <span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-5 h-5"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>
    </div>
    <!-- pc mode -->
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <a
            href="#"
            @click.prevent="onClickPreviousPage"
            :class="hitung.isInFirstPage ? 'disabled' : ''"
            :disabled="hitung.isInFirstPage"
            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:text-gray-300 dark:bg-new-dark-secondary dark:border-new-dark-primary"
          >
            <span class="sr-only">Previous</span>
            <!-- Heroicon name: solid/chevron-left -->
            <svg
              class="h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <li :key="page.id" v-for="page in hitung.pages">
            <a
              href="#"
              @click.prevent="onClickPage(page.name)"
              :disabled="page.isDisabled"
              :class="[
                isPageActive(page.name)
                  ? ' bg-white border-gray-300 text-blue-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium dark:text-gray-300 dark:bg-blue-600 dark:border-new-dark-primary'
                  : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium dark:text-gray-300 dark:bg-new-dark-secondary dark:border-new-dark-primary'
              ]"
              class=""
            >
              {{ page.name }}
            </a>
          </li>
          <li v-if="!hitung.isInLastPage && !hitung.isInFirstPage && props.totalPages - 1">
            <a
              href="#"
              :disabled="hitung.isInLastPage"
              class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium dark:text-gray-300 dark:bg-new-dark-secondary dark:border-new-dark-primary"
            >
              ...
            </a>
            <a
              href="#"
              @click.prevent="onClickPage(props.totalPages)"
              :disabled="hitung.isInLastPage"
              class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium dark:text-gray-300 dark:bg-new-dark-secondary dark:border-new-dark-primary"
            >
              {{ props.totalPages }}
            </a>
          </li>
          <a
            href="#"
            @click.prevent="onClickNextPage"
            :class="hitung.isInLastPage ? 'disabled' : ''"
            :disabled="hitung.isInLastPage"
            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:text-gray-300 dark:bg-new-dark-secondary dark:border-new-dark-primary"
          >
            <span class="sr-only">Next</span>
            <!-- Heroicon name: solid/chevron-right -->
            <svg
              class="h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
        </nav>
      </div>
    </div>
  </div>
  <div v-if="props.tipe === 'pagination'">
    <span>
      Halaman {{ props.pages }} dari {{ props.totalPages }}, Total : {{ props.totalData }} Data
    </span>
  </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
const props = defineProps({
  headers: {
    type: Array,
    required: true
  },
  hidden: {
    type: Array,
    required: false
  },
  items: {
    type: Array,
    required: true
  },
  tipe: {
    type: String,
    default: 'base'
  },
  nomor: {
    type: Boolean,
    default: true
  },
  // Pagination
  pages: {
    type: Number,
    required: false
  },
  pageSize: {
    type: Number,
    required: false
  },
  maxVisibleButtons: {
    type: Number,
    required: false,
    default: 3
  },
  totalPages: {
    type: Number,
    required: false
  },
  totalData: {
    type: Number,
    required: false
  }
})
const isHidden = ref(false)
if (props.hidden) {
  isHidden.value = true
}
const openHiddenIndex = ref(null)
const buttonToggleHiddenIndex = async (index) => {
  openHiddenIndex.value = openHiddenIndex.value === index ? null : index
}
const hitung = reactive({
  isInFirstPage: computed(() => {
    return props.pages === 1
  }),
  isInLastPage: computed(() => {
    if (props.totalPages === 0) {
      return true
    }
    return props.pages === props.totalPages
  }),
  endPage: computed(() => {
    if (props.totalPages === 0) {
      return 1
    }
    if (props.totalPages < props.maxVisibleButtons) {
      return props.totalPages
    }
    return Math.min(hitung.startPage + props.maxVisibleButtons - 1, props.totalPages)
  }),
  startPage: computed(() => {
    //page1
    if (props.pages === 1) {
      return 1
    }
    //page akhir
    if (props.totalPages < props.maxVisibleButtons) {
      return 1
    }
    if (props.pages === props.totalPages) {
      return props.totalPages - props.maxVisibleButtons + 1
    }
    //page bukan 1
    return props.pages - 1
  }),
  pages: computed(() => {
    const range = []
    for (let i = hitung.startPage; i <= hitung.endPage; i++) {
      range.push({
        name: i,
        isDisabled: i === props.pages
      })
    }
    return range
  })
})
const emit = defineEmits([
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
function onClickPreviousPage() {
  if (hitung.isInFirstPage) {
    return false
  }
  emit('pagechanged', props.pages - 1)
}
function onClickPage(page) {
  emit('pagechanged', page)
}
function onClickNextPage() {
  if (hitung.isInLastPage) {
    return false
  }
  emit('pagechanged', props.pages + 1)
}
function isPageActive(page) {
  return props.pages === page
}

function deleteThis(e) {
  emit('delete', e)
}
function detailThis(e) {
  emit('detail', e)
}
function editThis(e) {
  emit('edit', e)
}
function restoreThis(e) {
  emit('restore', e)
}
function validThis(e) {
  emit('valid', e)
}
function fileThis(e) {
  emit('file', e)
}
function cancelThis(e) {
  emit('cancel', e)
}
function printThis(e) {
  emit('print', e)
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
