<template>
  <LoaderComponent :loading="loader"></LoaderComponent>
  <ParentTransation appear :visibility="true">
    <div v-if="!show_form">
      <ButtonComponnet @click="buttonShowForm" right icon="plus" size="xs" text="Tambah User">
      </ButtonComponnet>

      <CardComponent title="List User Terdaftar">
        <TableComponent
          :headers="headers"
          @pageSize="handlePerPageChange"
          @search="handleSearch"
          :dataTable="data_table"
          @pagechanged="onPageChange"
          @edit="buttonEdit"
          @detail="buttonDetail"
          @delete="buttonDelete"
        >
        </TableComponent>
      </CardComponent>
    </div>
    <div v-if="show_form">
      <AdminCreateAkunForm
        :tipe_form="tipe_form"
        :data_form="data_awal"
        @back="buttonHideForm"
      ></AdminCreateAkunForm>
    </div>
  </ParentTransation>
</template>

<script setup>
import CardComponent from '@/components/CardComponent.vue'
import LoaderComponent from '@/components/LoaderComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import TableComponent from '@/components/TableComponent.vue'

import { computed, inject, onMounted, reactive, ref, watch } from 'vue'
import { debounce } from 'lodash'
import useAdminUser from '@/composables/Admin/AdminUser'
import AdminCreateAkunForm from '@/views/form/AdminCreateAkunForm.vue'
import ButtonComponnet from '@/components/ButtonComponnet.vue'
const loader = ref(false)
const show_form = ref(false)
const tipe_form = ref('')
const data_awal = ref({})
const swal = inject('$swal')
const { admin_user_list_pagination, GetAdminUserListPagination, deleteUser } = useAdminUser()
const data_table = reactive({
  data: [],
  page: 1,
  per_page: 0,
  total: 0,
  last_page: 0,
  from: 0,
  to: 0
})
const filter = reactive({
  filter_nama: '',
  paginate: 0
})
onMounted(async () => {
  loader.value = true
  filter.paginate = 25
  await GetAdminUserListPagination(1, { ...filter })
  loader.value = false
})
watch(admin_user_list_pagination, (data) => {
  if (data) {
    Object.assign(data_table, data)
  }
})

const headers = computed(() => {
  return [
    { key: 'role_name', label: 'Nama Role', view: 'title' },
    { key: 'username', label: 'User Name' },
    { button: ['Detail', 'Edit', 'Delete'] }
  ]
})

const onPageChange = async (page) => {
  loader.value = true
  data_table.page = page
  await GetAdminUserListPagination(data_table.page, { ...filter })
  loader.value = false
}
const handlePerPageChange = async (value) => {
  loader.value = true
  filter.paginate = value
  await GetAdminUserListPagination(1, { ...filter })
  loader.value = false
}

const handleSearch = debounce(async (value) => {
  filter.filter_nama = value
  loader.value = true
  await GetAdminUserListPagination(1, { ...filter })
  loader.value = false
}, 500)

const buttonShowForm = async () => {
  loader.value = true
  show_form.value = true
  tipe_form.value = 'create'
  loader.value = false
}
const buttonDetail = async (id) => {
  loader.value = true
  show_form.value = true
  tipe_form.value = 'detail'
  data_awal.value = id
  loader.value = false
}
const buttonEdit = async (id) => {
  loader.value = true
  show_form.value = true
  tipe_form.value = 'edit'
  data_awal.value = id
  loader.value = false
}
const buttonHideForm = async () => {
  loader.value = true
  show_form.value = false
  filter.paginate = 25
  data_awal.value = {}
  await GetAdminUserListPagination(1, { ...filter })

  loader.value = false
}
const buttonDelete = async (id) => {
  const result = await swal({
    title: 'Apakah Anda Yakin?',
    text: 'Menghapus User ' + '' + id.username,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  })
  if (result.isConfirmed) {
    loader.value = true
    let data_form = new FormData()
    data_form.append('id', id.id)

    const { error } = await deleteUser(data_form)
    if (!error) {
      await GetAdminUserListPagination(1, { ...filter })
    }
    loader.value = false
  }
}
</script>

<style lang="scss" scoped></style>
