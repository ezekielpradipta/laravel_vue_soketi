const guestRoutes = [
  {
    path: "/login",
    name: "Login",
    component: () => import("./../views/pages/Login.vue"),
    meta: {
      isGuest: true,
    },
  },
];
export default guestRoutes;
