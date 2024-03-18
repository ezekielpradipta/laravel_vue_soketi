<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div
    v-show="isSidebarOpen"
    @click="isSidebarOpen = false"
    class="fixed inset-0 z-10 bg-black bg-opacity-50 lg:hidden"
  ></div>

  <aside
    id="sidebar"
    :class="[isSidebarOpen ? ' ' : ' hidden']"
    class="fixed top-0 left-0 z-20 flex-col flex-shrink-0 h-full pt-16 font-normal duration-75 lg:flex transition-width"
  >
    <div
      class="relative flex flex-col flex-1 h-full pt-0 w-64 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
        <div
          class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
        >
          <ul class="pb-2 space-y-2">
            <li v-for="item in menus" :key="item.name">
              <div v-if="!item.children">
                <router-link
                  :to="item.to"
                  :class="
                    $route.name === item.to.name
                      ? ' bg-gray-100 dark:bg-gray-700'
                      : ' hover:bg-gray-100 dark:hover:bg-gray-700 '
                  "
                  class="flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200"
                >
                  <svg
                    :class="
                      $route.name === item.to.name
                        ? '  text-gray-900 dark:text-white'
                        : ' group-hover:text-gray-900  dark:group-hover:text-white'
                    "
                    class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path fill-rule="evenodd" :d="item.path" clip-rule="evenodd" />
                  </svg>
                  <span class="ml-3" sidebar-toggle-item="">{{ item.name }}</span>
                </router-link>
              </div>
              <div v-else @click="toggleSubMenu(item)">
                <div
                  :class="
                    $route.name === item.to.name
                      ? ' bg-gray-100 dark:bg-gray-700'
                      : ' hover:bg-gray-100 dark:hover:bg-gray-700 '
                  "
                  class="flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200"
                >
                  <svg
                    :class="
                      $route.name === item.to.name
                        ? '  text-gray-900 dark:text-white'
                        : ' group-hover:text-gray-900  dark:group-hover:text-white'
                    "
                    class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path fill-rule="evenodd" :d="item.path" clip-rule="evenodd" />
                  </svg>
                  <span class="ml-3" sidebar-toggle-item="">{{ item.name }}</span>
                </div>
              </div>
              <ul v-if="item.showSubMenu" class="ml-4 mt-2 max-h-40 overflow-y-auto">
                <li v-for="childItem in item.children" :key="childItem.name" class="mt-1">
                  <router-link
                    :to="childItem.to"
                    :class="
                      $route.name === childItem.to.name
                        ? ' bg-gray-100 dark:bg-gray-700'
                        : ' hover:bg-gray-100 dark:hover:bg-gray-700 '
                    "
                    class="flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200"
                  >
                    <svg
                      :class="
                        $route.name === childItem.to.name
                          ? '  text-gray-900 dark:text-white'
                          : ' group-hover:text-gray-900  dark:group-hover:text-white'
                      "
                      class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4.2a1 1 0 1 0-2 0V11H7.8a1 1 0 1 0 0 2H11v3.2a1 1 0 1 0 2 0V13h3.2a1 1 0 1 0 0-2H13V7.8Z"
                        clip-rule="evenodd"
                      />
                    </svg>

                    <span class="ml-3" sidebar-toggle-item="">{{ childItem.name }}</span>
                  </router-link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { inject, onMounted, ref } from 'vue'
import { sidebarMenu } from './sidebarMenu/SidebarMenuRole'
const isSidebarOpen = inject('isSidebarOpen')

const menus = ref([])
onMounted(() => {
  menus.value = sidebarMenu()
})

const toggleSubMenu = (item) => {
  item.showSubMenu = !item.showSubMenu
}
</script>

<style lang="scss" scoped></style>
