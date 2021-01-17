<!-- @format -->

<template>
    <b-modal id="new-activity" :title="`${mode} Activity`">
        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Activity Name</label>
                        <input
                            type="text"
                            style="text-transform: uppercase"
                            class="form-control place"
                            v-model="activity.name"
                            placeholder="Enter Activity name"
                            :class="{ 'is-invalid': errors.name }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                            <li v-for="error in errors.name" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Cost Per Person</label>
                        <input
                            type="number"
                            class="form-control"
                            v-model="activity.cost_per_person"
                            placeholder="500"
                            :class="{ 'is-invalid': errors.cost_per_person }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.cost_per_person"
                        >
                            <li v-for="error in errors.cost_per_person" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Location</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="activity.location"
                            placeholder="500"
                            :class="{ 'is-invalid': errors.location }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.location">
                            <li v-for="error in errors.location" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea
                            class="form-control"
                            placeholder="Say something about the activity"
                            rows="6"
                            v-model="activity.description"
                            :class="{ 'is-invalid': errors.description }"
                        ></textarea>
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.description"
                        >
                            <li v-for="error in errors.description" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()"
                >Cancel</b-button
            >
            <b-overlay
                :show="loading"
                rounded
                opacity="0.6"
                spinner-small
                class="d-inline-block"
            >
                <b-button
                    size="sm"
                    variant="success"
                    :disabled="loading"
                    @click=";`${mode}` == 'create' ? addActivity() : updateActivity()"
                    >{{ `${mode}` == 'create' ? 'Add' : 'Update' }} Activity</b-button
                >
            </b-overlay>
        </template>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            errors: {}
        }
    },
    props: {
        mode: String,
        activity: Object
    },
    methods: {
        addActivity() {
            this.loading = true
            this.errors = {}

            this.$http
                .post('/activities', this.activity)
                .then((response) => {
                    this.alertAddSuccess()
                    this.$parent.getActivities()
                    this.$bvModal.hide('new-activity')
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        updateActivity() {
            this.loading = true
            this.errors = {}

            this.$http
                .patch('/activities/' + this.activity.id, this.activity)
                .then((response) => {
                    this.toastSuccess('Successfully Updated')
                    this.$parent.getActivities()
                    this.$bvModal.hide('new-activity')
                })
                .catch((errors) => {
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
