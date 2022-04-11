<template>
    <b-modal id="allocate-guides-modal" title="Allocate Guide" size="lg" hide-footer>
        <b-table
            :items="guides"
            :fields="all_guides_fields"
            :striped="true"
            :responsive="true"
            no-border-collapse
            sticky-header
            sort-icon-left
        >
            <template v-slot:cell(#)="data">
                {{ data.index + 1 }}
            </template>
            <template v-slot:cell(payment_date)="row"> {{ row.item.date }} </template>
            <template v-slot:cell(paid_in_by)="row"> {{ row.item.user }} </template>
            <template v-slot:cell(action)="row">
                <span
                    class="badge badge-success"
                    v-if="allocatedGuides.includes(row.item.id)"
                    style="font-size: 12px"
                    >Allocated</span
                >
                <b-button v-else
                    size="lg"
                    class=""
                    @click="allocateGuide(row.item.id)"
                    pill
                    variant="outline-info"
                    >Allocate</b-button
                >
            </template>
        </b-table>
    </b-modal>
</template>

<script>

export default {
    data() {
        return {
            guides: [],
            loading: false,
            errors: {},
            all_guides_fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'full_name',
                    sortable: true
                },
                {
                    key: 'code',
                    sortable: true
                },
                {
                    key: 'cost_per_day',
                    sortable: true
                },
                {
                    key: 'status',
                    sortable: true
                },
                {
                    key: 'experience',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ]
        }
    },
    props: {
        allocatedGuides: Array
    },
    methods: {
        getGuides() {
            this.$http.get('/guides').then((guides) => {
                this.guides = guides.data.data
            })
        },
        allocateGuide(guideId) {
            this.loading = true
            this.errors = {}
            this.$http.post('/bookings/' + this.$route.params.id + '/guides/' + guideId)
                .then(response => {
                    this.alertAddSuccess()
                    this.allocatedGuides = response.data.data.map(i => i.id)
                    this.$parent.callBookings()
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    mounted() {
        this.getGuides()
    }
}
</script>
