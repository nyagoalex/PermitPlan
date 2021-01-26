<!-- @format -->

<template>
    <div class="pb-5">
        <b-carousel
            class="carousel-1"
            v-model="slide"
            :interval="4000"
            controls
            background="#ababab"
            img-width="1024"
            img-height="450"
            style="text-shadow: 1px 1px 2px #333"
        >
            <b-carousel-slide
                img-src="https://picsum.photos/1024/480/?image=52"
            ></b-carousel-slide>
            <b-carousel-slide
                img-src="https://picsum.photos/1024/480/?image=12"
            ></b-carousel-slide>
            <b-carousel-slide
                img-src="https://picsum.photos/1024/480/?image=22"
            ></b-carousel-slide>
            <div class="carousel-div">
                <div class="content text-left p-5">
                    <b-row class="mr-4">
                        <b-col offset-md="1">
                            <p class="mb-4">
                                Uganda Gorilla Discovery - Gorilla Trekking
                            </p>
                            <small
                                >Trip duration:<span>
                                    {{ itinerary.days.length }} days</span
                                >
                                <span class="mx-3">|</span> Itinerary ref. #:<span>
                                    TC-QKS8GMAV</span
                                >
                                <span class="mx-3">|</span> Travelers:<span>
                                    2 adults</span
                                >
                            </small>
                        </b-col>
                        <b-col class="text-right pr-5"
                            >Total Price <br /><strong>{{
                                itinerary.total_cost | moneyFormat
                            }}</strong></b-col
                        >
                    </b-row>
                </div>
            </div>
        </b-carousel>
        <b-row class="days-list text-left mx-auto pb-4">
            <div
                class="col-6 pt-5 px-3"
                v-for="day in itinerary.days"
                v-bind:key="day.name"
            >
                <span style="color: gray">Day {{ day.priority }}</span
                ><br />
                <strong>{{ day.name }} </strong>
                <hr />
                <p style="color: #2f2e2e">{{ day.description | truncate(50) }}</p>
                <div>
                    <div
                        class="mt-2"
                        v-for="item in day.items"
                        v-bind:key="item.priority"
                    >
                        <!-- <b-icon
                            font-scale="1.7"
                            icon="exclamation-circle-fill"
                            variant="success"
                            class="circle-icon"
                        ></b-icon> -->
                        <b-iconstack font-scale="2">
                            <b-icon stacked icon="circle-fill" variant="success"></b-icon>
                            <b-icon
                                v-if="item.type === 'road transfer'"
                                stacked
                                icon="bell-fill"
                                scale="0.5"
                                variant="white"
                            ></b-icon>
                            <b-icon
                                v-if="item.type === 'flight transfer'"
                                stacked
                                icon="asterisk"
                                scale="0.5"
                                variant="white"
                            ></b-icon>
                            <b-icon
                                v-if="item.type === 'accomodation'"
                                stacked
                                icon="house-fill"
                                scale="0.5"
                                variant="white"
                            ></b-icon>
                            <b-icon
                                v-if="item.type === 'activity'"
                                stacked
                                icon="puzzle-fill"
                                scale="0.5"
                                variant="white"
                            ></b-icon>
                            <b-icon stacked icon="circle" variant="primary"></b-icon>
                        </b-iconstack>
                        <span class="activitylabel"> {{ item.text }}</span>
                    </div>
                </div>
            </div>
            <!-- <div class="col-6 pt-5 px-3">
                <span style="color: gray">Day 1</span><br />
                <strong>Depart for Bwindi Forest</strong>
                <hr />
                <p style="color: #2f2e2e">Bwindi Impenetrable National Park</p>
                <div>
                    <div>
                        <b-icon
                            font-scale="1.7"
                            icon="exclamation-circle-fill"
                            variant="success"
                        ></b-icon>
                        <span class="activitylabel">
                            Sanctuary Gorilla Forest Camp Uganda</span
                        >
                    </div>
                    <div class="mt-2">
                        <b-icon
                            font-scale="1.7"
                            icon="exclamation-circle-fill"
                            variant="success"
                        ></b-icon>
                        <span class="activitylabel">
                            Sanctuary Gorilla Forest Camp Uganda</span
                        >
                    </div>
                </div>
            </div>
            <div class="col-6 pt-5 px-3">
                <span style="color: gray">Day 1</span><br />
                <strong>Depart for Bwindi Forest</strong>
                <hr />
                <p style="color: #2f2e2e">Bwindi Impenetrable National Park</p>
                <div>
                    <div>
                        <b-icon
                            font-scale="1.7"
                            icon="exclamation-circle-fill"
                            variant="success"
                        ></b-icon>
                        <span class="activitylabel">
                            Sanctuary Gorilla Forest Camp Uganda</span
                        >
                    </div>
                    <div class="mt-2">
                        <b-icon
                            font-scale="1.7"
                            icon="exclamation-circle-fill"
                            variant="success"
                        ></b-icon>
                        <span class="activitylabel">
                            Sanctuary Gorilla Forest Camp Uganda</span
                        >
                    </div>
                </div>
            </div> -->
        </b-row>
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
.days-list {
    max-width: 1022px;
    padding: 0px 16px;
}

.days-list hr {
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: -1.5em;
    margin-right: 2em;
    border-style: inset;
    border-width: 1px;
    background-color: green;
}

.days-list .activitylabel {
    font-size: 15px;
    color: #524b4b;
}

.carousel-div {
    position: absolute;
    z-index: 2;
    width: 100%;
    bottom: 80px;
}

.carousel-div .content {
    background-color: rgba(0, 0, 0, 0.65);
    color: rgb(255, 255, 255);
    line-height: 18px;
    min-height: 200px;
    width: 100%;
    flex-flow: row wrap;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
}
</style>
