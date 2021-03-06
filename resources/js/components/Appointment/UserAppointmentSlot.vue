<template>
    <v-card flat
            tile>
        <v-card-text class="appointmentSlot">
            <div>{{ appointmentSlot.start|dateFormat('LT', selectedLanguage.language_code) }} - {{ appointmentSlot.end| dateFormat('LT', selectedLanguage.language_code)
                }}
            </div>
        </v-card-text>

        <v-card-actions>
            <v-layout v-if="checkAvailability(appointmentSlot)"
                      row
                      wrap
                      justify-center
                      align-center>
                <v-flex xs12>
                    <div class="appointment-button available"
                         @click="onAppointmentDetail(appointmentSlot, 'available')">{{ trans.available }}
                    </div>
                </v-flex>
            </v-layout>
            <!-- Available slot -->

            <AppointmentOverview :user="user" v-else :appointment="getAppointmentInfo()"></AppointmentOverview>
            <!-- unavailable -->
        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UnavailableDialogContent from "./UnavailableDialogContent"
    import AvailableDialogContent from "./AvailableDialogContent"
    import AppointmentOverview from "./AppointmentOverview"

    export default {
        components: {
            UnavailableDialogContent,
            AvailableDialogContent,
            AppointmentOverview
        },

        data() {
            return {
                available: false,
                unAvailable: false
            }
        },

        props: {
            appointmentSlot: {
                type: Object,
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
                selectedUser: 'getSelectedUser',
                existingAppointments: 'getAppointments',
                otherAppointments: 'getOtherAppointments',
                selectedLanguage: 'getSelectedLanguage'
            })
        }),

        created() {
        },

        methods: {
            checkAvailability(currentSlot) {
                let selectedUser = {...this.selectedUser}
                if(this.user){
                    selectedUser = {...this.user}
                }

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
                }
                if(isSlotAvailable){
                    if(this.otherAppointments.length > 0){
                        _.map(this.otherAppointments, (otherAppointment) => {
                            if(otherAppointment.user_id === selectedUser.id){

                                const startTimeStart = new Date(currentSlot.start).getTime()
                                const startTimeEnd = new Date(currentSlot.end).getTime() - 1000

                                const endTimeStart = new Date(currentSlot.start).getTime() + 1000
                                const endTimeEnd = new Date(currentSlot.end).getTime()

                                const otherAppointmentStart = new Date(otherAppointment.start).getTime()
                                const otherAppointmentEnd = new Date(otherAppointment.end).getTime()

                                if(
                                    otherAppointmentStart >= startTimeStart &&
                                    otherAppointmentStart <= startTimeEnd ||
                                    otherAppointmentEnd >= endTimeStart &&
                                    otherAppointmentEnd <= endTimeEnd
                                ){
                                    isSlotAvailable = false
                                }
                            }

                        })
                    }
                }

                return isSlotAvailable
            },

            checkOtherAppointments(currentSlot){
            },

            getAppointmentInfo(){
                let selectedUser = {...this.selectedUser}
                if(this.user){
                    selectedUser = {...this.user}
                }
                let slotInfo = {...this.appointmentSlot}

                _.map(this.existingAppointments, (appointment) => {
                    if (
                        appointment.start === this.appointmentSlot.start &&
                        selectedUser.id === appointment.user_id
                    ) {
                        slotInfo = {
                            ...slotInfo,
                            ...appointment
                        }
                    }
                })

                if(this.otherAppointments.length > 0){
                    _.map(this.otherAppointments, (otherAppointment) => {
                        if(otherAppointment.user_id === selectedUser.id){

                            const startTimeStart = new Date(slotInfo.start).getTime()
                            const startTimeEnd = new Date(slotInfo.end).getTime() - 1000

                            const endTimeStart = new Date(slotInfo.start).getTime() + 1000
                            const endTimeEnd = new Date(slotInfo.end).getTime()

                            const otherAppointmentStart = new Date(otherAppointment.start).getTime()
                            const otherAppointmentEnd = new Date(otherAppointment.end).getTime()

                            if(
                                otherAppointmentStart >= startTimeStart &&
                                otherAppointmentStart <= startTimeEnd ||
                                otherAppointmentEnd >= endTimeStart &&
                                otherAppointmentEnd <= endTimeEnd
                            ){
                                slotInfo = {
                                    ...slotInfo,
                                    ...otherAppointment
                                }
                            }
                        }
                    })
                }

                return slotInfo
            },

            onAppointmentDetail(appointmentSlot, type) {
                if(this.user){
                    this.$store.commit('setSelectedUser', this.user)
                }

                switch (type) {
                    case 'unavailable':
                        this.$store.commit('setAppointmentAvailable', false)
                        this.$store.commit('setAppointmentUnavailable', true)
                        break

                    case 'available':
                        this.$store.commit('setAppointmentAvailable', true)
                        this.$store.commit('setAppointmentUnavailable', false)
                }

                this.$store.commit('setAppointmentDialog', true)
                this.$store.commit('setAppointmentDialogSlot', this.appointmentSlot)
            }
        }
    }
</script>
