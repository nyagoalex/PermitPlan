<template>
<b-container fluid="md">
  <b-label class="float-left text-uppercase"> <strong> PERMITS EXPIRY </strong></b-label>
  <br><hr>
  <b-row class="bg-light py-5 pl-5 pr-3">
    <b-col md='7' class="bg-white pr-3 py-4">
      <b-label ><b>Update deposit expiry</b></b-label>

      <b-form-group class="mt-5 text-left"  label="Maximum Period Allowed (In Days)"  label-for="expiry_period" >
        <b-form-input id="expiry_period" type="number" v-model='expiry_period' size="lg"></b-form-input>
      </b-form-group>

      <div class="form-group text-right">
          <button class="btn btn-success" @click="updateExpiry"><b-icon icon="pencil" ></b-icon> Update </button>
          <div v-if="error" class="alert alert-danger">{{error}}</div>
          <b-icon v-show="loading" class="ml-2" icon="arrow-clockwise" animation="spin" font-scale="2"></b-icon>
      </div>
    </b-col>
    <b-col md='5' class="bg-white pt-5 text-left border-left">
      <h5>You have set the permits to expire after <br><span>{{expiry_period}}</span> Day(s).</h5>

      <p class="mt-4" style="color:#606162"> <span class="" style="color:firebrick"><b>Note: </b>&nbsp;</span>Please note that the syste will remind you when the expiry period is approaching but the system can not make a payment automatically and so after making the payment, please update the booking permits accordingly.</p>
    </b-col>
  </b-row>
</b-container>
</template>

<script>

export default {
  data () {
    return {
      expiry_period: 9,
      loading: false
    }
  },
  methods: {
    updateExpiry: function () {
      this.submitted = true
      this.loading = true
      updateExpiry(this)
      this.submitted = false
      this.loading = false
    }
  }
}

function updateExpiry (sel) {
  alert(sel.expiry_period)
}
</script>

<style>
.list-group-item .lb-cost {
 color: #29693a !important;
 font-size: 15px;
}
</style>
