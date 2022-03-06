<template>
<div class="bg-white text-left mt-3 mx-4">
    <div v-if="loading" class="my-5 text-center"><b-icon icon="arrow-clockwise" animation="spin" font-scale="4"></b-icon>Loading ...</div>
    <div v-else-if="!lodges.length" class="my-5 text-center">
        <b-button
                    v-b-modal.new-lodge
                    variant="btn btn-outline-success"
                    size="lg"
                    >+ Add a hotel</b-button
                >

            <h2 class="text-muted mt-5">NO HOTELS ADDED YET</h2>
        </div>
    <div v-else>
    <b-table :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="lodges" :fields="fields" caption-top :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm" @row-clicked="onRowClicked" class="acc-tb" sticky-header>
        <template v-slot:table-caption>
            <b-row>
                <b-col><span class='font-weight-bold'>Lodges + Hotels</span></b-col>
                <b-col>
                    <b-button v-b-modal.new-lodge class='float-right' size="sm" variant="success">
                        <b-icon icon="plus"></b-icon> Add Lodges / Hotels
                    </b-button>
                </b-col>
            </b-row>
        </template>
        <template v-slot:cell(#)="row"> {{ row.index + 1 }} </template>
        <template v-slot:cell(hotel_star_rating)="row">
            <span>
                <star-rating :rating="row.item.star_rating" :star-size="20" :read-only="true" :increment="0.01" :show-rating="false"></star-rating>
            </span>
        </template>
    </b-table>
    <div>
        <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
            <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
        <b-pagination class="float-right" v-model="current_page" :total-rows="total" :per-page="per_page" last-number @input="getLodges(current_page)"></b-pagination>
    </div>
    </div>
    <AddAccomodation/>
</div>
</template>

<script>
import AddAccomodation from '@/components/Modals/AddAccomodation.vue'
import StarRating from 'vue-star-rating'
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
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'code',
                    sortable: true
                },
                {
                    key: 'name',
                    sortable: true
                },
                {
                    key: 'email',
                    sortable: true
                },
                {
                    key: 'phone',
                    sortable: true
                },
                {
                    key: 'location',
                    sortable: true
                },
                {
                    key: 'hotel_star_rating',
                    sortable: true
                },
                {
                    key: 'contracted_rating',
                    sortable: true
                }
            ],
            lodges: [],
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS,
            loading: false
        }
    },
    components: {
        AddAccomodation,
        StarRating
    },
    methods: {
        getLodges(page = 1) {
            const filters = this.filters
            this.loading = true
            filters.page = page
            this.$http.get('/lodges', {
                params: filters
            }).then(lodges => {
                this.lodges = lodges.data.data
                const meta = lodges.data.meta
                this.current_page = meta.current_page
                this.per_page = meta.per_page
                this.total = meta.total
                this.loading = false
            })
        },
        onRowClicked(item, index, event) {
            this.$router.push({
                name: 'AccommodationDetails',
                params: {
                    id: item.id
                }
            })
        }
    },
    mounted() {
        this.getLodges()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Accommodations') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.search': function (val, oldVal) {
            this.getLodges()
        }
    }
}
</script>
