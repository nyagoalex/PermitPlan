<template>
<b-container-fluid class="bg-white text-left mt-3 fluid">
    <div class="pt-3">
        <b-tabs fill>
            <b-tab class="nav-item" title="Road Transfers">
                <Road />
            </b-tab>
            <b-tab class="nav-item" title="Flight Transfers">
                <Flight />
            </b-tab>
        </b-tabs>
    </div>
</b-container-fluid>
</template>

<script>
import Road from '@/components/Transfers/Road.vue'
import Flight from '@/components/Transfers/Flight.vue'

export default {
    components: {
        Road,
        Flight
    }
}
</script>

<style>
.nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}

.nav-link:hover,
.nav-link:focus {
    text-decoration: none;
}

.nav-tabs {
    border-bottom: 1px solid #39bdc8;
}

.nav-tabs .nav-item {
    margin-bottom: .5rem !important;
}

.nav-tabs .nav-link:hover,
.nav-tabs .nav-link:focus {
    /* border-color: #e9ecef #e9ecef #dee2e6; */
}

.nav-tabs .nav-link.active,
.nav-tabs .nav-item.show .nav-link {
    color: #fff;
    background-color: #39bdc8;
    /* border-color: #dee2e6 #dee2e6 #fff; */
}

/*  impproved   tabs*/
.nav-tabs {
    border-radius: 0px !important;
    background-color: #39bdc8;
}

.nav-tabs {
    border-bottom: 0 solid transparent;
}

.nav-tabs .nav-item {
    margin: .5rem;
}

.nav-tabs .nav-link:not(.active) {
    color:#fff !important;
    font-weight: 700;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
    border: none !important;
    border-radius: 8px !important;
}

.nav-tabs .nav-link {
    font-size: 1rem;
    font-weight: 700;
    border-radius: .5rem !important;
    padding: .5rem;
    transition: color .35s ease-out;
}
</style>
