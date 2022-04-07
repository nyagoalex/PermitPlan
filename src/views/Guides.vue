<template>
<div class="bg-white text-left mt-3 mx-4">
           <div v-if="loading" class="my-5 text-center"><b-icon icon="arrow-clockwise" animation="spin" font-scale="4"></b-icon>Loading ...</div>
    <div v-else-if="!guides.length" class="my-5 text-center">
        <b-button
                    v-b-modal.new-guide
                    variant="btn btn-outline-success"
                    size="md"
                    >+ Add a guide</b-button
                >
            <!-- <h2 class="text-muted mt-5">NO GUIDES ADDED YET</h2> -->
<div class="container py-5" style="padding-left:100px;padding-right:100px;">
                <div class="">
                <div class="d-flex align-items-center rounded py-3 px-5 bg-info-light">
                    <span class="svg-icon svg-icon svg-icon-3x svg-icon-warning me-5" style="">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mh-50px"><rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="orange"></rect><rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="orange"></rect><rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="orange"></rect>
                </svg>
                </span>
                <div class="" style="font-size:20px;padding-left:10px;color: #8e887a;">
                     No guides have been added to your system. Please add some guides details
                </div>
                </div>
                </div>
                </div>

        </div>
    <div v-else>
    <b-table class="acc-tb" :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="guides" :fields="fields" caption-top :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm" sticky-header @row-clicked="item=>$set(item, '_showDetails', !item._showDetails)">
        <template v-slot:table-caption>
            <b-row>
                <b-col><span class='font-weight-bold'>Tour Guide</span></b-col>
                <b-col class='text-center'>
                    <b-button v-b-modal.new-guide size="sm" variant="success">
                        <b-icon icon="plus"></b-icon> Add Tour Guide
                    </b-button>
                </b-col>
                <b-col>
                    <b-button :pressed.sync="show_filters" class='float-right' variant="link">
                        <b-icon icon="funnel"></b-icon> show filters
                    </b-button>
                </b-col>
            </b-row>
            <b-row v-show="show_filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
                <b-col>
                    <b>Status: </b>
                    <b-badge pill :variant="`${(filters.status === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != null, 'ml-2': true }" @click="filters.status = null">All</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'working') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'working', 'ml-2': true }" @click="filters.status = 'working'">Working</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'terminated') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'terminated', 'ml-2': true }" @click="filters.status = 'terminated'">Teminated</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'probation') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'probation', 'ml-2': true }" @click="filters.status = 'probation'">On Probation</b-badge>
                </b-col>
                <b-col class='text-right'>
                    <b>Contract Basis: </b>
                    <b-badge pill :variant="`${(filters.contract_basis === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.contract_basis != null, 'ml-2': true }" @click="filters.contract_basis = null">All</b-badge>
                    <b-badge pill :variant="`${(filters.contract_basis === 'full_time') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.contract_basis != 'full_time', 'ml-2': true }" @click="filters.contract_basis = 'full_time'">Full Time</b-badge>
                    <b-badge pill :variant="`${(filters.contract_basis === 'freelancer') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.contract_basis != 'freelancer', 'ml-2': true }" @click="filters.contract_basis = 'freelancer'">Freelancer</b-badge>
                </b-col>
            </b-row>
        </template>
        <template v-slot:cell(#)="row"> {{ row.index + 1 }} </template>
        <template v-slot:cell(name)="row"> {{ row.item.full_name}} </template>
        <template v-slot:cell(status)="row">
            <span :class="{ badge: true, 'badge-success': row.item.status == 'working', 'badge-danger': row.item.status == 'terminated', 'badge-warning': row.item.status == 'probation'}">
                {{ row.item.status}}</span>
        </template>
        <template v-slot:row-details="row">
            <b-row>
                <b-col><strong>Age: </strong> {{row.item.age}}</b-col>
                <b-col><strong>Email: </strong> {{row.item.email}}</b-col>
                <b-col><strong>Contract Basis: </strong>{{row.item.contract_basis.replace("_", " ")}} </b-col>
                <b-col class="text-center">
                    <b-button pill size="sm" variant="info" class="mr-4" v-b-modal.guide-details @click="guide = row.item">
                        <b-icon icon="info-circle-fill"> </b-icon> View
                    </b-button>
                    <b-button pill size="sm" variant="danger" @click="deleteGuides(row.item.id)">
                        <b-icon icon="trash-fill"> </b-icon> Delete
                    </b-button>
                </b-col>
            </b-row>
        </template>
    </b-table>
    <div>
        <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
            <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
        <b-pagination class="float-right" v-model="current_page" :total-rows="total" :per-page="per_page" last-number @input="getGuides(current_page)"></b-pagination>
    </div>
    </div>
    <AddGuide />
    <GuideDetails v-if="guide" :guide="guide" />
</div>
</template>

<script>
import AddGuide from '@/components/Modals/AddGuide.vue'
import GuideDetails from '@/components/Modals/GuideDetails.vue'
import EventBus from '@/Events/EventBus.js'

export default {
    data() {
        return {
            sortBy: 'experience_since',
            sortDesc: false,
            filters: {
                status: null,
                contract_basis: null,
                page: 1,
                search: null
            },
            show_filters: false,
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
                    key: 'phone',
                    sortable: true
                },
                // { key: 'email', sortable: true },
                // { key: 'age', sortable: true },
                {
                    key: 'experience',
                    sortable: true
                },
                {
                    key: 'cost_per_day',
                    sortable: true
                },
                // { key: 'contract_basis', sortable: true },
                {
                    key: 'status'
                }
            ],
            guides: [],
            guide: false,
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS,
            loading: false
        }
    },
    components: {
        AddGuide,
        GuideDetails
    },
    methods: {
        getGuides(page = 1) {
            this.loading = true
            const filters = this.filters
            filters.page = page
            this.$http.get('/guides', {
                params: filters
            }).then(guides => {
                this.guides = guides.data.data
                const meta = guides.data.meta
                this.current_page = meta.current_page
                this.per_page = meta.per_page
                this.total = meta.total
                this.loading = false
            })
        },
        deleteGuides(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/guides/' + id).then(() => {
                        this.guides = this.guides.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Guides has been deleted.', 'success')
                    })
                }
            })
        },
        editGuideModal(guide) {
            this.guide = guide
            this.$bvModal.show('new-guide')
        }
    },
    mounted() {
        this.getGuides()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Guides') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.status': function (val, oldVal) {
            this.getGuides()
        },
        'filters.contract_basis': function (val, oldVal) {
            this.getGuides()
        },
        'filters.search': function (val, oldVal) {
            this.getGuides()
        }
    }
}
</script>
