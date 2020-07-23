<template>
    <span @click="logout">Logout</span>
</template>

<script>
import router from '@/router'
import axios from 'axios'
const apiUrl = process.env.VUE_APP_APIURL
// axios.defaults.headers.common.Authorization = authHeader()
export default {
  name: 'Logout',
  // isLoggedIn: true,
  props: {
    msg: String
  },
  methods: {
    logout: function () {
      logout()
    }
  }
}

function logout () {
  console.log('logout')
  axios.post(apiUrl + '/auth/logout')
    .then(() => {
      Promise.resolve().then(function () {
        return localStorage.removeItem('user')
      })
        .then(function (value) {
          router.push('/login')
        })
    })
    .catch(function (error) {
      alert(error.response.data.message)
    })
}
</script>
