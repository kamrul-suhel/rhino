<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-layout row
                      wrap
                      justify-center
                      align-item-center
                      v-if="showUserInfo()"
                      mb-2>
                <v-avatar size="150">
                    <img :src="selectedUser.profile_image|image(themeOption.userDefaultImage)"/>
                </v-avatar>
            </v-layout>

            <v-layout row
                      wrap
                      justify-center
                      align-item-center
                      v-if="showUserInfo()"
                      mb-2>
                <strong>{{ trans.email }}: </strong><span>{{ selectedUser.email }}</span>
            </v-layout>

            <!-- Remove break time -->
            <v-layout row
                      v-if="appointment.status === 4"
                      wrap
                      justify-center
                      align-item-center>
                <v-btn :color="themeOption.primaryColor"
                       @click="onRemoveBreakTime()">
                    <span
                        :style="{color: themeOption.primaryTextColor}">{{ `${trans.removeBreakTime}`}}</span>
                </v-btn>
            </v-layout>


            <!-- Remove not available -->
            <v-layout row
                      v-if="appointment.status === 3"
                      wrap
                      justify-center
                      align-item-center>
                <v-btn :color="themeOption.primaryColor"
                       @click="onRemoveBreakTime()">
                    <span :style="{color: themeOption.primaryTextColor}">{{ `${trans.removeNotAvailable}`}}</span>
                </v-btn>
            </v-layout>

            <!-- Show confirmed appointment -->
            <v-layout row
                      v-if="appointment.status === 1"
                      mb-4
                      wrap>
                <v-flex xs12>
                    <h3>{{ trans.guest }}</h3>
                    <v-divider></v-divider>
                </v-flex>

                <v-flex xs12>
                    <strong>Name:</strong> {{ `${appointment.guest_surname} ${appointment.guest_first_name}` }}
                </v-flex>

                <v-flex xs12>
                    <strong>{{ trans.bringGuest|trans }}:</strong> {{ `${appointment.bring_guest}` }}
                </v-flex>

                <v-flex xs12 sm6>
                    <strong>{{ trans.partExchange|trans }}:</strong> {{ `${appointment.part_ex_vrm}` }}
                </v-flex>

                <v-flex xs12 sm6>
                    <strong>{{ trans.model|trans }}:</strong> {{ `${appointment.part_ex_vehicle}` }}
                </v-flex>

                <v-flex xs12 sm6>
                    <strong>{{ trans.currentMileage|trans }}:</strong> {{ `${appointment.part_ex_distance}` }}
                </v-flex>
            </v-layout>

            <v-layout row
                      v-if="appointment.status === 1"
                      wrap
                      justify-center
                      align-item-center>
                <v-btn :color="themeOption.primaryColor"
                       @click="onAssignToSaleExecutive()">
                    <span :style="{color: themeOption.primaryTextColor}">
                        {{ `${trans.assignToSalesExecutive}`}}
                    </span>
                </v-btn>

                <v-btn :color="themeOption.primaryColor"
                       @click="onCancelAppointment()">
                    <span
                        :style="{color: themeOption.primaryTextColor}">{{ `${trans.cancelAppointment}`}}</span>
                </v-btn>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        props: {
            appointment: {
                type: Object,
                required: true
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                existingAppointments: 'getAppointments',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        created() {
        },

        methods: {

            onRemoveBreakTime() {
                const appointmentId = this.appointment.id
                const URL = `/api/appointments/${appointmentId}`
                axios.delete(URL).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setAppointmentAvailable', false)
                        this.$store.commit('setAppointmentUnavailable', false)
                        this.$store.commit('setAppointmentDialog', false)
                        this.$store.commit('setAppointmentDialogSlot', {})
                        this.$store.commit('setUpdateComponent')
                    }
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            onCancelAppointment() {
                // Make slot is unavailable
                let appointmentForm = new FormData()
                appointmentForm.append('canceled', true) // canceled the appointment
                _.forOwn(this.appointment, (value, key) => {
                    switch (key) {
                        case 'id':
                            appointmentForm.append('appointment_id', value)
                            break

                        case 'status':
                            appointmentForm.append('status', 6) // Consistance with guest table
                            break

                        default:
                            appointmentForm.append(key, value)
                    }
                })

                appointmentForm.append('_method', 'PUT')

                const appointmentId = this.appointment.id
                const URL = `/api/appointments/${appointmentId}`
                axios.post(URL, appointmentForm).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setAppointmentAvailable', false)
                        this.$store.commit('setAppointmentUnavailable', false)
                        this.$store.commit('setAppointmentDialog', false)
                        this.$store.commit('setAppointmentDialogSlot', {})
                        this.$store.commit('setUpdateComponent')
                    }
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            onAssignToSaleExecutive(){
                this.$store.commit('setAssignToSaleExecutiveAppointment', this.appointment)
                this.$store.commit('setAssignToSaleExecutiveDialog', true)
            },

            showUserInfo() {
                let showUser = false
                switch (this.appointment.status) {
                    case 3://
                    case 4:
                        showUser = true
                        break
                    case 2: //
                    case 1:
                        showUser = false
                        break
                }

                return showUser
            }
        }
    }
</script>
