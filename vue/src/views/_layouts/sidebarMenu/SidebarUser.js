const sidebarUsers = [
  {
    name: 'Dashboard',
    to: { name: 'UserHome' },
    showSubMenu: false,
    path: 'M11.3 3.3a1 1 0 0 1 1.4 0l6 6 2 2a1 1 0 0 1-1.4 1.4l-.3-.3V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3c0 .6-.4 1-1 1H7a2 2 0 0 1-2-2v-6.6l-.3.3a1 1 0 0 1-1.4-1.4l2-2 6-6Z'
  },
  {
    name: 'Tulis Pesan',
    to: { name: 'UserTulisPesan' },
    showSubMenu: false,
    path: 'M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z'
  },

  {
    name: 'List Pesan',
    to: { name: 'UserPesan' },
    showSubMenu: false,
    path: 'M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9'
  }
]

export default sidebarUsers
