<template>
<b-modal id="new-user" title="Add User">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>First Name</label>
                <input class="form-control" type="text" placeholder="e.g Vicky" v-model="form.first_name" :class="{ 'is-invalid': errors.first_name}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.first_name">
                    <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Other Names</label>
                <input class="form-control" type="text" placeholder="e.g Gardner" v-model="form.last_name" :class="{ 'is-invalid': errors.last_name}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.last_name">
                    <li v-for="(error) in errors.last_name" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

    </div>
    <b-row>
        <b-col class="form-group">
            <label>Email Address</label>
            <input class="form-control" type="email" placeholder="ask@lacel.tech" v-model="form.email" :class="{ 'is-invalid': errors.email}">
            <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
            </ul>
        </b-col>

        <b-col class="form-group">
            <label>Phone</label>
            <input class="form-control" type="number" placeholder="256 700 905609" v-model="form.phone" :class="{ 'is-invalid': errors.phone}">
            <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
            </ul>
        </b-col>
    </b-row>
    <div class="form-group">
        <label>Username</label>
        <input class="form-control" type="text" placeholder="e.g username" v-model="form.username" :class="{ 'is-invalid': errors.username}">
        <ul class="list-unstyled invalid-feedback" v-if="errors.username">
            <li v-for="(error) in errors.username" :key="error">{{ error }}</li>
        </ul>
    </div>
    <div class="form-group">
        <label>Designation</label>
        <select class="form-control" v-model="form.role" :class="{ 'is-invalid': errors.role}" disabled></select>
        <ul class="list-unstyled invalid-feedback" v-if="errors.role">
            <li v-for="(error) in errors.role" :key="error">{{ error }}</li>
        </ul>
    </div>
    <div class="form-group row mb-0">
        <b-col>
            <b-button variant="secondary" @click="generatePassword" :class="{ 'is-invalid': errors.password}"> <i class="zmdi zmdi-settings"></i> Generate Password</b-button>
            <ul class="list-unstyled invalid-feedback mb-0" v-if="errors.password">
                <li v-for="(error) in errors.password" :key="error">{{ error }}</li>
            </ul>
        </b-col>
        <b-col>
            <span variant="danger" style="color: blue;">{{form.password}}</span>
        </b-col>
    </div>
    <small class="text-center">copy password and store it somewhere same</small>
    <template v-slot:modal-footer="{ cancel }">
        <b-button size="lg" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
        <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
            <b-button size="lg" variant="success" :disabled="loading" @click="addUser">Add User</b-button>
        </b-overlay>
    </template>
</b-modal>
</template>

<script>
const faker = require('faker')
export default {
    data() {
        return {
            form: {
                password: '',
                first_name: '',
                last_name: '',
                email: '',
                role: '',
                username: ''
            },
            loading: false,
            errors: {}
        }
    },
    methods: {
        addUser() {
            this.loading = true
            this.errors = {}

            this.$http.post('/users', this.form)
                .then(response => {
                    this.alertAddSuccess()
                    this.resetModal()
                    this.$parent.getUsers()
                    this.$bvModal.hide('new-user')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        async generatePassword() {
            this.form.password = await faker.internet.password()
        },
        resetModal() {
            this.form = {
                password: '',
                first_name: '',
                last_name: '',
                email: '',
                role: '',
                username: ''
            }
        }
    }
}
</script>
