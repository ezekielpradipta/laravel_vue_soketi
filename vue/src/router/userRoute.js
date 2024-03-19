const userRoutes = [
  {
    path: '/home',
    name: 'UserHome',
    component: () => import('./../views/pages/users/UserHome.vue'),
    meta: {
      isUser: true,
      title: 'Home'
    }
  },
  {
    path: '/user_akun',
    name: 'UserAkun',
    component: () => import('./../views/pages/users/UserAkun.vue'),
    meta: {
      isUser: true,
      title: 'Pengaturan Akun'
    }
  },
  {
    path: '/list_pesan',
    name: 'UserPesan',
    component: () => import('./../views/pages/users/UserPesan.vue'),
    meta: {
      isUser: true,
      title: 'List Pesan'
    }
  },
  {
    path: '/tulis_pesan',
    name: 'UserTulisPesan',
    component: () => import('./../views/pages/users/UserTulisPesan.vue'),
    meta: {
      isUser: true,
      title: 'Tulis Pesan'
    }
  }
]
export default userRoutes
