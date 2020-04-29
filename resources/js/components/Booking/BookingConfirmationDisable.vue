<template>
    <v-flex sm12 md7 px-5>
        <v-layout row wrap class="booking-confirmed-disabled">
            <div>
                <h1>{{ trans.yourBookingIsConfirmed }}</h1>
                <p>{{ trans.sendEmailMessage }}</p>
            </div>

            <v-flex xs12>
                <v-container grid-list-lg pa-0>
                    <v-layout row wrap>
                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>access_time
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        {{ trans.time }}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        <strong v-if="scheduled_start && scheduled_end" :style="{color: color}">
                                            {{ scheduledStart }} - 
                                            {{ scheduledEnd }}
                                        </strong>
                                        <strong v-if="!scheduled_start || !scheduled_end" :style="{color: color}">
                                            {{ slot.start|dateFormat('HH:mm', selectedLanguage.language_code) }} - 
                                            {{ slot.end|dateFormat('LT', selectedLanguage.language_code)}}
                                        </strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>person
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        {{ `${trans.salesPerson}`}}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        <strong :style="{color: color}">{{ saleExecutive.firstname }} {{ saleExecutive.surname }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>date_range
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        {{ trans.date }}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        <strong :style="{color: color}">{{ date| dateFormat('DD/MM/YYYY',
                                            selectedLanguage.language_code) }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>compare_arrows
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="body-1 text-xs-center">
                                        {{ trans.partExchange }}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="registration-confirmation">
                                        <strong>{{ getPartExchangeTitle() ? getPartExchangeTitle() : 'N/A'  }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>person_add
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        {{ trans.guests }}
                                    </h6>
                                </v-flex>

                                <v-flex mt-1>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        <strong :style="{color: color}">
                                            {{ (bringGuest.name != 'undefined' && bringGuest.name ) ? bringGuest.name : 'None' }}
                                        </strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-btn class="border-medium rounded-25"
                                   outline
                                   :loading="loading"
                                   :disabled="loading"
                                   @click="onUpdateAppointment"
                                   :color="color"
                                   depressed>
                                {{ trans.updateAppointment | trans }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                loader: null,
                loading: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                vehicles: 'getBookingSelectedVehicles',
                slot: 'getSelectedSlot',
                saleExecutive: 'getBookingSelectedSaleExecutive',
                bringGuest: 'getBookingBringGuest',
                guest: 'getBookingGuest',
                partExchange: 'getBookingPartExchange',
                scheduled_start: 'getOverrideStart',
                scheduled_end: 'getOverrideEnd',
                date: 'getBookingSelectedDate',
                event: 'getSelectedEvent',
                isDisable: 'getDisableEditing',
                selectedLanguage: 'getSubSelectedLanguage',
                users: 'getUsers'
            })
        }),

        created() {
            this.scheduledStart = moment(this.scheduled_start).format('HH:mm')
            this.scheduledEnd = moment(this.scheduled_end).format('HH:mma')
        },

        methods: {
            getPartExchangeTitle() {
                let title = ''
                if (this.partExchange.vehicleExchange) {
                    title = this.trans.none
                } else {
                    title = this.partExchange.registrationNumber
                }
                return title
            },

            onUpdateAppointment() {
                this.loader = 'loading'
                this.loading = true

                const appointmentId = this.guest.appointment[0].id
                const guestId = this.guest.id

                let updateAppointmentForm = new FormData()
                updateAppointmentForm.append('appointment_id', appointmentId)
                updateAppointmentForm.append('guest_id', guestId)
                updateAppointmentForm.append('type', 'updateByGuest')
                updateAppointmentForm.append('updateByGuest', true)
                updateAppointmentForm.append('_method', 'PUT')

                const URL = `/api/appointments/${appointmentId}/update`
                axios.post(URL, updateAppointmentForm).then((response) => {
                    if (response.data.success) {
                        // Initialize selected slot, selected sale executive, selected Date
                        this.$store.commit('setSelectedSlot',{})
                        this.$store.commit('setBookingSelectedDate','')
                        this.$store.commit('setBookingSelectedSaleExecutive',{})


                        // reset saleExecutives
                        const users = _.map(this.users, (user) => {
                            return {
                                ...user,
                                selected:''
                            }
                        })
                        this.$store.commit('setUsers', users)


                        this.$store.commit('setDisableEditing', false)
                        this.loading = false
                        this.loader = null
                        this.$store.commit('setBookingStep',    1)
                    }
                }, error => {
                    this.loader = null
                    this.loading = false
                })
            }
        }
    }
</script>