<template>
    <div class="bg-white text-left mt-3 mx-4">
            <div v-if="loading" class="my-5 text-center"><b-icon icon="arrow-clockwise" animation="spin" font-scale="4"></b-icon>Loading ...</div>
    <div v-else-if="!agents.length" class="my-5 text-center">
        <b-button
                    @click="newAgentModal"
                    variant="btn btn-outline-success"
                    size="lg"
                    >+ Add an agent</b-button
                >

            <h2 class="text-muted mt-5">NO AGENTS ADDED YET</h2>
        </div>
    <div v-else>
        <b-table class="acc-tb" :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="agents" :fields="fields" caption-top :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm" sticky-header @row-clicked="agent=>$set(agent, '_showDetails', !agent._showDetails)">
            <template v-slot:table-caption>
                <b-row>
                    <b-col><span class='font-weight-bold'>Agents</span></b-col>
                    <b-col class='text-center'>
                        <b-button @click="newAgentModal" size="sm" variant="success">
                            <b-icon icon="plus"></b-icon> Add Agent
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
                        <b-badge pill :variant="`${(filters.active === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === null, 'ml-2': true }" @click="filters.active = null">All</b-badge>
                        <b-badge pill :variant="`${(filters.active === true) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === true, 'ml-2': true }" @click="filters.active = true">Active</b-badge>
                        <b-badge pill :variant="`${(filters.active === false) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === false, 'ml-2': true }" @click="filters.active = false">Inactive</b-badge>

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
            <template v-slot:cell(bookings)="row">{{row.item.bookings_count}} </template>
            <template v-slot:row-details="row">
                <b-row>
                    <b-col><strong>Country: </strong> {{row.item.country}}</b-col>
                    <b-col><strong>Email: </strong> {{row.item.email}}</b-col>
                    <b-col class="small-time">Added on: {{row.item.created_at}}<br> Edited on: {{row.item.updated_at}}</b-col>
                    <b-col class="text-center">
                        <b-button pill size="sm" variant="outline-warning" v-if="row.item.active" @click="deactivateAgent(row.item.id)" class="mr-4">Deactivate</b-button>
                        <b-button pill size="sm" variant="outline-success" v-else @click="activateAgent(row.item.id)" class="mr-4">Activate</b-button>
                        <b-button pill size="sm" variant="outline-primary" @click="editAgentModal(row.item)" class="mr-4">Edit</b-button>
                        <b-button pill size="sm" variant="outline-danger" @click="deleteAgent(row.item.id)"> Delete</b-button>
                    </b-col>
                </b-row>
            </template>
        </b-table>
        <div>
            <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
                <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
            <b-pagination class="float-right" v-model="current_page" :total-rows="total" :per-page="per_page" last-number @input="getAgents(current_page)"></b-pagination>
        </div>
    </div>
        <AddAgent v-bind:agent="agent" v-bind:mode="mode" />
    </div>
</template>

<script>
import AddAgent from '@/components/Modals/AddAgent.vue'
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
            fields: [ // prettier-ignore
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
                    sortable: true,
                    stickyColumn: true
                },
                {
                    key: 'city',
                    sortable: true
                },
                {
                    key: 'phone',
                    sortable: true
                },
                {
                    key: 'bookings',
                    sortable: true
                },
                {
                    key: 'status'
                }
            ],
            agents: [],
            agent: this.resetModal(),
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS,
            loading: false
        }
    },
    components: {
        AddAgent
    },
    methods: {
        getAgents(page = 1) {
            this.loading = true
            const filters = this.filters
            filters.page = page
            this.$http.get('/agents', {
                params: filters
            }).then(agents => {
                this.agents = agents.data.data
                const meta = agents.data.meta
                this.current_page = meta.current_page
                this.per_page = meta.per_page
                this.total = meta.total
                this.loading = false
            })
        },
        deleteAgent(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/agents/' + id).then(() => {
                        this.agents = this.agents.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Agent has been deleted.', 'success')
                    })
                }
            })
        },
        deactivateAgent(id) {
            const index = this.agents.findIndex(item => item.id === id)
            this.$swal.fire({
                title: 'Deactivate Agent?',
                text: 'Are you sure you want to perform this action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, deactivate it!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    this.$http.delete('/agents/' + id + '/deactivate').then(() => {
                        this.$set(this.agents[index], 'active', false)
                        this.$swal.fire('Deactivated!', 'Agent has been deactivated.', 'success')
                    })
                }
            })
        },
        activateAgent(id) {
            const index = this.agents.findIndex(item => item.id === id)
            this.$swal.fire({
                title: 'Activate Agent?',
                text: 'Are you sure you want to perform this action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, activate it!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    this.$http.post('/agents/' + id + '/activate').then(() => {
                        this.$set(this.agents[index], 'active', true)
                        this.$swal.fire('Activated!', 'Agent has been activated.', 'success')
                    })
                }
            })
        },
        newAgentModal() {
            this.agent = this.resetModal()
            this.mode = 'create'
            this.$bvModal.show('new-agent')
        },
        editAgentModal(agent) {
            this.agent = agent
            this.mode = 'update'
            this.$bvModal.show('new-agent')
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
        this.getAgents()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Agents') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.active': function (val, oldVal) {
            this.getAgents()
        },
        'filters.search': function (val, oldVal) {
            this.getAgents()
        }
    }
}
</script>
