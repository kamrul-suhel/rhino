<template>
    <v-layout row wrap>
        <v-flex xs3
                v-for="(appointmentSlot, index) in appointmentSlots"
                :key="index">
            <UserAppointmentSlot :appointmentSlot="appointmentSlot">
            </UserAppointmentSlot>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'
    import UserAppointmentSlot from '@/components/Appointment/UserAppointmentSlot'

    export default {
        components: {
            UserAppointmentSlot
        },

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
                selectedUser: 'getSelectedUser',
                selectedEvent: 'getSelectedEvent',
                update: 'getInitializeAppointment',
                appointmentUsers: 'getAppointmentUsers',
                existingAppointments: 'getAppointments'
            })
        }),

        created() {
            this.initializeUserAppointment()
        },

        methods: {
            initializeUserAppointment() {
                const time = fn.getStartTimeEndTime(this.date, this.dealership)
                this.appointmentSlots = fn.getTimeSlotsForDay(time, this.selectedEvent)
            },

            checkAvailability(currentSlot){
                const selectedUser = {...this.selectedUser}
                let isSlotAvailable = true

                if (this.existingAppointments.length > 0) {
                    _.map(this.existingAppointments, (appointment) => {
                        if (
                            appointment.start === currentSlot.start &&
                            selectedUser.id === appointment.user_id
                        ) {
                            isSlotAvailable = false
                        }
                    })
                    return isSlotAvailable

                }else{
                    return isSlotAvailable
                }
            }
        }
    }
</script>
