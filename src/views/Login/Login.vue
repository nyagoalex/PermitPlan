<template>

<div class="container-fluid " style="background-color:#001E2B;height:100vh;">

<div class="">
<div class="text-left" style="">
<img alt="safari plan" style="width:200px;" src="@/assets/image/pplanw.png">
</div>
</div>
<div class="container">
    <div class="row py-0">
        <div class="col-md-7 col-sm-12 p-5 text-left">
            <div class="float-left py-5">
                <br>
                <h2 class="display-5" style="font-weight:800;color:#fff;">Halo,</h2>
                <h2 class="pt-4" style="color:yellow;font-weight:800;font-size:40px;">Welcome to Destination Jungle Safari Planner</h2>
                <div class="" style="border-top:2px solid #fff;"></div>
                <span class="p-2 float-left" style="color:tomato;font-family:none;font-size:23px;"><i>simpliefied safari planning</i></span>

                <br>

                <div class="">
                <p class="pt-5"><a href="http://www.lacel.tech" target="_blank" style="color:#95A5A6;">&copy;
                        {{ new Date().getFullYear() }} Lacel Techologies</a></p>
                </div>

            </div>

        </div>

        <div class="col-md-5 col-sm-12 text-center signup-form pt-3">
            <form @submit.prevent="handleSubmit" class="inner-form">
                <img class="" src="@/assets/image/pplanw.png" alt="" width="150" height="55">
                <h2 class="">sign in to your Account</h2>
                <b-input-group class="mt-5">
                    <template v-slot:prepend>
                        <b-input-group-text>
                            <b-icon class="text-success" icon="person-fill"></b-icon>
                        </b-input-group-text>
                    </template>
                    <b-form-input type="text" v-model="username" name="username" :class="{ 'is-invalid': submitted && !username }" placeholder="username"></b-form-input>
                    <div v-show="submitted && !username" class="invalid-feedback">Username is required</div>
                </b-input-group>
                <b-input-group class="mt-5">
                    <template v-slot:prepend>
                        <b-input-group-text>
                            <b-icon class="text-success" icon="lock"></b-icon>
                        </b-input-group-text>
                    </template>
                    <b-form-input type="password" v-model="password" name="password" :class="{ 'is-invalid': submitted && !password }" placeholder="password"></b-form-input>
                    <div v-show="submitted && !password" class="invalid-feedback">Password is required</div>
                </b-input-group>
                <div class="checkbox mb-3 mt-4 text-left">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <hr>
                <div class="form-group float-left">
                    <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                        <button class="btn btn-success" style="padding:10px 45px;font-size:20px;border-radius:2px;" :disabled="loading">Sign in <b-icon icon="arrow-right"></b-icon></button>
                    </b-overlay>
                    <div v-if="error" class="alert alert-danger">{{error}}</div>
                </div>
                <br>
                <br>
                <br>
                <div class="text-left">
                    Create new Company?
                     <a :href="registerUrl">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

</template>

<script>
import router from '@/router'
import {
    authHeader
} from '@/services'
import {
    Logout
} from '@/components/Logout.vue'

export default {
    data() {
        return {
            username: '',
            password: '',
            submitted: false,
            loading: false,
            returnUrl: '',
            error: '',
            registerUrl: 'https://safari-plan.com/register.php'
        }
    },
    created() {
        // reset login status
        const loggedIn = localStorage.getItem('user')
        if (loggedIn) {
            const http = this.$http
            Logout.logout(http)
        }

        // get return url from route parameters or default to '/'
        this.returnUrl = this.$route.query.returnUrl || '/dashboard'
    },
    methods: {
        handleSubmit(e) {
            this.submitted = true
            const {
                username,
                password
            } = this
            const param = {
                username: username,
                password: password
            }
            this.loading = true
            this.$http.post('/auth/token', param)
                .then(response => {
                    localStorage.setItem('user', JSON.stringify(response.data.data.user))
                    localStorage.setItem('settings', JSON.stringify(response.data.data.settings))
                    this.$http.defaults.headers.common.Authorization = authHeader()
                    router.push(this.returnUrl)
                    return true
                })
                .catch(error => {
                    localStorage.clear() // remove user from local storage to log user out
                    this.loading = false
                    this.error = error.message
                })
        }
    }
}
// function logout () {
//   // remove user from local storage to log user out
//   localStorage.removeItem('user')
// }
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

/* .signup-form .form-control {
    box-shadow: none !important;
    font-size: 1rem;
    font-weight: 800;
    border:1px solid #b5b0a1;
    border-radius: 0.3125rem;
    font-size: 1.125rem;
    min-height: calc(1.3em + 1.625rem);
    padding: 0.75rem 1rem;
} */

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

.btn-oranges{
    background-color:#E36049 ;
    color: #fff;

}
</style>
