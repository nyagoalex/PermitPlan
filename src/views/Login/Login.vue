<template>
        <div class="row">
          <div class="col-md-7 col-sm-12 p-5">
                <div class="pt-5 ">
                    <h2  style="font-size:45px;color:#B03A2E;"><small class="float-left" style="font-size:28px;color:#7E5109;">Halo,</small><br> Tukwaniriza ku Safariplan</h2>

                    <hr>

                    <span class="p-2 float-left" style="color:#7E5109;font-family:none;font-size:23px;"><i>simpliefied safari planning</i></span>
                    <p class="pt-5"><a href="http://www.lacel.tech" target="_blank" style="color:#95A5A6;">&copy;

                            {{ new Date().getFullYear() }} Lacel Techologies</a></p>
                </div>

            </div>

          <div class="col-md-5 col-sm-12 text-center signup-form">
            <form @submit.prevent="handleSubmit" class="inner-form">
                <img class="" src="@/assets/image/pplanw.png" alt="" width="150" height="55">
                <h2 class="">sign in to your Account</h2>
                 <b-input-group class="mt-5">
                    <template v-slot:prepend>
                        <b-input-group-text><b-icon class="text-success" icon="person-fill"></b-icon></b-input-group-text>
                    </template>
                    <b-form-input type="text" v-model="username" name="username" :class="{ 'is-invalid': submitted && !username }" placeholder="username">{{username}}</b-form-input>
                    <div v-show="submitted && !username" class="invalid-feedback">Username is required</div>
                </b-input-group>
                 <b-input-group class="mt-5">
                    <template v-slot:prepend>
                        <b-input-group-text><b-icon class="text-success" icon="person-fill"></b-icon></b-input-group-text>
                    </template>
                    <b-form-input type="password" v-model="password" name="password" :class="{ 'is-invalid': submitted && !password }" placeholder="password"></b-form-input>
                  <div  v-show="submitted && !password" class="invalid-feedback">Password is required</div>
                </b-input-group>
               <div class="checkbox mb-3 mt-4 text-left">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                 <hr>
                <div class="form-group">
                    <button class="btn btn-success"  style="padding:10px 45px;font-size:20px;" :disabled="loading">SignIn <b-icon icon="arrow-right"></b-icon></button>
                    <div v-if="error" class="alert alert-danger">{{error}}</div>
                    <b-icon v-show="loading" class="ml-2" icon="arrow-clockwise" animation="spin" font-scale="2"></b-icon>
                </div>
                <div class="text-center">Create new Company? <router-link to="/register">Sign Up</router-link></div>
            </form>
          </div>
        </div>
</template>

<script>
import router from '@/router'
import { authHeader } from '@/services'
import { Logout } from '@/components/Logout.vue'
import axios from 'axios'
const apiUrl = process.env.VUE_APP_APIURL

export default {
  data () {
    return {
      username: '',
      password: '',
      submitted: false,
      loading: false,
      returnUrl: '',
      error: ''
    }
  },
  created () {
    // reset login status
    console.log('login created')
    const loggedIn = localStorage.getItem('user')
    if (loggedIn) {
      Logout()
    }

    // get return url from route parameters or default to '/'
    this.returnUrl = this.$route.query.returnUrl || '/about'
  },
  methods: {
    handleSubmit (e) {
      this.submitted = true
      const { username, password } = this

      this.loading = true
      axios.post(apiUrl + '/auth/token', {
        username: username,
        password: password
      })
        .then(user => {
          localStorage.setItem('user', JSON.stringify(user.data))
          axios.defaults.headers.common.Authorization = authHeader()
          return user
        })
        .then(
          user => router.push(this.returnUrl),
          error => {
            this.error = error.response.data.message
            this.loading = false
            // remove user from local storage to log user out
            localStorage.removeItem('user')
          }
        )
        .catch(function (error) {
          this.error = error.response
          this.loading = false
          // remove user from local storage to log user out
          localStorage.removeItem('user')
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
