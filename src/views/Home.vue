<template>
    <div class=" pt-3" style="background-color:#f6f9fc;">
        <Summary :permits="permits_totals" />
        <b-row class="mt-2">
            <PemitGraph />
            <Notifications />
        </b-row>
    </div>
</template>

<script>
import Summary from '@/components/Dashboard/TotalSummary.vue'
import PemitGraph from '@/components/Dashboard/PemitGraph.vue'
import Notifications from '@/components/Dashboard/Notifications.vue'
export default {
    name: 'Dashboard',
    data() {
        return {
            permits_totals: {}
        }
    },
    components: {
        Summary,
        PemitGraph,
        Notifications
    },
    methods: {
        getTotalPermits() {
            this.$http.get('reports/permits-total')
                .then(totals => {
                    this.permits_totals = totals.data
                })
        }
    },
    mounted() {
        this.getTotalPermits()
    }
}
</script>
