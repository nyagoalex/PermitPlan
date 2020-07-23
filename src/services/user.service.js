
// import config from 'config'
import { authHeader } from '@/services'
import axios from 'axios'

export const userService = {
  login,
  logout,
  getAll
}
const apiUrl = process.env.VUE_APP_APIURL
function login (username, password) {
  axios.post(apiUrl + '/auth/token', {
    username: username,
    password: password
  })
    // .then(handleResponse)
    .then(user => {
      localStorage.setItem('user', JSON.stringify(user))
      return user
    })
    .catch(function (error) {
      console.log(error)
    })
}

function logout () {
  // remove user from local storage to log user out
  localStorage.removeItem('user')
}

function getAll () {
  const requestOptions = {
    method: 'GET',
    headers: authHeader()
  }
  return fetch(`${apiUrl}/users`, requestOptions).then(handleResponse)
  // ${config.apiUrl}
}

function handleResponse (response) {
  return response.text().then(text => {
    const data = text && JSON.parse(text)
    if (!response.ok) {
      if (response.status === 401) {
        // auto logout if 401 response returned from api
        logout()
        location.reload(true)
      }

      const error = (data && data.message) || response.statusText
      return Promise.reject(error)
    }

    return data
  })
}
