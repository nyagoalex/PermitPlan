<template>
    <span @click="logout">Logout</span>
</template>

<script>
import router from '@/router'
export const Logout = {
    logout
}
export default {
    name: 'Logout',
    // isLoggedIn: true,
    props: {
        msg: String
    },
    methods: {
        logout: function () {
            const http = this.$http
            logout(http)
        }
    }
}

function logout(http) {
    console.log('logout')
    http.post('/auth/logout')
        .finally(function () {
            localStorage.clear()
            delete http.defaults.headers.common.Authorization
            if (router.currentRoute.name !== 'Login') {
                router.push({
                    name: 'Login'
                })
            }
        })
}
</script>
