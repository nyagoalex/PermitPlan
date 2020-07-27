<template>
    <div class="col-9 p-0 pr-2">
        <div class="pl-4 pr-4">
            <div class="accordion-panel  text-left">
                <div class="buttons-wrapper">
                    <i class="plus-icon"></i>
                    <div class="open-btn">
                        Open all
                    </div>
                    <div class="close-btn hidden">
                        Close all
                    </div>
                </div>

                <dl class="accordion">
                    <dt>Permits <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">

                        <div class="mt-3 header-small pt-3 bg-white  p-3">
                            <b-button  size="sm" pill variant="outline-secondary" class="float-right" data-toggle="modal" data-target="#new-payment">+ Permit Payment</b-button>

                                <b-table :items="permit_items" :fields="permit_fields" outlined striped hover>
                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                  <template v-slot:cell(action)="data">
                                    <b-dropdown text="Action" variant="light" size="sm">
                                        <b-dropdown-item-button> Reschedule</b-dropdown-item-button>
                                        <b-dropdown-item>Show Payments</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-item>Register Payment</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-item disabled>Delete</b-dropdown-item>
                                        <b-dropdown-item disabled>{{ data.action }}</b-dropdown-item>
                                    </b-dropdown>

                                  </template>

                                </b-table>

                            </div>
                            <br>
                        </div>

                    </dd>

                    <dt>Payments <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">

                            <div class="mt-3 pt-3 header-small bg-white  p-3">
                                <b-button v-b-modal.overall_payment_modal size="sm" pill variant="outline-secondary" class="float-right" >+ add payment</b-button>

                                <b-table :items="payment_items" :fields="payment_fields" outlined striped hover>
                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                  <template v-slot:cell(action)="data">
                                    <b-dropdown text="Action" variant="light" size="sm">
                                        <b-dropdown-item-button> Reschedule</b-dropdown-item-button>
                                        <b-dropdown-item>Show Payments</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-item>Register Payment</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-item disabled>Delete</b-dropdown-item>
                                        <b-dropdown-item disabled>{{ data.action }}</b-dropdown-item>
                                    </b-dropdown>

                                  </template>

                                </b-table>

                            </div>
                            <br>
                        </div>
                    </dd>

                    <dt>Guests Details<i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">

                          <div class="mt-3 header-small pt-3 bg-white  p-3">
                            <b-table :items="guest_items" :fields="guest_fields" outlined striped hover>
                                <template v-slot:cell(index)="data">
                                    {{ data.index + 1 }}
                                </template>
                              <template v-slot:cell(action)="data">
                                <b-dropdown text="Action" variant="light" size="sm">
                                    <b-dropdown-item-button> Reschedule</b-dropdown-item-button>
                                    <b-dropdown-item>Show Payments</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
                                    <b-dropdown-item>Register Payment</b-dropdown-item><b-dropdown-divider></b-dropdown-divider>
                                    <b-dropdown-item disabled>Delete</b-dropdown-item>
                                    <b-dropdown-item disabled>{{ data.action }}</b-dropdown-item>
                                </b-dropdown>

                              </template>

                            </b-table>

                            </div>
                        </div>
                    </dd>

                    <dt>Day to day Itinerary (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>

                    <dt>Accommodation (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>

                    <dt>Activities (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>

                    <dt>Guide & Vehicle (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <br>

        <div class="pl-3 pr-3">
            <h6 class="container w-100" style="font-size:20px;color:purple;"><strong>Recent Activity</strong></h6>

            <div class="container">
                <div class="card mb-2 hover-shadow-lg" style="display: flex;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid #eff2f7;border-radius: .25rem;">
                    <div class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0">

                        <div class="col-lg-2 col-8 pl-0 pl-md-2 pt-3 pt-lg-0"><span class="h6 text-sm">Aaliyah Haworth</span></div>
                        <div class="col col-lg-1 text-right px-0 order-lg-4 pt-3 pt-lg-0"><span class="text-muted text-sm">Dec 25</span></div>
                        <div class="col-12 col-lg-8 d-flex align-items-center position-static pb-3 py-lg-3 px-0">
                            <div class="col col-lg-11 position-static px-0">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center">
                                    <div class="col-12 col-lg pl-0 text-limit text-left text-sm text-muted d-none d-sm-block pl-lg-2">Today we are happy to announce Bit's public Beta support for Vue components between different apps.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2 hover-shadow-lg" style="display: flex;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid #eff2f7;border-radius: .25rem;">
                    <div class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0">

                        <div class="col-lg-2 col-8 pl-0 pl-md-2 pt-3 pt-lg-0"><span class="h6 text-sm">Alex Nyago</span></div>
                        <div class="col col-lg-1 text-right px-0 order-lg-4 pt-3 pt-lg-0"><span class="text-muted text-sm">Dec 25</span></div>
                        <div class="col-12 col-lg-8 d-flex align-items-center position-static pb-3 py-lg-3 px-0">
                            <div class="col col-lg-11 position-static px-0">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center">
                                    <div class="col-12 col-lg pl-0 text-limit text-left text-sm text-muted d-none d-sm-block pl-lg-2">Today we are happy to announce Bit's public Beta support for Vue components between different apps.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <OverallPayment/>
    </div>
</template>

<style>
/*bookings details accordion panel*/
.accordion-panel {

    margin: 0px auto;
    /*  max-width: 560px;*/
}

.accordion-panel .accordion {
    padding-top: 30px;
}

.accordion-panel .accordion dt {
    display: block;
    padding: 19px;
    background: #fff;
    color: #555;
    cursor: pointer;
    position: relative;
    user-select: none;
    border-radius: 3px;
    border: 1px solid #eff2f7;

    box-shadow: 0 0 1.25rem rgba(31, 45, 61, .05);
}

.accordion-panel .accordion dd {
    height: 0;
    overflow: hidden;
    transition: height .35s ease-out;
    margin-left: 0;
    margin-bottom: 5px;
    background: #F4F4F4;
}

.accordion-panel .accordion .contents {
    /*  padding: 25px;*/
    overflow: auto;
}

.accordion-panel .plus-icon {
    display: inline-block;
    width: 15px;
    height: 15px;
    position: relative;
    transition: transform 0.35s ease-out;
    position: absolute;
    right: 35px;
    top: 50%;
    margin-top: -12px;
}

.accordion-panel .plus-icon:before,
.accordion-panel .plus-icon:after {
    content: '';
    background: #6bbf49;
    position: absolute;
}

.accordion-panel .plus-icon:before {
    width: 2px;
    height: 15px;
    margin-left: -0.5px;
    left: 50%;
}

.accordion-panel .plus-icon:after {
    width: 15px;
    height: 2px;
    margin-top: -0.5px;
    top: 50%;
    opacity: 1;
    transition: opacity 0.35s ease-out;
}

.accordion-panel .is-open .plus-icon {
    transform: rotate(90deg);
}

.accordion-panel .is-open .plus-icon:after {
    opacity: 0;
}

.accordion-panel .hidden {
    display: none;
}

.accordion-panel .open-btn,
.accordion-panel .close-btn {
    cursor: pointer;
    position: absolute;
    right: 0;
    width: 90px;
}

.accordion-panel .buttons-wrapper {
    position: relative;
}

.accordion-panel .buttons-wrapper .plus-icon {
    position: absolute;
    right: 10px;
    top: 12px;
}
.header-small {
  font-size: 13px;
}
</style>

<script>
import $ from 'jquery'
import OverallPayment from '@/components/Bookings/Modals/OverallPayment.vue'

export default {
  data () {
    return {
      permit_fields: ['index', 'permit_type', 'permits_no', 'cost_(USD)', 'balances_(USD)', 'payment_status', 'preffered_sector', 'tracking_date', 'action'],
      permit_items: [
        { permit_type: 'golden monkey permits', permits_no: 'PT0001', 'cost_(USD)': 70.00, 'balances_(USD)': 609.9, payment_status: 'Tentative', preffered_sector: 'hb sdhb', tracking_date: '24th/Jul/2020 12:20 pm' }
      ],

      payment_fields: ['index', 'payment_date', 'amount', 'created_by', 'action'],
      payment_items: [
        { payment_date: '24th/Jul/2020 12:20 pm', amount: 30000, created_by: 'Alex Nyago' }
      ],

      guest_fields: ['index', 'name', 'passport_no', 'DOB', 'nationality', 'action'],
      guest_items: [
        { name: 'Alex Nyago', passport_no: '66y6666', DOB: '24th/Jul/2020 12:20 pm', nationality: 'Uganda' },
        { name: 'Alex Nyago', passport_no: '66y6666', DOB: '24th/Jul/2020 12:20 pm', nationality: 'Uganda' }
      ]
    }
  },
  components: {
    OverallPayment
  },
  created () {
    // reset login status

  },
  methods: {
    handleSubmit (e) {

    }
  }
}

$(document).ready(function () {
  var bodyEl = $('body')
  var accordionDT = $('.accordion').find('dt')
  var accordionDD = accordionDT.next('dd')
  var accordionPanel = $('.accordion-panel')
  var buttonsWrapper = accordionPanel.find('.buttons-wrapper')
  var openBtn = accordionPanel.find('.open-btn')
  var closeBtn = accordionPanel.find('.close-btn')

  bodyEl.on('click', function (argument) {
    var totalItems = $('.accordion').children('dt').length
    var totalItemsOpen = $('.accordion').children('dt.is-open').length

    if (totalItems === totalItemsOpen) {
      openBtn.addClass('hidden')
      closeBtn.removeClass('hidden')
      buttonsWrapper.addClass('is-open')
    } else {
      openBtn.removeClass('hidden')
      closeBtn.addClass('hidden')
      buttonsWrapper.removeClass('is-open')
    }
  })

  function openAll () {
    openBtn.on('click', function (argument) {
      accordionDD.each(function (argument) {
        var eachNewHeight = $(this).children('.contents').outerHeight(true)
        $(this).css({
          height: eachNewHeight
        })
      })
      accordionDT.addClass('is-open')
    })
  }

  function closeAll () {
    closeBtn.on('click', function (argument) {
      accordionDD.css({
        height: 0
      })
      accordionDT.removeClass('is-open')
    })
  }

  function openCloseItem () {
    accordionDT.on('click', function () {
      var el = $(this)
      var target = el.next('dd')
      var parentHeight = target.height()
      var childHeight = target.children('.contents').outerHeight(true)
      var newHeight = parentHeight > 0 ? 0 : childHeight

      // animate to new height
      target.css({
        height: newHeight
      })

      // remove existing classes & add class to clicked target
      if (!el.hasClass('is-open')) {
        el.addClass('is-open')
      } else { // if we are on clicked target then remove the class
        el.removeClass('is-open')
      }
    })
  }

  openAll()
  closeAll()
  openCloseItem()
})

</script>
