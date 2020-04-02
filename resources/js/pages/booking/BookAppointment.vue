<template>
    <div class="book-appointment px-5">
        <v-layout row wrap>
            <v-flex xs12>
                <h4 class="display-1 mt-5 text-xs-center">
                    {{ trans.nowBookYourAppointment }}
                </h4>
            </v-flex>
        </v-layout>

        <v-layout row wrap
                  mt-5
                  justify-center>
            <v-flex xs12
                    class="border-right px-4"
                    :md4="vehicleType !== 'unsure'"
                    :md6="vehicleType === 'unsure' || vehicleType === ''">
                <Calender></Calender>
            </v-flex>

            <v-flex xs12 md4
                    class="border-right px-4"
                    v-if="vehicleType !== 'unsure' && vehicleType !== ''">
                <SalePerson></SalePerson>
            </v-flex>

            <v-flex xs12
                    class="px-4"
                    :md4="vehicleType !== 'unsure'"
                    :md6="vehicleType === 'unsure' || vehicleType === ''">
                <ChooseTime></ChooseTime>
            </v-flex>

        </v-layout>

        <v-layout row wrap class="my-5">
            <v-flex xs12 class="text-xs-center">
                <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85"
                       outline
                       @click="onContinue()"
                       :color="color"
                       depressed>{{ trans.continue }}
                </v-btn>
            </v-flex>
        </v-layout>

        <v-snackbar
            class="appointmentValidationError"
            v-model="error"
            right
            :timeout="timeOut"
            multi-line
            top
            color="error"
        >
            <ul>
                <li v-for="message in messages">{{ message }}</li>
            </ul>
            <v-btn
                color="white"
                flat
                @click="error = false"
            >
                {{ trans.close }}
            </v-btn>
        </v-snackbar>
    </div>
</template>


<script>
    import {mapGetters} from 'vuex'
    import SalePerson from "@/components/Booking/SalePerson";
    import ChooseTime from "@/components/Booking/ChooseTime";
    import Calender from "@/components/Booking/Calender"

    export default {
        components: {
            SalePerson,
            ChooseTime,
            Calender
        },

        data() {
            return {
                error: false,
                messages: [],
                timeOut: 5000
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                dealership: 'getSelectedDealership',
                selectedVehicles: 'getBookingSelectedVehicles',
                color: 'getFrontendColor',
                selectedEvent: 'getSelectedEvent',
                vehicleType: 'getBookingVehicleType',
                selectedDate: 'getBookingSelectedDate',
                selectedSaleExecutive: 'getBookingSelectedSaleExecutive',
                selectedSlot: 'getSelectedSlot'
            })
        }),

        created() {
        },

        methods: {
            onContinue() {
                let error = false
                this.messages = []
                // Validate appointment
                if (this.vehicleType !== 'unsure') {
                    // Validate selected date, sales executive & slot
                    if (!this.selectedDate) {
                        this.messages.push(this.trans.selectADate)
                        error = true
                    }

                    if (
                        !this.selectedSaleExecutive ||
                        !this.selectedSaleExecutive.id
                    ) {
                        this.messages.push(this.trans.selectSalesExecutive)
                        error = true
                    }

                    if (
                        !this.selectedSlot ||
                        !this.selectedSlot.slotId
                    ) {
                        this.messages.push(this.trans.selectATime)
                        error = true
                    }
                } else {
                    if (!this.selectedDate) {
                        this.messages.push(this.trans.selectADate)
                        error = true
                    }

                    if (
                        !this.selectedSlot &&
                        this.selectedSlot.slotId
                    ) {
                        this.messages.push(this.trans.selectATime)
                        error = true
                    }
                }
                if(error){
                    this.error = true
                    return
                }

                this.$store.commit('setBookingStep', 2)
            }
        }
    }
</script>
