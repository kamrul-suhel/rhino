<template>
    <v-layout row wrap
              align-center
              class="book-step calenderComponent"
              style="border-right: 1px solid rgb(240,240,240)">
        <v-flex xs12>
            <h6 class="headline text-xs-center">{{ selectedEvent.start | dateFormat('MMMM')}} <b>{{
                selectedEvent.start | dateFormat('YYYY')}}</b></h6>
        </v-flex>

        <v-flex xs12>
            <v-layout row nowrap class="mt-4">
                <v-flex>
                    <label class="body-2">
                        {{ trans.available }}
                        {{ trans.dates }}
                    </label>
                </v-flex>

                <v-flex>
                    <div style="width:12px;height:12px;border:1px solid rgb(100,0,0); border-radius:6px; margin:4px"></div>
                </v-flex>

                <v-flex ml-2>
                    <label class="body-2">
                        {{ trans.no }}
                        {{ trans.available }}
                        {{ trans.times }}
                    </label>
                </v-flex>

                <v-flex>
                    <div style="width:12px;height:12px; background-color:rgb(160,160,160); border-radius:6px; margin:4px"></div>
                </v-flex>

                <v-flex>
                    <button :style="{color:color}"
                            @click="onDateCancel()"
                            style="opacity:0.7">
                        {{ trans.clear }}
                    </button>
                </v-flex>
            </v-layout>
        </v-flex>

        <v-flex xs12>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-date-picker
                        class="calender mt-3"
                        full-width
                        no-title
                        reactive
                        :color="color"
                        v-model="selectedDate"
                        :allowed-dates="val => allowDates.indexOf(val) !== -1"
                        :show-current="selectedEvent.start"
                        :min="selectedEvent.start"
                        :max="selectedEvent.end"
                    ></v-date-picker>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {
        data() {
            return {
                type: 'month',
                selectedDate: '',
                allowDates:[]
            }
        },

        created() {
        },

        watch: {

            selectedDate() {
                this.$store.commit('setBookingSelectedDate', this.selectedDate)
            },

            selectedEvent(){
                this.allowedDates()
            },

            selectedSaleExecutive(){
                this.allowedDates()
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                event: 'getSelectedEvent',
                selectedEvent: 'getSelectedEvent',
                dealership: 'getSelectedDealership',
                selectedSlot: 'getSelectedSlot',
                existingAppointments: 'getAllBookingAppointments',
                selectedSaleExecutive: 'getBookingSelectedSaleExecutive'
            })
        }),

        methods: {
            allowedDates() {
                let start = moment(this.selectedEvent.start)
                let end = moment(this.selectedEvent.end)
                const dates = fn.getDates(start, end, this.dealership)

                // Check is slot is selected or not
                if(this.selectedSlot.start){
                    if(this.selectedSaleExecutive.id){
                        let availableDates = []

                         _.map(dates, (date) => {
                             const isExists = _.findIndex(this.existingAppointments, (appointment) => {
                                 const appointmentDate = moment(appointment.start).format('L')
                                 const selectedDate = moment(date).format('L')
                                 if(
                                     selectedDate === appointmentDate &&
                                     this.selectedSaleExecutive.id === appointment.user_id &&
                                     this.selectedSlot.slotId === appointment.slot_id
                                 ){
                                     return appointment
                                 }
                             })

                            if(isExists === -1){
                                availableDates.push(date)
                            }
                        })

                        this.allowDates = [...availableDates]
                        // default select first date
                        if(this.allowDates.length > 0){
                            this.selectedDate = this.allowDates[0]
                        }
                        return
                    }

                }

                this.allowDates = [...dates]
            },

            onDateCancel(){
                this.selectedDate = ''
            }
        }
    }
</script>
