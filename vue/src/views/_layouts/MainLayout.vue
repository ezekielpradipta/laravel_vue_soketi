<template>
  <div
    class="relative overflow-hidden flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-gray-950 dark:text-gray-50"
  >
    <sidebar-layout></sidebar-layout>
    <div class="flex flex-col flex-1 overflow-hidden">
      <header-layout></header-layout>
      <div class="overflow-y-auto">
        <main class="flex-1 px-4 py-8 mb-20 lg:ml-64">
          <router-view></router-view>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import SidebarLayout from './SidebarLayout.vue'
import HeaderLayout from './HeaderLayout.vue'
import { provide, ref } from 'vue'
import { jwtDecode } from 'jwt-decode'

let isSidebarOpen = ref(false)
let token = localStorage.getItem('token')
const decode_token = jwtDecode(token)
const username = decode_token.user_name
const role_name = decode_token.role_name
const user_id = decode_token.sub
provide('isSidebarOpen', isSidebarOpen)
provide('username', username)
provide('role_name', role_name)
provide('user_id', user_id)
</script>

<style lang="scss" scoped></style>
