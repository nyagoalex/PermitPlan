<!-- @format -->

<template>
    <div
        class="bg-light to-scroll"
        v-infinite-scroll="getActivities"
        infinite-scroll-disabled="busy"
        infinite-scroll-distance="10"
    >
        <h4 v-if="!activities.length" class="mt-5">No Activities Available</h4>
        <div class="card task-item" v-for="(activity, index) in activities" :key="index">
            <div class="card-body">
                <b-row>
                    <b-col cols="1" class="pl-0 text-left">
                        <b-button
                            variant="link"
                            class="p-0"
                            @click="addDayActivity('activity')"
                            v-b-popover.hover.topright="'Add activity to day activity'"
                        >
                            <b-icon font-scale="2" icon="arrow-left-circle"></b-icon>
                        </b-button>
                    </b-col>
                    <b-col class="text-left">
                        <span style="font-size: 1rem; text-transform: capitalize">
                            {{ activity.name }}</span
                        >
                        <p class="text-muted">
                            {{ activity.location }} <br />
                            <small>{{ activity.description | truncate(70) }}</small>
                        </p>
                    </b-col>
                </b-row>
            </div>
        </div>
    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll'
import EventBus from '@/Events/EventBus.js'
export default {
    data() {
        return {
            activities: [],
            busy: false,
            next_page: 1,
            filters: {
                search: null
            }
        }
    },
    methods: {
        getActivities() {
            if (this.next_page) {
                this.busy = true
                const filters = this.filters
                filters.page = this.next_page
                this.$http
                    .get('/activities', {
                        params: filters
                    })
                    .then((activities) => {
                        if (this.next_page === 1) {
                            this.activities = activities.data.data
                        } else {
                            this.activities.push(...activities.data.data)
                        }
                        const next = activities.data.links.next
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
            this.getActivities()
        }
    }
}
</script>
