<template>
    <div class="pricing text-right">
        <h5 class="m-3 float-left">Pricing Summary</h5>
        <b-table class="text-left" striped hover :items="items" table-variant="light"></b-table>
        <strong>Total Price: $50000</strong>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [ // prettier-ignore
                {
                    title: 'Uganda Gorilla Discovery - Gorilla Trekking',
                    travelers: '2 Adults',
                    price_per_person: 300,
                    total_price: 456700
                },
                {
                    title: 'Uganda Gorilla Discovery - Gorilla Trekking',
                    travelers: '2 Adults',
                    price_per_person: 300,
                    total_price: 456700
                },
                {
                    title: 'Uganda Gorilla Discovery - Gorilla Trekking',
                    travelers: '2 Adults',
                    price_per_person: 300,
                    total_price: 456700
                },
                {
                    title: 'Uganda Gorilla Discovery - Gorilla Trekking',
                    travelers: '2 Adults',
                    price_per_person: 300,
                    total_price: 456700
                }
            ]
        }
    }
}
</script>

<style>
.pricing {
    padding: 0px 10em;
}
</style>
