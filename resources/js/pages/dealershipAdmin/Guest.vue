<template>
    <v-container fluid px-5>
        <v-layout row wrap>
            <v-flex xs12>
                <v-data-table
                    hide-headers
                    :items="appointmentsTable"
                    hide-actions
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <tr>
                            <td><strong>{{ trans.surName }}:</strong> {{ guest.surname }}</td>
                            <td class="text-xs-left"><strong>{{ trans.firstName }}:</strong> {{ guest.first_name }}</td>
                        </tr>

                        <tr>
                            <td><strong>{{ trans.email }}:</strong> {{ guest.email | trans }}</td>
                            <td class="text-xs-left"><strong>{{ trans.mobile }}:</strong> {{ guest.mobile | trans }}</td>
                        </tr>

                        <tr>
                            <td><strong>{{ trans.postcode }}:</strong> {{ guest.postcode | trans }}</td>
                            <td class="text-xs-left"><strong>{{ trans.landline }}:</strong> {{ guest.landline | trans }}</td>
                        </tr>

                        <tr>
                            <td><strong>{{ `${trans.addressLine} 1` }}:</strong> {{ guest.address_line_1 | trans }}</td>
                            <td class="text-xs-left"><strong>{{ `${trans.landline} 2` }}:</strong> {{
                                guest.address_line_2 | trans }}
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-flex>

            <v-flex xs12 class="mt-5">
                <h2 class="mb-2">{{ trans.appointments }}</h2>

                <v-layout row wrap>
                    <v-flex xs12
                            v-for="appointment in guest.appointment"
                            :key="appointment.id">
                        <v-card class="mb-3">
                            <v-card-title>
                                <strong>{{ trans.name }}:</strong> {{ appointment.event.event_name | trans}}
                                <v-spacer></v-spacer>
                                <strong>{{ trans.status }}: </strong> {{ getAppointmentStatus(appointment) }}
                            </v-card-title>

                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs6>
                                        <strong>{{ trans.start }}:</strong> {{ appointment.start|dateFormat('LLLL') }}
                                    </v-flex>

                                    <v-flex xs6>
                                        <strong>{{ trans.end }}:</strong> {{ appointment.end|dateFormat('LLLL') }}
                                    </v-flex>
                                </v-layout>

                                <v-divider class="my-2"></v-divider>

                                <v-layout row wrap>
                                    <v-flex xs6>
                                        <strong>{{ trans.salesExecutive }}:</strong> {{ appointment.user ?
                                        `${appointment.user.firstname} ${appointment.user.surname}` : ''}}
                                    </v-flex>

                                    <v-flex xs5>
                                        <strong>{{ trans.email }}</strong>{{ appointment.user ? appointment.user.email : '' }}
                                    </v-flex>
                                </v-layout>

                                <v-divider class="my-2"></v-divider>

                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <h3>Interested in vehicles</h3>
                                    </v-flex>

                                    <v-flex xs12 sm4 v-for="vehicle in appointment.vehicles"
                                            :key="vehicle.id"
                                            class="pa-2">

                                        <v-card>
                                            <v-img
                                                :src="renderVehicleImage(vehicle)"
                                                aspect-ratio="2"
                                            ></v-img>

                                            <v-card-title primary-title>
                                                <div>
                                                    <h5 class="mb-0"><strong>{{ trans.model }}:</strong> {{ vehicle.vehicle_name }}</h5>
                                                    <div>
                                                        <strong>{{trans.condition}} :</strong> {{ vehicle.vehicle_condition === 1 ? trans.new : trans.used }}
                                                    </div>
                                                </div>
                                            </v-card-title>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                            <v-divider light></v-divider>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn :color="themeOption.primaryColor"
                                       flat
                                       v-if="appointment.status === 1"
                                       @click="onCancel(appointment)">
                                    <span :style="{color: themeOption.primaryColor}">{{ `${trans.cancelAppointment}` }}</span>
                                </v-btn>

                                <v-btn :color="themeOption.primaryColor"
                                       flat
                                       v-if="appointment.status === 1"
                                       @click="onUpdateScheduleTime(appointment)">
                                    <span :style="{color: themeOption.primaryColor}">{{ `${trans.updateArrivedLeaveTime}`}}</span>
                                </v-btn>

                                <v-btn :color="themeOption.primaryColor"
                                       flat
                                       v-if="appointment.status === 6"
                                       @click="onReebok(appointment)">
                                    <span :style="{color: themeOption.primaryColor}">
                                        {{ `${trans.reebokAppointment}` }}
                                    </span>
                                </v-btn>

                                <v-btn :color="themeOption.primaryColor"
                                       flat
                                       v-if="appointment.status === 0"
                                       @click="onBookGuest(appointment)">
                                    <span :style="{color: themeOption.primaryColor}">
                                        {{ `${trans.finishGuestBookingJourney}` }}
                                    </span>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-dialog
            v-model="dialog"
            width="500"
        >
            <v-card>
                <v-card-title
                    class="headline"
                    :style="{backgroundColor: themeOption.primaryColor, color: themeOption.primaryTextColor}"
                    primary-title
                >
                <span :style="{color: themeOption.primaryTextColor}">
                    {{ `${dialogTitle}` }}
                </span>
                </v-card-title>

                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs12 class="text-xs-center">
                                {{ dialogDescription }}
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="dialogButtonCancel"
                        @color="themeOption.primaryColor"
                        flat
                        @click="onConfirmAction('confirmedCancel')"
                    >
                        {{ `${trans.confirmedCancel}` }}
                    </v-btn>

                    <v-btn
                        v-if="selectedAppointment.status === 6"
                        @color="themeOption.primaryColor"
                        flat
                        @click="onConfirmAction('reebokAppointment')"
                    >
                        {{ `${trans.reebokAppointment}` }}
                    </v-btn>

                    <v-btn
                        v-if="selectedAppointment.status === 0"
                        @color="themeOption.primaryColor"
                        flat
                        @click="onConfirmAction('finishExistingBooking')"
                    >
                        {{ `${trans.finishGuestBookingJourney}` }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <UpdateScheduledDialog :dialog="updateSchedule"
                               @onUpdateSchedule="onUpdateSchedule"
                               :appointment="appointment"/>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'
    import UpdateScheduledDialog from "@/components/Appointment/UpdateScheduledDialog";

    export default {
        components:{
          UpdateScheduledDialog
        },

        data() {
            return {
                appointmentsTable: [
                    {
                        name: ''
                    }
                ],
                dialog: false,
                dialogTitle: null,
                dialogDescription: null,
                dialogButtonCancel: true,
                selectedAppointment: {},
                updateSchedule: false,
                appointment:{}
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                guest: 'getGuestDetail',
                dealership: 'getSelectedDealership',
            })
        }),

        watch: {
            '$route.params.guestId': function (id) {
                this.initialize()
            }
        },

        created() {
            this.initialize()
            this.$store.commit('setHeaderTitle', `${this.trans.welcomeBack}`)
        },

        mounted() {

        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchGuestDetailInfo', {guestId: this.$route.params.guestId})
            },

            getAppointmentStatus(appointment) {
                return fn.appointmentStatusString(appointment, this.trans)
            },

            onCancel(appointment) {
                this.dialogTitle = `${this.trans.cancelAppointment}`
                this.dialogDescription = `${this.trans.confirmationForCancel}`
                this.selectedAppointment = {...appointment}
                this.dialogButtonCancel = true
                this.dialog = true
            },

            onReebok(appointment) {
                this.selectedAppointment = {...appointment}
                this.dialogTitle = `${this.trans.reebokAppointment}`
                this.dialogDescription = `${this.trans.confirmationForReebok}`
                this.dialogButtonCancel = false
                this.dialog = true
            },

            onBookGuest(appointment) {
                this.selectedAppointment = {...appointment}
                this.dialogTitle = `${this.trans.bookGuest}`
                this.dialogDescription = `${this.trans.confirmationForBook}`
                this.dialogButtonCancel = false
                this.dialog = true
            },

            onConfirmAction(type) {
                let appointmentForm = new FormData()
                let URL = null

                switch (type) {
                    case 'confirmedCancel':
                        appointmentForm.append('canceled', true) // canceled the appointment
                        _.forOwn(this.selectedAppointment, (value, key) => {
                            switch (key) {
                                case 'id':
                                    appointmentForm.append('appointment_id', value)
                                    break

                                case 'status':
                                    appointmentForm.append('status', 6) // Consistance with guest table
                                    break

                                case 'vehicles':
                                    break

                                default:
                                    appointmentForm.append(key, value)
                            }
                        })

                        appointmentForm.append('_method', 'PUT')

                        const appointmentId = this.selectedAppointment.id
                        URL = `/api/appointments/${appointmentId}`
                        axios.post(URL, appointmentForm).then((response) => {
                            if (response.data.success) {
                                this.initialize()
                                this.dialog = false
                            }
                        }).catch(error => {
                            this.$store.dispatch('initializeError', error)
                        })
                        return

                    case 'reebokAppointment':
                        appointmentForm.append('guest_id', this.$route.params.guestId)
                        appointmentForm.append('appointment_id', this.selectedAppointment.id)
                        appointmentForm.append('_method', 'PUT')
                        URL = `/api/appointments/${this.selectedAppointment.id}/reebok`
                        axios.post(URL, appointmentForm).then((response) => {
                            if (response.data.success) {
                                axios.get('/refresh_csrf_token').then((csrfResponse) => {
                                    let csrfToken = csrfResponse.data.csrfToken

                                    let guestLogin = new FormData()
                                    guestLogin.append('uniqueId', this.guest.unique)
                                    // login guest into frontend
                                    axios.post('/guests/login', guestLogin, {
                                        'X-CSRF-TOKEN': csrfToken
                                    }).then((loginResponse) => {
                                        if (loginResponse.data.success) {
                                            window.location.href = '/booking'
                                        }
                                    }).catch(error => {
                                        this.$store.dispatch('initializeError', error)
                                    })
                                })
                            }
                        }).catch(error => {
                            this.$store.dispatch('initializeError', error)
                        })
                        return

                    case 'finishExistingBooking':
                        axios.get('/refresh_csrf_token').then((csrfResponse) => {
                            let csrfToken = csrfResponse.data.csrfToken

                            let guestLogin = new FormData()
                            guestLogin.append('uniqueId', this.guest.unique)
                            // login guest into frontend
                            axios.post('/guests/login', guestLogin, {
                                'X-CSRF-TOKEN': csrfToken
                            }).then((loginResponse) => {
                                if (loginResponse.data.success) {
                                    window.location.href = '/booking'
                                }
                            }).catch(error => {
                                this.$store.dispatch('initializeError', error)
                            })
                        }).catch(error => {
                            this.$store.dispatch('initializeError', error)
                        })
                }

            },

            renderVehicleImage(vehicle){
                const image = fn.renderVehicleImage(vehicle, this.dealership, this.themeOption.brandDefaultImage)
                return image
            },

            onUpdateScheduleTime(appointment){
                this.appointment = {...appointment}
                this.updateSchedule = true
            },

            onUpdateSchedule(schedule){
                this.updateSchedule = schedule
            }
        }
    }
</script>
