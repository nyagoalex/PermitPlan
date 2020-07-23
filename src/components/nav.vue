<template>
<div>
  <b-navbar toggleable="lg" variant="faded" type="light" class="bg-white shadow-lg" style="max-height:60px;">
    <b-navbar-brand href="/dashboard"><img src="@/assets/image/pplanw.png" alt="Kitten" width="130" height="50"></b-navbar-brand>

    <b-navbar-nav>
      <b-nav-item href="#">Dashbord</b-nav-item>
      <b-nav-item href="bookings">All Bookings</b-nav-item>
      <b-nav-item href="#">Safari Calenda</b-nav-item>
      <b-nav-item-dropdown text="+ More" right>
        <b-dropdown-item href="#">Agents</b-dropdown-item>
        <b-dropdown-item href="#">Departures Permits</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item href="#">Lodges + Hotels</b-dropdown-item>
        <b-dropdown-item href="#">Transfers</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item href="#">Vehicles</b-dropdown-item>
        <b-dropdown-item href="#">Guides & Drivers</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
      <!-- Right aligned nav items -->
    <b-navbar-nav class="ml-auto">
      <b-nav-form>
        <b-form-input size="sm" class="mr-sm-2"  placeholder="Search"></b-form-input>
        <!-- <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button> -->
      </b-nav-form>
      <b-button variant="success" style="max-height:40px; padding:0px 30px;font-size:15px;">+ Add Booking</b-button>
      <b-nav-item-dropdown class="ml-4" right>
        <!-- Using 'button-content' slot -->
        <template v-slot:button-content>
          <!-- <em>User</em> -->
          <img v-bind="mainProps" rounded="circle" src="@/assets/image/user-ic.png"  alt="">
        </template>
        <b-dropdown-item href="/profile">Profile</b-dropdown-item>
        <b-dropdown-item href="/settings">Settings</b-dropdown-item>
        <b-dropdown-item href="#"><Logout/></b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </b-navbar>
</div>

</template>

<script>
import Logout from '@/components/Logout'
// // axios.defaults.headers.common.Authorization = authHeader()
export default {
  data () {
    return {
      myStyle: {
        backgroundColor: '#16a085'
      },
      mainProps: { width: 35, height: 35, class: 'm1' }
    }
  },
  components: {
    Logout
  }
}
</script>
