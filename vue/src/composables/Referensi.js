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
  const getPenerimaPesan = async (data) => {
    let response = await axiosClient.post('/user_list', data)
    return response.data
  }
  const gantiPassword = async (data) => {
    const response = await axiosClient.post('/ganti_password', data)

    return { error: response.response }
  }
  const resetPassword = async (data) => {
    const response = await axiosClient.post('/reset_password', data)

    return { error: response.response }
  }
  return {
    role_list_pagination,
    GetRoleListPagination,
    role_list,
    GetRoleList,
    gantiPassword,
    resetPassword,

    getPenerimaPesan
  }
}
