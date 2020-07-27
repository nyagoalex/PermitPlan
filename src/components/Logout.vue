<template>
    <span @click="logout">Logout</span>
</template>

<script>
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
    .finally(() => {
      localStorage.removeItem('user')
      delete axios.defaults.headers.common.Authorization
      this.$router.push({ name: 'Login' })
    })
}
</script>
