const adminRoutes = [
  {
    path: '/home',
    name: 'AdminHome',
    component: () => import('./../views/pages/admin/AdminHome.vue'),
    meta: {
      isAdmin: true,
      title: 'Home'
    }
  },
  {
    path: '/create_akun',
    name: 'AdminCreateAkun',
    component: () => import('./../views/pages/admin/AdminCreateAkun.vue'),
    meta: {
      isAdmin: true,
      title: 'User List'
    }
  },
  {
    path: '/referensi/role',
    name: 'AdminReferensiRole',
    component: () => import('./../views/pages/admin/AdminReferensiRole.vue'),
    meta: {
      isAdmin: true,
      title: 'Referensi Role'
    }
  },
  {
    path: '/admin_akun',
    name: 'AdminAkun',
    component: () => import('./../views/pages/admin/AdminAkun.vue'),
    meta: {
      isAdmin: true,
      title: 'Pengaturan Akun'
    }
  }
]

export default adminRoutes
