<!-- @format -->

<template>
    <b-modal id="edit-booking" :title="`Edit Booking : ${booking.number} `" size="lg">
        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Booking Reference</label>
                        <input
                            class="form-control place"
                            placeholder="Eg. Edgar X20"
                            v-model="booking.ref"
                            :class="{ 'is-invalid': errors.ref }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.ref">
                            <li v-for="error in errors.ref" :key="error">{{ error }}</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label>Tour Name</label>
                        <input
                            class="form-control place"
                            placeholder="Eg. 4 Days Bwindi Gorilla safari"
                            v-model="booking.client_name"
                            :class="{ 'is-invalid': errors.client_name }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.client_name"
                        >
                            <li v-for="error in errors.client_name" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>No. of Persons</label>
                        <input
                            type="number"
                            class="form-control place"
                            placeholder="eg. 2"
                            v-model="booking.no_of_persons"
                            :class="{ 'is-invalid': errors.no_of_persons }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.no_of_persons"
                        >
                            <li v-for="error in errors.no_of_persons" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Arrival Date</label>
                        <input
                            type="date"
                            class="form-control place"
                            placeholder="input number"
                            v-model="booking.arrival_date"
                            :class="{ 'is-invalid': errors.arrival_date }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.arrival_date"
                        >
                            <li v-for="error in errors.arrival_date" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>Departure Date</label>
                        <input
                            type="date"
                            class="form-control place"
                            placeholder="input number"
                            v-model="booking.departure_date"
                            :class="{ 'is-invalid': errors.departure_date }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.departure_date"
                        >
                            <li v-for="error in errors.departure_date" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>Source</label>
                        <select class="form-control place" v-model="source_selected">
                            <option disabled value="">--select source--</option>
                            <option value="Direct">Direct</option>
                            <option value="Agent">Agent</option>
                        </select>
                    </div>

                    <div class="form-group" v-if="source_selected == 'Agent'">
                        <label><small>Select agent</small></label>
                        <model-select
                            :options="this.agents"
                            placeholder="select Agent"
                            v-model="booking.agent_id"
                            :class="{ 'is-invalid': errors.agent_id }"
                        >
                        </model-select>
                        <ul class="list-unstyled invalid-feedback" v-if="errors.agent_id">
                            <li v-for="error in errors.agent_id" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="lg" variant="danger" :disabled="loading" @click="cancel()"
                >Cancel</b-button
            >
            <b-button
                size="lg"
                variant="success"
                :disabled="loading"
                ref="button"
                @click="updateBooking"
                >Update Booking</b-button
            >
        </template>
        <b-overlay :show="loading" opacity="0.6" no-wrap></b-overlay>
    </b-modal>
</template>

<script>
import { ModelSelect } from 'vue-search-select'
export default {
    data() {
        return {
            source_selected: '',
            loading: false,
            errors: {},
            agents: []
        }
    },
    components: {
        ModelSelect
    },
    props: {
        booking: Object
    },
    methods: {
        getAgents() {
            this.$http.get('/agents').then((agents) => {
                this.agents = agents.data.data.map(function (num) {
                    return {
                        value: num.id,
                        text: num.name + ' (' + num.code + ')'
                    }
                })
            })
        },
        updateBooking() {
            this.loading = true
            this.errors = {}
            if (this.source_selected !== 'Agent') {
                this.booking.agent_id = null
            }
            this.$http
                .patch('/bookings/' + this.$route.params.id, this.booking)
                .then((booking) => {
                    this.toastSuccess('Successfully Updated')
                    this.$bvModal.hide('edit-booking')
                    this.$parent.getBooking()
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    mounted() {
        this.getAgents()
    },
    watch: {
        'booking.source': function (val, oldVal) {
            this.source_selected = val
        }
    }
}
</script>
