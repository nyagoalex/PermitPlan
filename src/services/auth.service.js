export function authHeader () {
  // return authorization header with basic auth credentials
  const user = JSON.parse(localStorage.getItem('user'))

  if (user && user.data) {
    return 'Bearer ' + user.data.access_token
  } else {
    return ''
  }
}
