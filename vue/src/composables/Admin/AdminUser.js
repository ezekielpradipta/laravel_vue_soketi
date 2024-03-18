import axiosClient from '@/axios'
import { ref } from 'vue'

export default function useAdminUser() {
  const admin_user_list_pagination = ref([])

  const GetAdminUserListPagination = async (page, data) => {
    let url = '/admin/user_list_pagination?page=' + page
    let response = await axiosClient.post(url, data)

    admin_user_list_pagination.value = response.data
  }
  const createUser = async (data) => {
    const response = await axiosClient.post('/admin/create_user', data)

    return { error: response.response }
  }
  const updateUser = async (data) => {
    const response = await axiosClient.post('/admin/update_user', data)

    return { error: response.response }
  }
  const deleteUser = async (data) => {
    const response = await axiosClient.post('/admin/delete_user', data)

    return { error: response.response }
  }
  return {
    admin_user_list_pagination,
    GetAdminUserListPagination,
    createUser,
    updateUser,
    deleteUser
  }
}
