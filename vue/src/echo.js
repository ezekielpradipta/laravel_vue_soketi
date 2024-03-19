import Echo from 'laravel-echo'

import Pusher from 'pusher-js'
const token = localStorage.getItem('token')
const options = {
  cluster: 'mt1',
  wsHost: '127.0.0.1',
  wsPort: 6001,
  forceTLS: false,
  enabledTransports: ['ws', 'wss'],
  disableStats: true,
  disabledTransports: ['sockjs', 'xhr_polling', 'xhr_streaming'],
  authEndpoint: 'http://127.0.0.1:8000/api/broadcasting/auth',
  auth: {
    headers: {
      Authorization: `Bearer ${token}`
    }
  }
}
const pusher = new Pusher('app-key', options)
const echo = new Echo({
  broadcaster: 'pusher',
  client: pusher
})

export default echo
