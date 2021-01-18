<!-- @format -->

<template>
    <div class="tab-pane" id="rates">
        <div class="pt-4">
            <div class="row">
                <div class="col-md-6 col-12">
                    <span>
                        <h6>The Contracted Rate (Percentage)</h6>
                        <input
                            class="form-control"
                            style="height: calc(1.5em + 1.5rem + 2px)"
                            type="number"
                            v-model="contracted_rating"
                            :class="{ 'is-invalid': errors.contracted_rating }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.contracted_rating"
                        >
                            <li v-for="error in errors.contracted_rating" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </span>

                    <div class="pt-3">
                        <b-button variant="outline-success" @click="setContractedRating">
                            + Update contract Rate</b-button
                        >
                    </div>
                </div>

                <div class="col-md-6 col-12 border-left pt-1">
                    <div class="text-right mb-2">
                        <b-button
                            variant="outline-success"
                            v-b-modal.new-season
                            @click="resetModal, (mode = 'create')"
                        >
                            + Add a new Season</b-button
                        >
                    </div>
                    <div class="season mb-3" v-if="!seasons || !seasons.length">
                        <p class="text-muted p-2">No Seasons Registered Yet.</p>
                    </div>
                    <div
                        class="season mb-3"
                        v-for="(item, index) in seasons"
                        :key="item.id"
                    >
                        <div class="row">
                            <div class="col-md-8">
                                <div
                                    class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-1"
                                >
                                    <b-icon
                                        icon="emoji-sunglasses"
                                        class="d-inline-block text-success"
                                    ></b-icon>
                                </div>
                                {{ item.name }}
                                <br />
                                <small class="text-muted ml-4"
                                    >{{ item.from_date | displayDate }}
                                    <b-icon
                                        icon="arrow-right"
                                        variant="primary"
                                        animation="cylon"
                                    ></b-icon
                                    >{{ item.to_date | displayDate }}</small
                                >
                            </div>
                            <div class="col-md-3 text-right">
                                <span
                                    style="cursor: pointer"
                                    v-b-tooltip.hover
                                    title="Edit Room Type"
                                    v-b-modal.new-season
                                    @click=";(season = item), (mode = 'update')"
                                >
                                    <b-icon icon="pen"></b-icon>
                                </span>
                                <br />
                                <span
                                    style="cursor: pointer"
                                    class="text-danger"
                                    v-b-tooltip.hover
                                    title="Remove Room Type"
                                    @click="removeSeason(index)"
                                >
                                    <b-icon icon="trash"></b-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid" id="seasonal-cost"></div>
        </div>
        <b-modal id="new-season" :title="`${mode} Sector`">
            <form>
                <div class="form-group">
                    <label for="s-name">Season Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="s-name"
                        placeholder="High season, Low Season, or peak season"
                        v-model="season.name"
                        :class="{ 'is-invalid': errors.name }"
                    />
                    <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                        <li v-for="error in errors.name" :key="error">{{ error }}</li>
                    </ul>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>From</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="season.from_date"
                            :class="{ 'is-invalid': errors.from_date }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.from_date"
                        >
                            <li v-for="error in errors.from_date" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group col-md-6">
                        <label>To</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="season.to_date"
                            :class="{ 'is-invalid': errors.to_date }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.to_date">
                            <li v-for="error in errors.to_date" :key="error">
                                {{ error }}
                            </li>
                        </ul>
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
                        @click=";`${mode}` == 'create' ? addSeason() : updateSeason()"
                        >{{ `${mode}` == 'create' ? 'Add' : 'Update' }} Season
                    </b-button>
                </b-overlay>
            </template>
        </b-modal>
    </div>
</template>

<script>
// import AddSeason from '@/components/Modals/AddSeason.vue'

export default {
    data() {
        return {
            loading: false,
            errors: {},
            mode: '',
            season: {}
        }
    },
    props: {
        seasons: Array,
        contracted_rating: Number
    },
    methods: {
        resetModal() {
            this.season = {
                name: '',
                from_date: '',
                to_date: ''
            }
        },
        addSeason() {
            this.loading = true
            this.errors = {}
            this.$http
                .post('/lodges/' + this.$route.params.id + '/seasons', this.season)
                .then((response) => {
                    this.alertAddSuccess()
                    this.resetModal()
                    this.$bvModal.hide('new-season')
                    const {
                        id,
                        name,
                        from_date, // eslint-disable-line
                        to_date // eslint-disable-line
                    } = response.data.data
                    this.seasons.push({
                        id: id,
                        name: name,
                        from_date: from_date,
                        to_date: to_date
                    })
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        updateSeason() {
            const { id } = this.season
            var season = (({
                name,
                from_date, // eslint-disable-line
                to_date // eslint-disable-line
            }) => ({
                name,
                from_date, // eslint-disable-line
                to_date // eslint-disable-line
            }))(this.season) // eslint-disable-line
            this.$http
                .patch('/lodges/' + this.$route.params.id + '/seasons/' + id, season)
                .then((response) => {
                    this.toastSuccess('Successfully Updated')
                    this.resetModal()
                    this.$bvModal.hide('new-season')
                    this.getseasons()
                })
                .catch((errors) => {
                    this.$swal.fire('Failed!', errors.message, 'error')
                })
        },
        removeSeason(index) {
            const id = this.seasons[index].id
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http
                        .delete('/lodges/' + this.$route.params.id + '/seasons/' + id)
                        .then(() => {
                            this.$swal.fire(
                                'Deleted!',
                                'Season has been deleted.',
                                'success'
                            )
                            this.getseasons()
                        })
                        .catch((errors) => {
                            this.toastError(errors.message)
                        })
                }
            })
        },
        async getseasons() {
            await this.$http
                .get('/lodges/' + this.$route.params.id + '/seasons')
                .then((seasons) => {
                    this.seasons = seasons.data.data
                })
        },
        setContractedRating() {
            this.loading = true
            this.errors = {}
            const param = {
                contracted_rating: this.contracted_rating
            }
            this.$http
                .patch('/lodges/' + this.$route.params.id + '/contracted-rating', param)
                .then((response) => {
                    this.contracted_rating = response.data.data.contracted_rating
                    this.toastSuccess('Star Rating Successfully Updated')
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
        this.resetModal()
    }
}
</script>
