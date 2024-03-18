import axiosClient from '@/axios'
import { ref } from 'vue'

export default function useReferensi() {
  const role_list_pagination = ref([])
  const role_list = ref([])
  const GetRoleListPagination = async (page, data) => {
    let url = '/role_list_pagination?page=' + page
    let response = await axiosClient.post(url, data)

    role_list_pagination.value = response.data
  }
  const GetRoleList = async () => {
    let response = await axiosClient.get('/role_list')
    role_list.value = response.data
  }
  return { role_list_pagination, GetRoleListPagination, role_list, GetRoleList }
}
