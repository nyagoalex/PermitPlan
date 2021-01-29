<!-- @format -->

<template>
    <div>
        <div
            class="stays text-left"
            v-for="day in itinerary.stays"
            v-bind:key="day.period"
        >
            <b-row
                class="item bg-light border-bottom-1 border-top-0 border border-success"
            >
                <strong class="title"> {{ day.period }}</strong>
            </b-row>
            <b-row
                class="item-details"
                v-for="(accomodation, index) in day.items"
                v-bind:key="index"
            >
                <b-col
                    ><img
                        :src="getPhotoUrl(accomodation.photos[0])"
                        class="rounded img-details"
                        height="280"
                        alt="ggg"
                /></b-col>
                <b-col class="mt-4">
                    <p style="color: green; font-size: 1.2em" class="mb-1">
                        {{ accomodation.name }}
                    </p>
                    <p class="mb-1">
                        <b-icon
                            font-scale="1"
                            icon="geo-alt"
                            variant="success"
                            class="link"
                        ></b-icon>
                        {{ accomodation.location }}, {{ accomodation.country }} -
                        <small class="text-success link"> Show on map</small>
                    </p>
                    <p class="mb-1">
                        <b-icon icon="stopwatch" variant="success"></b-icon>
                        {{ accomodation.duration }}
                        <b-icon class="ml-3" icon="person" variant="success"></b-icon>
                        {{ accomodation.children }} children
                        <b-icon class="ml-3" icon="people" variant="success"></b-icon>
                        {{ accomodation.adults }}
                        adults
                    </p>
                    <p class="images mt-5 mb-0 pl-2 text-secondary">
                        <small>More images:</small>
                    </p>
                    <b-row class="images">
                        <div style="max-width= 10px;">
                            <img
                                v-for="photo in accomodation.photos"
                                v-bind:key="photo"
                                :src="getPhotoUrl(photo)"
                                class="rounded img-more mx-1"
                                alt="ggg"
                            />
                        </div>
                    </b-row>
                </b-col>
            </b-row>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {}
    },
    props: {
        itinerary: Object
    },
    methods: {
        getPhotoUrl(filename) {
            return (
                process.env.VUE_APP_PROTOCOL +
                process.env.VUE_APP_APIURL +
                '/api/file/' +
                filename
            )
        }
    }
}
</script>
<style>
.stays .item {
    padding: 0.4em 11em;
}

.stays .item-details {
    padding: 2em 11em;
}

.stays .item .title {
    font-size: 1.3em;
}

.stays .item-details .img-details {
    width: inherit !important;
}

.stays .item-details .img-more {
    width: 70px;
    height: 70px;
}

.stays .item-details .link {
    cursor: pointer;
}
</style>
