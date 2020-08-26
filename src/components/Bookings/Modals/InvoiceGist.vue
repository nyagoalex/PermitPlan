<template>
    <div class="p-5">
    <b-row class="py-2 font-weight-bold" style="background-color: #eee; font-size: 23px;">
      <b-col class="text-center"><span style="letter-spacing: 15px;">INVOICE </span>  #123</b-col>
    </b-row>
    <b-row class="mt-4">
      <b-col class="text-left">
        <img src="@/assets/image/avatar.jpg" width="100" >
      </b-col>
      <b-col class="text-right">
      <label>{{company.company_name}}<br>
        {{company.physical_address}}<br>
        {{company.phone}}<br>
        {{company.email}}
        </label>
      </b-col>
    </b-row>

    <b-row class="mt-4 ">
      <b-col class="text-left"> Client Name #: 123</b-col>
      <b-col class="text-center">Ref No: HBUF5</b-col>
      <b-col class="text-right">Booking No: 55HUHDB</b-col>
    </b-row>

    <b-row class="mt-4 mb-0 font-weight-bold" style="color:blue">
      <b-col class="text-left"><small>Created On: {{created_on}}</small></b-col>
      <b-col class="text-right"> <small>Due: February 1, 2015</small></b-col>

    </b-row>
    <b-row class="py-2 mt-0 font-weight-bold" style="background-color: #eee;">
      <b-col class="text-left">Payment Method</b-col>
      <b-col class="text-right"> Cheque # </b-col>
    </b-row>

    <b-row class="my-0">
      <b-col class="text-left"> Cheque</b-col>
      <b-col class="text-right"> 1000 </b-col>
    </b-row>

    <b-row class="mt-4 py-2 font-weight-bold" style="background-color: #42b883; color: white">
      <b-col cols="1">Item #</b-col>
      <b-col cols="5">Description</b-col>
      <b-col cols="1">Permits</b-col>
      <b-col cols="2">Cost Per Person</b-col>
      <b-col cols="1">Pax</b-col>
      <b-col cols="2"> Price </b-col>
    </b-row>

    <b-row class="">
      <b-col cols="1">1</b-col>
      <b-col cols="5">
        <p> Travel Date <br><span> 16th July, 2020 - 21st July, 2020</span></p>
        <p>Trip Duration <br> <span>6 Days | 5 Nights </span></p>
        <p>Activites <br> <span>Swimming, gym</span></p>
      </b-col>
      <b-col cols="1">45</b-col>
      <b-col cols="2">540,000</b-col>
      <b-col cols="1">5</b-col>
      <b-col cols="2"> 466,000 </b-col>
    </b-row>

    <b-row class="mt-5">
      <b-col class="text-right" offset="8" style="border-top: 4px solid #eee;">
        <p><strong class="ml-5 float-left">Sub Total</strong> 33000,00</p>
        <p><strong class="ml-5 float-left">Amount Paid</strong> 7,900</p>
        <p><strong class="ml-5 float-left">Balance</strong> 7,000,000</p>
      </b-col>
    </b-row>
    <b-row class="mt-0">
      <b-col class="text-center"> TERMS <hr class="m-0" style="border: 1px solid #000;">
      <span style="color:#092f55; font-size: 12px; font-style: oblique;">NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</span>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  data () {
    return {
      created_on: new Date().toJSON().slice(0, 10).replace(/-/g, '/')
    }
  },
  props: {
    company: Object
  }
}
</script>
