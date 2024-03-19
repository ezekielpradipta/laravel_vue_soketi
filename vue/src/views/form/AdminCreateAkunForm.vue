<template>
  <LoaderComponent :loading="loader"></LoaderComponent>

  <ButtonComponnet @click="backButton" right icon="back" size="xs" text="Kembali"></ButtonComponnet>
  <FormStep :mode="mode_form" @submit="buttonSimpanForm">
    <FormStepChild title="Data User">
      <CardComponent>
        <AlertComponent title="Informasi">
          <div class="flex">
            <ButtonComponnet
              @click="buttonResetPassword"
              size="xs"
              text="Reset Password"
            ></ButtonComponnet>
          </div>
        </AlertComponent>
        <div class="grid gap-6 mb-4 md:grid-cols-2">
          <div class="col-span-1">
            <LabelComponent title="Role"></LabelComponent>
            <Multiselect
              v-model="model.role_id"
              placeholder="Role:  "
              class="mb-4"
              :searchable="true"
              :options="role_list"
              valueProp="id"
              label="role_name"
              track-by="role_name"
              :disabled="props.tipe_form === 'detail'"
            />
          </div>
          <div class="col-span-1">
            <TextComponent
              title="Username"
              v-model="model.username"
              placeholder="....."
              :disabled="props.tipe_form === 'detail'"
            ></TextComponent>
          </div>
        </div>
        <div v-if="props.tipe_form == 'create'" class="grid gap-6 mb-4 md:grid-cols-2">
          <div class="col-span-1">
            <TextComponent
              title="Password"
              v-model="model.password"
              type="password"
              placeholder="....."
            ></TextComponent>
          </div>
        </div>
      </CardComponent>
    </FormStepChild>
  </FormStep>
</template>

<script setup>
import ButtonComponnet from '@/components/ButtonComponnet.vue'
import FormStep from '@/components/FormStep.vue'
import FormStepChild from '@/components/FormStepChild.vue'

import { computed, inject, onMounted, reactive, ref } from 'vue'
import LoaderComponent from '@/components/LoaderComponent.vue'
import CardComponent from '@/components/CardComponent.vue'
import Multiselect from '@vueform/multiselect'
import '@/css/Multi.css'
import TextComponent from '@/components/TextComponent.vue'
import LabelComponent from '@/components/LabelComponent.vue'
import useReferensi from '@/composables/Referensi'
import useAdminUser from '@/composables/Admin/AdminUser'
import AlertComponent from '@/components/AlertComponent.vue'
const swal = inject('$swal')
const { role_list, GetRoleList, resetPassword } = useReferensi()
const { createUser, updateUser } = useAdminUser()
const emit = defineEmits(['back', 'edit', 'delete'])
const props = defineProps({
  tipe_form: {
    type: String,
    required: true
  },
  data_form: {
    type: Object,
    default: () => ({})
  }
})
const model = reactive({
  username: '',
  role_id: '',
  id: ''
})
onMounted(async () => {
  loader.value = true
  await GetRoleList()
  if (props.data_form) {
    Object.assign(model, props.data_form)
  }
  loader.value = false
})

const loader = ref(false)
const mode_form = computed(() => {
  if (props.tipe_form === 'edit' || props.tipe_form === 'akun' || props.tipe_form === 'create') {
    return 'edit'
  } else {
    return 'detail'
  }
})
const backButton = async () => {
  emit('back')
}
const buttonSimpanForm = async () => {
  const result = await swal({
    title: 'Apakah Anda Yakin?',
    text: props.tipe_form == 'create' ? 'Menambah User' : 'Mengubah User',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  })
  if (result.isConfirmed) {
    loader.value = true
    let data_form = new FormData()
    data_form.append('id', model.id)
    data_form.append('username', model.username)
    data_form.append('password', model.password)
    data_form.append('role_id', model.role_id)
    if (props.tipe_form == 'create') {
      const { error } = await createUser(data_form)
      if (!error) {
        emit('back')
      }
    } else {
      const { error } = await updateUser(data_form)
      if (!error) {
        emit('back')
      }
    }
    loader.value = false
  }
}
const buttonResetPassword = async () => {
  const result = await swal({
    title: 'Apakah Anda Yakin?',
    text: 'Merubah Password menjadi qwerty123',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  })
  if (result.isConfirmed) {
    loader.value = true
    let data_form = new FormData()
    data_form.append('id', model.id)
    const { error } = await resetPassword(data_form)
    if (!error) {
      emit('back')
    }

    loader.value = false
  }
}
</script>
