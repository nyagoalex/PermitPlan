<!-- @format -->

<template>
    <div class="bg-white text-left mt-3 mx-4">
        <b-table
            class="acc-tb"
            :striped="true"
            :outlined="true"
            :hover="true"
            :no-border-collapse="true"
            :items="itineraries"
            :fields="fields"
            caption-top
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            sort-icon-left
            responsive="sm"
            sticky-header
            @row-clicked="onRowClicked"
        >
            <template v-slot:table-caption>
                <b-row>
                    <b-col><span class="font-weight-bold">Itineraries</span></b-col>
                    <b-col class="text-center">
                        <b-button size="sm" variant="success">
                            <b-icon icon="plus"></b-icon> Build New Itinerary
                        </b-button>
                    </b-col>
                    <b-col>
                        <b-button
                            :pressed.sync="show_filters"
                            class="float-right"
                            variant="link"
                        >
                            <b-icon icon="funnel"></b-icon> show filters
                        </b-button>
                    </b-col>
                </b-row>
                <b-row
                    v-show="show_filters"
                    class="pt-3"
                    style="height: 50px; background-color: #f5f9f7"
                >
                    <b-col>
                        <b>Status: </b>
                        <b-badge
                            pill
                            :variant="`${filters.active === null ? 'primary' : 'light'}`"
                            :class="{
                                'bg-white': !filters.active === null,
                                'ml-2': true
                            }"
                            @click="filters.active = null"
                            >All</b-badge
                        >
                        <b-badge
                            pill
                            :variant="`${filters.active === true ? 'primary' : 'light'}`"
                            :class="{
                                'bg-white': !filters.active === true,
                                'ml-2': true
                            }"
                            @click="filters.active = true"
                            >Active</b-badge
                        >
                        <b-badge
                            pill
                            :variant="`${filters.active === false ? 'primary' : 'light'}`"
                            :class="{
                                'bg-white': !filters.active === false,
                                'ml-2': true
                            }"
                            @click="filters.active = false"
                            >Inactive</b-badge
                        >
                    </b-col>
                </b-row>
            </template>
            <template v-slot:cell(#)="row">
                {{ row.index + 1 }}
            </template>
            <template v-slot:cell(status)="row">
                <b-badge pill variant="success" v-if="row.item.active">Active</b-badge>
                <b-badge pill variant="danger" v-else>Inactive</b-badge>
            </template>
        </b-table>
        <div>
            <b-pagination
                class="float-right"
                v-model="current_page"
                :total-rows="total"
                :per-page="per_page"
                last-number
                @input="getItineraries(current_page)"
            ></b-pagination>
        </div>
    </div>
</template>

<script>
import EventBus from '@/Events/EventBus.js'

export default {
    data() {
        return {
            sortBy: 'code',
            sortDesc: false,
            show_filters: false,
            filters: {
                active: null,
                search: null
            },
            fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'ref_no',
                    sortable: true
                },
                {
                    key: 'date',
                    sortable: true,
                    stickyColumn: true
                },
                {
                    key: 'title',
                    sortable: true
                },
                {
                    key: 'status'
                }
            ],
            itineraries: [],
            // itinerary: this.resetModal(),
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS
        }
    },
    methods: {
        getItineraries(page = 1) {
            const filters = this.filters
            filters.page = page
            this.$http
                .get('/itineraries', {
                    params: filters
                })
                .then((itineraries) => {
                    this.itineraries = itineraries.data.data
                    const meta = itineraries.data.meta
                    this.current_page = meta.current_page
                    this.per_page = meta.per_page
                    this.total = meta.total
                })
        },
        onRowClicked(item, index, event) {
            this.$router.push({
                name: 'OffTheSelfItineraryDetails',
                params: {
                    id: item.id
                }
            })
        }
        // deleteItinerary(id) {
        //     this.ConfirmDelete().then((result) => {
        //         if (result.value) {
        //             this.$http.delete('/itineraries/' + id).then(() => {
        //                 this.itineraries = this.itineraries.filter(
        //                     (item) => item.id !== id
        //                 )
        //                 this.$swal.fire(
        //                     'Deleted!',
        //                     'Itinerary has been deleted.',
        //                     'success'
        //                 )
        //             })
        //         }
        //     })
        // },
        // deactivateItinerary(id) {
        //     const index = this.itineraries.findIndex((item) => item.id === id)
        //     this.$swal
        //         .fire({
        //             title: 'Deactivate Itinerary?',
        //             text: 'Are you sure you want to perform this action',
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, deactivate it!',
        //             reverseButtons: true
        //         })
        //         .then((result) => {
        //             if (result.value) {
        //                 this.$http
        //                     .delete('/itineraries/' + id + '/deactivate')
        //                     .then(() => {
        //                         this.$set(this.itineraries[index], 'active', false)
        //                         this.$swal.fire(
        //                             'Deactivated!',
        //                             'Itinerary has been deactivated.',
        //                             'success'
        //                         )
        //                     })
        //             }
        //         })
        // },
        // activateItinerary(id) {
        //     const index = this.itineraries.findIndex((item) => item.id === id)
        //     this.$swal
        //         .fire({
        //             title: 'Activate Itinerary?',
        //             text: 'Are you sure you want to perform this action',
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, activate it!',
        //             reverseButtons: true
        //         })
        //         .then((result) => {
        //             if (result.value) {
        //                 this.$http.post('/itineraries/' + id + '/activate').then(() => {
        //                     this.$set(this.itineraries[index], 'active', true)
        //                     this.$swal.fire(
        //                         'Activated!',
        //                         'Itinerary has been activated.',
        //                         'success'
        //                     )
        //                 })
        //             }
        //         })
        // },
        // newItineraryModal() {
        //     this.itinerary = this.resetModal()
        //     this.mode = 'create'
        //     this.$bvModal.show('new-itinerary')
        // },
        // editItineraryModal(itinerary) {
        //     this.itinerary = itinerary
        //     this.mode = 'update'
        //     this.$bvModal.show('new-itinerary')
        // },
        // resetModal() {
        //     return {
        //         name: '',
        //         code: '',
        //         country: '',
        //         city: '',
        //         phone: '',
        //         no_of_booking: '',
        //         email: ''
        //     }
        // }
    },
    mounted() {
        this.getItineraries()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Itineraries') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.active': function (val, oldVal) {
            this.getItineraries()
        },
        'filters.search': function (val, oldVal) {
            this.getItineraries()
        }
    }
}
</script>
