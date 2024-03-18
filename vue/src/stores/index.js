import { defineStore } from 'pinia'

export const useStore = defineStore({
  id: 'store',
  state: () => ({
    display: 'light'
  }),
  actions: {
    setDisplay(display) {
      if (display === 'dark') {
        document.body.classList.add('dark')
      } else {
        document.body.classList.remove('dark')
      }
      this.display = display
    }
  },
  getters: {
    getDisplay() {
      return this.display
    }
  }
})
