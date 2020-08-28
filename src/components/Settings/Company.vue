<template>
<div>

    <b-row class="float-left"> <strong> COMPANY DETAILS </strong></b-row><br>
    <div class="row">
        <div class="col-md-7 col-sm-12 text-left signup-form ">
            <b-form @submit.prevent="updateCompany" class="inner-form">
                <div class="bg-light rounded-lg mb-4">
                    <div class="media align-items-center">

                        <img id="c-img-logo" src="@/assets/image/avatar.jpg" width="90" alt="Logo">
                        <div class="media-body pl-3">
                            <b-button class="btn btn-sm mb-2" type="button" data-toggle="file" data-target="#logo">Change Logo</b-button>
                            <input type="file" name="logo" id="logo" accept="image/*" hidden>
                            <div class="mb-0  text-muted"><small>Upload JPG, GIF or PNG image. 300 x 300 required.</small></div>
                        </div>
                    </div>
                </div>
                <hr>
                <b-row style="color:black !important">
                    <b-col>
                        <b-form-group label="Company Name: *" label-for="company_name">
                            <b-form-input id="company_name" v-model="company.company_name" type="text" required placeholder="Enter company name" :class="{ 'is-invalid': errors.company_name}"></b-form-input>
                            <ul class="list-unstyled invalid-feedback" v-if="errors.company_name">
                                <li v-for="(error) in errors.company_name" :key="error">{{ error }}</li>
                            </ul>
                        </b-form-group>
                        <b-form-group label="Email address:" label-for="input-1">
                            <b-form-input id="email" v-model="company.email" type="email" required placeholder="Enter email" :class="{ 'is-invalid': errors.email}"></b-form-input>
                            <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                                <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                            </ul>
                        </b-form-group>
                        <b-form-group label="website:" label-for="website">
                            <b-form-input id="website" v-model="company.website" required placeholder="Enter website" :class="{ 'is-invalid': errors.website}"></b-form-input>
                            <ul class="list-unstyled invalid-feedback" v-if="errors.website">
                                <li v-for="(error) in errors.website" :key="error">{{ error }}</li>
                            </ul>
                        </b-form-group>
                    </b-col>
                    <b-col>
                        <b-form-group label="physical_address: *" label-for="physical_address">
                            <b-form-input id="physical_address" v-model="company.physical_address" required placeholder="Enter physical address" :class="{ 'is-invalid': errors.physical_address}"></b-form-input>
                            <ul class="list-unstyled invalid-feedback" v-if="errors.address">
                                <li v-for="(error) in errors.physical_address" :key="error">{{ error }}</li>
                            </ul>
                        </b-form-group>
                        <b-form-group label="Phone: *" label-for="phone">
                            <b-form-input id="phone" v-model="company.phone" required placeholder="Enter phone" :class="{ 'is-invalid': errors.phone}"></b-form-input>
                            <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                                <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                            </ul>
                        </b-form-group>
                        <b-form-group label="registration Number: *" label-for="registration_no">
                            <b-form-input id="registration_no" v-model="company.registration_no" required placeholder="Enter phone" :class="{ 'is-invalid': errors.registration_no}"></b-form-input>
                            <ul class="list-unstyled invalid-feedback" v-if="errors.registration_no">
                                <li v-for="(error) in errors.registration_no" :key="error">{{ error }}</li>
                            </ul>
                        </b-form-group>
                    </b-col>
                </b-row>

                <div class="form-group text-right">
                    <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                        <button class="btn btn-success" @click="updateCompany" :disabled="loading">
                            <b-icon icon="pencil"></b-icon> Update
                        </button>
                    </b-overlay>
                </div>
            </b-form>
        </div>
        <div class="col-md-5 py-4 pl-5 col-sm-12">
            <small class="mt-5">last modified on: <b style="color: green;">{{company.updated_at}}</b></small>
            <div class="card" style="width: 19rem;">
                <div class="card-header"> Summary </div>
                <ul class="list-group list-group-flush text-left">
                    <li class="list-group-item">Company Name <br><span class="lb-cost">{{company.company_name}}</span></li>
                    <li class="list-group-item">Address <br><span class="lb-cost">{{company.physical_address}}</span></li>
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
export default {
    name: 'company',
    data() {
        return {
            company: {
                company_name: '',
                phone: '',
                physical_address: '',
                website: '',
                registration_no: '',
                email: ''
            },
            loading: false,
            errors: {}
        }
    },
    mounted: function () {
        this.getCompanyDetails()
    },
    methods: {
        getCompanyDetails() {
            this.$http.get('/settings').then(settings => {
                this.company = settings.data.data
            })
        },
        updateCompany() {
            this.loading = true
            this.errors = {}
            this.$http.patch('/settings', this.company)
                .then(response => {
                    this.company = response.data.data
                    this.toastSuccess('Company Details Successfully Updated')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
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
