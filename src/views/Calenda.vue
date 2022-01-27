<template>
    <b-container class="pt-4">
        <FullCalendar :options="calendarOptions" />
    </b-container>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import {
    BPopover
} from 'bootstrap-vue'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                editable: false,
                themeSystem: 'minty',
                weekNumbers: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridDay,timeGridWeek,dayGridMonth,listWeek'
                },
                events: [],
                eventMouseEnter(args) {
                    const obj = args.event
                    var status = '<span class="badge badge-default" style="font-size:12px;">Tentative</span>'
                    if (obj.status === 'confirmed') {
                        status = '<span class="badge badge-success" style="font-size:12px;">Confirmed</span>'
                    } else if (obj.status === 'cancelled') {
                        status = '<span class="badge badge-danger" style="font-size:12px;">Cancelled</span>'
                    }
                    new BPopover({
                        propsData: {
                            title: 'Booking Details',
                            content: '<b>Name:</b> ' + obj.name + '<br><b>Number:</b> ' + obj.number + '<br> <b>Ref:</b>  ' + obj.ref + '<br><b>Permit:</b> ' + obj.permits + '<br> <b>Status:</b> ' + status,
                            boundary: 'scrollParent',
                            container: 'body',
                            boundaryPadding: 5,
                            delay: 500,
                            offset: 0,
                            triggers: 'hover',
                            html: true,
                            target: args.el
                        }
                    }).$mount()
                }
            }
        }
    },
    methods: {
        getCalendar() {
            this.$http.get('/bookings').then(bookings => {
                this.calendarOptions.events = bookings.data.data.map((item) => {
                    let color = 'navy'
                    if (item.status === 'confirmed') {
                        color = 'green'
                    }
                    if (item.status === 'cancelled') {
                        color = 'maroon'
                    }

                    return {
                        title: item.number + ' ' + item.client_name,
                        start: item.arrival_date,
                        end: item.departure_date,
                        url: 'bookings/' + item.id,
                        color: color,
                        number: item.number,
                        permits: item.permits_count
                    }
                })
            })
        }
    },
    mounted() {
        this.getCalendar()
    }
}
</script>

<style>
.fc-day-today .fc-daygrid-day-top .fc-daygrid-day-number {
    font-size: 24px;
    background-color: #07461c;
    color: #FFFFFF;
    border-radius: 50%;
    margin: 4px;
}
</style>
