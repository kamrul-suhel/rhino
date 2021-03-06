<template>
    <div>
        <v-layout row wrap align-center justify-center class="booking-confirmation px-md-5">
            <v-flex class="xs12" align-center v-if="!isDisable">
                <h4 class="display-1 mt-5 mx-2 text-xs-center">
                    {{ trans.FollowingDetailsAreCorrect }}
                </h4>

                <h5 class="headline mt-2 mx-4 text-xs-center">
                    {{ trans.areTheseDetailsStillCorrect }}
                </h5>
            </v-flex>

            <v-flex row nowrap mt-5 justify-center class="confirmation-container xs12">
                <v-container pa-0>
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
                                                        class="mt-2 vehicle-carousel">
                                                <v-carousel-item
                                                    cycle="false"
                                                    v-for="vehicle in filterVehicles()"
                                                    :key="`${vehicle.id}-${vehicle.condition}`"
                                                    :src="renderVehicleImage(vehicle)"
                                                ></v-carousel-item>
                                            </v-carousel>
                                        </v-flex>

                                        <v-flex xs12 v-else>
                                            <v-card flat
                                                    elevation="0"
                                                    height="250">
                                                <v-card-text>
                                                    <h3>{{ `${trans.noVehicleSelected}`}}</h3>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>

                                        <v-flex xs12 class="btnPositioning" v-if="!isDisable">
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

                        <BookingConfirmationDisable v-if="isDisable">
                        </BookingConfirmationDisable>

                        <v-flex sm12 md7
                                d-flex
                                child-flex
                                pa-2
                                v-else>
                            <v-layout row wrap>
                                <v-flex xs12 v-if="!isDisable">
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
                                                                {{ slot.start|dateFormat('LT', selectedLanguage.language_code) }} to {{
                                                                slot.end|dateFormat('LT', selectedLanguage.language_code)}}
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
                                                                {{ `${trans.salesPerson}`}}
                                                            </h6>
                                                        </v-flex>

                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">
                                                                {{ saleExecutive.firstname }} {{ saleExecutive.surname }}
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
                                                                {{ date| dateFormat('MMM do YYYY', selectedLanguage.language_code) }}
                                                            </h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>

                                                <v-flex xs12 v-if="!isDisable">
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

                                <v-flex v-if="!isDisable" xs12>
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
                                                        <v-flex xs12 v-if="!isDisable">
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

                                                        <v-flex xs12 v-if="!isDisable">
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

            <v-flex xs12 my-5 v-if="!isDisable">
                <v-layout xs12 row justify-center>
                    <v-btn class="border-medium height-50 rounded-25 padding-l-85 padding-r-45"
                           :style="{backgroundColor: color}"
                           @click="onConfirmBooking()"
                           :loading="loading"
                           :disabled="loading"
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
    import BookingConfirmationDisable from "@/components/Booking/BookingConfirmationDisable";
    import fn from "@/utils/function"

    export default {
        components: {
            BookingConfirmationDisable
        },

        data() {
            return {
                loader: null,
                loading: false,
                vehicleids: [],
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
                dealership: 'getSelectedDealership'
            })
        }),

        created() {

        },

        methods: {
            onConfirmBooking() {
                if (this.isDisable) return

                this.loader = 'loading'
                this.loading = true

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
                bookingForm.append('type', 'confirmed') // Make guest status confirmed
                bookingForm.append('_method', 'post')
                bookingForm.append('sendEmail', true)

                _.map(this.vehicles, function (vehicle, index) {
                    if (vehicle.appointment_vehicle_id) {
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

                        // Check is redirect query is exists
                        if (this.$route.query.redirect) {
                            switch (this.$route.query.redirect) {
                                case 'calendar':
                                    window.location = '/admin/calendar'
                                    return
                            }
                        }
                    }
                    this.loading = false
                    this.loader = null
                    this.moveTo()
                },error => {
                    this.loading = false
                    this.loader = null
                })
            },

            onAmend(step) {
                this.$store.commit('setBookingStep', step)
            },

            getTitle() {
                let title = ''
                if (this.vehicles.length > 1) {
                    title = `${this.trans.yourModelsOfInterest}`
                } else {
                    title = `${this.trans.yourModelOfInterest}`
                }

                return title
            },

            getPartExchangeTitle() {
                let title = ''
                if (this.partExchange.noVehicleExchange) {
                    title = this.trans.none
                } else {
                    title = this.partExchange.registrationNumber
                }
                return title
            },

            renderVehicleImage(vehicle) {
                if(this.dealership){
                    const image =  fn.renderVehicleImage(vehicle, this.dealership, this.themeOption.brandDefaultImage)
                    return image
                }
            },

            filterVehicles(){
                // Filter out repeated vehicles (used & new) for carousel

                const filterVehicles = _.uniqBy(this.vehicles, function (e) {
                    return e.vehicle_id;
                });

                return filterVehicles

            },

            moveTo () {
                let to = this.moveToDown
                    ? this.$refs.description.offsetTop - 60
                    : 0

                window.scroll({
                    top: to,
                    left: 0,
                    behavior: 'smooth'
                })

                this.moveToDown = !this.moveToDown
            }
        }
    }
</script>
<style scoped>

.vehicle-carousel .v-image__image.v-image__image--cover {
    background-size: contain!important;
}

</style>