<template>
      <b-container fluid="md">
      <label class="float-left"> <strong> USERS </strong></label>
      <b-button pill variant="outline-success" class="float-right" v-b-modal.new-user><b-icon icon="person-plus-fill"></b-icon> add user</b-button>
      <br><hr>
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

const faker = require('faker')
export default {
  name: 'users',
  data () {
    return {
      users: {},
      current_page: process.env.VUE_APP_CURRENTPAGE,
      per_page: process.env.VUE_APP_PERPAGE,
      total: process.env.VUE_APP_TOTALROWS,
      filters: {
        active: null
      },
      user: {}
    }
  },
  components: {
    UserDetails,
    AddUser
  },
  methods: {
    getUsersm () {
      const s = []
      for (let i = 1; i < 10; i++) {
        const v = { id: i, name: faker.name.firstName() + ' ' + faker.name.lastName(), role: faker.random.arrayElement(['administrator', 'cashier', 'tour guide']), active: faker.random.boolean() }
        s.push(v)
      }
      return s
    },
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
  },
  watch: {
    'filters.active': function (val, oldVal) {
      this.getUsers()
    }
  }
}

</script>
