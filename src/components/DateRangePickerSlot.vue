<!-- @format -->

<template>
    <date-range-picker v-model="dateRange" @update="changeDateRange(dateRange)">
        <!--    header slot-->
        <div slot="header" slot-scope="header" class="slot">
            <h5>Select Date range</h5>
            <span v-if="header.in_selection"> - in selection</span>
        </div>
        <!--    input slot (new slot syntax)-->
        <template #input="picker" style="min-width: 350px">
            {{ picker.startDate | displayDate }} - {{ picker.endDate | displayDate }}
        </template>
        <!--    ranges (new slot syntax) -->
        <template #ranges="ranges">
            <div class="ranges">
                <ul>
                    <li
                        v-for="(range, name) in ranges.ranges"
                        :key="name"
                        @click="ranges.clickRange(range)"
                    >
                        <b>{{ name }}</b
                        ><br />
                        <small class="text-muted"
                            >{{ range[0].toDateString() }} -
                            {{ range[1].toDateString() }}</small
                        >
                    </li>
                </ul>
            </div>
        </template>
    </date-range-picker>
</template>

<script>
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

export default {
    name: 'SlotsDemo',
    components: { DateRangePicker },
    data() {
        var startDate = new Date()
        var endDate = new Date()
        endDate.setDate(endDate.getDate() + 6)
        return {
            dateRange: { startDate, endDate }
        }
    },
    props: {
        changeDateRange: Function
    }
}
</script>

<style scoped>
.slot {
    background-color: #aaa;
    padding: 0.5rem;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.text-black {
    color: #000;
}
</style>
