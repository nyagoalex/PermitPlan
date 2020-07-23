<template>
    <div id="app">
      <navComponent v-if="true"/>
      <router-view></router-view>
    </div>
</template>

<script>
import navComponent from '@/components/nav.vue'

export default {
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
  background-color:#e2e8f0;
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
