<template>
      <b-container fluid="md">
      <b-label class="float-left"> <strong> TRACKING & HABITUATION SECTORS </strong></b-label>
      <b-button pill variant="outline-success" class="float-right"><b-icon icon="plus-circle"></b-icon> add sector</b-button>
      <br><hr>
        <div class="row pl-3" >
          <b-col v-for="sector in sectors" v-bind:key="sector.id" md='3' class="m-4 user_card" style="background-color:#F5F9F7;">
            <b-row class="mb-2">
                <b-col md='3' style="font-size: 2rem;"> <b-icon icon="tag-fill"></b-icon></b-col>
                <b-label class="user-name pt-3 px-0">{{sector.name}} </b-label><br>
            </b-row>
            <b-row>
              <b-label class="user-name mx-3">{{sector.national_park}} </b-label><br>
            </b-row>
            <b-row >
             <b-col class="p-0" ><b-button block variant="outline-success" style="height: 2em;"> <b-icon icon="pen"></b-icon></b-button></b-col>
             <b-col class="p-0"><b-button block variant="outline-danger" style="height: 2em;"> <b-icon icon="trash"></b-icon></b-button></b-col>
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
  data () {
    return {
      sectors: this.getSectors()
    }
  },
  methods: {
    getSectors () {
      const s = []
      for (let i = 1; i < 10; i++) {
        const v = { id: i, name: faker.random.word(), national_park: faker.lorem.words(), active: faker.random.boolean() }
        s.push(v)
      }
      return s
    }
  }
}

</script>
