import { createRouter, createWebHistory } from 'vue-router'

import guestRoutes from './guestRoute'
import adminRoutes from './adminRoute'
import userRoutes from './userRoute'
import { jwtDecode } from 'jwt-decode'
const router = createRouter({
  history: createWebHistory(),
  routes: [
    ...guestRoutes,
    {
      path: '/',
      redirect: '/home',
      meta: {
        requiresAuth: true
      },

      component: () => import('../views/_layouts/MainLayout.vue'),
      children: [...adminRoutes, ...userRoutes]
    },
    {
      path: '/:pathMatch(.*)*',
      component: () => import('../views/pages/404Page.vue')
    }
  ]
})
const getToken = () => localStorage.getItem('token')
const isAuthenticated = () => !!getToken()
const roleDashboard = (role) => {
  switch (role) {
    case 'admin':
      return { name: 'AdminHome' }
    case 'user':
      return { name: 'UserHome' }

    default:
      return { name: 'Login' }
  }
}

router.beforeEach((to, from, next) => {
  const token = getToken()
  if (to.meta.requiresAuth || to.meta.isAdmin || to.meta.isUser) {
    if (!isAuthenticated()) {
      next({
        path: '/login'
      })
      return
    } else {
      const decode_token = jwtDecode(token)
      const role_name = decode_token.role_name
      if (to.meta.isAdmin && role_name.includes('admin')) {
        next()
        return
      } else if (to.meta.isUser && role_name.includes('user')) {
        next()
        return
      } else {
        next(roleDashboard(role_name))
        return
      }
    }
  } else if (to.meta.isGuest && !isAuthenticated()) {
    next()
    return
  } else {
    next()
  }
})
export default router
