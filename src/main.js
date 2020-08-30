
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

import myMixin from '@/mixins/mixin.js'

Vue.use(VueSweetalert2)

// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// Install BootstrapVue
Vue.use(BootstrapVue)
// Vue.component('font-awesome-icon', FontAwesomeIcon)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(Vuelidate)

Vue.config.productionTip = false

const subdir = () => {
    var host = window.location.hostname
    host = host.replace('www.', '') // remove www
    var domain = process.env.VUE_APP_DOMAIN
    var subdir = host.split('.')[0]
    subdir = (subdir === domain) ? '' : subdir + '.'
    return 'http://' + subdir
}

// axios.defaults.baseURL = process.env.VUE_APP_APIURL
// this.$http.defaults.headers.common.Authorization = authHeader()
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'
// axios.defaults.headers.patch['Content-Type'] = 'application/x-www-form-urlencoded'
axios.defaults.headers.common.Authorization = authHeader()
const baseAxios = axios.create({
    baseURL: subdir() + process.env.VUE_APP_APIURL
})

baseAxios.interceptors.response.use(
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
        Vue.swal.fire({ // network error
            icon: 'error',
            title: 'Oops...',
            text: 'network error!',
            footer: '<a href>Why do I have this issue?</a>'
        })
        return Promise.reject(error)
    }
)
Vue.prototype.$http = baseAxios

Vue.mixin({
    mixins: [myMixin]
})
new Vue({
    created() {
        console.log('Component is created')
        // var host = window.location.hostname
        // host = host.replace('www.', '') // remove www
        // var domain = 'localhost'
        // var subdir = host.split('.')[0]
        // subdir = (subdir === domain) ? null : subdir
        // alert(subdir)
    },
    mounted() {
        console.log('Component is mounted')
    },
    router,
    render: h => h(App)
}).$mount('#app')