<template>
<b-modal id="user-details" title="User Details" hide-footer hide-header size="md">
    <b-overlay :show="loading" rounded opacity="0.6">
        <div class="container" fluid>

            <div class="row">

                <div class=" col-lg-12 col-sm-12 col-12 main-section text-center">

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 profile-header pt-3">
                            <h4>User Details <span style="font-size: 15px; cursor:pointer" @click="$bvModal.hide('user-details')" class="float-right"> X</span></h4>
                            <b-icon icon="trophy" variant="warning"></b-icon><small class="last_login"> member since {{user.created_since}}</small>

                        </div>
                    </div>
                    <div class="row user-detail">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <img src="@/assets/image/user-ic.png" class="rounded-circle img-thumbnail">
                            <h5>{{user.full_name}}</h5>
                            <small>
                                <b-icon icon="person-check"></b-icon> {{user.role}}
                            </small>

                            <hr>
                            <b-badge pill class="m-2" variant="success" v-if="user.active">Active</b-badge>
                            <b-badge pill class="m-2" variant="danger" v-else>Inactive</b-badge>
                            <b-badge pill variant="warning" v-if="!user.blocked">Blocked</b-badge>
                            <br><small class="last_login">last login: {{user.last_login}}</small>

                            <hr>
                            <span class="m-2">
                                <b-icon icon="envelope"></b-icon> <a :href="`mailto:${user.full_name}`">{{user.email}}</a>
                            </span>
                            <span class="m-2">
                                <b-icon icon="question-circle"></b-icon> <a :href="`tel:${user.phone}`">{{user.phone}}</a>
                            </span>
                        </div>
                    </div>
                    <div class="row user-actions">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <b-button pill size="sm" :disabled="loading" class="m-2" variant="outline-success" v-if="!user.active" @click="activate">
                                <b-icon icon="check-circle"></b-icon> activate
                            </b-button>
                            <b-button pill size="sm" :disabled="loading" class="m-2" variant="outline-danger" v-else @click="deactivate">
                                <b-icon icon="slash-circle"></b-icon> deactivate
                            </b-button>
                            <b-button pill size="sm" :disabled="loading" class="m-2" variant="outline-warning">
                                <b-icon icon="shield-slash"></b-icon> unblock
                            </b-button>
                            <b-button pill size="sm" :disabled="loading" class="m-2" variant="danger" @click="deleteUser">
                                <b-icon icon="trash"></b-icon> Delete
                            </b-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </b-overlay>
</b-modal>
</template>

<script>
export default {
    data() {
        return {
            loading: false
        }
    },
    props: {
        user: Object
    },
    methods: {
        activate() {
            this.loading = true
            this.$http.post('/users/' + this.user.id + '/activate')
                .then(response => {
                    this.alertAddSuccess('User Successfully Activated')
                    this.user = response.data.data
                })
                .catch(errors => {
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        deactivate() {
            this.loading = true
            this.$http.delete('/users/' + this.user.id + '/deactivate')
                .then(response => {
                    this.alertAddSuccess('User Successfully DeActivated')
                    this.user = response.data.data
                })
                .catch(errors => {
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        deleteUser() {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.loading = true
                    this.$http.delete('/users/' + this.user.id)
                        .then(() => {
                            this.$swal.fire('Deleted!', 'User has been deleted.', 'success')
                            this.$bvModal.hide('user-details')
                            this.$parent.getUsers()
                        })
                        .catch(errors => {
                            this.toastError(errors.message)
                        })
                        .finally(() => {
                            this.loading = false
                        })
                }
            })
        }
    }
}
</script>

<style>
.main-section {
    border: 1px solid #138496;
    background-color: #fff;
}

.profile-header {
    background-color: #F5F9F7;
    height: 150px;
}

.user-detail {
    margin: -50px 0px 30px 0px;
}

.user-detail img {
    height: 100px;
    width: 100px;
}

.user-detail h5 {
    margin: 15px 0px 5px 0px;
}

.user-actions {
    padding: 15px 0px;
    background-color: #F5F9F7;
}

@media (min-width: 576px) {
    #user-details .modal-dialog {
        max-width: 400px !important;
    }

    #user-details .modal-body {
        padding: 0px !important;
    }
}

.user-detail span a {
    font-size: 13px;
}

.last_login {
    font-style: italic;
    color: gray;
}
</style>
