<template>
  <ParentTransation appear :visibility="true">
    <LoaderComponentVue :loading="loader"></LoaderComponentVue>
    <CardComponent title="Dashboard Admin">
      <AlertComponent title="Informasi">
        <div class="mt-2 mb-2 text-sm">
          <p>Halaman Dashboard Admin</p>
        </div>
      </AlertComponent>
    </CardComponent>
  </ParentTransation>
</template>

<script setup>
import AlertComponent from '@/components/AlertComponent.vue'
import CardComponent from '@/components/CardComponent.vue'
import LoaderComponentVue from '@/components/LoaderComponent.vue'
import ParentTransation from '@/components/ParentTransation.vue'
import { ref } from 'vue'

const loader = ref(false)
</script>

<style lang="scss" scoped></style>
