<template>
      <b-container fluid="md">
      <b-row>
        <b-col><label class="float-left"> <strong> USERS </strong></label></b-col>
        <b-col class='text-center mb-2' ><b-button pill variant="outline-success" v-b-modal.new-user><b-icon icon="person-plus-fill"></b-icon> add user</b-button></b-col>
        <b-col><b-button :pressed.sync="show_filters" class='float-right' variant="link"><b-icon icon="funnel"></b-icon> show filters</b-button></b-col>
      </b-row>
      <hr class="my-0">
        <b-row v-show="show_filters" class="pt-3"  style="height: 50px; background-color:#F5F9F7;">
          <b-col class="text-left">
            <b>Status: </b>
            <b-badge pill :variant="`${(filters.active === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === null, 'ml-2': true }" @click="filters.active = null">All</b-badge>
            <b-badge pill :variant="`${(filters.active === true) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === true, 'ml-2': true }" @click="filters.active = true">Active</b-badge>
            <b-badge pill :variant="`${(filters.active === false) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === false, 'ml-2': true }" @click="filters.active = false">Inactive</b-badge>
          </b-col>
          <b-col class="text-right">
            <b>Blocked: </b>
            <b-badge pill :variant="`${(filters.blocked === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.blocked === null, 'ml-2': true }" @click="filters.blocked = null">All</b-badge>
            <b-badge pill :variant="`${(filters.blocked === true) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.blocked === true, 'ml-2': true }" @click="filters.blocked = true">blocked</b-badge>
            <b-badge pill :variant="`${(filters.blocked === false) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.blocked === false, 'ml-2': true }" @click="filters.blocked = false">Not blocked</b-badge>

          </b-col>
        </b-row>
        <div class="row pl-3" >
          <b-col v-for="(userItem, index) in users" :key="index" md='3' v-b-modal.user-details @click="user=userItem" class="m-4 user_card" style="background-color:#F5F9F7;">
            <b-row class="mb-2">
                <b-col md='4' class="usericon"> <b-icon icon="person-circle"></b-icon></b-col>
                <b-col class="pt-3 px-0">
                <label class="user-name">{{userItem.full_name}}</label><br>
                <small> {{userItem.role}}</small><br>
                <b-badge pill variant="success" v-if="userItem.active">Active</b-badge>
                <b-badge pill variant="danger" v-else>Inactive</b-badge>
                </b-col>
            </b-row>
          </b-col>
        </div>
        <b-pagination align="center"
        v-model="current_page"
        :total-rows="total"
        :per-page="per_page"
        last-number
        @input="getUsers(current_page)"
      ></b-pagination>
      <UserDetails :user="user"/>
      <AddUser/>
      </b-container>
</template>

<script>
import UserDetails from '@/components/Modals/UserDetails.vue'
import AddUser from '@/components/Modals/AddUser.vue'
import EventBus from '@/Events/EventBus.js'

export default {
  name: 'users',
  data () {
    return {
      users: {},
      current_page: process.env.VUE_APP_CURRENTPAGE,
      per_page: process.env.VUE_APP_PERPAGE,
      total: process.env.VUE_APP_TOTALROWS,
      filters: {
        active: null,
        blocked: null,
        search: null
      },
      show_filters: false,
      user: {}
    }
  },
  components: {
    UserDetails,
    AddUser
  },
  methods: {
    getUsers (page = 1) {
      const filters = this.filters
      filters.page = page
      this.$http.get('/users', { params: filters }).then(users => {
        this.users = users.data.data
        const meta = users.data.meta
        this.current_page = meta.current_page
        this.per_page = meta.per_page
        this.total = meta.total
      })
    },
    deleteSector (id) {
      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/sectors/' + id).then(() => {
            this.sectors = this.sectors.filter(item => item.id !== id)
            this.$swal.fire('Deleted!', 'Sector has been deleted.', 'success')
          })
        }
      })
    }
  },
  mounted () {
    this.getUsers()
    EventBus.$on('EVENT_SEARCH', (search) => {
      if (this.$route.name === 'Settings') {
        this.filters.search = search
      }
    })
  },
  watch: {
    'filters.active': function (val, oldVal) {
      this.getUsers()
    },
    'filters.search': function (val, oldVal) {
      this.getUsers()
    }
  }
}

</script>
