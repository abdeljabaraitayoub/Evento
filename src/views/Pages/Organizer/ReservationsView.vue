<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultLayout2.vue'

import router from '@/router'
import api from '@/stores/api'

export default {
  data() {
    return {
      Reservations: [],
      action: 'Create',
      show: false,
      event_id: this.$route.params.id,
      name: '',
      pageTitle: 'Reservations',
      statistic: {}
    }
  },
  mounted() {
    this.fetchData(), this.statistics()
  },
  components: {
    BreadcrumbDefault,
    DefaultLayout
  },
  methods: {
    fetchData() {
      api.get(`/events/${this.event_id}/reservations`).then((response) => {
        this.Reservations = response.data
      })
    },
    accept(id) {
      api.patch(`/reservations/${id}`).then(() => {
        this.fetchData(), this.statistics()
      })
    },
    statistics() {
      api.get(`/events/${this.event_id}/Statistiques`).then((response) => {
        this.statistic = response.data
      })
    }
  }
}
</script>

<template>
  <DefaultLayout>
    <BreadcrumbDefault :pageTitle="pageTitle" />

    <div class="flex flex-col gap-10">
      <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
      >
        <div class="max-w-full overflow-x-auto">
          <table class="w-full table-auto">
            <thead>
              <tr class="bg-gray-2 text-left dark:bg-meta-4">
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">User</th>
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                  Event
                </th>
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                  Reservation Date
                </th>
                <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                  Status
                </th>
                <th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in Reservations" :key="item.id">
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.name }}</p>
                </td>
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.title }}</p>
                </td>
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.created_at }}</p>
                </td>

                <td class="py-5 px-4">
                  <p
                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium"
                    :class="{
                      'bg-success text-success': item.confirmed === 1,
                      'bg-danger text-danger': item.confirmed !== 1
                    }"
                  >
                    {{ item.confirmed != 0 ? 'confirmed' : 'Not Confirmed' }}
                  </p>
                </td>
                <td class="py-5 px-4">
                  <div class="flex items-center justify-center space-x-3.5">
                    <button @click="accept(item.id)" class="hover:text-primary">
                      <i
                        class="bi"
                        :class="{
                          'bi-check-square': item.confirmed !== 1,
                          'bi-x-square': item.confirmed === 1
                        }"
                      ></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div
      class="mt-4.5 mb-5.5 grid max-w-94 grid-cols-3 rounded-md border border-stroke py-2.5 shadow-1 dark:border-strokedark dark:bg-[#37404F]"
    >
      <div class="flex gap-1 border-r border-stroke px-4 dark:border-strokedark xsm:flex-row">
        <span class="font-semibold text-black dark:text-white">{{ statistic.Total }}</span
        ><span class="text-sm">Total</span>
      </div>
      <div
        class="flex flex-col items-center justify-center gap-1 border-r border-stroke px-4 dark:border-strokedark xsm:flex-row"
      >
        <span class="font-semibold text-black dark:text-white">{{ statistic.confirmed }}</span
        ><span class="text-sm">Confirmed</span>
      </div>
      <div class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row">
        <span class="font-semibold text-black dark:text-white">{{ statistic.unconfirmed }}</span
        ><span class="text-sm">Unconfirmed</span>
      </div>
    </div>
  </DefaultLayout>
</template>
