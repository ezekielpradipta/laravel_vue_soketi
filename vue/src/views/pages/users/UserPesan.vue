<template>
  <LoaderComponent :loading="loader"></LoaderComponent>
  <ParentTransation appear :visibility="true">
    <!--  -->
    <div class="grid grid-cols-12 gap-4 mt-10 mb-10">
      <div class="col-span-12 xl:col-span-2">
        <CardComponent>
          <div class="flex-1 px-4 space-y-2">
            <ul>
              <li class="mt-2" @click="buttonKotakMasuk">
                <div
                  :class="
                    kotak_pesan === 'kotak_masuk'
                      ? 'flex items-center w-full space-x-2 text-white bg-blue-600 dark:bg-gray-700 rounded-lg dark:text-gray-100'
                      : 'flex items-center space-x-2 text-blue-600 transition-colors rounded-lg group hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:bg-gray-700 dark:hover:text-gray-100'
                  "
                >
                  <span
                    aria-hidden="true"
                    :class="
                      kotak_pesan === 'kotak_masuk'
                        ? 'p-2 bg-blue-700 dark:bg-gray-700 rounded-lg'
                        : 'p-2 transition-colors rounded-lg group-hover:bg-blue-700 group-hover:text-white dark:group-hover:bg-new-dark-primary'
                    "
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
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                      />
                    </svg>
                  </span>
                  <span>Kotak Masuk</span>
                </div>
              </li>

              <li class="mt-2" @click="buttonKotakKeluar">
                <div
                  :class="
                    kotak_pesan === 'kotak_keluar'
                      ? 'flex items-center w-full space-x-2 text-white bg-blue-600 dark:bg-gray-700 rounded-lg dark:text-gray-100'
                      : 'flex items-center space-x-2 text-blue-600 transition-colors rounded-lg group hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:bg-gray-700 dark:hover:text-gray-100'
                  "
                >
                  <span
                    aria-hidden="true"
                    :class="
                      kotak_pesan === 'kotak_keluar'
                        ? 'p-2 bg-blue-700 dark:bg-gray-700 rounded-lg'
                        : 'p-2 transition-colors rounded-lg group-hover:bg-blue-700 group-hover:text-white dark:group-hover:bg-new-dark-primary'
                    "
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
                        d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
                      />
                    </svg>
                  </span>
                  <span>Kotak Keluar</span>
                </div>
              </li>
            </ul>
          </div>
        </CardComponent>
      </div>

      <!--  -->
      <div class="col-span-12 xl:col-span-10">
        <!-- Filter -->
        <CardComponent class="mb-4">
          <div class="grid xl:grid-cols-4 gap-6">
            <div class="col-span-1">
              <SearchComponent
                placeholder="Filter Judul"
                v-model="filter.judul"
                v-on:keyup="filter_judul"
              ></SearchComponent>
            </div>
            <div class="col-span-1">
              <Datepicker
                v-model="filter.date"
                range
                multi-calendars
                auto-apply
                format="yyyy-MM-dd"
                placeholder="Filter Tanggal"
                @cleared="clear_date"
                :dark="display === 'dark' ? true : false"
                @closed="selectDate"
                :enable-time-picker="false"
              >
              </Datepicker>
            </div>
            <div class="col-span-1" v-if="kotak_pesan === 'kotak_masuk'">
              <button
                @click="buttonStatusUnread"
                type="button"
                class="mr-4 mb-4 text-sm font-medium px-3 py-2 rounded-lg flex items-center"
                :class="
                  filter.status_baca == 0
                    ? ' bg-blue-700 text-white hover:bg-blue-800 border dark:border-new-dark-darker dark:bg-new-dark-secondary '
                    : 'border hover:bg-blue-800 hover:text-white dark:border-new-dark-darker dark:bg-new-dark-secondary'
                "
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6 mr-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"
                  />
                </svg>

                Pesan Belum Dibaca
              </button>
              <button
                @click="buttonStatusRead"
                type="button"
                class="mr-4 mb-4 text-sm font-medium px-3 py-2 rounded-lg flex items-center"
                :class="
                  filter.status_baca == 1
                    ? 'bg-blue-700 text-white hover:bg-blue-800 border dark:border-new-dark-darker dark:bg-new-dark-secondary '
                    : ' border hover:bg-blue-800 hover:text-white dark:border-new-dark-darker dark:bg-new-dark-secondary'
                "
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6 mr-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"
                  />
                </svg>
                Pesan Sudah Dibaca
              </button>
            </div>
          </div>
        </CardComponent>

        <!-- pagination -->
        <div
          class="block justify-between items-center p-4 mx-4 mb-5 bg-white rounded-2xl dark:bg-gray-700 sm:flex lg:mt-5"
        >
          <div class="flex items-center divide-x divide-gray-100 dark:divide-gray-700">
            <a
              href="#"
              @click.prevent="onClickPreviousPage"
              :class="hitung.isInFirstPage ? 'disabled' : ''"
              :disabled="hitung.isInFirstPage"
              class="inline-flex justify-center p-1 text-gray-500 dark:text-gray-300 rounded cursor-pointer"
            >
              <svg
                class="w-7 h-7"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
            <a
              @click.prevent="onClickNextPage"
              :class="hitung.isInLastPage ? 'disabled' : ''"
              :disabled="hitung.isInLastPage"
              href="#"
              class="inline-flex justify-center p-1 text-gray-500 dark:text-gray-300 rounded cursor-pointer"
            >
              <svg
                class="w-7 h-7"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
            <span class="font-normal text-gray-500 dark:text-gray-300 sm:text-xs md:text-sm"
              >Show
              <span class="font-semibold text-gray-900 dark:text-gray-200"
                >{{ data_table.from }} - {{ data_table.to }}</span
              >
              of
              <span class="font-semibold text-gray-900 dark:text-gray-200">{{
                data_table.totalData
              }}</span></span
            >
          </div>
        </div>
        <!-- Table -->
        <CardComponent>
          <div class="flex flex-col">
            <div class="overflow-x-auto">
              <div class="inline-block min-w-full align-middle">
                <!--  -->
                <div class="overflow-hidden shadow">
                  <table
                    class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-800"
                  >
                    <thead
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-50 bg-gray-50 dark:text-gray-300 dark:bg-gray-700"
                    >
                      <th
                        scope="col"
                        class="px-6 py-3 bg-white text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                      >
                        <span v-if="kotak_pesan === 'kotak_masuk'"> Pengirim </span>
                        <span v-else> Penerima </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 bg-white text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                      >
                        Pesan
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 bg-white text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                      >
                        Tanggal
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 bg-white text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                      >
                        Aksi
                      </th>
                    </thead>
                    <!--  -->
                    <tbody v-if="data_table.data.length == 0">
                      <tr>
                        <td
                          colspan="5"
                          class="p-4 text-sm text-gray-700 text-center dark:text-gray-400"
                        >
                          Pesan Tidak Ditemukan
                        </td>
                      </tr>
                    </tbody>
                    <tbody
                      v-else
                      class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-new-lighter-shader"
                    >
                      <!--  -->
                      <tr
                        class="hover:bg-gray-100 dark:hover:bg-gray-800"
                        v-for="(p, index) in data_table.data"
                        :key="index"
                      >
                        <!--  -->

                        <td
                          @click="buttonDetailPesan(p.id)"
                          class="p-4 text-sm text-gray-700 whitespace-nowrap dark:text-gray-400"
                          :class="
                            kotak_pesan === 'kotak_masuk' && p.is_read == '0'
                              ? 'font-bold'
                              : 'font-medium'
                          "
                        >
                          {{ p.nama }}
                        </td>
                        <td
                          @click="buttonDetailPesan(p.id)"
                          class="p-4 text-sm text-gray-700 whitespace-nowrap dark:text-gray-400"
                          :class="
                            kotak_pesan === 'kotak_masuk' && p.is_read == '0'
                              ? 'font-bold'
                              : 'font-medium'
                          "
                        >
                          {{ p.subject }}
                        </td>
                        <td
                          @click="buttonDetailPesan(p.id)"
                          class="p-4 text-sm text-gray-700 whitespace-nowrap dark:text-gray-400"
                          :class="
                            kotak_pesan === 'kotak_masuk' && p.is_read == '0'
                              ? 'font-bold'
                              : 'font-medium'
                          "
                        >
                          {{ p.tanggal }}
                        </td>
                        <td>
                          <button
                            @click="buttonDeletePesan(p.id)"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-500 rounded-lg dark:text-red-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Delete"
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
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </CardComponent>

        <!-- pagination -->
        <div
          class="block justify-between items-center p-4 mx-4 mt-10 mb10 bg-white rounded-2xl dark:bg-gray-700 sm:flex lg:mt-5"
        >
          <div class="flex items-center divide-x divide-gray-100 dark:divide-gray-800">
            <a
              href="#"
              @click.prevent="onClickPreviousPage"
              :class="hitung.isInFirstPage ? 'disabled' : ''"
              :disabled="hitung.isInFirstPage"
              class="inline-flex justify-center p-1 text-gray-500 dark:text-gray-300 rounded cursor-pointer"
            >
              <svg
                class="w-7 h-7"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
            <a
              @click.prevent="onClickNextPage"
              :class="hitung.isInLastPage ? 'disabled' : ''"
              :disabled="hitung.isInLastPage"
              href="#"
              class="inline-flex justify-center p-1 text-gray-500 dark:text-gray-300 rounded cursor-pointer"
            >
              <svg
                class="w-7 h-7"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
            <span class="font-normal text-gray-500 dark:text-gray-300 sm:text-xs md:text-sm"
              >Show
              <span class="font-semibold text-gray-900 dark:text-gray-200"
                >{{ data_table.from }} - {{ data_table.to }}</span
              >
              of
              <span class="font-semibold text-gray-900 dark:text-gray-200">{{
                data_table.totalData
              }}</span></span
            >
          </div>
        </div>
      </div>
    </div>
  </ParentTransation>
</template>

<script setup>
import LoaderComponent from '@/components/LoaderComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import { computed, inject, onMounted, reactive, ref, watch } from 'vue'
import moment from 'moment'
import { debounce } from 'lodash'
import usePesan from '@/composables/User/Pesan'
import { useStore } from '@/stores'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import CardComponent from '@/components/CardComponent.vue'
import SearchComponent from '@/components/SearchComponent.vue'
const {
  kotak_keluar,
  getKotakKeluar,
  kotak_masuk,
  getKotakMasuk,
  detailPesan,
  readPesan,
  deletePesan
} = usePesan()
const kotak_pesan = ref('kotak_masuk')
const swal = inject('$swal')
const store = useStore()
const display = computed(() => store.getDisplay)
const loader = ref(false)
const filter = reactive({
  tanggal_awal: '',
  tanggal_akhir: '',
  judul: '',
  pengirim: '',
  status_baca: 0,
  date: []
})
const data_table = reactive({
  data: [],
  pages: 1,
  pageSize: 0,
  totalPages: 0,
  totalData: 0,
  to: 0,
  from: 0
})
onMounted(async () => {
  loader.value = true
  await Promise.all([getKotakMasuk(1, { ...filter })])
  loader.value = false
})
watch(kotak_masuk, (data) => {
  if (data) {
    data_table.data = data.data
    data_table.totalPages = data.last_page
    data_table.pageSize = data.per_page
    data_table.totalData = data.total
    data_table.to = data.to
    data_table.from = data.from
  }
})
watch(kotak_keluar, (data) => {
  if (data) {
    data_table.data = data.data
    data_table.totalPages = data.last_page
    data_table.pageSize = data.per_page
    data_table.totalData = data.total
    data_table.to = data.to
    data_table.from = data.from
  }
})
const hitung = reactive({
  isInFirstPage: computed(() => {
    return data_table.pages === 1
  }),
  isInLastPage: computed(() => {
    if (data_table.totalPages === 0) {
      return true
    }
    return data_table.pages === data_table.totalPages
  })
})
async function onClickPreviousPage() {
  loader.value = true
  if (hitung.isInFirstPage) {
    return false
  }
  data_table.pages = data_table.pages - 1
  if (kotak_pesan.value === 'kotak_masuk') {
    await getKotakMasuk(data_table.pages, { ...filter })
  } else {
    await getKotakKeluar(data_table.pages, { ...filter })
  }
  loader.value = false
}
async function onClickNextPage() {
  loader.value = true
  if (hitung.isInLastPage) {
    return false
  }
  data_table.pages = data_table.pages + 1
  if (kotak_pesan.value === 'kotak_masuk') {
    await getKotakMasuk(data_table.pages, { ...filter })
  } else {
    await getKotakKeluar(data_table.pages, { ...filter })
  }
  loader.value = false
}
const buttonKotakMasuk = async () => {
  loader.value = true
  kotak_pesan.value = 'kotak_masuk'
  await getKotakMasuk(1, { ...filter })
  loader.value = false
}
const buttonKotakKeluar = async () => {
  loader.value = true
  kotak_pesan.value = 'kotak_keluar'
  await getKotakKeluar(1, { ...filter })
  loader.value = false
}
const buttonStatusUnread = async () => {
  loader.value = true
  filter.status_baca = 0
  await getKotakMasuk(1, { ...filter })
  loader.value = false
}
const filter_judul = debounce(async () => {
  data_table.pages = 1
  if (kotak_pesan.value === 'kotak_masuk') {
    await getKotakMasuk(data_table.pages, { ...filter })
  } else {
    await getKotakKeluar(data_table.pages, { ...filter })
  }
}, 1000)

const clear_date = async () => {
  loader.value = true
  filter.tanggal_awal = ''
  filter.tanggal_akhir = ''
  if (kotak_pesan.value === 'kotak_masuk') {
    await getKotakMasuk()
  } else {
    await getKotakKeluar()
  }
  loader.value = false
}
const selectDate = async () => {
  // dp.value.selectDate();
  loader.value = true
  if (filter.date !== null) {
    filter.tanggal_awal = ''
    filter.tanggal_akhir = ''
    let tAawl = moment(filter.date[0]).format('yyyy-MM-DD')
    let tAkh = moment(filter.date[1]).format('yyyy-MM-DD')
    filter.tanggal_awal = tAawl
    filter.tanggal_akhir = tAkh
    if (kotak_pesan.value === 'kotak_masuk') {
      await getKotakMasuk(data_table.pages, { ...filter })
    } else {
      await getKotakKeluar(data_table.pages, { ...filter })
    }
  }
  loader.value = false
}

const buttonDeletePesan = async (id) => {
  const result = await swal({
    title: 'Apakah Anda Yakin?',
    text: 'Data Tidak Bisa dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  })
  if (result.isConfirmed) {
    loader.value = true
    let data_form = new FormData()
    data_form.append('id_pesan', id)
    if (kotak_pesan.value === 'kotak_keluar') {
      data_form.append('jenis_pesan', 'KOTAK_KELUAR')
    } else {
      data_form.append('jenis_pesan', 'KOTAK_MASUK')
    }
    const { error } = await deletePesan(data_form)
    if (!error) {
      if (kotak_pesan.value === 'kotak_masuk') {
        await getKotakMasuk(1, { ...filter })
      } else {
        await getKotakKeluar(1, { ...filter })
      }
    }
    loader.value = false
  }
}
const buttonDetailPesan = async (id) => {
  let data_form = new FormData()
  data_form.append('id_pesan', id)
  if (kotak_pesan.value === 'kotak_keluar') {
    data_form.append('jenis_pesan', 'KOTAK_KELUAR')
  } else {
    data_form.append('jenis_pesan', 'KOTAK_MASUK')
  }
  const { error } = await detailPesan(data_form)
  if (!error) {
    const { error } = await readPesan(data_form)
    if (!error) {
      console.log('AAAAAAAAAAAAAA')
    }
  }
}
</script>

<style lang="scss" scoped></style>
