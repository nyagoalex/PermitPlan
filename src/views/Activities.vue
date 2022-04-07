<!-- @format -->

<template>
    <div class="bg-white text-left mt-3 mx-4">
        <div v-if="loading" class="my-5 text-center"><b-icon icon="arrow-clockwise" animation="spin" font-scale="4"></b-icon>Loading ...</div>
    <div v-else-if="!activities.length" class="my-5 text-center">
        <b-button
                    @click="newActivityModal"
                    variant="btn btn-outline-success"
                    size="md"
                    >+ Add an activity</b-button
                >

            <!-- <h2 class="text-muted mt-5">NO ACTIVITIES ADDED YET</h2> -->
            <div class="container py-5" style="padding-left:100px;padding-right:100px;">

                <div class="">
                <div class="d-flex align-items-center rounded py-3 px-5 bg-info-light">
                    <span class="svg-icon svg-icon svg-icon-3x svg-icon-warning me-5" style="">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mh-50px"><rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="orange"></rect><rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="orange"></rect><rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="orange"></rect>
                </svg>
                </span>
                <div class="" style="font-size:20px;padding-left:10px;color: #8e887a;">
                     No activities have been added to your system. Please add some activities
                </div>

                </div>
                </div>
                </div>
        </div>
    <div v-else>
        <b-table
            class="acc-tb"
            :striped="true"
            :outlined="true"
            :hover="true"
            :no-border-collapse="true"
            :items="activities"
            :fields="fields"
            caption-top
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            sort-icon-left
            responsive="sm"
            sticky-header
            @row-clicked="
                (activity) => $set(activity, '_showDetails', !activity._showDetails)
            "
        >
            <template v-slot:table-caption>
                <b-row>
                    <b-col><span class="font-weight-bold">Activities</span></b-col>
                    <b-col class="text-right">
                        <b-button @click="newActivityModal" size="sm" variant="success">
                            <b-icon icon="plus"></b-icon> Add Activity
                        </b-button>
                    </b-col>
                </b-row>
            </template>
            <template v-slot:cell(#)="row">
                {{ row.index + 1 }}
            </template>
            <template v-slot:cell(description)="row"
                >{{ row.item.description | truncate(20) }}
            </template>
            <template v-slot:row-details="row">
                <b-row>
                    <b-col class="small-time">Added on: {{ row.item.created_at }}</b-col>
                    <b-col class="small-time">Edited on: {{ row.item.updated_at }}</b-col>
                    <b-col class="text-center">
                        <b-button
                            pill
                            size="sm"
                            variant="outline-primary"
                            @click="editActivityModal(row.item)"
                            class="mr-4"
                            >Edit</b-button
                        >
                        <b-button
                            pill
                            size="sm"
                            variant="outline-danger"
                            @click="deleteActivity(row.item.id)"
                        >
                            Delete</b-button
                        >
                    </b-col>
                </b-row>
            </template>
        </b-table>
        <div>
            <label
                >Sorting By: <b>{{ sortBy }}</b
                >, Sort Direction:
                <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label
            >
            <b-pagination
                class="float-right"
                v-model="current_page"
                :total-rows="total"
                :per-page="per_page"
                last-number
                @input="getActivities(current_page)"
            ></b-pagination>
        </div>
    </div>
        <AddActivity v-bind:activity="activity" v-bind:mode="mode" />
    </div>
</template>

<script>
import AddActivity from '@/components/Modals/AddActivity.vue'
import EventBus from '@/Events/EventBus.js'

export default {
    data() {
        return {
            sortBy: 'code',
            sortDesc: false,
            show_filters: false,
            filters: {
                search: null
            },
            fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'name',
                    sortable: true,
                    stickyColumn: true
                },
                {
                    key: 'location',
                    sortable: true
                },
                {
                    key: 'cost_per_person',
                    sortable: true
                },
                {
                    key: 'description',
                    sortable: true
                }
            ],
            activities: [],
            activity: this.resetModal(),
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS,
            loading: false

        }
    },
    components: {
        AddActivity
    },
    methods: {
        getActivities(page = 1) {
            this.loading = true
            const filters = this.filters
            filters.page = page
            this.$http
                .get('/activities', {
                    params: filters
                })
                .then((activities) => {
                    this.activities = activities.data.data
                    const meta = activities.data.meta
                    this.current_page = meta.current_page
                    this.per_page = meta.per_page
                    this.total = meta.total
                    this.loading = false
                })
        },
        deleteActivity(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/activities/' + id).then(() => {
                        this.activities = this.activities.filter((item) => item.id !== id)
                        this.$swal.fire(
                            'Deleted!',
                            'Activity has been deleted.',
                            'success'
                        )
                    })
                }
            })
        },
        newActivityModal() {
            this.activity = this.resetModal()
            this.mode = 'create'
            this.$bvModal.show('new-activity')
        },
        editActivityModal(activity) {
            this.activity = activity
            this.mode = 'update'
            this.$bvModal.show('new-activity')
        },
        resetModal() {
            return {
                name: '',
                code: '',
                country: '',
                city: '',
                phone: '',
                no_of_booking: '',
                email: ''
            }
        }
    },
    mounted() {
        this.getActivities()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Activities') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.search': function (val, oldVal) {
            this.getActivities()
        }
    }
}
</script>
