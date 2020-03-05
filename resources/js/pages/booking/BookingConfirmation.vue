<template>
    <div>
        <v-layout row wrap align-center justify-center class="booking-confirmation" px-5>
            <v-flex class="xs12" align-center>
                <h4 class="display-1 mt-5 mx-2 text-xs-center">
                    {{ trans.FollowingDetailsAreCorrect }}
                </h4>

                <h5 class="headline mt-2 mx-4 text-xs-center">
                    {{ trans.areTheseDetailsStillCorrect }}
                </h5>
            </v-flex>

            <v-flex row nowrap mt-5 justify-center class="confirmation-container xs12">
                <v-container>
                    <v-layout row wrap justify-center>
                        <v-flex sm12 md5 d-flex child-flex pa-2>
                            <v-card>
                                <v-card-text>
                                    <v-layout row wrap pa-3 align-center justify-center>
                                        <v-flex xs12 my-3 pa-0>
                                            <h6 class="title mx-1 text-xs-center">
                                                {{ getTitle() }}
                                            </h6>
                                        </v-flex>

                                        <v-flex xs10
                                                v-if="vehicles.length > 0">
                                            <v-carousel light
                                                        contain
                                                        height="250"
                                                        :hide-delimiters="vehicles.length <= 1"
                                                        :hide-controls="vehicles.length <= 1"
                                                        class="mt-2">
                                                <v-carousel-item
                                                    cycle="false"
                                                    v-for="vehicle in vehicles"
                                                    :key="vehicle.id"
                                                    :src="vehicle.driver_seating_position_left_image"
                                                ></v-carousel-item>
                                            </v-carousel>
                                        </v-flex>

                                        <v-flex xs12 v-else>
                                            <v-card flat
                                                    elevation="0"
                                                    height="250">
                                                <v-card-text>
                                                    <h3>{{ `${trans.no} ${trans.vehicle} ${trans.selected}`}}</h3>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>

                                        <v-flex xs12 class="btnPositioning">
                                            <v-layout justify-center my-3>
                                                <v-btn class="border-medium height-40 mx-1 rounded-25 light-grey"
                                                       @click="onAmend(0)">
                                                    {{ trans.amend }}
                                                </v-btn>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex sm12 md7 d-flex child-flex pa-2>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-card>
                                        <v-card-text>
                                            <v-layout row wrap justify-center pa-3>
                                                <v-flex xs3 mt-4>
                                                    <v-layout justify-center row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>access_time
                                                            </v-icon>
                                                        </v-flex>

                                                        <v-flex xs12 mt-2>
                                                            <h6 class="xs12 body-2 text-xs-center">
                                                                {{ trans.time }}
                                                            </h6>
                                                        </v-flex>

                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">
                                                                {{ slot.start|dateFormat('LT') }} to {{
                                                                slot.end|dateFormat('LT')}}
                                                            </h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>

                                                <v-flex xs3 mt-4>
                                                    <v-layout justify-center row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>person
                                                            </v-icon>
                                                        </v-flex>

                                                        <v-flex xs12 mt-2>
                                                            <h6 class="xs12 body-2 text-xs-center">
                                                                {{ `${trans.sales} ${trans.person}`}}
                                                            </h6>
                                                        </v-flex>

                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">
                                                                {{ saleExecutive.firstname }}
                                                            </h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>

                                                <v-flex xs3 mt-4>
                                                    <v-layout justify-center row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>date_range
                                                            </v-icon>
                                                        </v-flex>

                                                        <v-flex xs12 mt-2>
                                                            <h6 class="xs12 body-2 text-xs-center">
                                                                {{ trans.date }}
                                                            </h6>
                                                        </v-flex>

                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">
                                                                {{ date| dateFormat }}
                                                            </h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>

                                                <v-flex xs12>
                                                    <v-layout justify-center row nowrap mt-4>
                                                        <v-btn class="border-medium height-40 rounded-25 light-grey"
                                                               @click="onAmend(1)">
                                                            {{ trans.amend }}
                                                        </v-btn>
                                                    </v-layout>
                                                </v-flex>
                                            </v-layout>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>

                                <v-flex xs12>
                                    <v-layout row wrap class="part-exchange-and-guest">
                                        <v-flex xs12 md6 d-flex child-flex pt-4 pr-2>
                                            <v-card>
                                                <v-card-text>
                                                    <v-layout pa-3 row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>compare_arrows
                                                            </v-icon>
                                                        </v-flex>
                                                        <v-flex xs12 mt-1>
                                                            <h6 class="xs12 body-1 text-xs-center">
                                                                {{ trans.partExchange }}
                                                            </h6>
                                                        </v-flex>
                                                        <v-flex mt-1>
                                                            <h6 class="registration-confirmation">
                                                                {{ getPartExchangeTitle() }}
                                                            </h6>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <v-layout justify-center row nowrap mt-3>
                                                                <v-btn @click="onAmend(2)"
                                                                       class="border-medium height-40 rounded-25 light-grey">
                                                                    {{ trans.amend }}
                                                                </v-btn>
                                                            </v-layout>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>

                                        <v-flex xs12 md6 d-flex child-flex pt-4 pl-2>
                                            <v-card>
                                                <v-card-text>
                                                    <v-layout pa-3 row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>person_add
                                                            </v-icon>
                                                        </v-flex>

                                                        <v-flex xs12 mt-1>
                                                            <h6 class="xs12 body-1 text-xs-center">
                                                                {{ trans.guests }}
                                                            </h6>
                                                        </v-flex>

                                                        <v-flex mt-1>
                                                            <h6 class="xs12 body-2 text-xs-center">
                                                                {{ bringGuest.name }}
                                                            </h6>
                                                        </v-flex>

                                                        <v-flex xs12>
                                                            <v-layout justify-center row nowrap mt-3>
                                                                <v-btn @click="onAmend(1)"
                                                                       class="border-medium height-40 rounded-25 light-grey">
                                                                    {{ trans.amend }}
                                                                </v-btn>
                                                            </v-layout>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>

            <v-flex xs12 my-5>
                <v-layout xs12 row justify-center>
                    <v-btn class="border-medium height-50 rounded-25 padding-l-85 padding-r-45"
                           :style="{backgroundColor: color}"
                           @click="onConfirmBooking()"
                           outline
                           :color="color"
                           depressed>
                        {{ trans.confirm }}
                        <v-icon class="padding-l-35"
                                :color="color"
                                small light>arrow_forward
                        </v-icon>
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
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
                date: 'getBookingSelectedDate',
                event: 'getSelectedEvent'
            })
        }),

        created() {

        },

        methods: {
            onConfirmBooking() {
                let bookingForm = new FormData()

                // Check is existing appointment
                if (this.guest.appointment.length > 0 && this.guest.appointment[0].id) {
                    bookingForm.append('appointment_id', this.guest.appointment[0].id)
                }

                bookingForm.append('date', this.date)
                bookingForm.append('event_id', this.event.id)
                bookingForm.append('user_id', this.saleExecutive.id)
                bookingForm.append('guest_id', this.guest.id)
                bookingForm.append('slot_id', this.slot.slotId)
                bookingForm.append('bring_guest', this.bringGuest.name)

                if (this.bringGuest.changingCar) {
                    bookingForm.append('guest_changing_car', 1)
                } else {
                    bookingForm.append('guest_changing_car', 0)
                }

                bookingForm.append('start', this.slot.start)
                bookingForm.append('end', this.slot.end)
                bookingForm.append('part_ex_vrm', this.partExchange.registrationNumber)
                bookingForm.append('part_ex_vehicle', this.partExchange.makeAndModel)
                bookingForm.append('part_ex_distance', this.partExchange.currentMilege)

                bookingForm.append('status', 1) // Make booking confirm
                bookingForm.append('_method', 'post')

                _.map(this.vehicles, function (vehicle, index) {
                    if(vehicle.appointment_vehicle_id){
                        bookingForm.append(`vehicles[${index}][appointment_vehicle_id]`, vehicle.id)
                    }

                    bookingForm.append(`vehicles[${index}][vehicle_id]`, vehicle.vehicle_id)
                    bookingForm.append(`vehicles[${index}][condition]`, vehicle.condition)
                })

                const URL = `/api/booking`
                axios.post(URL, bookingForm).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            bgColor: this.themeOption.snackBarBgSuccess,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.yourReservationConfirmed}`
                        })

                        // Disable editing for guest
                        this.$store.commit('setDisableEditing', true)
                        this.$store.commit('setAppointmentDialog', true)
                        // this.$router.push({name: 'bookingConfirmed'})
                    }
                })
            },

            onAmend(step) {
                this.$store.commit('setBookingStep', step)
            },

            getTitle(){
                let title = ''
                if(this.vehicles.length > 1){
                    title =`${this.trans.yourModel} (${this.trans.s}) ${this.trans.ofInterest}`
                }else{
                    title = `${this.trans.yourModel} ${this.trans.ofInterest}`
                }

                return title
            },

            getPartExchangeTitle(){
                let title = ''
                if(this.partExchange.vehicleExchange){
                    title = this.trans.none
                } else{
                    title = this.partExchange.registrationNumber
                }
                return title
            }
        }
    }
</script>
