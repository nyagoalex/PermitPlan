<template>
    <b-container class="bg-white text-left mt-3 fluid">
        <div class="">
            <!-- <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="accommodation">Lodges + Hotels</a></li>
          <li class="breadcrumb-item"><a href="#"><span class="l-name-label">
                      lodge name</span> (<span class="l-location-label">
                      location</span>)</a></li>
          <li class="breadcrumb-item active" aria-current="page">Details</li>
      </ol> -->
            <b-breadcrumb :items="breadcrumb_items"></b-breadcrumb>
            <div class="">
                <div class="bg-grey2 p-2" style="border-radius:4px;">

                    <span class="pl-2 hotel-name border-right pr-3"><span class="mr-3"><a href="#" @click="$router.push({name: 'Accommodations'})">
                                <b-icon icon="arrow-left"></b-icon>
                            </a></span><span class="l-name-label">
                            lodge name </span></span>
                    <span class="ml-4">
                        <star-rating :rating="star_rating" :increment="0.01" :star-size="20" :fixed-points="2" @rating-selected="setRating" :inline="true"></star-rating>
                    </span>
                </div>
            </div>
            <div class="pt-3">

                <b-tabs fill>
                    <b-tab class="nav-item" title="Lodge Details">
                        <Details :lodge="lodge" />
                    </b-tab>
                    <b-tab class="nav-item" title="The Rooms">
                        <Rooms :rooms="lodge.rooms" />
                    </b-tab>
                    <b-tab class="nav-item" title="Rates & Seasons">
                        <Rates :seasons="lodge.seasons" :contracted_rating="lodge.contracted_rating" />
                    </b-tab>

                    <b-tab class="nav-item" title="Photos">
                        <Photos />
                    </b-tab>

                    <b-tab class="nav-item" title="Facilities & Activities">
                        <Activities :activities="lodge.activities" :facilities="lodge.facilities" />
                    </b-tab>
                </b-tabs>
            </div>
        </div>
    </b-container>
</template>

<script>
import Details from '@/components/Accomodation/Details.vue'
import Rooms from '@/components/Accomodation/Rooms.vue'
import Rates from '@/components/Accomodation/Rates.vue'
import Photos from '@/components/Accomodation/Photos.vue'
import Activities from '@/components/Accomodation/Activities.vue'

import StarRating from 'vue-star-rating'
export default {
    data() {
        return {
            breadcrumb_items: this.breadcrumbItems(),
            lodge: {},
            star_rating: 0
        }
    },
    components: {
        Details,
        Rooms,
        Rates,
        Photos,
        Activities,
        StarRating
    },
    methods: {
        setRating: function (rating) {
            this.$http.patch('/lodges/' + this.$route.params.id + '/star-rating', {
                star_rating: rating
            }).then(() => {
                this.toastSuccess('Star Rating Successfully Updated')
            })
        },
        async getLodge() {
            await this.$http.get('/lodges/' + this.$route.params.id).then(lodge => {
                this.lodge = lodge.data.data
                this.star_rating = this.lodge.star_rating
            })
        },
        breadcrumbItems: function () {
            return [ // prettier-ignore
                {
                    text: 'Dashboard',
                    to: {
                        name: 'Dashboard'
                    }
                },
                {
                    text: 'Accommodations',
                    to: {
                        name: 'Accommodations'
                    }
                },
                {
                    text: 'Details',
                    active: true
                }
            ]
        }
    },
    mounted() {
        this.getLodge()
    }
}
</script>

<style>
.rating:not(:checked)>input {
    position: absolute;
    top: -9999px;
    clip: rect(0, 0, 0, 0);
}

.rating:not(:checked)>label {
    float: right;
    width: 1em;
    /* padding:0 .1em; */
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 120%;
    /* line-height:1.2; */
    color: #ddd;
}

.rating:not(:checked)>label:before {
    content: '★ ';
}

.rating>input:checked~label {
    color: #115D3B;

}

.rating:not(:checked)>label:hover,
.rating:not(:checked)>label:hover~label {
    color: #115D3B;

}

.rating>input:checked+label:hover,
.rating>input:checked+label:hover~label,
.rating>input:checked~label:hover,
.rating>input:checked~label:hover~label,
.rating>label:hover~input:checked~label {
    color: #115D3B;

}

.rating>label:active {
    position: relative;
    top: 2px;
    left: 2px;
}

.rating>label {
    margin-top: .5rem !important;
    margin-bottom: 0 !important;
}

.breadcrumb {
    background: rgba(245, 245, 245, 0);
    display: flex;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
    font-size: 12px;

}

.bg-grey2 {
    /*        background: #DCDBDB;*/
    /*        background: #FAF7F0;*/
    border: 1px solid #F1F0EE;
}

.hotel-name {
    font-size: 25px;
    color: #666;
    /*        text-shadow: 1px 0px #000;*/
}

.content .content-overlay {
    background: rgba(0, 0, 0, 0.7);
    position: absolute;
    height: 99%;
    width: 100%;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    opacity: 0;
    -webkit-transition: all 0.4s ease-in-out 0s;
    -moz-transition: all 0.4s ease-in-out 0s;
    transition: all 0.4s ease-in-out 0s;
}

.content:hover .content-overlay {
    opacity: 1;
    cursor: pointer;
}

.content-details {
    position: absolute;
    text-align: center;
    padding-left: 1em;
    padding-right: 1em;
    width: 100%;
    top: 80%;
    left: 50%;
    opacity: 0;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    -webkit-transition: all 0.3s ease-in-out 0s;
    -moz-transition: all 0.3s ease-in-out 0s;
    transition: all 0.3s ease-in-out 0s;
}

.content:hover .content-details {
    top: 50%;
    left: 50%;
    opacity: 1;
}

.content-details h3 {
    color: #fff;
    font-weight: 500;
    letter-spacing: 0.15em;
}

.content-details .content-title {
    text-transform: uppercase;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    width: 200px;
}

.content-details .content-text {
    color: #fff;
    font-size: 0.8em;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    width: 250px;
}

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
    border-bottom: 1px solid #dee2e6;
}

.nav-tabs .nav-item {
    margin-bottom: .5rem !important;
}

.nav-tabs .nav-link:hover,
.nav-tabs .nav-link:focus {
    border-color: #e9ecef #e9ecef #dee2e6;
}

.nav-tabs .nav-link.active,
.nav-tabs .nav-item.show .nav-link {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.tab-content>.tab-pane {
    display: none;
}

.tab-content>.active {
    display: block;
}

/*  impproved   tabs*/
.nav-tabs {
    border-radius: 0.5rem;
    background: #e9ecef;
}

.nav-tabs {
    border-bottom: 0 solid transparent;
}

.nav-tabs .nav-item {
    margin: .5rem;
}

.nav-tabs .nav-link:not(.active) {
    color: rgba(33, 37, 41, 0.5);
}

.nav-tabs .nav-link {
    font-size: 1rem;
    font-weight: 500;
    border-radius: .5rem !important;
    padding: .5rem;
    transition: color .35s ease-out;
}

.card {
    /*    position: relative;*/
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    /*    border: 1px solid #eff2f7;*/
    border: 1px solid #dee2e6 !important;
    border-radius: .65rem;
    /*    box-shadow: 0 0 1.25rem rgba(31, 45, 61, .05);*/
}

.rooms {
    padding: 16px 10px;
    background-color: transparent;
    border: 1px solid #94ACB9;
    color: #4C7F9C !important;
    font-size: 18px;
}

.season {
    padding: 16px 10px;
    background-color: transparent;
    border: 1px solid #94ACB9;
    color: #4C7F9C !important;
    font-size: 16px;
}

.bg-soft-success {
    background-color: rgba(12, 220, 185, 0.1) !important;
}

.icon-xs,
.icon-alt-xs {
    width: 1.5rem;
    height: 1.5rem;
    font-size: 0.75rem;
    line-height: 1.5rem;
    text-align: center;
}

.icon-text-xs,
.icon-alt-text-xs {
    font-size: 0.75rem;
}

.gallery-item {
    overflow: hidden;
    height: 300px;
    background-color: #f9f9f9;
}

.gallery-item img {
    height: 100%;
    cursor: pointer;
}

.form-control {
    color: #4a5568;
    font-size: 0.875rem;
    transition: all .2s ease;
}
</style>
