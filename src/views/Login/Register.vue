<template>
        <div class="row">
          <div class="col-md-5 col-sm-12 p-3">
                <div class="pt-5">
                    <h2  style="font-size:30px;color:#B03A2E;" class="mt-5 ">Create your account here</h2>

                    <hr>

                    <span class="p-2 float-left" style="color:#7E5109;font-family:none;font-size:23px;"><i>simpliefied safari planning</i></span><br>
                    <p class="mt-5"><a href="http://www.lacel.tech" target="_blank" style="color:#95A5A6;">&copy;

                            {{ new Date().getFullYear() }} Lacel Techologies</a></p>
                </div>

            </div>

          <div class="col-md-7 col-sm-12 text-center signup-form">
            <form @submit.prevent="handleSubmit" class="inner-form">
                <img class="" src="../../assets/pplanw.png" alt="" width="150" height="55">
                <h2 class="">Create Account</h2>
                 <b-input-group class="mt-5 mb-3">
                    <template v-slot:prepend>
                        <b-input-group-text><b-icon class="text-success" icon="people-fill"></b-icon></b-input-group-text>
                    </template>
                    <b-form-input type="text" v-model="company_name" name="company_name" :class="{ 'is-invalid': submitted && !company_name }" placeholder="company name"></b-form-input>
                    <div v-show="submitted && !company_name" class="invalid-feedback">Company Name is required</div>
                </b-input-group>
                <hr>
                <b-row  class="mt-2">
                  <b-col>
                    <b-input-group>
                      <template v-slot:prepend>
                          <b-input-group-text><b-icon class="text-success" icon="person"></b-icon></b-input-group-text>
                      </template>
                      <b-form-input type="text" v-model="first_name" name="first_name" :class="{ 'is-invalid': submitted && !first_name }" placeholder="first name"></b-form-input>
                      <div v-show="submitted && !first_name" class="invalid-feedback">first name is required</div>
                  </b-input-group>
                  </b-col>
                  <b-col>
                    <b-input-group>
                      <template v-slot:prepend>
                          <b-input-group-text><b-icon class="text-success" icon="person"></b-icon></b-input-group-text>
                      </template>
                      <b-form-input type="text" v-model="last_name" name="last_name" :class="{ 'is-invalid': submitted && !last_name }" placeholder="last name"></b-form-input>
                      <div v-show="submitted && !last_name" class="invalid-feedback">last name is required</div>
                  </b-input-group>
                  </b-col>
                </b-row>
                <b-row  class="mt-4">
                  <b-col>
                    <b-input-group>
                      <template v-slot:prepend>
                          <b-input-group-text><b-icon class="text-success" icon="person-fill"></b-icon></b-input-group-text>
                      </template>
                      <b-form-input type="text" v-model="username" name="username" :class="{ 'is-invalid': submitted && !username }" placeholder="username"></b-form-input>
                      <div v-show="submitted && !username" class="invalid-feedback">Username is required</div>
                  </b-input-group>
                  </b-col>
                  <b-col>
                    <b-input-group>
                      <template v-slot:prepend>
                          <b-input-group-text><b-icon class="text-success" icon="envelope-fill"></b-icon></b-input-group-text>
                      </template>
                      <b-form-input type="text" v-model="email" name="email" :class="{ 'is-invalid': submitted && !email }" placeholder="email"></b-form-input>
                      <div v-show="submitted && !email" class="invalid-feedback">email is required</div>
                  </b-input-group>
                  </b-col>
                </b-row>
                <b-row  class="mt-4 mb-4">
                  <b-col>
                    <b-input-group>
                        <template v-slot:prepend>
                            <b-input-group-text><b-icon class="text-success" icon="lock"></b-icon></b-input-group-text>
                        </template>
                        <b-form-input type="password" v-model="password" name="password" :class="{ 'is-invalid': submitted && !password }" placeholder="password"></b-form-input>
                      <div  v-show="submitted && !password" class="invalid-feedback">Password is required</div>
                    </b-input-group>

                  </b-col>
                  <b-col>
                    <b-input-group>
                        <template v-slot:prepend>
                            <b-input-group-text><b-icon class="text-success" icon="lock-fill"></b-icon></b-input-group-text>
                        </template>
                        <b-form-input type="password" v-model="confirm_password" name="confirm_password" :class="{ 'is-invalid': submitted && !confirm_password }" placeholder="confirm password"></b-form-input>
                      <div  v-show="submitted && !confirm_password" class="invalid-feedback">Password Confirmation is required</div>
                    </b-input-group>

                  </b-col>
                </b-row>
                <hr>
                <div class="form-group" >
                  <label for="agree"><input id="agree" type="checkbox" value="agree" v-model="checked"/> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
                </div>
                <div class="form-group">
                    <button :disabled="!checked" class="btn btn-success"  style="padding:10px 35px;font-size:20px;"><b-icon icon="people-fill" ></b-icon> Create Account </button>
                    <div v-if="error" class="alert alert-danger">{{error}}</div>
                    <b-icon v-show="loading" class="ml-2" icon="arrow-clockwise" animation="spin" font-scale="2"></b-icon>
                </div>
                <div class="text-center">I already have an account? <router-link to="/login"><u> login here</u></router-link></div>
            </form>
          </div>
        </div>
</template>

<script>
import router from '@/router'
import { userService } from '@/services'

// const config = process.env.VUE_APP_APIURL

export default {
  data () {
    return {
      company_name: '',
      first_name: '',
      last_name: '',
      username: '',
      email: '',
      password: '',
      confirm_password: '',
      submitted: false,
      loading: false,
      returnUrl: '',
      error: '',
      checked: false
    }
  },
  created () {
    // reset login status
    userService.logout()

    // get return url from route parameters or default to '/'
    this.returnUrl = this.$route.query.returnUrl || '/'
  },
  methods: {
    handleSubmit (e) {
      this.submitted = true
      const { username, password } = this
      // console.log(this)
      // stop here if form is invalid
      if (!(username && password)) {
        return
      }

      this.loading = true
      userService.login(this)
        .then(
          user => router.push(this.returnUrl),
          error => {
            this.error = error
            this.loading = false
          }
        )
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
