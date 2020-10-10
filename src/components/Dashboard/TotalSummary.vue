<template>
    <div class="row mx-3">
        <b-col class="p-1">
            <div class="bg-white text-center mx-2 dash-card">
                <p class="dash-no" style="color: #f68e1f">{{permits.gorilla_permits}}</p>
                <p class="dash-text mb-0">Gorilla Permits</p>
            </div>
        </b-col>
        <b-col class="p-1">
            <div class="bg-white text-center mx-2 dash-card">
                <p class="dash-no" style="color: #00adef">{{permits.chimpanzee_permits}}</p>
                <p class="dash-text mb-0">Chimp Permits</p>
            </div>
        </b-col>
        <b-col class="p-1">
            <div class="bg-white text-center mx-2 dash-card">
                <p class="dash-no" style="color: #87c440">{{permits.golden_monkey_permits}}</p>
                <p class="dash-text mb-0">Golden Monkey</p>
            </div>
        </b-col>
        <b-col class="p-1">
            <div class="bg-white text-center mx-2 dash-card">
                <p class="dash-no" style="color: #ec008b">{{permits.gorilla_habituation}}</p>
                <p class="dash-text mb-0">Gorilla Habituation</p>
            </div>
        </b-col>
        <b-col class="p-1">
            <div class="bg-white text-center mx-2 dash-card">
                <p class="dash-no" style="color: #b877d4">{{permits.chimpanzee_habituation}}</p>
                <p class="dash-text mb-0">Chimp Habituation</p>
            </div>
        </b-col>
    </div>
</template>

<script>
export default {
    props: {
        permits: Object
    }
}
</script>

<style>
.dash-no {
    font-size: 40px;
}

.dash-text {
    color: #777676;
    font-size: 17px;
    font-family: Arial, Helvetica, sans-serif;
}

.dash-card {
    border: 2px solid #13111120;
    border-radius: 0.5rem;
    transition: box-shadow .3s;
}

.dash-card:hover {
    box-shadow: 0 5px 15px #dddbdb;
    cursor: pointer;
}
</style>
