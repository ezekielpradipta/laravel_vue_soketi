import axiosClient from '@/axios'
import { ref } from 'vue'

export default function usePesan() {
  const kotak_keluar = ref([])
  const kotak_masuk = ref([])
  const kirimPesan = async (data, config) => {
    const response = await axiosClient.post('/user/kirim_pesan', data, config)
    return { error: response.response }
  }
  const getKotakMasuk = async (page, data) => {
    let url = '/user/kotak_masuk?page=' + page

    let response = await axiosClient.post(url, data)
    kotak_masuk.value = response.data
  }
  const getKotakKeluar = async (page, data) => {
    let url = '/user/kotak_keluar?page=' + page

    let response = await axiosClient.post(url, data)
    kotak_keluar.value = response.data
  }

  const readPesan = async (data) => {
    const response = await axiosClient.post('/user/read_pesan', data)
    return { error: response.response }
  }
  const deletePesan = async (data) => {
    const response = await axiosClient.post('/user/delete_pesan', data)
    return { error: response.response }
  }
  const detailPesan = async (data) => {
    const response = await axiosClient.post('/user/detail_pesan', data)
    return { error: response.response }
  }
  return {
    kirimPesan,
    kotak_keluar,
    getKotakKeluar,
    kotak_masuk,
    getKotakMasuk,
    detailPesan,
    readPesan,
    deletePesan
  }
}
