<template>
    <div id="app">
      <navComponent v-if="!nav_allowed_routes.includes(this.$route.name)"/>
      <router-view></router-view>
    </div>
</template>

<script>
import navComponent from '@/components/nav.vue'

export default {
  data () {
    return {
      nav_allowed_routes: ['Login', 'Register', 'NotFound', null]
    }
  },
  name: 'app',
  components: {
    navComponent
  }
}
</script>
<style src="./assets/css/tailwind.css"></style>
<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  // background-color:#e2e8f0;
}
.acc-tb table tbody tr[tabindex="0"]:hover {
  color: blue !important;
  cursor: pointer;
}

.b-table-details {
  background-color: #d4ebf2 !important;
}
.small-time {
  font-style: italic;
  font-weight: bold;
  font-size: .7em;
}

// #nav {
//   padding: 30px;

//   &.a {
//     font-weight: bold;
//     color: #2c3e50;

//     &.router-link-exact-active {
//       color: #42b983;
//     }
//   }
// }
</style>
