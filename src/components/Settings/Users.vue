<template>
      <b-container fluid="md">
      <label class="float-left"> <strong> USERS </strong></label>
      <b-button pill variant="outline-success" class="float-right"><b-icon icon="person-plus-fill"></b-icon> add user</b-button>
      <br><hr>
        <div class="row pl-3" >
          <b-col v-for="user in users" v-bind:key="user.id" md='3' class="m-4 user_card" style="background-color:#F5F9F7;">
            <b-row class="mb-2">
                <b-col md='4' class="usericon"> <b-icon icon="person-circle"></b-icon></b-col>
                <b-col class="pt-3 px-0">
                <label class="user-name">{{user.name}} </label><br>
                <small> {{user.role}}</small><br>
                <b-badge pill variant="success" v-if="user.active">Active</b-badge>
                <b-badge pill variant="danger" v-else>Inactive</b-badge>
                </b-col>
            </b-row>
          </b-col>
        </div>
        <b-pagination align="center"
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="my-table"
      ></b-pagination>
      </b-container>
</template>

<script>
const faker = require('faker')
export default {
  name: 'users',
  data () {
    return {
      users: this.getUsers(),
      perPage: 10,
      currentPage: 1,
      rows: 10
    }
  },
  methods: {
    getUsers () {
      const s = []
      for (let i = 1; i < 10; i++) {
        const v = { id: i, name: faker.name.firstName() + ' ' + faker.name.lastName(), role: faker.random.arrayElement(['administrator', 'cashier', 'tour guide']), active: faker.random.boolean() }
        s.push(v)
      }
      return s
    }
  }
}

</script>
