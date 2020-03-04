<template>
    <v-layout row wrap>
        <v-flex xs3
                v-for="(appointmentSlot, index) in appointmentSlots"
                :key="index">
            <UserAppointmentSlot :appointmentSlot="appointmentSlot" :user="user">
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
            },

            user:{
                type: Object,
                required: false,
                default: null
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
                existingAppointments: 'getAppointments',
                initialize: 'getInitAppointmentByDate'
            })
        }),

        watch:{
            initialize(){
                this.initializeUserAppointment()
            }
        },

        created() {
            this.initializeUserAppointment()
        },

        methods: {
            initializeUserAppointment() {
                const time = fn.getStartTimeEndTime(this.date, this.dealership)
                this.appointmentSlots = [...fn.getTimeSlotsForDay(time, this.selectedEvent)]
            }
        }
    }
</script>
