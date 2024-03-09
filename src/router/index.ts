import { createRouter, createWebHistory } from 'vue-router'

import SigninView from '@/views/Authentication/SigninView.vue'
import SignupView from '@/views/Authentication/SignupView.vue'
import ResetPasswordVIew from '@/views/Authentication/ResetPasswordVIew.vue'
import ResetPasswordVIew2 from '@/views/Authentication/ResetPasswordVIew2.vue'
import CalendarView from '@/views/CalendarView.vue'
import BasicChartView from '@/views/Charts/BasicChartView.vue'
import ECommerceView from '@/views/Dashboard/ECommerceView.vue'
import FormElementsView from '@/views/Forms/FormElementsView.vue'
import FormLayoutView from '@/views/Forms/FormLayoutView.vue'
import mainView from '@/views/Pages/mainView.vue'
import EventsUsersView from '@/views/Pages/EventsUsersView.vue'
import CategoriesView from '@/views/Pages/CategoriesView.vue'
import UsersView from '@/views/Pages/UsersView.vue'
import EventsView from '@/views/Pages/EventsView.vue'
import ReservationsView from '@/views/Pages/Organizer/ReservationsView.vue'
import ProfileView from '@/views/ProfileView.vue'
import TablesView from '@/views/TablesView.vue'
import AlertsView from '@/views/UiElements/AlertsView.vue'
import ButtonsView from '@/views/UiElements/ButtonsView.vue'
import  paymentView from '@/views/paymentView.vue'
// organizer 
import EventsByUserView from '@/views/Pages/Organizer/EventsView.vue'


const routes = [
  {
    path: '/dashboard',
    name: 'eCommerce',
    component: ECommerceView,
    meta: {
      title: 'eCommerce Dashboard'
    }
  },{
    path: '/payment/:id',
    name: 'paymentView',
    component: paymentView,
    meta: {
      title: 'paymentView Dashboard'
    }
  },
  {
    path: '/calendar',
    name: 'calendar',
    component: CalendarView,
    meta: {
      title: 'Calendar'
    }
  },{
    path: '/dashboard/events',
    name: 'Events',
    component: EventsView,
    meta: {
      title: 'Events'
    }
  },{
    path: '/dashboard/categories',
    name: 'category',
    component: CategoriesView,
    meta: {
      title: 'Categories'
    }
  },{
    path: '/dashboard/users',
    name: 'users',
    component: UsersView,
    meta: {
      title: 'Users'
    }
  },{
    path: '/Organizer/events',
    name: 'events',
    component: EventsByUserView,
    meta: {
      title: 'events'
    }
  },{
    path: '/Organizer/reservations/:id',
    name: 'Reservations',
    component: ReservationsView,
    meta: {
      title: 'Reservations'
    }
  },
  {
    path: '/events/:id',
    name: 'EventsUsersView',
    component: EventsUsersView,
    meta: {
      title: 'EventsUsersView'
    }
  },
  {
    path: '/forms/form-elements',
    name: 'formElements',
    component: FormElementsView,
    meta: {
      title: 'Form Elements'
    }
  },
  {
    path: '/forms/form-layout',
    name: 'formLayout',
    component: FormLayoutView,
    meta: {
      title: 'Form Layout'
    }
  },
  {
    path: '/tables',
    name: 'tables',
    component: TablesView,
    meta: {
      title: 'Tables'
    }
  },
  {
    path: '/',
    name: 'main',
    component: mainView,
    meta: {
      title: 'main'
    }
  },
  {
    path: '/charts/basic-chart',
    name: 'basicChart',
    component: BasicChartView,
    meta: {
      title: 'Basic Chart'
    }
  },
  {
    path: '/ui-elements/alerts',
    name: 'alerts',
    component: AlertsView,
    meta: {
      title: 'Alerts'
    }
  },
  {
    path: '/ui-elements/buttons',
    name: 'buttons',
    component: ButtonsView,
    meta: {
      title: 'Buttons'
    }
  },
  {
    path: '/auth/signin',
    name: 'signin',
    component: SigninView,
    meta: {
      title: 'Signin'
    }
  },{
    path: '/auth/resetpassword',
    name: 'ResetPasswordVIew',
    component: ResetPasswordVIew,
    meta: {
      title: 'ResetPasswordVIew'
    }
  },{
    path: '/auth/resetpassword/:token',
    name: 'ResetPassword',
    component: ResetPasswordVIew2,
    meta: {
      title: 'ResetPasswordVIew'
    }
  },
  {
    path: '/auth/signup',
    name: 'signup',
    component: SignupView,
    meta: {
      title: 'Signup'
    }
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 }
  }
})

router.beforeEach((to, from, next) => {
  document.title = `Vue.js ${to.meta.title} | TailAdmin - Vue.js Tailwind CSS Dashboard Template`
  next()
})

export default router
