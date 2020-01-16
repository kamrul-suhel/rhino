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
    import fn from '@/utils/function'

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
                const time = fn.getStartTimeEndTime(this.date, this.dealership)
                this.appointmentSlots = fn.getTimeSlotsForDay(time, this.selectedEvent)
            }
        }
    }
</script>
