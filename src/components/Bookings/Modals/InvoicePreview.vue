<!-- @format -->

<template>
    <b-modal id="invoice-preview" hide-header size="xl">
        <InvoiceGist :company="company" :booking="booking" />
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" type="submit" variant="info" @click="print"
                >Print Invoice</b-button
            >
            <b-button size="sm" type="submit" variant="success" @click="generateReport"
                >Save Invoice To PDF</b-button
            >
        </template>

        <vue-html2pdf
            :show-layout="false"
            :enable-download="true"
            :paginate-elements-by-height="2500"
            :filename="number"
            :pdf-quality="2"
            :manual-pagination="false"
            pdf-format="letter"
            pdf-orientation="landscape"
            pdf-content-width="auto"
            ref="html2Pdf"
        >
            <section slot="pdf-content">
                <InvoiceGist :company="company" :booking="booking" />
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
                // prettier-ignore
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
        number() {
            return this.booking.number === undefined
                ? null
                : this.booking.number.replace('B', '')
        }
    },
    props: {
        booking: Object
    },
    methods: {
        print() {
            window.print()
        },
        generateReport() {
            this.$refs.html2Pdf.generatePdf()
        }
    },
    filters: {
        currency(value) {
            return value.toFixed(2)
        }
    },
    mounted: function () {
        this.company = JSON.parse(localStorage.getItem('settings'))
    }
}
</script>

<style>
#invoice-preview .modal-body {
    padding: 0px !important;
}
</style>
