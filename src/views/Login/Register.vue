<template>
    <div class="row">
        <div class="col-md-5 col-sm-12 p-3">
            <div class="pt-5">
                <h2 style="font-size:30px;color:#B03A2E;" class="mt-5 ">Create your account here</h2>

                <hr>

                <span class="p-2 float-left" style="color:#7E5109;font-family:none;font-size:23px;"><i>simpliefied safari planning</i></span><br>
                <p class="mt-5"><a href="http://www.lacel.tech" target="_blank" style="color:#95A5A6;">&copy;

                        {{ new Date().getFullYear() }} Lacel Techologies</a></p>
            </div>

        </div>

        <div class="col-md-7 col-sm-12 text-center signup-form">

            <b-overlay :show="loading" rounded opacity="0.6" variant="transparent" class="d-inline-block">
                <form @submit.prevent="handleSubmit" class="inner-form">
                    <img class="" src="@/assets/image/pplanw.png" alt="" width="150" height="55">
                    <h2 class="">Create Account</h2>
                    <b-input-group class="mt-5 mb-3">
                        <template v-slot:prepend>
                            <b-input-group-text>
                                <b-icon class="text-success" icon="people-fill"></b-icon>
                            </b-input-group-text>
                        </template>
                        <b-form-input type="text" v-model="form.company_name" placeholder="company name" :class="{ 'is-invalid': errors.company_name }"></b-form-input>
                        <ul class="list-unstyled invalid-feedback" v-if="errors.company_name">
                            <li v-for="(error) in errors.company_name" :key="error">{{ error }}</li>
                        </ul>

                    </b-input-group>
                    <hr>
                    <b-row class="mt-2">
                        <b-col>
                            <b-input-group>
                                <template v-slot:prepend>
                                    <b-input-group-text>
                                        <b-icon class="text-success" icon="person"></b-icon>
                                    </b-input-group-text>
                                </template>
                                <b-form-input type="text" v-model="form.first_name" name="first_name" placeholder="first name" :class="{ 'is-invalid': errors.first_name}"></b-form-input>
                                <ul class="list-unstyled invalid-feedback" v-if="errors.first_name">
                                    <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                                </ul>
                            </b-input-group>
                        </b-col>
                        <b-col>
                            <b-input-group>
                                <template v-slot:prepend>
                                    <b-input-group-text>
                                        <b-icon class="text-success" icon="person"></b-icon>
                                    </b-input-group-text>
                                </template>
                                <b-form-input type="text" v-model="form.last_name" name="last_name" placeholder="last name" :class="{ 'is-invalid': errors.last_name}"></b-form-input>
                                <ul class="list-unstyled invalid-feedback" v-if="errors.last_name">
                                    <li v-for="(error) in errors.last_name" :key="error">{{ error }}</li>
                                </ul>
                            </b-input-group>
                        </b-col>
                    </b-row>
                    <b-row class="mt-4">
                        <b-col>
                            <b-input-group>
                                <template v-slot:prepend>
                                    <b-input-group-text>
                                        <b-icon class="text-success" icon="person-fill"></b-icon>
                                    </b-input-group-text>
                                </template>
                                <b-form-input type="text" v-model="form.username" placeholder="username" :class="{ 'is-invalid': errors.username}"></b-form-input>
                                <ul class="list-unstyled invalid-feedback" v-if="errors.username">
                                    <li v-for="(error) in errors.username" :key="error">{{ error }}</li>
                                </ul>
                            </b-input-group>
                        </b-col>
                        <b-col>
                            <b-input-group>
                                <template v-slot:prepend>
                                    <b-input-group-text>
                                        <b-icon class="text-success" icon="envelope-fill"></b-icon>
                                    </b-input-group-text>
                                </template>
                                <b-form-input type="text" v-model="form.email" name="email" placeholder="email" :class="{ 'is-invalid': errors.email}"></b-form-input>
                                <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                                    <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                                </ul>
                            </b-input-group>
                        </b-col>
                    </b-row>
                    <b-row class="mt-4 mb-4">
                        <b-col>
                            <b-input-group>
                                <template v-slot:prepend>
                                    <b-input-group-text>
                                        <b-icon class="text-success" icon="lock"></b-icon>
                                    </b-input-group-text>
                                </template>
                                <b-form-input type="password" v-model="form.password" placeholder="password" :class="{ 'is-invalid': errors.password}"></b-form-input>
                                <ul class="list-unstyled invalid-feedback" v-if="errors.password">
                                    <li v-for="(error) in errors.password" :key="error">{{ error }}</li>
                                </ul>
                            </b-input-group>

                        </b-col>
                        <b-col>
                            <b-input-group>
                                <template v-slot:prepend>
                                    <b-input-group-text>
                                        <b-icon class="text-success" icon="lock-fill"></b-icon>
                                    </b-input-group-text>
                                </template>
                                <b-form-input type="password" v-model="form.password_confirmation" name="password_confirmation" placeholder="confirm password"></b-form-input>
                            </b-input-group>

                        </b-col>
                    </b-row>
                    <hr>
                    <div class="form-group">
                        <label for="agree"><input id="agree" type="checkbox" value="agree" v-model="checked" /> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
                    </div>
                    <div class="form-group">
                        <button :disabled="loading || !checked" class="btn btn-success" style="padding:10px 35px;font-size:20px;" @click="register">
                            <b-icon icon="people-fill"></b-icon> Create Account
                        </button>
                    </div>
                    <div class="text-center">I already have an account? <router-link to="/login"><u> login here</u></router-link>
                    </div>
                </form>
                <template v-slot:overlay>
                    <div class="text-center">
                        <b-icon icon="stopwatch" font-scale="3" animation="cylon"></b-icon>
                        <p id="cancel-label"><strong> Registering Company...</strong></p>
                        <b-progress min="1" max="100" :value="counter" variant="primary" height="3px" aria-describedby="cancel-label" class="mx-n4 rounded-0"></b-progress>
                    </div>
                </template>
            </b-overlay>
        </div>
    </div>
</template>

<script>
// import router from '@/router'
// import { userService } from '@/services'

// const config = process.env.VUE_APP_APIURL

export default {
    data() {
        return {
            form: {
                company_name: '',
                first_name: '',
                last_name: '',
                username: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            loading: false,
            returnUrl: '',
            errors: {},
            checked: false,
            counter: 1
        }
    },
    created() {
        // reset login status
        // userService.logout()

        // get return url from route parameters or default to '/'
        this.returnUrl = this.$route.query.returnUrl || '/'
    },
    methods: {
        register() {
            this.loading = true
            this.errors = {}
            this.counter = 1
            setInterval(() => {
                if (this.counter < 100) {
                    this.counter += 1
                }
            }, 1000)

            this.$http.post('api/register', this.form)
                .then(response => {
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Company Registered',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        const domain = response.data.data.domain
                        window.location = process.env.VUE_APP_PROTOCOL + domain + '.' + process.env.VUE_APP_DOMAIN + '/login'
                    })
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
.signup-form {
    width: 450px;
    margin: 0 auto;
    padding: 30px 0;
}

.signup-form .inner-form {
    color: #999;
    border-radius: .75rem;
    margin-bottom: 15px;
    background: #fff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 0 1.25rem rgba(31, 45, 61, .05);
    /*    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);*/
    padding: 30px;
}

.signup-form h2 {
    color: #333;
    font-weight: bold;
    margin-top: 0;
}

.signup-form hr {
    margin: 0 -30px 20px;
}

.signup-form .form-group {
    margin-bottom: 20px;
}

.signup-form .form-control {
    min-height: 48px;
    box-shadow: none !important;
}

.signup-form input[type="checkbox"] {
    margin-top: 2px;
}

.signup-form a {
    color: #fff;
    text-decoration: underline;
}

.signup-form a:hover {
    text-decoration: none;
}

.signup-form .inner-form a {
    color: #19aa8d;
    text-decoration: none;
}
</style>
