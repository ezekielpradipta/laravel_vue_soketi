<template>
  <button
    type="button"
    @click="buttonShowNotif"
    class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700"
  >
    <span class="sr-only">View notifications</span>
    <div class="flex items-center">
      <svg
        class="w-6 h-6"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
        ></path>
      </svg>
      <span
        class="text-xs bg-red-500 text-white px-1 rounded-full"
        v-if="data_pesan.data.length > 0"
        >{{ data_pesan.data.length }}</span
      >
    </div>
  </button>
  <div
    v-if="show_notif"
    class="z-20 absolute top-10 right-10 max-w-sm my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700"
  >
    <div
      class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
    >
      Notifications
    </div>
    <div>
      <div
        v-for="item in data_pesan.data"
        :key="item"
        @click="buttonDetailPesan(item)"
        class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600"
      >
        <div class="flex-shrink-0">
          <img
            class="rounded-full w-11 h-11"
            src="https://flowbite-admin-dashboard.vercel.app/images/users/bonnie-green.png"
            alt="Jese image"
          />
          <div
            class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 border border-white rounded-full bg-primary-700 dark:border-gray-700"
          >
            <svg
              class="w-3 h-3 text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"
              ></path>
              <path
                d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"
              ></path>
            </svg>
          </div>
        </div>
        <div class="w-full pl-3">
          <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
            New message from
            <span class="font-semibold text-gray-900 dark:text-white">{{ item.nama }}</span
            >: "{{ item.judul }}"
          </div>
          <div class="text-xs font-medium text-primary-700 dark:text-primary-400">
            {{ item.tanggal }}
          </div>
        </div>
      </div>
    </div>
    <div
      @click="buttonPesanAll"
      class="block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline"
    >
      <div class="inline-flex items-center">
        <svg
          class="w-5 h-5 mr-2"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
          <path
            fill-rule="evenodd"
            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
            clip-rule="evenodd"
          ></path>
        </svg>
        View all
      </div>
    </div>
  </div>
</template>

<script setup>
import usePesan from '@/composables/User/Pesan'
import { inject, onMounted, reactive, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import echo from '@/echo'
const { notif_pesan, getNotifPesan } = usePesan()
const show_notif = ref(false)
const router = useRouter()
const user_id = inject('user_id')
const buttonShowNotif = async () => {
  show_notif.value = !show_notif.value
}
const data_pesan = reactive({
  data: []
})
onMounted(async () => {
  await getNotifPesan()
  const channel = echo.private('kirim-notif.' + user_id)
  channel.listen('KirimNotifikasi', () => {
    getNotifPesan()
  })
})

watch(notif_pesan, (data) => {
  data_pesan.data = data
})
const buttonPesanAll = async () => {
  router.push({
    name: 'UserPesan'
  })
}
const buttonDetailPesan = async (id) => {
  router.push({
    name: 'UserPesan',
    query: {
      id: btoa(JSON.stringify(id))
    }
  })
}
</script>

<style lang="scss" scoped></style>
