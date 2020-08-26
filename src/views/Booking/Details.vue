<template>
  <div class="bg-light m-3">
    <b-row class="mt-5 mx-0" style="background-color:#e9ecef;">
      <b-col>
        <div class="pl-3 head-t p-2 text-left">
          number-ref- <span style="font-size:26px;color:#666;">client_name</span>
        </div>
        </b-col>
      <b-col col lg="2">
        <b-dropdown id="dropdown-1" text="Booking Action" class="m-md-2" variant="outline-success">
          <b-dropdown-item-button  v-b-modal.new-permit>
            <b-icon icon="plus-circle-fill"></b-icon> Add Permit
          </b-dropdown-item-button><b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item v-b-modal.new-guest>Add Guest</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item v-b-modal.invoice-details>Add Invoice Details</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item  v-b-modal.invoice-preview active>Preview Invoice</b-dropdown-item>
        </b-dropdown>
      </b-col>
    </b-row>
    <b-row class="mt-3 mx-0">
      <b-container fluid>
        <b-row>
        <SideDetails/>
        <MainDetails/>
        </b-row>
      </b-container>
    </b-row>
    <AddPermit/>
    <AddGuest/>
    <AddInvoiceDetails/>
    <InvoicePreview/>
  </div>
</template>

<script>
import SideDetails from '@/components/Bookings/SideDetails.vue'
import MainDetails from '@/components/Bookings/MainDetails.vue'
import AddPermit from '@/components/Bookings/Modals/AddPermit.vue'
import AddGuest from '@/components/Bookings/Modals/AddGuest.vue'
import AddInvoiceDetails from '@/components/Bookings/Modals/AddInvoiceDetails.vue'
import InvoicePreview from '@/components/Bookings/Modals/InvoicePreview.vue'
export default {
  name: 'side_details',
  components: {
    SideDetails,
    MainDetails,
    AddPermit,
    AddGuest,
    AddInvoiceDetails,
    InvoicePreview
  }
}
</script>
<style>
.head-t{
  font-size: 30px;
  color: #687B6D;
}
</style>
