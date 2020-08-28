<template>
<b-modal id="new-guide" title="Add Tour Guide">
    <form>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>First name</label>
                <input type="text" class="form-control" v-model="guide.first_name" :class="{ 'is-invalid': errors.first_name}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.first_name">
                    <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label>Other Names</label>
                <input type="text" class="form-control" v-model="guide.last_name" :class="{ 'is-invalid': errors.last_name}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.last_name">
                    <li v-for="(error) in errors.last_name" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="add_dob">Date of Birth(DOB)</label>
                <input type="date" class="form-control" v-model="guide.dob" :class="{ 'is-invalid': errors.dob}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.dob">
                    <li v-for="(error) in errors.dob" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label for="add_experience">Guide Experience</label>
                <input type="date" class="form-control" v-model="guide.experience_since" :class="{ 'is-invalid': errors.experience_since}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.experience_since">
                    <li v-for="(error) in errors.experience_since" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="add_email">Email</label>
                <input type="email" class="form-control" v-model="guide.email" :class="{ 'is-invalid': errors.email}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                    <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label for="add_phone">Phone Number</label>
                <input type="number" class="form-control" v-model="guide.phone" :class="{ 'is-invalid': errors.phone}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                    <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Contract Basis</label>
                <select type="text" class="form-control" v-model="guide.contract_basis" :class="{ 'is-invalid': errors.contract_basis}">
                    <option value="">Select employment terms</option>
                    <option value="full_time">Full-Time</option>
                    <option value="freelancer">Freelancer</option>

                </select>
                <ul class="list-unstyled invalid-feedback" v-if="errors.contract_basis">
                    <li v-for="(error) in errors.contract_basis" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label>Guide Status</label>
                <select type="text" class="form-control" v-model="guide.status" :class="{ 'is-invalid': errors.status}">
                    <option value="">Select guide status</option>
                    <option value="working">Working</option>
                    <option value="terminated">Terminated</option>
                    <option value="probation">On Probation</option>

                </select>
                <ul class="list-unstyled invalid-feedback" v-if="errors.status">
                    <li v-for="(error) in errors.status" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Cost Per Day (USD)</label>
                <input type="number" placeholder="300" class="form-control" v-model="guide.cost_per_day" :class="{ 'is-invalid': errors.cost_per_day}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.cost_per_day">
                    <li v-for="(error) in errors.cost_per_day" :key="error">{{ error }}</li>
                </ul>
            </div>

        </div>

    </form>
    <template v-slot:modal-footer="{ cancel }">
        <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
        <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="addGuide">Add Guide</b-button>
        </b-overlay>
    </template>
</b-modal>
</template>

<script>
export default {
    data() {
        return {
            guide: this.resetModal(),
            loading: false,
            errors: {}
        }
    },
    methods: {
        addGuide() {
            this.loading = true
            this.errors = {}

            this.$http.post('/guides', this.guide)
                .then(response => {
                    this.alertAddSuccess()
                    this.guide = this.resetModal()
                    this.$parent.getGuides()
                    this.$bvModal.hide('new-guide')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        resetModal() {
            return {
                first_name: '',
                last_name: '',
                dob: '',
                experience_since: '',
                email: '',
                phone: '',
                contract_basis: '',
                status: '',
                cost_per_day: ''
            }
        }
    }
}
</script>
