<template>
  <div id="logout">
    <div id="nav">
      <span v-if="{isLoggedIn}"> | <b-button @click="logout">Logout</b-button></span>
    </div>
    <router-view/>
  </div>
</template>

<script>
import router from '@/router'
import axios from 'axios'
const apiUrl = process.env.VUE_APP_APIURL
// axios.defaults.headers.common.Authorization = authHeader()
export default {
  name: 'Logout',
  isLoggedIn: true,
  props: {
    msg: String
  },
  computed: {
    isLoggedIn: true
  },
  methods: {
    logout: function () {
      logout()
    }
  }
}

function logout () {
  axios.post(apiUrl + '/api/auth/logout')
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
