<template>
    <v-layout row wrap>
        <v-flex xs3
                v-for="(appointmentSlot, index) in appointmentSlots"
                :key="index">
            <v-card
                tile
                height="80"
                class="d-flex">
                <v-card-text class="appointmentSlot">
                    <div>{{ appointmentSlot.start|dateFormat('LT', 'en') }}</div>
                    <div>{{ appointmentSlot.end| dateFormat('LT', 'en') }}</div>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                isClose: false,
                appointmentSlots: []
            }
        },

        props: {
            date: {
                type: String,
                required: true
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedUsers: 'getUsers',
                selectedEvent: 'getSelectedEvent',
                update: 'getInitializeAppointment',
                appointmentUsers: 'getAppointmentUsers'
            })
        }),

        created() {
            this.initializeUserAppointment()
        },

        methods: {
            initializeUserAppointment() {
                const time = this.getStartTimeEndTime()
                this.getTimeSlotsForDay(time)
            },

            getStartTimeEndTime() {
                const startTime = `${moment(this.date).format('dddd').toLowerCase()}_start`
                const endTime = `${moment(this.date).format('dddd').toLowerCase()}_end`

                return {
                    start: `${this.date} ${this.dealership[startTime]}`,
                    end: `${this.date} ${this.dealership[endTime]}`
                }
            },

            getTimeSlotsForDay(date) {
                const appointmentDuration = this.selectedEvent.appointment_duration
                const breakTime = this.selectedEvent.break_time

                let timeSlots = []
                let dayStart = moment(date.start)
                let dayEnd = moment(date.end)
                do {
                    let newDate = moment(dayStart).add(appointmentDuration, 'minutes')
                    const times = {
                        start: dayStart.format('YYYY-MM-DD HH:mm:ss'),
                        end: newDate.format('YYYY-MM-DD HH:mm:ss')
                    }

                    dayStart.add(appointmentDuration, 'minutes')
                    timeSlots.push(times)
                } while (dayStart <= dayEnd);

                this.appointmentSlots = [...timeSlots]
            }
        }
    }
</script>
