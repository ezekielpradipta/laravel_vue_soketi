<template>
  <LoaderComponent :loading="loader"></LoaderComponent>
  <ParentTransation appear :visibility="true">
    <CardComponent title="List Role Tersedia">
      <TableComponent
        :headers="headers"
        @pageSize="handlePerPageChange"
        @search="handleSearch"
        :dataTable="data_table"
        @pagechanged="onPageChange"
      >
      </TableComponent>
    </CardComponent>
  </ParentTransation>
</template>

<script setup>
import CardComponent from '@/components/CardComponent.vue'
import LoaderComponent from '@/components/LoaderComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import TableComponent from '@/components/TableComponent.vue'

import { computed, onMounted, reactive, ref, watch } from 'vue'
import { debounce } from 'lodash'
import useReferensi from '@/composables/Referensi'

const loader = ref(false)
const { role_list_pagination, GetRoleListPagination } = useReferensi()
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
  await GetRoleListPagination(1, { ...filter })
  loader.value = false
})
watch(role_list_pagination, (data) => {
  console.log(data)
  if (data) {
    Object.assign(data_table, data)
  }
})

const headers = computed(() => {
  return [{ key: 'role_name', label: 'Nama Role', view: 'title' }]
})

const onPageChange = async (page) => {
  loader.value = true
  data_table.page = page
  await GetRoleListPagination(data_table.page, { ...filter })
  loader.value = false
}
const handlePerPageChange = async (value) => {
  loader.value = true
  filter.paginate = value
  await GetRoleListPagination(1, { ...filter })
  loader.value = false
}

const handleSearch = debounce(async (value) => {
  filter.filter_nama = value
  loader.value = true
  await GetRoleListPagination(1, { ...filter })
  loader.value = false
}, 500)
</script>

<style lang="scss" scoped></style>
