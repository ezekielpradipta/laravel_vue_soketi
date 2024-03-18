const userRoutes = [
  {
    path: '/home',
    name: 'UserHome',
    component: () => import('./../views/pages/users/UserHome.vue'),
    meta: {
      isUser: true
    }
  }
]
export default userRoutes
