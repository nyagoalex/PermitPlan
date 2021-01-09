<!-- @format -->

<template>
    <div class="bg-light to-scroll" v-infinite-scroll="getLodges" infinite-scroll-disabled="busy" infinite-scroll-distance="10">
        <h4 v-if="!lodges.length" class="mt-5">No Lodges Available</h4>
        <div class="card task-item" v-for="(lodge, index) in lodges" :key="index">
            <div class="card-body">
                <b-row>
                    <b-col cols="1" class="pl-0 text-left">
                        <b-button variant="link" class="p-0" @click="addDayActivity('accomodation')" v-b-popover.hover.topright="'Add lodge to day activity'">
                            <b-icon font-scale="2" icon="arrow-left-circle"></b-icon>
                        </b-button>
                    </b-col>
                    <b-col class="text-left">
                        <span style="font-size: 1rem; text-transform: capitalize"> {{ lodge.name }}</span>
                        <small class="ml-3">{{ lodge.code }}</small
                        ><br />
                        <label class="text-muted"
                            >{{ lodge.location }} - {{ lodge.country }} <br />
                            <star-rating :rating="lodge.star_rating" :star-size="13" :read-only="true" :increment="0.01" :show-rating="false"></star-rating>
                        </label>
                    </b-col>
                </b-row>
            </div>
        </div>
    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll'
import EventBus from '@/Events/EventBus.js'
import StarRating from 'vue-star-rating'
export default {
    data() {
        return {
            lodges: [],
            busy: false,
            next_page: 1,
            filters: {
                search: null
            }
        }
    },
    components: {
        StarRating
    },
    methods: {
        getLodges() {
            if (this.next_page) {
                this.busy = true
                const filters = this.filters
                filters.page = this.next_page
                this.$http
                    .get('/lodges', {
                        params: filters
                    })
                    .then((lodges) => {
                        if (this.next_page === 1) {
                            this.lodges = lodges.data.data
                        } else {
                            this.lodges.push(...lodges.data.data)
                        }
                        const next = lodges.data.links.next
                        this.next_page = next ? this.next_page + 1 : null
                    })
                this.busy = false
            }
        }
    },
    props: {
        addDayActivity: Function
    },
    directives: {
        infiniteScroll
    },
    mounted() {
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'ItineraryDetails') {
                this.next_page = 1
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
