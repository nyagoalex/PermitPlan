<!-- @format -->

<template>
    <div class="pricing justify-content-center">
        <h5 class="m-3 block">Pricing Details</h5><br>
        <div class="card justify-content-center" style="width: 70%;">
            <div class="card-body text-center ">
                <div class="card-titled d-flex justify-content-center"> <h1><strong>{{ itinerary.total_cost | moneyFormat }}</strong></h1></div>
                <p class="card-text">Total Price</p>
            </div>
        </div>
        <!-- <b-table
            class="text-left"
            striped
            hover
            :items="[{ type: 'to', cost: 1800 }]"
            table-variant="light"
        ></b-table> -->
        <!-- <strong>Total Price: {{ itinerary.total_cost | moneyFormat }}</strong>{{itinerary.summary}} -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            // items: [
            //     // prettier-ignore
            //     {
            //         title: 'Uganda Gorilla Discovery - Gorilla Trekking',
            //         travelers: '2 Adults',
            //         price_per_person: 300,
            //         total_price: 456700
            //     },
            //     {
            //         title: 'Uganda Gorilla Discovery - Gorilla Trekking',
            //         travelers: '2 Adults',
            //         price_per_person: 300,
            //         total_price: 456700
            //     },
            //     {
            //         title: 'Uganda Gorilla Discovery - Gorilla Trekking',
            //         travelers: '2 Adults',
            //         price_per_person: 300,
            //         total_price: 456700
            //     },
            //     {
            //         title: 'Uganda Gorilla Discovery - Gorilla Trekking',
            //         travelers: '2 Adults',
            //         price_per_person: 300,
            //         total_price: 456700
            //     }
            // ]
        }
    },
    props: {
        itinerary: Object
    }
}
</script>

<style>
.pricing {
    padding: 0px 10em;
}
</style>
