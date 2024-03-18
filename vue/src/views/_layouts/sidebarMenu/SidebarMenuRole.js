import { jwtDecode } from 'jwt-decode'
import sidebarAdmins from './SidebarAdmin'

const token = localStorage.getItem('token')
const token_decode = jwtDecode(token)
const user_role = token_decode.role_name

export function sidebarMenu() {
  if (user_role === 'admin') {
    return sidebarAdmins
  } else {
    return []
  }
}
