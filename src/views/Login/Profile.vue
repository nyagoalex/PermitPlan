<template>
<div class="container px-4 pt-4 ">
    <div class="row pt-5 bg-light">
        <div class="col-md-4 col-12 pt-5">
            <br />
            <br />
            <br />
            <br />
            <div class="row pt-4">
                <div class="col-md-3 col-4" style="border-radius:50%;height:110px;width:110px;"><img alt="Vue logo" rounded="circle" src="@/assets/image/user-avatar.png" width="110px" height='110px'>
                </div>
                <div class="col-md-9 col-6 pt-2">
                    <h2 id="account-name-label">{{profile.full_name}}</h2>
                    <span id="account-role-label">{{profile.role}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-12 pt-3 pb-2">
            <div class style="border:1px solid #eee;">
                <div class="p-4 border-bottom">
                    <b-badge pill variant="success" class="pl-2 float-left" v-if="profile.active">Active</b-badge>
                    <b-badge pill variant="danger" class="pl-2 float-left" v-else>Inactive</b-badge>
                    <label class="pl-2" style="font-size:23px;">My Profile</label>
                    <!-- <label class="float-right" >since:Sat, 08 Aug 2020</label> -->
                    <small class="pr-2 float-right">since: <b class="text-success">{{profile.created_at}}</b></small>
                </div>
                <form class="p-4" style="background-color:#fff;">
                    <div class="row pl-3 pr-3 text-left">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" v-model="profile.first_name" placeholder="Enter First Name" :class="{ 'is-invalid': errors.first_name}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.first_name">
                                    <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-ln">Other Names</label>
                                <input class="form-control" type="text" v-model="profile.last_name" placeholder="Enter Last Name" :class="{ 'is-invalid': errors.last_name}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.last_name">
                                    <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="form-control" type="email" v-model="profile.email" placeholder="Enter Email" :class="{ 'is-invalid': errors.email}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                                    <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" type="number" v-model="profile.phone" placeholder="Enter Phone" :class="{ 'is-invalid': errors.phone}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                                    <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="mt-2 mb-3" />
                            <div class="form-group text-right">
                                <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                                    <b-button class="btn btn-success" @click="updateProfile">
                                        <b-icon icon="pencil"></b-icon> Update Details
                                    </b-button>
                                </b-overlay>
                            </div>
                        </div>
                    </div>
                </form>
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
            profile: {},
            loading: false,
            errors: {}
        }
    },
    methods: {
        getProfile() {
            this.$http.get('/auth/me')
                .then(profile => {
                    this.profile = profile.data.data
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        updateProfile() {
            this.loading = true
            this.errors = {}
            this.$http.patch('/users/' + this.profile.id, this.profile)
                .then(response => {
                    this.profile = response.data.data
                    this.toastSuccess('My Profile Details Successfully Updated')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    created: function () {
        this.$nextTick(function () {
            // Code that will run only after the
            // entire view has been rendered
            this.getProfile()
        })
    }
}
</script>
