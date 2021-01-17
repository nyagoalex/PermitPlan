<!-- @format -->

<template>
    <div class="bg-white text-left mt-3 mx-4">
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
            total: process.env.VUE_APP_TOTALROWS
        }
    },
    components: {
        AddActivity
    },
    methods: {
        getActivities(page = 1) {
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
