export function authHeader() {
    // return authorization header with basic auth credentials
    const user = JSON.parse(localStorage.getItem('user'))

    if (user) {
        return 'Bearer ' + user.access_token
    } else {
        return ''
    }
}
