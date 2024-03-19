<template>
  <div>
    <Menu>
      <MenuButton
        class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
        id="user-menu-button-2"
      >
        <span class="sr-only">Open user menu</span>
        <svg
          class="w-8 h-8 text-gray-500 dark:text-white"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            fill-rule="evenodd"
            d="M12 20a8 8 0 0 1-5-1.8v-.6c0-1.8 1.5-3.3 3.3-3.3h3.4c1.8 0 3.3 1.5 3.3 3.3v.6a8 8 0 0 1-5 1.8ZM2 12a10 10 0 1 1 10 10A10 10 0 0 1 2 12Zm10-5a3.3 3.3 0 0 0-3.3 3.3c0 1.7 1.5 3.2 3.3 3.2 1.8 0 3.3-1.5 3.3-3.3C15.3 8.6 13.8 7 12 7Z"
            clip-rule="evenodd"
          />
        </svg>
      </MenuButton>

      <MenuItems
        class="absolute py-1 mt-2 right-0 bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
      >
        <div class="px-4 py-3" role="none">
          <p class="text-sm text-gray-900 dark:text-white" role="none">{{ username }}</p>
          <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none"></p>
        </div>
        <MenuItem
          v-for="item in userNavigation"
          :key="item.name"
          v-slot="{ active }"
          @click="handleItemClick(item)"
        >
          <a
            href="#"
            :class="[
              active ? 'bg-gray-100' : '',
              'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white'
            ]"
            >{{ item.name }}</a
          >
        </MenuItem>
      </MenuItems>
    </Menu>
  </div>
</template>

<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import useAuth from '@/composables/Auth'
import { inject } from 'vue'
import { useRouter } from 'vue-router'
const { logout } = useAuth()
const userNavigation = [
  { name: 'Akun', href: '#' },
  { name: 'Log Out', href: '#' }
]
const username = inject('username')
const role_name = inject('role_name')
const router = useRouter()
const handleItemClick = async (item) => {
  if (item.name === 'Log Out') {
    await logout()
  } else if (item.name === 'Akun') {
    if (role_name == 'admin') {
      router.push({
        name: 'AdminAkun'
      })
    } else {
      router.push({
        name: 'UserAkun'
      })
    }
  }
}
</script>

<style lang="scss" scoped></style>
