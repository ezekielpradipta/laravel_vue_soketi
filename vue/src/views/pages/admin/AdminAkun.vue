<template>
  <ParentTransation appear :visibility="true">
    <AlertComponent title="Informasi">
      <div class="flex">
        <ButtonComponnet
          @click="buttonGantiPassword"
          size="xs"
          text="Ganti Password"
        ></ButtonComponnet>
      </div>
    </AlertComponent>
  </ParentTransation>

  <form @submit.prevent="buttonSimpanForm" enctype="multipart/form-data">
    <ModalComponent title="Modal Ganti Password" :show="show_modal" @exit="toggleModal">
      <div class="w-full">
        <div class="grid xl:grid-cols-2 xl:gap-6">
          <div class="col-span-2 mb-4">
            <TextComponent
              title="Password Lama"
              v-model="model.password_lama"
              type="password"
              placeholder="....."
            ></TextComponent>
          </div>
        </div>
        <div class="grid xl:grid-cols-2 xl:gap-6">
          <div class="col-span-2 mb-4">
            <TextComponent
              title="Password Baru"
              v-model="model.password_baru"
              type="password"
              placeholder="....."
            ></TextComponent>
          </div>
        </div>
      </div>
    </ModalComponent>
  </form>
</template>

<script setup>
import AlertComponent from '@/components/AlertComponent.vue'
import ButtonComponnet from '@/components/ButtonComponnet.vue'
import ModalComponent from '@/components/ModalComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import TextComponent from '@/components/TextComponent.vue'
import useReferensi from '@/composables/Referensi'
import { inject, reactive, ref } from 'vue'

const { gantiPassword } = useReferensi()
const show_modal = ref(false)
const model = reactive({
  password_lama: '',
  password_baru: ''
})
const user_id = inject('user_id')
const toggleModal = async () => {
  show_modal.value = !show_modal.value
}
const buttonGantiPassword = async () => {
  show_modal.value = true
}
const buttonSimpanForm = async () => {
  let data_form = new FormData()
  data_form.append('id', user_id)
  data_form.append('password_baru', model.password_baru)
  data_form.append('password_lama', model.password_lama)

  const { error } = await gantiPassword(data_form)
  if (!error) {
    show_modal.value = false
  }
}
</script>

<style lang="scss" scoped></style>
