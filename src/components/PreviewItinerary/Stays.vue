<template>
    <div>
        <div class="stays text-left" v-for="(i) in 3" :key="i">
            <b-row class="item  bg-light border-bottom-1 border-top-0 border border-success">
                <strong class="title"> Day 1 - Day 2</strong>
            </b-row>
            <b-row class="item-details">
                <b-col><img src="https://picsum.photos/1024/480/?image=52" class="rounded img-details" height="280" alt="ggg"></b-col>
                <b-col class="mt-4">
                    <p style="color:green; font-size:1.2em;" class="mb-1">Sanctuary Gorilla Forest Camp Uganda</p>
                    <p class="mb-1">
                        <b-icon font-scale="1" icon="geo-alt" variant="success" class="link"></b-icon> Uganda
                        - <small class="text-success link"> Show on map</small>
                    </p>
                    <p class="mb-1">
                        <b-icon icon="stopwatch" variant="success"></b-icon> 1 night
                        <b-icon class="ml-3" icon="people" variant="success"></b-icon> 2 adults
                    </p>
                    <p class="images mt-5 mb-0 pl-2 text-secondary"><small>More images:</small> </p>
                    <b-row class="images">
                        <b-col>
                            <img src="https://picsum.photos/1024/480/?image=52" class="rounded img-more mx-1" alt="ggg">
                            <img src="https://picsum.photos/1024/480/?image=52" class="rounded img-more mx-1" alt="ggg">
                            <img src="https://picsum.photos/1024/480/?image=52" class="rounded img-more mx-1" alt="ggg">
                            <img src="https://picsum.photos/1024/480/?image=52" class="rounded img-more mx-1" alt="ggg">
                            <img src="https://picsum.photos/1024/480/?image=52" class="rounded img-more mx-1" alt="ggg">
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<style>
.stays .item {
    padding: .4em 11em;
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
