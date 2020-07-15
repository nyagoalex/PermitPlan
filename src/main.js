
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import Vue from 'vue'
import App from './App.vue'
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import Vuelidate from 'vuelidate'
import axios from 'axios'
import { authHeader } from '@/services'

// import '@fortawesome/fontawesome-free/css/all.css'
// import '@fortawesome/fontawesome-free/js/all.js'
// Install BootstrapVue
Vue.use(BootstrapVue)

// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(Vuelidate)
Vue.use(axios)
Vue.config.productionTip = false

// axios.defaults.baseURL = process.env.VUE_APP_APIURL
axios.defaults.headers.common.Authorization = authHeader()
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

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
