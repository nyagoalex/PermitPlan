<template>
<div class="tab-content">
    <div class="tab-pane fade active show" id="lodge-details" role="tabpanel">
        <div class="row justify-content-between pt-4">
            <div class="col-lg-8" id="hotel-details">
                <div class="card mb-0">
                    <div class="card-body p-lg-5" style="color:black !important; font-size: 14px;">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="l-name">Hotel/Lodge Name</label>
                                        <input class="form-control" type="text" style="text-transform:capitalize ;" v-model="lodge.name" :class="{ 'is-invalid': errors.name}">
                                        <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                                            <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="l-email">Email</label>
                                        <input class="form-control" type="email" v-model="lodge.email" :class="{ 'is-invalid': errors.email}">
                                        <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                                            <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number" class="form-control" v-model="lodge.phone" :class="{ 'is-invalid': errors.phone}">
                                        <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                                            <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="l-country">Country</label>
                                        <model-select :options="countries" placeholder="select country" v-model="countriesItem" :class="{ 'is-invalid': errors.country}">
                                        </model-select>
                                        <ul class="list-unstyled invalid-feedback" v-if="errors.country">
                                            <li v-for="(error) in errors.country" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="l-location">Location</label>
                                        <model-select :options="countriesItem.regions" placeholder="select Location" v-model="regionsItem" :isDisabled="!(countriesItem.regions.length > 0)" :isError="!(countriesItem.regions.length > 0)" :class="{ 'is-invalid': errors.location}">
                                        </model-select>
                                        <ul class="list-unstyled invalid-feedback" v-if="errors.location">
                                            <li v-for="(error) in errors.location" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="l-address">Address</label>
                                        <textarea class="form-control" placeholder="Where do you see yourself in years?" rows="6" v-model="lodge.address" :class="{ 'is-invalid': errors.address}">address</textarea>
                                        <ul class="list-unstyled invalid-feedback" v-if="errors.address">
                                            <li v-for="(error) in errors.address" :key="error">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                                    <b-button variant="success" :disabled="loading" @click="updateLodge">Update Hotel Details</b-button>
                                </b-overlay>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="alert alert-primary" role="alert">

                    <h5>Hotel Details Summary</h5>
                    Please check these details summary and make edits where necessary.

                    <div class="pt-4">

                        <div class="card card-fluid border-0" style="background-color:transparent !important;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-sm mb-0"><i class="zmdi zmdi-hotel mr-2"></i>Lodge Name</h6>
                                    </div>
                                    <div class="col-auto"><span class="text-sm l-name-label"> {{lodge.name}}</span></div>
                                </div>
                                <hr class="my-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-sm mb-0"><i class="zmdi zmdi-email mr-2"></i>Email</h6>
                                    </div>
                                    <div class="col-auto"><a href="#" class="text-sm l-email-label">{{lodge.email}}</a></div>
                                </div>
                                <hr class="my-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-sm mb-0"><i class="zmdi zmdi-smartphone-android mr-2"></i>Phone</h6>
                                    </div>
                                    <div class="col-auto"><span class="text-sm l-phone-label"> {{lodge.phone}}</span></div>
                                </div>
                                <hr class="my-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-sm mb-0"><i class="zmdi zmdi-navigation mr-2"></i>Location</h6>
                                    </div>
                                    <div class="col-auto"><span class="text-sm l-location-label"> {{lodge.location}}</span></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    ModelSelect
} from 'vue-search-select'
import {
    countries
} from '@/Constants/countries.js'

export default {
    data() {
        return {
            countries: countries,
            countriesItem: {
                value: '',
                text: '',
                regions: []
            },
            regionsItem: {
                value: '',
                text: ''
            },
            loading: false,
            errors: {}
        }
    },
    components: {
        ModelSelect
    },
    props: {
        lodge: Object
    },
    watch: {
        countriesItem: function (val) {
            this.lodge.country = val.text
            this.lodge.location = ''
        },
        regionsItem: function (val) {
            this.lodge.location = val.text
        }
    },
    methods: {
        updateLodge() {
            this.loading = true
            this.errors = {}

            this.$http.patch('/lodges/' + this.$route.params.id, this.lodge)
                .then(response => {
                    // this.contracted_rating = response.data.data
                    this.toastSuccess('Star Rating Successfully Updated')
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
