<template>
    <v-card flat
            tile>
        <v-card-text class="appointmentSlot">
            <div>{{ appointmentSlot.start|dateFormat('LT', 'en') }} - {{ appointmentSlot.end| dateFormat('LT', 'en')
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
                         @click="onAppointmentDetail(appointmentSlot, 'available')">Available
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
                existingAppointments: 'getAppointments'
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

                return isSlotAvailable
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
