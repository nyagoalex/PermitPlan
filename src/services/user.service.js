
// // import config from 'config'
// import { authHeader } from '@/services'

// export const userService = {
//     login,
//     logout,
//     getAll
// }

// function login(username, password) {
//     this.$http.post('/auth/token', {
//         username: username,
//         password: password
//     }).then(user => {
//         localStorage.setItem('user', JSON.stringify(user))
//         return user
//     }).catch(error => {
//         console.log(error)
//     })
// }

// function logout() {
//     // remove user from local storage to log user out
//     localStorage.clear()
// }

// function getAll() {
//     const requestOptions = {
//         method: 'GET',
//         headers: authHeader()
//     }
//     return fetch(this.$apiURL + '/users', requestOptions).then(handleResponse)
//     // ${config.apiUrl}
// }

// function handleResponse(response) {
//     return response.text().then(text => {
//         const data = text && JSON.parse(text)
//         if (!response.ok) {
//             if (response.status === 401) {
//                 // auto logout if 401 response returned from api
//                 logout()
//                 location.reload(true)
//             }

//             const error = (data && data.message) || response.statusText
//             return Promise.reject(error)
//         }
//         return data
//     })
// }
