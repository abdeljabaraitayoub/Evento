<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout2 from '@/layouts/DefaultLayout2.vue'

import router from '@/router'
import api from '@/stores/api'
export default {
  data() {
    return {
      events: [],
      action: 'Create',
      id: '',
      show: false,
      categories: [],

      title: '',
      category: '',
      date: '',
      capacity: '',
      description: '',
      adresse: '',
      region: '',
      auto_approve: false
    }
  },
  mounted() {
    this.fetchData(), this.fetchCategories()
  },
  onchange() {
    this.fetchData()
  },
  components: {
    BreadcrumbDefault,
    DefaultLayout2
  },
  methods: {
    create() {
      api
        .post('/events', {
          title: this.title,
          category_id: this.category,
          description: this.description,
          location: this.adresse,
          region_id: this.region,
          start_date: this.date,
          capacity: this.capacity,
          auto_approve: this.auto_approve
        })
        .then((response) => {
          this.fetchData()
          this.show = false
          this.name = ''
          this.description = ''
          this.adresse = ''
          this.region = ''
          this.date = ''
          this.category = ''
          this.capacity = ''
          this.auto_approve = false
        })
        .catch((error) => {
          console.log(error)
        })
    },
    fetchData() {
      api.get('/event').then((response) => {
        this.events = response.data
      })
    },
    fetchCategories() {
      api.get('/categories').then((response) => {
        this.categories = response.data
      })
    },
    destroy(id) {
      api.delete(`/events/${id}`).then(() => {
        this.fetchData()
      })
    },
    read(id) {
      this.action = 'Update'
      this.id = id
      router.push = '/#form'
      api.get(`/events/${id}`).then((response) => {
        this.title = response.data.title
        this.category = response.data.category_id
        this.date = response.data.start_date
        this.capacity = response.data.capacity
        this.description = response.data.description
        this.adresse = response.data.location
        this.region = response.data.region_id
        if (response.data.auto_approve === 1) {
          this.auto_approve = true
        }
      })
    },
    modify() {
      api
        .put(`/events/${this.id}`, {
          title: this.title,
          category_id: this.category,
          description: this.description,
          location: this.adresse,
          region_id: this.region,
          start_date: this.date,
          capacity: this.capacity,
          auto_approve: this.auto_approve
        })
        .then(() => {
          this.fetchData()
          this.action = 'Create'
          this.id = ''

          this.show = false
          this.name = ''
          this.description = ''
          this.adresse = ''
          this.region = ''
          this.date = ''
          this.category = ''
          this.capacity = ''
          this.auto_approve = false
        })
    }
  }
}
</script>

<template>
  <DefaultLayout2>
    <BreadcrumbDefault pageTitle="Events" />

    <div class="flex flex-col gap-10">
      <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
      >
        <div class="max-w-full overflow-x-auto">
          <table class="w-full table-auto">
            <thead>
              <tr class="bg-gray-2 text-left dark:bg-meta-4">
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                  Title
                </th>
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                  Description
                </th>
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                  Category
                </th>
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                  Capacity
                </th>
                <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                  Status
                </th>
                <th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in events" :key="item.id">
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.title }}</p>
                </td>
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.description }}</p>
                </td>
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.name }}</p>
                </td>
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.capacity }}</p>
                </td>
                <td class="py-5 px-4">
                  <p
                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium"
                    :class="{
                      'bg-success text-success': item.is_valid === 1,
                      'bg-danger text-danger': item.is_valid !== 1
                    }"
                  >
                    {{ item.is_valid != 0 ? 'Approved' : 'Not approved' }}
                  </p>
                </td>
                <td class="py-5 px-4">
                  <div class="flex items-center space-x-3.5">
                    <button @click="destroy(item.id)" class="hover:text-primary">
                      <svg
                        class="fill-current"
                        width="18"
                        height="18"
                        viewBox="0 0 18 18"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"
                          fill=""
                        />
                        <path
                          d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"
                          fill=""
                        />
                        <path
                          d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"
                          fill=""
                        />
                        <path
                          d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"
                          fill=""
                        />
                      </svg>
                    </button>
                    <button @click="read(item.id), (show = true)" class="hover:text-primary">
                      <svg
                        class="feather feather-edit"
                        fill="none"
                        width="18"
                        height="18"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                      </svg>
                    </button>
                    <router-link :to="'reservations/' + item.id" class="nav-link">
                      <button class="hover:text-primary">
                        <i class="bi bi-graph-up-arrow"></i>
                      </button>
                    </router-link>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Button
        @click="(show = true), (name = ''), (action = 'Create'), (id = '')"
        class="flex items-center justify-center rounded-md bg-primary p-2 font-medium text-white hover:bg-opacity-90 w-20"
        >create</Button
      >
    </div>
    <div
      id="form"
      v-show="show"
      class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mt-10"
    >
      <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
        <h3 class="font-medium text-black dark:text-white">{{ action }}</h3>
      </div>
      <form action="#">
        <div class="p-6.5">
          <div class="mb-4.5">
            <label class="mb-2.5 block text-black dark:text-white"
              >Name
              <!--v-if--></label
            ><input
              type="name"
              v-model="title"
              placeholder="Enter your Event Name"
              class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
            />
          </div>
          <div class="mb-4.5">
            <label class="mb-2.5 block text-black dark:text-white"
              >Description
              <!--v-if--></label
            ><textarea
              v-model="description"
              rows="6"
              placeholder="Enter your Event Description"
              class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
            ></textarea>
          </div>
          <div class="mb-4.5">
            <label class="mb-2.5 block text-black dark:text-white"
              >Adresse
              <!--v-if--></label
            ><input
              type="name"
              v-model="adresse"
              placeholder="Enter your Event Adresse"
              class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
            />
          </div>
          <div class="mb-4.5">
            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
              Region
            </label>
            <div class="relative z-20 bg-white dark:bg-form-input">
              <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2"
                ><svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g opacity="0.8">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M10.0007 2.50065C5.85852 2.50065 2.50065 5.85852 2.50065 10.0007C2.50065 14.1428 5.85852 17.5007 10.0007 17.5007C14.1428 17.5007 17.5007 14.1428 17.5007 10.0007C17.5007 5.85852 14.1428 2.50065 10.0007 2.50065ZM0.833984 10.0007C0.833984 4.93804 4.93804 0.833984 10.0007 0.833984C15.0633 0.833984 19.1673 4.93804 19.1673 10.0007C19.1673 15.0633 15.0633 19.1673 10.0007 19.1673C4.93804 19.1673 0.833984 15.0633 0.833984 10.0007Z"
                      fill="#637381"
                    ></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.833984 9.99935C0.833984 9.53911 1.20708 9.16602 1.66732 9.16602H18.334C18.7942 9.16602 19.1673 9.53911 19.1673 9.99935C19.1673 10.4596 18.7942 10.8327 18.334 10.8327H1.66732C1.20708 10.8327 0.833984 10.4596 0.833984 9.99935Z"
                      fill="#637381"
                    ></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.50084 10.0008C7.55796 12.5632 8.4392 15.0301 10.0006 17.0418C11.5621 15.0301 12.4433 12.5632 12.5005 10.0008C12.4433 7.43845 11.5621 4.97153 10.0007 2.95982C8.4392 4.97153 7.55796 7.43845 7.50084 10.0008ZM10.0007 1.66749L9.38536 1.10547C7.16473 3.53658 5.90275 6.69153 5.83417 9.98346C5.83392 9.99503 5.83392 10.0066 5.83417 10.0182C5.90275 13.3101 7.16473 16.4651 9.38536 18.8962C9.54325 19.069 9.76655 19.1675 10.0007 19.1675C10.2348 19.1675 10.4581 19.069 10.6159 18.8962C12.8366 16.4651 14.0986 13.3101 14.1671 10.0182C14.1674 10.0066 14.1674 9.99503 14.1671 9.98346C14.0986 6.69153 12.8366 3.53658 10.6159 1.10547L10.0007 1.66749Z"
                      fill="#637381"
                    ></path>
                  </g></svg></span
              ><select
                v-model="region"
                class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
              >
                <option disabled="" value="">Select Region</option>
                <option class="text-body dark:text-bodydark" value="1">
                  Tanger-Tetouan-Al Hoceima
                </option>
                <option class="text-body dark:text-bodydark" value="2">Oriental</option>
                <option class="text-body dark:text-bodydark" value="3">Fès-Meknès</option>
                <option class="text-body dark:text-bodydark" value="4">Rabat-Salé-Kénitra</option>
                <option class="text-body dark:text-bodydark" value="5">Béni Mellal-Khénifra</option>
                <option class="text-body dark:text-bodydark" value="6">Casablanca-Settat</option>
                <option class="text-body dark:text-bodydark" value="7">Marrakech-Safi</option>
                <option class="text-body dark:text-bodydark" value="8">Drâa-Tafilalet</option>
                <option class="text-body dark:text-bodydark" value="9">Souss-Massa</option>
                <option class="text-body dark:text-bodydark" value="10">
                  Guelmim-Oued Noun
                </option></select
              ><span class="absolute top-1/2 right-4 z-10 -translate-y-1/2"
                ><svg
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g opacity="0.8">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                      fill="#637381"
                    ></path>
                  </g></svg
              ></span>
            </div>
          </div>
          <div class="mb-4.5">
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Date
              </label>
              <div class="relative z-20 bg-white dark:bg-form-input">
                <input
                  v-model="date"
                  type="date"
                  class="relative z-20 w-full rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
                  placeholder="mm/dd/yyyy"
                />
                <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g opacity="0.8">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                        fill="#637381"
                      ></path>
                    </g>
                  </svg>
                </span>
              </div>
            </div>
          </div>
          <div class="mb-4.5">
            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
              Category
            </label>
            <div class="relative z-20 bg-white dark:bg-form-input">
              <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2"
                ><svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g opacity="0.8">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M10.0007 2.50065C5.85852 2.50065 2.50065 5.85852 2.50065 10.0007C2.50065 14.1428 5.85852 17.5007 10.0007 17.5007C14.1428 17.5007 17.5007 14.1428 17.5007 10.0007C17.5007 5.85852 14.1428 2.50065 10.0007 2.50065ZM0.833984 10.0007C0.833984 4.93804 4.93804 0.833984 10.0007 0.833984C15.0633 0.833984 19.1673 4.93804 19.1673 10.0007C19.1673 15.0633 15.0633 19.1673 10.0007 19.1673C4.93804 19.1673 0.833984 15.0633 0.833984 10.0007Z"
                      fill="#637381"
                    ></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.833984 9.99935C0.833984 9.53911 1.20708 9.16602 1.66732 9.16602H18.334C18.7942 9.16602 19.1673 9.53911 19.1673 9.99935C19.1673 10.4596 18.7942 10.8327 18.334 10.8327H1.66732C1.20708 10.8327 0.833984 10.4596 0.833984 9.99935Z"
                      fill="#637381"
                    ></path>
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.50084 10.0008C7.55796 12.5632 8.4392 15.0301 10.0006 17.0418C11.5621 15.0301 12.4433 12.5632 12.5005 10.0008C12.4433 7.43845 11.5621 4.97153 10.0007 2.95982C8.4392 4.97153 7.55796 7.43845 7.50084 10.0008ZM10.0007 1.66749L9.38536 1.10547C7.16473 3.53658 5.90275 6.69153 5.83417 9.98346C5.83392 9.99503 5.83392 10.0066 5.83417 10.0182C5.90275 13.3101 7.16473 16.4651 9.38536 18.8962C9.54325 19.069 9.76655 19.1675 10.0007 19.1675C10.2348 19.1675 10.4581 19.069 10.6159 18.8962C12.8366 16.4651 14.0986 13.3101 14.1671 10.0182C14.1674 10.0066 14.1674 9.99503 14.1671 9.98346C14.0986 6.69153 12.8366 3.53658 10.6159 1.10547L10.0007 1.66749Z"
                      fill="#637381"
                    ></path>
                  </g></svg></span
              ><select
                v-model="category"
                class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
              >
                <option disabled="" value="">Select Category</option>
                <option
                  v-for="category in categories"
                  :key="category.id"
                  class="text-body dark:text-bodydark"
                  :value="category.id"
                >
                  {{ category.name }}
                </option></select
              ><span class="absolute top-1/2 right-4 z-10 -translate-y-1/2"
                ><svg
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g opacity="0.8">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                      fill="#637381"
                    ></path>
                  </g></svg
              ></span>
            </div>
          </div>
          <div class="mb-4.5">
            <label class="mb-2.5 block text-black dark:text-white">Capacity </label
            ><input
              type="name"
              v-model="capacity"
              placeholder="Enter your Event Capacity"
              class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
            />
          </div>
          <div class="mb-4.5">
            <label
              for="checkboxLabelOne"
              class="flex cursor-pointer select-none items-center mb-2.5 block text-black dark:text-white"
              ><div class="relative">
                <input
                  type="checkbox"
                  v-model="auto_approve"
                  id="checkboxLabelOne"
                  class="mr-4 flex h-5 w-5 items-center justify-center rounded border h-2.5 w-2.5 rounded-sm"
                />
              </div>
              auto_improve
            </label>
          </div>
          <button
            v-if="action === 'Update'"
            @click.prevent="modify"
            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
          >
            {{ action }}
          </button>
          <button
            v-if="action !== 'Update'"
            @click.prevent="create"
            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90"
          >
            {{ action }}
          </button>
        </div>
      </form>
    </div>
  </DefaultLayout2>
</template>
