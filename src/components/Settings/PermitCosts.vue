<template>
<b-container fluid="md">
  <b-label class="float-left text-uppercase"> <strong> {{ costTitle }} </strong></b-label>
  <br><hr>
  <b-row class="bg-light p-5">
    <b-col md='6' class="bg-white pr-5 py-4 border border-success" style="border-radius:30px 30px 10px 10px; box-shadow: 1px grey;">
    <b-label ><b>Update permit costs</b></b-label>

      <b-form-group class="mt-5" label-cols-md="5" label="East Africans:" label-align-sm="right" label-for="east-africans" >
        <b-form-input id="east-africans" type="number" v-model='east_africa' size="lg"></b-form-input>
      </b-form-group>

      <b-form-group label-cols-md="5" label="Foreign Residents:" label-align-sm="right" label-for="foreign-residents" >
        <b-form-input id="foreign-residents" type="number" v-model='foreign_residents' size="lg"></b-form-input>
      </b-form-group>

      <b-form-group label-cols-md="5" label="Non Residents:" label-align-sm="right" label-for="non-residents" >
        <b-form-input id="non-residents"  type="number" v-model='non_residents' size="lg"></b-form-input>
      </b-form-group>

      <b-form-group label-cols-md="5" label="Ugandans:" label-align-sm="right" label-for="ugandans" >
        <b-form-input id="ugandans" type="number" size="lg" v-model="uganda"></b-form-input>
      </b-form-group>

      <div class="form-group text-right">
          <button class="btn btn-success" @click="updateCost"><b-icon icon="pencil" ></b-icon> Update </button>
          <div v-if="error" class="alert alert-danger">{{error}}</div>
          <b-icon v-show="loading" class="ml-2" icon="arrow-clockwise" animation="spin" font-scale="2"></b-icon>
      </div>
    </b-col>
    <b-col class="py-4">
      <div class="card float-right"  style="width: 18rem;">
        <div class="card-header"> Summary </div>
        <ul class="list-group list-group-flush text-left">
          <li class="list-group-item">East Africans <br><span class="lb-cost">USD ${{east_africa}}</span></li>
          <li class="list-group-item">Foreign Residentsn <br><span class="lb-cost">USD ${{foreign_residents}}</span></li>
          <li class="list-group-item">Non Residents <br><span class="lb-cost">USD ${{non_residents}}</span></li>
          <li class="list-group-item">Ugandans <br><span class="lb-cost">USD ${{uganda}}</span></li>
        </ul>
      </div>
    </b-col>
  </b-row>
</b-container>
</template>

<script>
const faker = require('faker')
export default {
  data () {
    return {
      sectors: this.getSectors(),
      permit_cost_id: this.costs.id,
      uganda: this.costs.uganda,
      east_africa: this.costs.east_africa,
      foreign_residents: this.costs.foreign_residents,
      non_residents: this.costs.non_residents,
      loading: false
    }
  },
  props: {
    costTitle: String,
    costs: Object
  },
  methods: {
    getSectors () {
      const s = []
      for (let i = 1; i < 10; i++) {
        const v = { id: i, name: faker.random.word(), national_park: faker.lorem.words(), active: faker.random.boolean() }
        s.push(v)
      }
      return s
    },
    updateCost: function () {
      this.submitted = true
      this.loading = true
      updateCost(this)
      this.submitted = false
      this.loading = false
    }
  }
}

function updateCost (sel) {
  const data = {
    uganda: sel.uganda,
    east_africa: sel.east_africa,
    foreign_residents: sel.foreign_residents,
    non_residents: sel.non_residents
  }
  alert(JSON.stringify(data))
}
</script>

<style>
.list-group-item .lb-cost {
 color: #29693a !important;
 font-size: 15px;
}
</style>
