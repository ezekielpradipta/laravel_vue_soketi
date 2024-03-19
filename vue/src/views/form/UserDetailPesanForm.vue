<template>
  <LoaderComponent :loading="loader"></LoaderComponent>
  <ParentTransation appear :visibility="true">
    <div
      class="block justify-between items-center p-4 my-6 mx-4 bg-white rounded-2xl sm:flex dark:bg-gray-800"
    >
      <div class="flex items-center divide-x divide-gray-100">
        <ButtonComponnet size="sm" text="Kembali" @click="buttonBack"></ButtonComponnet>
        <div class="pr-3"></div>
        <ButtonComponnet
          color="red"
          size="sm"
          text="Delete"
          @click="buttonDelete"
        ></ButtonComponnet>
        <div class="pl-3 text-sm font-medium text-gray-500 dark:text-gray-300">
          {{ model.tanggal }}
        </div>
      </div>
    </div>

    <CardComponent>
      <div class="p-5">
        <div class="flex items-center mb-4">
          <div class="flex-shrink-0">
            <div>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-8 h-8"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                />
              </svg>
            </div>
          </div>
          <div class="ml-4">
            <div class="text-base font-semibold text-gray-900 dark:text-gray-200 truncate">
              {{ model.status }} :
              {{ model.nama }}
            </div>
          </div>
        </div>
        <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-gray-300">
          {{ model.judul }}
        </h1>

        <div class="space-y-2 text-base font-normal text-gray-600 dark:text-gray-400">
          <p class="blog" v-html="model.keterangan"></p>
          <!-- content -->
          <div v-if="model.keterangan_surat">
            <p class="blog" v-html="model.keterangan_surat"></p>
          </div>

          <div v-if="model.file_upload">
            <AlertComponent title="Informasi" class="mt-20">
              <div class="mt-4 mb-4 text-sm">
                <p>Pesan Berikut Memiliki Berkas Yang Dapat Diunduh.</p>
              </div>
              <div class="flex">
                <ButtonComponnet size="sm" class="mr-4" @click="buttonUnduhBerkas">
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
                      d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"
                    />
                  </svg>

                  <span>Unduh Berkas</span>
                </ButtonComponnet>
              </div>
            </AlertComponent>
          </div>
        </div>
      </div>
    </CardComponent>
  </ParentTransation>
</template>

<script setup>
import AlertComponent from '@/components/AlertComponent.vue'
import ButtonComponnet from '@/components/ButtonComponnet.vue'
import CardComponent from '@/components/CardComponent.vue'
import LoaderComponent from '@/components/LoaderComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import { inject, onMounted, reactive, ref } from 'vue'
import '@/css/Tiptap.css'
import usePesan from '@/composables/User/Pesan'
const { deletePesan, downloadPesan } = usePesan()
const model = reactive({
  tanggal: '',
  nama: '',
  judul: '',
  keterangan: '',
  status: '',
  file_upload: null,
  id: ''
})
const loader = ref(false)
const props = defineProps({
  data_form: {
    type: Object,
    default: () => ({})
  }
})
const emit = defineEmits(['back', 'delete'])

onMounted(async () => {
  loader.value = true

  if (props.data_form) {
    Object.assign(model, props.data_form)
  }
  loader.value = false
})
const swal = inject('$swal')
const buttonBack = async () => {
  emit('back')
}
const buttonDelete = async () => {
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
    data_form.append('id_pesan', model.id)
    if (model.status === 'PENERIMA') {
      data_form.append('jenis_pesan', 'KOTAK_KELUAR')
    } else {
      data_form.append('jenis_pesan', 'KOTAK_MASUK')
    }
    const { error } = await deletePesan(data_form)
    if (!error) {
      emit('back')
    }
    loader.value = false
  }
}
const buttonUnduhBerkas = async () => {
  const result = await swal({
    title: 'Apakah Anda Yakin?',
    text: 'Mengunduh Berkas Pesan ' + model.judul,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  })
  if (result.isConfirmed) {
    loader.value = true
    const data = model.judul
      .toLowerCase()
      .replace(/\s+/g, '-')
      .replace(/[^\w-]+/g, '')
      .replace(/--+/g, '-')
    let data_form = new FormData()
    data_form.append('judul', data)

    data_form.append('file_upload', model.file_upload)
    await downloadPesan(data_form)
    loader.value = false
  }
}
</script>

<style lang="scss" scoped></style>
