<script>
import DataStatsOne from '@/components/DataStats/DataStatsOne.vue'
import TableOne from '@/components/Tables/TableOne.vue'
import ChatCard from '@/components/ChatCard.vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'

export default {
  components: {
    DataStatsOne,
    TableOne,
    DefaultLayout,
    ChatCard
  },
  data() {
    return {}
  },
  watch: {},
  name: 'ProductsVue',
  mounted() {}
}
</script>

<template>
  <DefaultLayout>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
      <DataStatsOne />
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
      <div class="col-span-12 xl:col-span-8">
        <TableOne />
      </div>
      <ChatCard />
    </div>
  </DefaultLayout>
</template>
