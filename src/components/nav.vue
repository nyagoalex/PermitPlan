<template>
    <div>
        <b-navbar toggleable="lg" variant="faded" type="light" class="bg-white shadow-lg" style="max-height:60px;">
            <b-navbar-brand @click="$router.push({name: 'Dashboard'})" style="cursor:pointer"><img src="@/assets/image/pplanw.png" alt="Kitten" width="130" height="50"></b-navbar-brand>

            <b-navbar-nav>
                <b-nav-item @click="$router.push({name: 'Dashboard'})">Dashbord</b-nav-item>
                <b-nav-item @click="$router.push({name: 'Bookings'})">All Bookings</b-nav-item>
                <b-nav-item @click="$router.push({name: 'Calenda'})">Safari Calenda</b-nav-item>
                <b-nav-item-dropdown text="+ More" right>
                    <b-dropdown-item @click="$router.push({name: 'Agents'})">Agents</b-dropdown-item>
                    <b-dropdown-item @click="$router.push({name: 'GroupPermits'})">Departures Permits</b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item @click="$router.push({name: 'Accommodations'})">Lodges + Hotels</b-dropdown-item>
                    <b-dropdown-item @click="$router.push({name: 'Transfers'})">Transfers</b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item @click="$router.push({name: 'Vehicles'})">Vehicles</b-dropdown-item>
                    <b-dropdown-item @click="$router.push({name: 'Guides'})">Guides & Drivers</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-form>
                    <b-form-input size="sm" class="mr-sm-2" placeholder="Search" v-model="search"></b-form-input>
                    <!--<b-button size="sm" class="my-2 my-sm-0" @click="search(8)">Search</b-button> -->
                </b-nav-form>
                <b-button v-b-modal.new-booking variant="success" style="max-height:40px; padding:0px 30px;font-size:15px;">+ Add Booking</b-button>
                <b-nav-item-dropdown class="ml-4" right>
                    <!-- Using 'button-content' slot -->
                    <template v-slot:button-content>
                        <!-- <em>User</em> -->
                        <img v-bind="mainProps" rounded="circle" src="@/assets/image/user-ic.png" alt="">
                    </template>
                    <b-dropdown-item @click="$router.push({name: 'Profile'})">Profile</b-dropdown-item>
                    <b-dropdown-item @click="$router.push({name: 'Settings'})">Settings</b-dropdown-item>
                    <b-dropdown-item href="#">
                        <Logout />
                    </b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-navbar>
        <AddBooking />
    </div>
</template>

<script>
import Logout from '@/components/Logout'
import AddBooking from '@/components/Bookings/Modals/AddBooking.vue'
import EventBus from '@/Events/EventBus.js'
export default {
    data() {
        return {
            myStyle: {
                backgroundColor: '#16a085'
            },
            mainProps: {
                width: 35,
                height: 35,
                class: 'm1'
            },
            search: '',
            awaitingSearch: false
        }
    },
    components: {
        Logout,
        AddBooking
    },
    watch: {
        search: function (val) {
            if (!this.awaitingSearch) {
                setTimeout(() => {
                    EventBus.$emit('EVENT_SEARCH', this.search)
                    this.awaitingSearch = false
                }, 1000) // 1 sec delay
            }
            this.awaitingSearch = true
        }
    }
}
</script>
