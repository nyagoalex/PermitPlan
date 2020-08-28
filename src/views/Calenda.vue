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
                }
            }
        }
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
