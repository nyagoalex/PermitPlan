<template>
      <div>

      <b-row class="float-left"> <strong> COMPANY DETAILS </strong></b-row><br>
        <div class="row">
          <div class="col-md-7 col-sm-12 text-left signup-form ">
            <b-form @submit.prevent="handleSubmit" class="inner-form">
                <div class="bg-light rounded-lg mb-4">
                  <div class="media align-items-center">

                      <img id="c-img-logo" src="@/assets/image/avatar.jpg" width="90" alt="Logo">
                      <div class="media-body pl-3">
                          <b-button class="btn btn-sm mb-2" type="button"  data-toggle="file" data-target="#logo">Change Logo</b-button>
                          <input type="file" name="logo" id="logo" accept="image/*" hidden>
                          <div class="mb-0  text-muted"><small>Upload JPG, GIF or PNG image. 300 x 300 required.</small></div>
                      </div>
                  </div>
                </div>
                <hr>
                <p>{{company}}</p>
                <b-row style="color:black !important">
                  <b-col>
                    <b-form-group label="Company Name:" label-for="company_name">
                      <b-form-input id="company_name" v-model="company.company_name" type="text" required placeholder="Enter company name" :class="{ 'is-invalid': submitted && !company_name }"></b-form-input>
                      <div v-show="submitted && !company_name" class="invalid-feedback">Company Name is required</div>
                    </b-form-group>
                    <b-form-group label="Email address:" label-for="input-1"  description="We'll never be share with anyone else.">
                      <b-form-input id="email" v-model="company.email" type="email" required placeholder="Enter email"></b-form-input>
                    </b-form-group>
                    <b-form-group label="website:" label-for="website">
                      <b-form-input id="website" v-model="company.website" required placeholder="Enter website"></b-form-input>
                    </b-form-group>
                  </b-col>
                  <b-col>
                    <b-form-group label="Address:" label-for="address">
                      <b-form-input id="address" v-model="company.address" required placeholder="Enter address"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Phone:" label-for="phone">
                      <b-form-input id="phone" v-model="company.phone" required placeholder="Enter phone"></b-form-input>
                    </b-form-group>
                  </b-col>
                </b-row>

                <div class="form-group text-right">
                  <button class="btn btn-success" @click="updateCompany"><b-icon icon="pencil" ></b-icon> Update </button>
                  <div v-if="error" class="alert alert-danger">{{error}}</div>
                  <b-icon v-show="loading" class="ml-2" icon="arrow-clockwise" animation="spin" font-scale="2"></b-icon>
              </div>
            </b-form>
          </div>
           <div class="col-md-5 py-4 pl-5 col-sm-12">
              <small class="mt-5">last modified on: <b style="color: green;">{{company.updated_at}}</b></small>
              <div class="card"  style="width: 19rem;">
                <div class="card-header"> Summary </div>
                <ul class="list-group list-group-flush text-left">
                  <li class="list-group-item">Company Name <br><span class="lb-cost">{{company.company_name}}</span></li>
                  <li class="list-group-item">Address <br><span class="lb-cost">{{company.address}}</span></li>
                  <li class="list-group-item">Email <br><span class="lb-cost">{{company.email}}</span></li>
                  <li class="list-group-item">Phone Number <br><span class="lb-cost">{{company.phone}}</span></li>
                  <li class="list-group-item">Website <br><span class="lb-cost">{{company.website}}</span></li>
                </ul>
              </div>
            </div>
        </div>
      </div>
</template>

<script>
import axios from 'axios'

const apiUrl = process.env.VUE_APP_APIURL

export default {
  name: 'company',
  data () {
    return {
      company: {
        company_name: '',
        phone: '',
        address: '',
        website: '',
        email: ''
      },
      submitted: false,
      loading: false,
      error: false
    }
  },
  mounted: function () {
    this.getCompanyDetails()
  },
  methods: {
    getCompanyDetails () {
      axios.get(apiUrl + '/settings').then(settings => { this.company = settings.data.data })
    },
    updateCompany () {
      console.log(77777)
      axios.patch(apiUrl + '/settings', this.company)
        .then(response => {
          alert(' successfully updated')
          return Promise.resolve(response)
        })
    }
  }
}
</script>

<style>
.signup-form label {
  margin-bottom: 0px !important;
}
</style>
