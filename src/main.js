
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import Vue from 'vue'
import App from './App.vue'
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import Vuelidate from 'vuelidate'
import axios from 'axios'
import { authHeader } from '@/services'

import 'vue-search-select/dist/VueSearchSelect.css'

import VueSweetalert2 from 'vue-sweetalert2'

Vue.use(VueSweetalert2)

// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// Install BootstrapVue
Vue.use(BootstrapVue)
// Vue.component('font-awesome-icon', FontAwesomeIcon)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(Vuelidate)
Vue.use(axios)
Vue.config.productionTip = false

// axios.defaults.baseURL = process.env.VUE_APP_APIURL
axios.defaults.headers.common.Authorization = authHeader()
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'
// axios.defaults.headers.patch['Content-Type'] = 'application/x-www-form-urlencoded'

axios.interceptors.response.use(
  response => {
    if (response.status === 200 || response.status === 201) {
      return Promise.resolve(response)
    } else {
      return Promise.reject(response)
    }
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        case 400:
          // do something
          break
        case 401:
          if (router.currentRoute.name !== 'Login') {
            alert('session expired')
          }
          router.replace({
            path: '/login',
            query: {
              returnUrl: router.currentRoute.fullPath
            }
          })
          break
        case 403:
          router.replace({
            path: '/login',
            query: { returnUrl: router.currentRoute.fullPath }
          })
          break
        case 404:
          alert('page not exist')
          break
        case 502:
          setTimeout(() => {
            router.replace({
              path: '/login',
              query: {
                returnUrl: router.currentRoute.fullPath
              }
            })
          }, 1000)
      }
      return Promise.reject(error.response.data)
    }
    alert(error) // network error
    return Promise.reject(error)
  }
)

new Vue({
  created () {
    console.log('Component is created')
  },
  mounted () {
    console.log('Component is mounted')
  },
  router,
  render: h => h(App)
}).$mount('#app')
