<script>
import BreadcrumbDefault from '@/components/Breadcrumbs/BreadcrumbDefault.vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import router from '@/router'
import api from '@/stores/api'
export default {
  data() {
    return {
      name: '',
      categories: [],
      action: 'Create',
      id: '',
      show: false
    }
  },
  mounted() {
    this.fetchData()
  },
  onchange() {
    this.fetchData()
  },
  components: {
    BreadcrumbDefault,
    DefaultLayout
  },
  methods: {
    create() {
      api
        .post('/categories', {
          name: this.name
        })
        .then((response) => {
          this.fetchData()
          this.name = ''
          this.show = false
          console.log(response)
        })
        .catch((error) => {
          console.log(error)
        })
    },
    fetchData() {
      api.get('/categories').then((response) => {
        this.categories = response.data
      })
    },
    destroy(id) {
      api.delete(`/categories/${id}`).then(() => {
        this.fetchData()
      })
    },
    read(id) {
      this.action = 'Update'
      this.id = id
      router.push = '#form'
      api.get(`/categories/${id}`).then((response) => {
        this.name = response.data.name
      })
    },
    modify() {
      api
        .put(`/categories/${this.id}`, {
          name: this.name
        })
        .then(() => {
          this.fetchData()
          this.action = 'Create'
          this.id = ''
          this.name = ''
          this.show = false
        })
    }
  }
}
</script>

<template>
  <DefaultLayout>
    <BreadcrumbDefault pageTitle="Categories" />

    <div class="flex flex-col gap-10">
      <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
      >
        <div class="max-w-full overflow-x-auto">
          <table class="w-full table-auto">
            <thead>
              <tr class="bg-gray-2 text-left dark:bg-meta-4">
                <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                  ID
                </th>
                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">Name</th>
                <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                  Status
                </th>
                <th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in categories" :key="item.id">
                <td class="py-5 px-4 pl-9 xl:pl-11">
                  <h5 class="font-medium text-black dark:text-white">{{ item.id }}</h5>
                </td>
                <td class="py-5 px-4">
                  <p class="text-black dark:text-white">{{ item.name }}</p>
                </td>
                <td class="py-5 px-4">
                  <p
                    class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium"
                    :class="{
                      'bg-success text-success': item.deleted_at === null,
                      'bg-danger text-danger': item.deleted_at !== null
                    }"
                  >
                    {{ item.deleted_at === null ? 'Active' : 'Archived at ' + item.deleted_at }}
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
              v-model="name"
              placeholder="Enter your Category Name"
              class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
            />
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
  </DefaultLayout>
</template>
