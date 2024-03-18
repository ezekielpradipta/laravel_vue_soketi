import axiosClient from '@/axios'
import router from '@/router'
import { jwtDecode } from 'jwt-decode'

export default function useAuth() {
  const login = async (data) => {
    const response = await axiosClient.post('/login', data)

    if (!response.response) {
      localStorage.setItem('token', response.data.token)
      let token = jwtDecode(response.data.token)
      let user_role = token.role_name

      return new Promise((resolve, reject) => {
        if (user_role === 'admin') {
          router.push({ name: 'AdminHome' }).then(resolve).catch(reject)
        } else if (user_role === 'user') {
          router.push({ name: 'UserHome' }).then(resolve).catch(reject)
        } else {
          reject(new Error('Invalid user role'))
        }
      })
    }
  }

  const logout = async () => {
    await axiosClient.post('/logout')
    localStorage.removeItem('token')

    return new Promise((resolve, reject) => {
      router.push({ name: 'Login' }).then(resolve).catch(reject)
      setTimeout(() => {
        location.reload()
      }, 1000)
    })
  }

  return { login, logout }
}
