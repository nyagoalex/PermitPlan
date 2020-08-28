<template>
<b-modal id="invoice-preview" hide-header size="xl">
    <InvoiceGist :company="company" />
    <template v-slot:modal-footer="{ cancel}">
        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
        <b-button size="sm" type="submit" variant="info" @click="generateReport">Print Invoice</b-button>
        <b-button size="sm" type="submit" variant="success">Save Invoice To PDF</b-button>
    </template>

    <vue-html2pdf :show-layout="false" :enable-download="true" :preview-modal="true" :paginate-elements-by-height="1400" filename="hee hee" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="auto" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="html2Pdf">
        <section slot="pdf-content">
            <InvoiceGist :company="company" />
        </section>
    </vue-html2pdf>
</b-modal>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
import InvoiceGist from '@/components/Bookings/Modals/InvoiceGist.vue'

export default {
    data() {
        return {
            items: [
                {
                    description: 'Website design',
                    quantity: 1,
                    price: 300
                },
                {
                    description: 'Website design',
                    quantity: 1,
                    price: 75
                },
                {
                    description: 'Website design',
                    quantity: 1,
                    price: 10
                }
            ],
            company: {}
        }
    },
    components: {
        VueHtml2pdf,
        InvoiceGist
    },
    computed: {
        total() {
            return this.items.reduce(
                (acc, item) => acc + item.price * item.quantity,
                0
            )
        }
    },
    methods: {
        addRow() {
            this.items.push({
                description: '',
                quantity: 1,
                price: 0
            })
        },
        generateReport() {
            this.$refs.html2Pdf.generatePdf()
        },
        getCompanyDetails() {
            this.$http.get('/settings').then(settings => {
                this.company = settings.data.data
            })
        }
    },
    filters: {
        currency(value) {
            return value.toFixed(2)
        }
    },
    mounted: function () {
        this.getCompanyDetails()
    }
}
</script>

<style>
#invoice-preview .modal-body {
    padding: 0px !important;
}
</style>
