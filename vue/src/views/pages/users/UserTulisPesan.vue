<template>
  <LoaderComponent :loading="loader"></LoaderComponent>

  <ParentTransation appear :visibility="true">
    <form @submit.prevent="buttonSubmitPesan" enctype="multipart/form-data">
      <AlertComponent title="Informasi">
        <div class="mt-4 mb-4 text-sm">
          <p>Ukuran File Yang Dikirim Maksimal 2 MB</p>
        </div>
      </AlertComponent>
      <div class="grid xl:grid-cols-2 xl:gap-6 mb-4">
        <CardComponent>
          <div class="col-span-1 mb-4">
            <TextComponent
              type="text"
              title="Subject"
              v-model="model.subject"
              placeholder="........"
            >
            </TextComponent>
          </div>
          <div class="col-span-1 mb-4">
            <LabelComponent title="Body"></LabelComponent>
            <EditorComponent v-model="model.body"></EditorComponent>
          </div>
          <div class="col-span-1 mb-4">
            <LabelComponent title="File Upload"></LabelComponent>
            <FilePond
              name="test"
              ref="pond"
              label-idle="Drop files here..."
              v-bind:allow-multiple="false"
              :accepted-file-types="acceptedFileTypes"
              v-on:change="onUploadFile"
              v-on:removefile="removeFileUpload"
              maxFileSize="2MB"
            ></FilePond>
          </div>
        </CardComponent>

        <CardComponent class="mb-6 xl:h-52">
          <div class="col-span-1">
            <div class="grid xl:grid-cols-4 xl:gap-6 mb-4">
              <div class="col-span-1 xl:mt-2">
                <p class="text-base text-gray-900 dark:text-white">Penerima</p>
              </div>
              <div class="xl:col-span-3 sm:col-span-1">
                <Multiselect
                  v-model="model.receiver"
                  mode="tags"
                  placeholder="Choose your stack"
                  :close-on-select="false"
                  :filter-results="false"
                  :min-chars="0"
                  :resolve-on-load="false"
                  :infinite="true"
                  :limit="10"
                  :clear-on-search="true"
                  :delay="0"
                  :searchable="true"
                  :options="
                    async (query) => {
                      return await dataUser(query)
                    }
                  "
                  @open="
                    (select$) => {
                      if (select$.noOptions) {
                        select$.resolveOptions()
                      }
                    }
                  "
                ></Multiselect>
              </div>
            </div>
            <ButtonComponnet type="submit" right size="xs" text="Kirim"></ButtonComponnet>
          </div>
        </CardComponent>
      </div>
    </form>
  </ParentTransation>
</template>

<script setup>
import AlertComponent from '@/components/AlertComponent.vue'
import CardComponent from '@/components/CardComponent.vue'
import LabelComponent from '@/components/LabelComponent.vue'
import LoaderComponent from '@/components/LoaderComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import TextComponent from '@/components/TextComponent.vue'
import EditorComponent from '@/components/TiptapEditor/EditorComponent.vue'
import { inject, reactive, ref } from 'vue'
import vueFilePond from 'vue-filepond'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import '@/css/Tiptap.css'
import '@/css/FilePond.css'
import '@/css/Multi.css'

import ButtonComponnet from '@/components/ButtonComponnet.vue'
import Multiselect from '@vueform/multiselect'
import useReferensi from '@/composables/Referensi'
import usePesan from '@/composables/User/Pesan'
const { getPenerimaPesan } = useReferensi()
const { kirimPesan } = usePesan()
const loader = ref(false)
const swal = inject('$swal')
const user_id = inject('user_id')
const model = reactive({
  subject: '',
  body: '',
  receiver: [],
  file_upload: null
})
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize
)
const acceptedFileTypes = [
  'image/jpeg',
  'application/pdf',
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  'text/plain',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]
const config_file = {
  headers: {
    'Content-Type': 'multipart/form-data'
  }
}
const dataUser = async (query) => {
  const filter = reactive({
    filter_nama: query,
    user_id: user_id
  })
  const res = await getPenerimaPesan({ ...filter })
  // eslint-disable-next-line no-unused-vars
  await new Promise((resolve, reject) => {
    setTimeout(() => {
      resolve()
    }, 1000)
  })
  return res.map((item) => {
    return { value: item.id, label: item.username }
  })
}
const onUploadFile = async (ev) => {
  model.file_upload = ev.target.files[0]
}
const removeFileUpload = async () => {
  model.file_upload = null
}
const buttonSubmitPesan = async () => {
  const result = await swal({
    title: 'Apakah Anda Yakin?',
    text: 'Pastikan Data Sudah Benar ',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  })
  if (result.isConfirmed) {
    loader.value = true
    let data_form = new FormData()
    data_form.append('file_upload', model.file_upload)
    data_form.append('receiver', model.receiver)
    data_form.append('subject', model.subject)
    data_form.append('body', model.body)
    data_form.append('user_id', user_id)

    const { error } = await kirimPesan(data_form, config_file)
    if (!error) {
      console.log('AAAAAAAA')
    }
    loader.value = false
  }
}
</script>

<style lang="scss" scoped></style>
