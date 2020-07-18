<template>
      <div>
      <b-label class="float-left"> <strong> COMPANY DETAILS </strong></b-label><br>
        <div class="row mt-1">
          <div class="col-md-7 col-sm-12 text-left signup-form ">
            <b-form @submit.prevent="handleSubmit" class="inner-form">
                <div class="bg-light rounded-lg mb-4">
                  <div class="media align-items-center">

                      <img id="c-img-logo" src="../../assets/logo.png" width="90" alt="Logo">
                      <div class="media-body pl-3">
                          <b-button class="btn btn-sm mb-2" type="button"  data-toggle="file" data-target="#logo">Change Logo</b-button>
                          <input type="file" name="logo" id="logo" accept="image/*" hidden>
                          <div class="mb-0  text-muted"><small>Upload JPG, GIF or PNG image. 300 x 300 required.</small></div>
                      </div>
                  </div>
                </div>
                <hr>
                <b-row class="font-weight-bold">
                  <b-col>
                    <b-form-group label="Company Name:" label-for="company_name">
                      <b-form-input id="company_name" v-model="company" type="text" required placeholder="Enter company name" :class="{ 'is-invalid': submitted && !company_name }"></b-form-input>
                      <div v-show="submitted && !company_name" class="invalid-feedback">Company Name is required</div>
                    </b-form-group>
                    <b-form-group label="Email address:" label-for="input-1"  description="We'll never be share with anyone else.">
                      <b-form-input id="email" v-model="email" type="email" required placeholder="Enter email"></b-form-input>
                    </b-form-group>
                    <b-form-group label="website:" label-for="website">
                      <b-form-input id="website" v-model="phone" required placeholder="Enter website"></b-form-input>
                    </b-form-group>
                  </b-col>
                  <b-col>
                    <b-form-group label="Address:" label-for="address">
                      <b-form-input id="address" v-model="name" required placeholder="Enter address"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Phone:" label-for="phone">
                      <b-form-input id="phone" v-model="phone" required placeholder="Enter phone"></b-form-input>
                    </b-form-group>
                  </b-col>
                </b-row>
            </b-form>
          </div>
           <div class="col-md-5 py-4 pl-5 col-sm-12">
              <div class="card mt-5"  style="width: 19rem;">
                <div class="card-header"> Summary </div>
                <ul class="list-group list-group-flush text-left">
                  <li class="list-group-item">Company Name <br><span class="lb-cost">{{company}}</span></li>
                  <li class="list-group-item">Address <br><span class="lb-cost">{{address}}</span></li>
                  <li class="list-group-item">Email <br><span class="lb-cost">{{email}}</span></li>
                  <li class="list-group-item">Phone Number <br><span class="lb-cost">{{phone}}</span></li>
                  <li class="list-group-item">Website <br><span class="lb-cost">{{website}}</span></li>
                </ul>
              </div>
            </div>
        </div>
      </div>
</template>

<script>
const faker = require('faker')
export default {
  data () {
    return {
      company: '',
      phone: '',
      address: '',
      website: '',
      email: ''
    }
  },
  mounted: function () {
    this.getCompanyDetails()
  },
  methods: {
    getCompanyDetails () {
      console.log(77777)
      this.company = faker.company.companyName()
      this.phone = faker.phone.phoneNumber()
      this.address = faker.address.streetAddress()
      this.website = faker.internet.url()
      this.email = faker.internet.email()
      this.name = faker.name.findName()
    }
  }
}
</script>
