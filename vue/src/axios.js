import axios from 'axios'
import { createToaster } from '@meforma/vue-toaster'
import useAuth from './composables/Auth'
const { logout } = useAuth()
const toaster = createToaster({
  position: 'top-right',
  duration: 2000
})

const axiosClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  withCredentials: true
  // headers: {
  //   'Content-Type': 'application/json'
  // }
})
let isLoggingOut = false
axiosClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})
axiosClient.interceptors.response.use(
  async function (response) {
    if (response.data && response.data.message) {
      toaster.success(response.data.message)
    }
    return response
  },
  async function (error) {
    console.log(error)
    if (error.response && error.response.status === 401) {
      if (!isLoggingOut) {
        isLoggingOut = true
        toaster.error('Tidak Diijinkan, Silahkan Login Ulang')
        await logout()
        isLoggingOut = false
      }
    }
    if (error.response && error.response.status === 400) {
      if (error.response.data.message && error.response.data.tipe === 'multi') {
        // eslint-disable-next-line no-unused-vars
        for (const [key, value] of Object.entries(error.response.data.message)) {
          toaster.error(`${value}`)
        }
      } else {
        toaster.error(error.response.data.message)
      }
    }

    return error
  }
)
export default axiosClient
