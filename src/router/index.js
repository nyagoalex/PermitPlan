import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '@/views/Home.vue'
import About from '@/views/About.vue'
import Login from '@/views/Login/Login.vue'
import Register from '@/views/Login/Register.vue'
import Bookings from '@/views/Booking/BookingsList.vue'
import BookingDetails from '@/views/Booking/Details.vue'
import Settings from '@/views/Settings/Settings.vue'
import Profile from '@/views/Login/Profile.vue'
import Agents from '@/views/Agents.vue'
import GroupPermits from '@/views/GroupPermits.vue'
import Accommodation from '@/views/Accommodation.vue'
import AccommodationDetails from '@/views/AccommodationDetails.vue'
import Transfers from '@/views/Transfers.vue'
import Vehicles from '@/views/Vehicles.vue'
import Guides from '@/views/Guides.vue'
import Calenda from '@/views/Calenda.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/bookings',
        name: 'Bookings',
        component: Bookings
    },
    {
        path: '/bookings/:id',
        name: 'BookingDetails',
        component: BookingDetails
    },
    {
        path: '/settings',
        name: 'Settings',
        component: Settings
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile
    },
    {
        path: '/agents',
        name: 'Agents',
        component: Agents
    },
    {
        path: '/group-permits',
        name: 'GroupPermits',
        component: GroupPermits
    },
    {
        path: '/accommodations',
        name: 'Accommodations',
        component: Accommodation
    },
    {
        path: '/accommodations/:id',
        name: 'AccommodationDetails',
        component: AccommodationDetails
    },
    {
        path: '/transfers',
        name: 'Transfers',
        component: Transfers
    },
    {
        path: '/vehicles',
        name: 'Vehicles',
        component: Vehicles
    },
    {
        path: '/guides',
        name: 'Guides',
        component: Guides
    },
    {
        path: '/calenda',
        name: 'Calenda',
        component: Calenda
    },
    { // catch all 404 - define at the very end
        path: '*',
        name: 'NotFound',
        component: () => import('@/views/NotFound.vue')
    }
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

router.beforeEach((to, from, next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['Login', 'Register']
    const authRequired = !publicPages.includes(to.name)
    const loggedIn = localStorage.getItem('user')

    if (authRequired && !loggedIn) {
        return next({
            path: '/login',
            query: { returnUrl: to.path }
        })
    }

    next()
})
export default router
