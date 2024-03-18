import { createApp } from 'vue'

import App from './App.vue'
import router from './router'
import './index.css'
import 'flowbite'
import { createPinia } from 'pinia'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
const app = createApp(App)
app.use(router)
app.use(VueSweetalert2)
app.use(createPinia())
app.mount('#app')
