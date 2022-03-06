<!-- @format -->

<template>
    <b-container>
        <div class="pt-4 text-center">
            <div class="p-2">
                <b-button variant="outline-success" v-b-modal.lodge-photo-modal>
                    + Add Photos</b-button
                >
            </div>
            <div
                class="row px-3"
                id="lightgallery"
                v-infinite-scroll="getphotos"
                infinite-scroll-disabled="notify_busy"
                infinite-scroll-distance="10"
                style="max-height: 600px; overflow-y: auto"
            >
                <div
                    class="col-md-4 col-6 p-2 content"
                    v-for="photo in photos"
                    :key="photo.name"
                    :data-src="getPhotoUrl(photo.name)"
                    :data-sub-html="`<h2>${photo.title}</h2><p>${photo.description}</p>`"
                >
                    <div class="gallery-item">
                        <img v-lazy="getPhotoUrl(photo.name)" />
                    </div>

                    <div class="content-overlay"></div>
                    <div class="content-details">
                        <h3>
                            <label class="content-title">{{ photo.title }}</label>
                        </h3>
                        <label class="content-text">{{ photo.description }} </label>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <b-button variant="outline-success" v-b-modal.lodge-photo-modal>
                    + Add Photos</b-button
                >
            </div>
        </div>
        <AddLodgePhotos  :hidingModal="hidingModal"/>
    </b-container>
</template>

<script>
import AddLodgePhotos from '@/components/Modals/AddLodgePhotos.vue'
import infiniteScroll from 'vue-infinite-scroll'
import $ from 'jquery'
import 'lightgallery/dist/js/lightgallery.js'
import 'lightgallery/dist/css/lightgallery.min.css'
import 'lg-zoom'
import 'lg-thumbnail'
import 'lg-autoplay'
import 'lg-fullscreen'
import 'lg-rotate'
import 'lg-pager'

export default {
    data() {
        return {
            loading: false,
            errors: {},
            photos: [],
            next_photo_link: 1,
            photo_added: false
        }
    },
    components: {
        AddLodgePhotos
    },
    directives: {
        infiniteScroll
    },
    methods: {
        async getphotos(bypass = false) {
            if (this.next_photo_link || bypass) {
                const filters = {
                    page: this.next_photo_link
                }
                if ($('#lightgallery').data('lightGallery')) {
                    $('#lightgallery').data('lightGallery').destroy(true)
                }
                await this.$http
                    .get('/lodges/' + this.$route.params.id + '/photos', {
                        params: filters
                    })
                    .then((photos) => {
                        this.photos.push(...photos.data.data)
                        const next = photos.data.links.next
                        this.next_photo_link = next ? this.next_photo_link + 1 : null
                    })
                    .then((response) => {
                        $('#lightgallery').lightGallery()
                    })
            }
        },
        getPhotoUrl(filename) {
            return (
                process.env.VUE_APP_PROTOCOL +
                process.env.VUE_APP_APIURL +
                '/api/file/' +
                filename
            )
        },
        hidingModal(photoAdded) {
            if (photoAdded) {
                this.photos = []
                this.getphotos(true)
            }
        }
    },
    mounted() {
        // this.getphotos()
    }
}
</script>
